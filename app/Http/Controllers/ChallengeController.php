<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Difficulty;
use Illuminate\Http\Request;
use App\Models\Badge;
use App\Models\ChallengeCompletion;

class ChallengeController extends Controller
{
//    public function index()
//    {
//        $difficulties = Difficulty::all();
//        $challenges = Challenge::with('difficulty')
//            ->filter(request(['search', 'difficulty']))
//            ->get();
//        return view('challenges.all', ['challenges' => $challenges, 'difficulties' => $difficulties]);
//    }


    public function dashboard(Request $request)
    {
        $difficulties = Difficulty::all();
        $user = auth()->user();

        // Query + filter + max 3
        $challenges = Challenge::with('difficulty')
            ->where('published', 1)
            ->filter($request->only('search', 'difficulty'))
            ->latest()
            ->take(3)
            ->get();

        // Badge-IDs ophalen
        $userCompletedChallengeIds = $user
            ? ChallengeCompletion::where('user_id', $user->id)
                ->pluck('challenge_id')
                ->toArray()
            : [];

        foreach ($challenges as $challenge) {
            $challenge->completed = in_array($challenge->id, $userCompletedChallengeIds);
        }


        return view('dashboard', [
            'challenges' => $challenges,
            'difficulties' => $difficulties,
            'search' => $request->input('search'),
        ]);
    }


    public function show(Challenge $challenge)
    {
        if (!$challenge->published) {
            return redirect()
                ->route('dashboard')
                ->with('status', 'Deze challenge is nog niet beschikbaar.');
        }
        $steps = $challenge->steps()
            ->orderBy('step_number')
            ->get();
        $difficulty = Difficulty::where('id', $challenge->difficulty_id)
            ->value('difficulty');

        return view('challenges.show', compact('challenge', 'steps', 'difficulty'));
    }


    public function create()
    {
        $difficulties = Difficulty::all();
        $usedBadgeIds = Challenge::whereNotNull('badge_id')
            ->pluck('badge_id');
        $badges = Badge::whereNotIn('id', $usedBadgeIds)->get();
        $user = auth()->user();
        if (\Auth::user()->is_admin === 1) {
            return view('admin.challenges.create', compact('difficulties', 'badges'));
        } elseif ($user->rank < 3) {
            return redirect()->route('dashboard')->with('error', ' Je bent nog geen Uil rank.');
        }
        return view('user.create', compact('difficulties', 'badges'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1500',
            'difficulty_id' => 'required|exists:difficulties,id',
            'badge_id' => 'required|exists:badges,id',
            'published' => 'boolean',
            'duration' => 'required|date_format:H:i',
            'steps.*' => 'nullable|string|max:200',
            'image' => 'image|max:2048',
        ]);
        $user = auth()->user();

        if ($user->is_admin) {
            $published = true;
        } elseif ($user->rank >= 3) {
            $published = false;
        } else {
            return redirect()
                ->back()
                ->with('error', 'Je hebt niet voldoende rechten om een challenge aan te maken.');
        }
        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('challenge_images', 'public');
        }

// 1. Challenge aanmaken
        $challenge = new Challenge();
        $challenge->title = $validated['title'];
        $challenge->description = $validated['description'];
        $challenge->difficulty_id = $validated['difficulty_id'];
        $challenge->badge_id = $validated['badge_id'] ?? null;
        $challenge->published = $published;
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

    public function allChallenges(Request $request)
    {
        $difficulties = Difficulty::all();
        $user = auth()->user();

        $challenges = Challenge::with('difficulty')
            ->where('published', 1)
            ->filter($request->only('search', 'difficulty'))
            ->get();
        $userCompletedChallengeIds = $user
            ? ChallengeCompletion::where('user_id', $user->id)
                ->pluck('challenge_id')
                ->toArray()
            : [];

        foreach ($challenges as $challenge) {
            $challenge->completed = in_array($challenge->id, $userCompletedChallengeIds);
        }

        return view('challenges.all', [
            'challenges' => $challenges,
            'difficulties' => $difficulties,
            'search' => $request->input('search'),
        ]);
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

        return view('challenges.show', 'dashboard', compact('challenge', 'hasBadge'));
    }

}
