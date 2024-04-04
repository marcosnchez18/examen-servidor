<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Videojuego;
use Illuminate\Support\Facades\Auth;

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
        $id_usuario_log = Auth::id();

        $videojuegos = Videojuego::whereHas('usuarios', function($query) use ($id_usuario_log) {
            $query->where('user_id', $id_usuario_log);
        })->get();

        return view('videojuegos.index', [
            'videojuegos' => $videojuegos,
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

        $videojuego->usuarios()->attach(Auth::id());    //id del usuario identificado

        session()->flash('success', 'El videojuego se ha creado correctamente.');
        return redirect()->route('videojuegos.index');

    }

    /**
     * Display the specified resource.
     */
    public function show(Videojuego $videojuego)
    {
        return view('videojuegos.show', [
            'videojuego' => $videojuego,
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
        $videojuego->usuarios()->detach();  //te borra la relación de lo que borras de la tabla posesiones


        $videojuego->delete();
        session()->flash('success', 'El videojuego se ha eliminado correctamente.');
        return redirect()->route('videojuegos.index');
    }
}
