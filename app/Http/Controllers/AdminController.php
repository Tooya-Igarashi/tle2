<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\Challenge;
use App\Models\Difficulty;
use Illuminate\Http\Request;
use App\Models\Step;

class AdminController extends Controller
{

    public function admin()
    {
        $challenge = Challenge::all();
        return view('admin.challenges.dashboard', compact('challenge'));
    }

    public function authenticate(Challenge $challenge)
    {
        $challenge->published = $challenge->published ? 0 : 1;
        $challenge->save();

        $message = $challenge->published ? 'Challenge published.' : 'Challenge unpublished.';
        return redirect()->back()->with($challenge->published ? 'success' : 'info', $message);
    }

    public function edit(Challenge $challenge)
    {
        $difficulties = Difficulty::all();
        $badges = Badge::all();
        return view('admin.challenges.edit', ['challenge' => $challenge, 'difficulties' => $difficulties, 'badges' => $badges]);
    }
    public function update(Request $request, Challenge $challenge)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'difficulty_id' => 'required|exists:difficulties,id',
            'badge_id' => 'nullable|exists:badges,id',
            'published' => 'sometimes|boolean',
            'duration' => 'required|date_format:H:i',
            'image_path' => 'nullable|image|max:2048',
            'steps' => 'nullable|array',
            'steps.*.content' => 'nullable|string|max:500',
            'steps_to_delete' => 'nullable|array',
        ]);

        // Update challenge fields
        $challenge->title = $validated['title'];
        $challenge->description = $validated['description'];
        $challenge->difficulty_id = $validated['difficulty_id'];
        $challenge->badge_id = $validated['badge_id'] ?? null;
        $challenge->published = $request->has('published') ? 1 : 0;
        $challenge->duration = $validated['duration'];

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('challenge_images', 'public');
            $challenge->image_path = $path;
        }

        $challenge->save();

        // Delete steps marked for deletion
        $toDelete = $request->input('steps_to_delete', []);
        if (!empty($toDelete)) {
            Step::whereIn('id', $toDelete)->where('challenge_id', $challenge->id)->delete();
        }

        // Process steps: update existing and create new ones, set order
        $steps = $request->input('steps', []);
        foreach ($steps as $s) {
            $content = trim($s['content'] ?? '');
            $order = isset($s['order']) ? (int)$s['order'] : null;

            if ($content === '') {
                continue; // skip empty
            }

            if (!empty($s['id'])) {
                // update existing
                $step = $challenge->steps()->where('id', $s['id'])->first();
                if ($step) {
                    $step->step_description = $content;
                    if ($order) $step->step_number = $order;
                    $step->save();
                } else {
                    // fallback create if not found
                    $challenge->steps()->create([
                        'step_number' => $order ?: 0,
                        'step_description' => $content,
                    ]);
                }
            } else {
                // new step
                $challenge->steps()->create([
                    'step_number' => $order ?: 0,
                    'step_description' => $content,
                ]);
            }
        }

        // Normalize ordering (in case of gaps) by reassigning sequential numbers
        $ordered = $challenge->steps()->orderBy('step_number')->get();
        $count = 1;
        foreach ($ordered as $st) {
            $st->step_number = $count++;
            $st->save();
        }

        return redirect()->route('admin.dashboard')->with('success', 'Challenge updated.');
    }
}
