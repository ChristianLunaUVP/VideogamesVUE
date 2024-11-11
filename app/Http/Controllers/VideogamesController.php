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
            'platforms' => 'required|array',
        ]);
    
        $videogame = new Videogames();
        $videogame->name = $request->name;
        $videogame->description = $request->description;
        $videogame->type = $request->type;
        $videogame->genre = $request->genre;
    
        // Verifica que el archivo esté presente y que se haya subido correctamente
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imgName = microtime(true) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('img', $imgName, 'public');
            $videogame->image = '/img/' . $imgName;
        } else {
            return redirect()->back()->withErrors(['image' => 'Image upload failed. Please try again.']);
        }
        $videogame->platforms()->sync($request->platforms);
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

        public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required|max:255',
            'type' => 'required|max:255',
            'genre' => 'required|max:255',
            'id' => 'required|numeric',
            'platforms' => 'required|array',
        ]);

        $videogame = Videogames::find($request->id);

        // Actualizar los campos principales, excluyendo 'image'
        $videogame->update($request->except('image'));

        if ($request->hasFile('image')) {
            // Eliminar la imagen anterior si existe
            if ($videogame->image) {
                Storage::disk('public')->delete($videogame->image);
            }
            // Guardar la nueva imagen
            $imgName = microtime(true) . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('img', $imgName, 'public');
            $videogame->image = '/img/' . $imgName;
            $videogame->save();
        }
        $videogame->platforms()->sync($request->platforms);
        return redirect()->route('videogames.index')->with('success', 'Videogame updated successfully');
    }

}
