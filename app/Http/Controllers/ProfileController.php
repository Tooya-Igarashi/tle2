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
        $owned = $user->badges()->count();

        // -------------------------
        // 1. BEPAAL DE RANK
        // -------------------------
        if ($owned >= 12) {
            $user->rank = 3;
            $user->rankname = 'Uil';
        } elseif ($owned >= 8) {
            $user->rank = 2;
            $user->rankname = 'Vos';
        } elseif ($owned >= 4) {
            $user->rank = 1;
            $user->rankname = 'Bloem';
        } else {
            $user->rank = 0;
            $user->rankname = 'Bever';
        }

        // Rank opslaan in de database
        $user->save();

        // -------------------------
        // 2. PROGRESSIE PER RANK
        // -------------------------
        if ($user->rank == 0) {
            $rankStart = 0;
            $rankEnd = 4;
            $rankImage = '/images/badges/bever.png';
            $rankName = 'bever';
        } elseif ($user->rank == 1) {
            $rankStart = 4;
            $rankEnd = 8;
            $rankImage = '/images/badges/bloem.png';
            $rankName = 'Bloem';
        } elseif ($user->rank == 2) {
            $rankStart = 8;
            $rankEnd = 12;
            $rankImage = '/images/badges/vos.png';
            $rankName = 'vos';
        } else { // Rank 3 — hoogste rank
            $rankStart = 12;
            $rankEnd = 12; // geen hogere rank
            $rankImage = '/images/badges/uil.png';
            $rankName = 'uil';
        }

        // Progressie
        if ($user->rank < 3) {
            $progress = (($owned - $rankStart) / ($rankEnd - $rankStart)) * 100;
            $required = $rankEnd - $owned; // hoeveel nog tot volgende rank
        } else {
            $progress = 100;
            $required = null; // geen volgende rank
        }

        $progress = min(max($progress, 0), 100);

        // -------------------------
        // 3. LAAD BADGES
        // -------------------------
        $badges = $user->badges()->take(4)->get();

        // -------------------------
        // 4. RETURN DATA NAAR VIEW
        // -------------------------
        return view('profile.show', compact(
            'user',
            'badges',
            'owned',
            'progress',
            'rankImage',
            'rankName',
            'required'
        ));
    }
}
