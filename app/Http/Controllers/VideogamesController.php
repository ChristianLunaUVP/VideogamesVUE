<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Platforms;
use Inertia\Inertia;
use App\Models\Videogames;
use Illuminate\Support\Facades\Storage;

class VideogamesController extends Controller
{ 
    public function index()
    {
        return Inertia::render('Videogames/Index', [
            'videogames' => Videogames::paginate(10)
        ]);
    }
    
    public function create()
    {
        return Inertia::render('Videogames/Create', [
            'platforms' => Platforms::all()
        ]);
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'type' => 'required|max:255',
            'genre' => 'required|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $videogame = new Videogames();
        $videogame->name = $request->name;
        $videogame->description = $request->description;
        $videogame->type = $request->type;
        $videogame->genre = $request->genre;
    
        if ($request->hasFile('image')) {
            $imgName = microtime(true) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('public/img', $imgName);
            $videogame->image = '/img/' . $imgName;
        }
    
        $videogame->save();
    
        return redirect()->route('videogames.index')->with('success', 'Videogame created successfully');
    }
    
    public function show(Videogames $videogame)
    {
        return Inertia::render('Videogames/Show', [
            'videogame' => $videogame,
            'platforms' => $videogame->platforms,
        ]);
    }
    
    public function edit(Videogames $videogame)
    {
        return Inertia::render('Videogames/Edit', [
            'videogame' => $videogame,
            'platformsofvideogame' => $videogame->platforms,
            'platforms' => Platforms::all()
        ]);
    }

    public function update(Request $request, string $videogame)
    {
        //
    }

    public function destroy(Videogames $videogame)
    {
        $videogame->delete();
        return redirect()->route('videogames.index')->with('success', 'Videogame deleted successfully');
    }
}
