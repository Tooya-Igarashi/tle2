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
    /**
     * Display a listing of the resource.
     */


    use AuthorizesRequests;

    public function index()
    {
        $challenges = Challenge::all();

        return view('upload', compact('challenges'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($photos)
    {
        $this->authorize('create', $photos);
        $photos = Upload::all();
        return view('upload', compact('photos'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request, Challenge $challenge)
    {
        $request->validate([
            'content' => ['required', 'image', 'max:2048'],
        ]);

        // Check of user al heeft ingediend voor deze challenge
        $alreadySubmitted = Submitted::where('user_id', auth()->id())
            ->where('challenge_id', $challenge->id)
            ->exists();

        if ($alreadySubmitted) {
            return redirect()->route('dashboard')
                ->with('error', 'Je hebt deze challenge al ingestuurd.');
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

        // Mail sturen
        Mail::to('jordi1030@outlook.com')->send(new SubmittedMail($submitted));

        return redirect()->route('dashboard')
            ->with('status', 'Je inzending is succesvol verstuurd!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Request $request, Challenge $challenge)
    {
        $challenges = Challenge::where('id', $challenge->challenge_id);
        return view('upload', compact('challenge', 'request', 'challenges'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Upload $upload)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Upload $upload)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Upload $upload)
    {
        //
    }

    public function approve($id, $token)
    {
        $submitted = Submitted::findOrFail($id);

        if ($submitted->pending === true) {
            return view('dashboard', ['message' => 'Inzending is al beoordeeld.']);
        }

        if ($submitted->token !== $token) {
            return redirect()->route('dashboard');
        }


        $submitted->pending = true;
        $submitted->token = null;
        $submitted->save();
        $challenge = Challenge::find($submitted->challenge_id);

        if ($challenge && $challenge->badge_id) {

            // Check of gebruiker deze badge al eerder heeft gekregen
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

        return view('dashboard', [
            'message' => 'Inzending geaccepteerd! Badge toegekend!'
        ]);

    }


    public function reject($id, $token)
    {
        $submitted = Submitted::findOrFail($id);

        if ($submitted->token !== $token) {
            return redirect()->route('dashboard')
                ->with('error', 'Ongeldige token, actie afgebroken.');
        }

        // Markeer als afgewezen
        $submitted->pending = false;
        $submitted->token = null;
        $submitted->save();

        return redirect()->route('dashboard')
            ->with('status', 'De inzending is afgewezen.');
    }


}
