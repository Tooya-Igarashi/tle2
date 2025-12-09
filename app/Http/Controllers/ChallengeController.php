<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Difficulty;
use Illuminate\Http\Request;
use App\Models\Badge;

class ChallengeController extends Controller
{
    public function dashboard(Request $request)
    {
        $search = $request->input('search');

        $challenges = Challenge::query()
            ->when($search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->take(3)
            ->get();

        $user = auth()->user();
        $challengeAll = Challenge::all();

        // Badge-IDs van gebruiker ophalen (of leeg als niet ingelogd)
        $userBadgeIds = $user ? $user->badges->pluck('id')->toArray() : [];

        // Per challenge bepalen of completed
        foreach ($challengeAll as $challenge) {
            $challenge->completed = in_array($challenge->badge_id, $userBadgeIds);
        }

        return view('dashboard', ['challenges' => $challenges, 'challenge' => $challengeAll]);
    }

    public function show(Challenge $challenge)
    {
        $steps = $challenge->steps()->orderBy('step_number')->get();
        $difficulty = Difficulty::where('id', $challenge->difficulty_id)
            ->value('difficulty');

        return view('challenges.show', compact('challenge', 'steps', 'difficulty'));
    }

    public function create()
    {
        $difficulties = Difficulty::all();
        $badges = Badge::all();
        return view('admin.challenges.create', compact('difficulties', 'badges'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'difficulty_id' => 'required|exists:difficulties,id',
            'badge_id' => 'required|exists:badges,id',
            'published' => 'boolean',
            'duration' => 'required|date_format:H:i',
            'steps.*' => 'nullable|string|max:50',
            'image_path' => 'image|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('image_path')) {
            $path = $request->file('image_path')->store('challenge_images', 'public');
        }

// 1. Challenge aanmaken
        $challenge = new Challenge();
        $challenge->title = $validated['title'];
        $challenge->description = $validated['description'];
        $challenge->difficulty_id = $validated['difficulty_id'];
        $challenge->badge_id = $validated['badge_id'] ?? null;
        $challenge->published = $validated['published'] ?? false;
        $challenge->duration = $validated['duration'];
        $challenge->user_id = auth()->id();
        $challenge->image_path = $path;
        $challenge->save();
        $challenge->joinedUsers()->attach(auth()->id());


// 2. Steps opslaan (alleen als aanwezig)
        if ($request->has('steps') && $request->steps) {
            foreach ($request->steps as $index => $content) {
                if (!empty(trim($content))) {
                    $challenge->steps()->create([
                        'step_number' => $index + 1,
                        'step_description' => $content
                    ]);
                }
            }
        }


        return redirect()->route('dashboard')->with('success', 'Challenge created with steps!');
    }

    public function allChallenges()
    {
        $user = auth()->user();
        $challenges = Challenge::all();

        // Badge-IDs van gebruiker ophalen (of leeg als niet ingelogd)
        $userBadgeIds = $user ? $user->badges->pluck('id')->toArray() : [];

        // Per challenge bepalen of completed
        foreach ($challenges as $challenge) {
            $challenge->completed = in_array($challenge->badge_id, $userBadgeIds);
        }

        return view('challenges.all', compact('challenges'));
    }

    public function userHasBadgeForChallenge($challenge)
    {
        $user = auth()->user();

        if (!$user || !$challenge->badge_id) {
            return false;
        }

        return $user->badges->contains('id', $challenge->badge_id);
    }

    public function showBadge($id)
    {
        $challenge = Challenge::findOrFail($id);

        $hasBadge = $this->userHasBadgeForChallenge($challenge);

        return view('challenges.show', compact('challenge', 'hasBadge'));
    }

}
