<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Upload;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Submitted;
use App\Mail\SubmittedMail;
use App\Models\BadgeUser;
use Illuminate\Support\Facades\Mail;

class UploadController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $challenges = Challenge::all();
        return view('upload', compact('challenges'));
    }

    public function create($photos)
    {
        $this->authorize('create', $photos);
        $photos = Upload::all();
        return view('upload', compact('photos'));
    }

    public function store(Request $request, Challenge $challenge)
    {
        $request->validate([
            'content' => ['required', 'image', 'max:2048'],
        ]);


        $alreadySubmitted = Submitted::where('user_id', auth()->id())
            ->where('challenge_id', $challenge->id)
            ->whereNotNull('token')
            ->exists();

        if ($alreadySubmitted) {
            return redirect()->route('dashboard')
                ->with('error', 'Je inzending wordt nog beoordeeld. Je kunt nog niet opnieuw indienen.');
        }

        // Bestand opslaan
        $file = $request->file('content');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('challenge_submits'), $filename);

        // Opslaan in database
        $submitted = Submitted::create([
            'content' => 'challenge_submits/' . $filename,
            'user_id' => auth()->id(),
            'challenge_id' => $challenge->id,
            'token' => Str::random(40),
            'date' => now(),
            'pending' => false,
        ]);

        Mail::to('jordi1030@outlook.com')->send(new SubmittedMail($submitted));

        return redirect()->route('dashboard')
            ->with('status', 'Je inzending is succesvol verstuurd!');
    }


    public function show(Request $request, Challenge $challenge)
    {
        $challenges = Challenge::where('id', $challenge->challenge_id);
        return view('upload', compact('challenge', 'request', 'challenges'));
    }

    public function edit(Upload $upload)
    {
    }

    public function update(Request $request, Upload $upload)
    {
    }

    public function destroy(Upload $upload)
    {
    }

    public function approve($id, $token)
    {
        $submitted = Submitted::findOrFail($id);

        if ($submitted->pending === true) {
            return redirect()->route('dashboard')
                ->with('status', 'Dit antwoord is al goedgekeurd.');
        }

        if ($submitted->token !== $token) {
            return redirect()->route('dashboard')
                ->with('error', 'Ongeldige token.');
        }

        $submitted->pending = true;
        $submitted->token = null;
        $submitted->save();

        // Badge logic
        $challenge = Challenge::find($submitted->challenge_id);

        if ($challenge && $challenge->badge_id) {

            $alreadyHasBadge = BadgeUser::where('user_id', $submitted->user_id)
                ->where('id_badge', $challenge->badge_id)
                ->exists();

            if (!$alreadyHasBadge) {
                BadgeUser::create([
                    'id_badge' => $challenge->badge_id,
                    'user_id' => $submitted->user_id,
                    'acquire' => now(),
                ]);
            }
        }

        return redirect()->route('dashboard')
            ->with('status', 'Je antwoord klopt! Je hebt een badge gekregen!');
    }

    public function reject($id, $token)
    {
        $submitted = Submitted::findOrFail($id);

        if ($submitted->token !== $token) {
            return redirect()->route('dashboard')
                ->with('error', 'Ongeldige token, actie afgebroken.');
        }

        $submitted->pending = false;
        $submitted->token = null;
        $submitted->save();

        return redirect()->route('dashboard')
            ->with('denied', 'De inzending is afgewezen.');
    }
}
