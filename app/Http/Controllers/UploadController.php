<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Upload;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Submitted;
use App\Mail\SubmittedMail;
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

        $file = $request->file('content');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('challenge_submits'), $filename);

        $submitted = Submitted::create([
            'content' => 'challenge_submits/' . $filename,
            'user_id' => auth()->id(),
            'challenge_id' => $challenge->id,
            'token' => Str::random(40),
            'pending' => false,
        ]);

        Mail::to('jordi1030@outlook.com')->send(new SubmittedMail($submitted));

        return view('upload.index');
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
            abort(403, 'Invalid token');
        }

        $submitted->pending = true; // ✔ accepted
        $submitted->token = null;   // token ongeldig maken
        $submitted->save();

        return view('submission_result', ['message' => 'Inzending geaccepteerd!']);
    }

    public function reject($id, $token)
    {
        $submitted = Submitted::findOrFail($id);

        if ($submitted->token !== $token) {
            abort(403, 'Invalid token');
        }

        $submitted->pending = false; // ❌ rejected
        $submitted->token = null;
        $submitted->save();

        return view('submission_result', ['message' => 'Inzending afgewezen.']);
    }


}
