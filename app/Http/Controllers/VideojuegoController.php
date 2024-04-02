<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Videojuego;

class VideojuegoController extends Controller
{
    /**
     * Create a new controller instance.
     *
     */
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('videojuegos.index', [
            'videojuegos' => Videojuego::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('videojuegos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|max:255',
            'anyo' => 'required|integer',
            'desarrolladora_id' => 'required|integer',
        ]);

        $videojuego = new Videojuego();
        $videojuego->titulo = $validated['titulo'];
        $videojuego->anyo = $validated['anyo'];
        $videojuego->desarrolladora_id = $validated['desarrolladora_id'];
        $videojuego->save();
        session()->flash('success', 'El videojuego se ha creado correctamente.');
        return redirect()->route('videojuegos.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Videojuego $videojuego)
    {
        return view('videojuegos.show', [
            'videojuegos' => $videojuego,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Videojuego $videojuego)
    {
        return view('videojuegos.edit', [
            'videojuego' => $videojuego,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Videojuego $videojuego)
    {
        $validated = $request->validate([
            'titulo' => 'required|max:255',
            'anyo' => 'required|integer',
        ]);

        $videojuego->titulo = $validated['titulo'];
        $videojuego->anyo = $validated['anyo'];
        $videojuego->save();
        session()->flash('success', 'El videojuego se ha creado correctamente.');
        return redirect()->route('videojuegos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Videojuego $videojuego)
    {
        $videojuego->delete();
        session()->flash('success', 'El videojuego se ha eliminado correctamente.');
        return redirect()->route('videojuegos.index');
    }
}
