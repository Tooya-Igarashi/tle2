<?php

namespace App\Http\Controllers;

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

        // Badges die de gebruiker nog niet heeft
        $badges = Badge::whereNotIn('id', $userBadgeIds)->get();
        $nogNietGehaald = $badges->count();
        $earnedBadgesCount = BadgeUser::where('user_id', $user->id)->count();
        $totalebadges = Badge::count();
        return view('badges.index', compact('BadgeUser', 'badges', 'earnedBadgesCount', 'totalebadges', 'nogNietGehaald'));
    }

}
