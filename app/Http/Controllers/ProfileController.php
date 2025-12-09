<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Badge;
use App\Models\BadgeUser;

// vergeet dit niet

class ProfileController extends Controller
{
    /**
     * Display the user's profile page.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        // Haal ALLEEN badges op die de user heeft
        $badges = $user->badges()->take(4)->get();

        $earnedBadgesCount = BadgeUser::where('user_id', $user->id)->count();
        return view('profile.show', compact('user', 'badges', 'earnedBadgesCount'));
    }

}
