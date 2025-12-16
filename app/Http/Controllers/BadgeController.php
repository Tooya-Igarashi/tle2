<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Difficulty;
use App\Models\Badge;
use App\Models\BadgeUser;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\ChallengeCompletion;

class BadgeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $challenges = Challenge::with('badge')
            ->whereNotNull('badge_id')
            ->get();

        $completedChallengeIds = ChallengeCompletion::where('user_id', $user->id)
            ->pluck('challenge_id')
            ->toArray();

        foreach ($challenges as $challenge) {
            $challenge->completed = in_array($challenge->id, $completedChallengeIds);
        }

        $earnedBadges = $challenges
            ->where('completed', true)
            ->pluck('badge')
            ->unique('id')
            ->values();

        $todoBadges = $challenges
            ->where('completed', false)
            ->pluck('badge')
            ->unique('id')
            ->values();

        $earnedBadgesCount = $earnedBadges->count();
        $totalbadges = $todoBadges->count() + $earnedBadgesCount;
        $notyetachieved = $todoBadges->count();

        return view('badges.index', [
            'earnedBadges' => $earnedBadges,
            'todoBadges' => $todoBadges,
            'earnedBadgesCount' => $earnedBadgesCount,
            'totalbadges' => $totalbadges,
            'notyetachieved' => $notyetachieved,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'image' => 'required|image',
        ]);
        $path = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images_badges', 'public');
        }

        // 1. Challenge aanmaken
        $badge = new Badge();
        $badge->name = $validated['name'];
        $badge->description = $validated['description'];
        $badge->image = $path;
        $badge->save();
        return redirect()->route('badges.create')->with('success', 'Badge created!');
    }

    public function create(Request $request)
    {
        return view('admin.badges.create-badge');
    }

    public function show($badgeId, Request $request)
    {
        $user = $request->user();

        // 1️⃣ Alle challenges die een badge hebben
        $challengesWithBadge = Challenge::with('badge')
            ->whereNotNull('badge_id')
            ->get();

        // 2️⃣ Voltooide challenges van de user
        $completedChallengeIds = [];

        if ($user) {
            $completedChallengeIds = ChallengeCompletion::where('user_id', $user->id)
                ->pluck('challenge_id')
                ->toArray();
        }

        // 3️⃣ Markeer challenges als completed
        foreach ($challengesWithBadge as $challenge) {
            $challenge->completed = in_array($challenge->id, $completedChallengeIds);
        }

        // 4️⃣ Alle unieke badges die gekoppeld zijn aan challenges
        $badges = $challengesWithBadge
            ->pluck('badge')
            ->unique('id')
            ->values();

        // 5️⃣ Huidige badge
        $badge = $badges->firstWhere('id', $badgeId);

        abort_if(!$badge, 404);

        // 6️⃣ Challenges van deze badge
        $challenges = $challengesWithBadge
            ->where('badge_id', $badge->id)
            ->values();

        // 7️⃣ Badge is owned als minstens 1 challenge completed is
        $owned = $challenges->contains(fn($c) => $c->completed);

        // 8️⃣ Navigatie (ALLEEN badges met challenges)
        $currentIndex = $badges->search(fn($b) => $b->id === $badge->id);

        $previousBadge = $currentIndex > 0
            ? $badges[$currentIndex - 1]
            : null;

        $nextBadge = $currentIndex < $badges->count() - 1
            ? $badges[$currentIndex + 1]
            : null;

        return view('badges.show', compact(
            'badge',
            'owned',
            'challenges',
            'previousBadge',
            'nextBadge'
        ));
    }
}
