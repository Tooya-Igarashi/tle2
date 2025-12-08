<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Difficulty;
use App\Models\Badge;
use App\Models\BadgeUser;
use Illuminate\Http\Request;

class BadgeController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        // IDs van badges die de gebruiker heeft
        $userBadgeIds = \DB::table('badge_user')
            ->where('user_id', $user->id)
            ->pluck('id_badge');
        // Badges die de gebruiker al heeft
        $BadgeUser = Badge::whereIn('id', $userBadgeIds)->get();
        $badges = Badge::whereNotIn('id', $userBadgeIds)->get();
        $nogNietGehaald = $badges->count();
        $earnedBadgesCount = BadgeUser::where('user_id', $user->id)->count();
        $totalebadges = Badge::count();
        return view('badges.index', compact('BadgeUser', 'badges', 'earnedBadgesCount', 'totalebadges', 'nogNietGehaald'));
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

    public function show(Badge $badge, Request $request)
    {
        $user = $request->user();

        // Check of user deze badge heeft
        $owned = BadgeUser::where('user_id', $user->id)
            ->where('id_badge', $badge->id)
            ->first();

        // Challenge-koppeling (als badge gekoppeld is aan challenge)
        $user = $request->user();

// Alle badges die de user heeft
        $userBadges = $user->badges()->pluck('badges.id')->toArray();

// Alle badges, gesorteerd: eerst verdiend, dan niet-verdiend
        $allBadges = Badge::orderBy('id')->get()->sortBy(function ($b) use ($userBadges) {
            return in_array($b->id, $userBadges) ? 0 : 1;
        })->values(); // reset keys

// Vind de index van de huidige badge
        $currentIndex = $allBadges->search(function ($b) use ($badge) {
            return $b->id === $badge->id;
        });

// Vorige en volgende badge bepalen
        $previousBadge = $currentIndex > 0 ? $allBadges[$currentIndex - 1] : null;
        $nextBadge = $currentIndex < $allBadges->count() - 1 ? $allBadges[$currentIndex + 1] : null;

// Challenge koppeling
        $challenge = Challenge::where('badge_id', $badge->id)->first();

        return view('badges.show', compact('badge', 'owned', 'challenge', 'previousBadge', 'nextBadge'));


    }
}
