<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Upload;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        $request->validate([
            'content' => ['required', 'image', 'max:2048'],
        ]);

        $nameOfFile = $request->file('content')->storePublicly('challenge_submits', 'public');

        $photo = new Upload();
        $photo->content = $nameOfFile;
        $photo->user_id = auth()->id();
        $photo->challenge_id = 1;
        $photo->pending = false;
        $photo->save();

        $user = auth()->user();


        $challenge = Challenge::findOrFail($request->input('challenge_id'));


        if ($challenge->badge_id && !$user->badges->contains('id', $challenge->badge_id)) {
            $user->badges()->attach($challenge->badge_id, [
                'acquire' => now(),
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'Je bestand is succesvol geüpload!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Challenge $challenge)
    {
        $challenges = Challenge::where('id', $challenge->challenge_id);
//        dd($challenges);
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


}
