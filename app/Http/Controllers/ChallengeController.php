<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function create()
    {
        return view('admin.challenges.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'difficulty_id' => 'required|exists:difficulties,id',
            'badge_id' => 'nullable|exists:badges,id',
            'published' => 'boolean',
            'duration' => 'required|date_format:H:i:s',
            'steps.*' => 'nullable|string'
        ]);

        // 1. Challenge aanmaken
        $challenge = Challenge::create([
            'title' => $request->title,
            'description' => $request->description,
            'difficulty_id' => $request->difficulty_id,
            'badge_id' => $request->badge_id,
            'published' => $request->published ? 1 : 0,
            'duration' => $request->duration,
            'user_id' => auth()->id(),
        ]);

        // 2. Steps opslaan (alleen als aanwezig)
        if ($request->steps) {
            foreach ($request->steps as $index => $content) {
                if (!empty($content)) {
                    $challenge->steps()->create([
                        'step_number' => $index + 1,
                        'step_description' => $content
                    ]);
                }
            }
        }

        return redirect()->route('challenges.create')->with('success', 'Challenge created with steps!');
    }

}
