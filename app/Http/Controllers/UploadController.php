<?php

namespace App\Http\Controllers;

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
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create( $photos)
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
        $photo->user_id = 1;
        $photo->challenge_id = 1;
        $photo->pending = false;
        $photo->save();


//        return redirect()->route('upload.index');
return view('upload.index', compact('photo'))->with('success', 'Je bestand is succesvol geüpload!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Upload $upload)
    {
        //
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
