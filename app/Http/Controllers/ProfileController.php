<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Badge;

// vergeet dit niet

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function show(Request $request): View
    {
        $user = $request->user();

        // Haal alle badges op
        $badges = Badge::all();
        $badges = Badge::latest()->take(3)->get();


        // Bereken progressie naar volgende rank (dummy voor nu)
        $progress = $user->progress ?? 0;

        return view('profile.show', [
            'user' => $user,
            'badges' => $badges,
            'rankname' => $user->rankname ?? 'Onbekend',
            'rankimage' => $user->rankimage ?? '/img/default-rank.png',
            'rank_progress' => $user->rank_progress ?? 0,
        ]);
    }
}
