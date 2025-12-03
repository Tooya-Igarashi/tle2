<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Difficulty;
use Illuminate\Http\Request;
use App\Models\Badge;

class BadgeController extends Controller
{
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

}
