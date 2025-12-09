<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $user = $request->user();

        // Tel alle badges van de gebruiker
        $earnedBadgesCount = $user->badges()->count();

        // Bepaal rank automatisch
        if ($earnedBadgesCount >= 12) {
            $user->rank = 3;
        } elseif ($earnedBadgesCount >= 8) {
            $user->rank = 2;
        } elseif ($earnedBadgesCount >= 4) {
            $user->rank = 1;
        } else {
            $user->rank = 0; // nog geen rank
        }

        // Sla de rank op in de database
        $user->save();

        // Haal de badges op
        $badges = $user->badges()->take(4)->get();

        // Bereken progressie per rank
        if ($user->rank == 0) {
            $progress = ($earnedBadgesCount / 4) * 100;
        } elseif ($user->rank == 1) {
            $progress = (($earnedBadgesCount - 4) / 4) * 100;
        } elseif ($user->rank == 2) {
            $progress = (($earnedBadgesCount - 8) / 4) * 100;
        } else { // rank 3
            $progress = 100; // hoogste rank
        }

        $progress = min($progress, 100);

        return view('profile.show', compact('user', 'badges', 'earnedBadgesCount', 'progress'));
    }
}
