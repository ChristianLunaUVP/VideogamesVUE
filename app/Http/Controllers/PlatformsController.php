<?php

namespace App\Http\Controllers;

use App\Models\Platforms;
use App\Models\Videogames;
use Inertia\Inertia;    
use Illuminate\Http\Request;

class PlatformsController extends Controller
{
    public function index()
    {
        $videogames = Videogames::all();
        $platforms = Platforms::with('videogames:name')->get();
        return Inertia::render('Platforms/Index', [
            'platforms' => $platforms,
            'videogames' => $videogames
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:120'
        ]);
        $platforms = new Platforms($request->input());
        $platforms->save();
        return redirect()->route('platforms.index');
    }

    public function show(Platforms $platforms)
    {
        //
    }

    public function edit(Platforms $platforms)
    {
        //
    }

public function update(Request $request, Platforms $platform)
{
    $request->validate([
        'name' => 'required|max:120'
    ]);

    $platform->name = $request->name;
    $platform->save();

    return redirect()->route('platforms.index');
}

    public function destroy(Platforms $platform)
    {
        $platform->delete();
        return redirect()->route('platforms.index');
    }
}