<?php

namespace App\Http\Controllers;

use App\Models\Desarrolladora;
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
    public function index(Request $request)
    {
        $order = $request->query('order', 'desarrolladoras.nombre');
        $order_dir = $request->query('order_dir', 'asc');
        $videojuegos = Auth::user()->videojuegos()
            ->with(['desarrolladora', 'desarrolladora.distribuidora'])
            ->selectRaw('videojuegos.*')
            ->leftJoin('desarrolladoras', 'videojuegos.desarrolladora_id', '=', 'desarrolladoras.id')
            ->leftJoin('distribuidoras', 'desarrolladoras.distribuidora_id', '=', 'distribuidoras.id')
            ->orderBy($order, $order_dir)
            ->get();

        return view('videojuegos.index', [
            'videojuegos' => $videojuegos,
            'order' => $order,
            'order_dir' => $order_dir,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('videojuegos.create', [
            'desarrolladoras' => Desarrolladora::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'titulo' => 'required|max:255',
            'anyo' => 'required|integer',
            'desarrolladora_id' => 'required|exists:desarrolladoras,id',
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
            'desarrolladoras' => Desarrolladora::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Videojuego $videojuego)
    {
        $validated = $request->validate([
            'titulo' => 'required|max:255',
            'anyo' => 'required|digits:4',
            'desarrolladora_id' => 'required|exists:desarrolladoras,id',
        ]);
        $videojuego->titulo = $validated['titulo'];
        $videojuego->anyo = $validated['anyo'];
        $videojuego->desarrolladora_id = $validated['desarrolladora_id'];
        $videojuego->save();
        return redirect()->route('videojuegos.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Videojuego $videojuego)
    {
        $videojuego->usuarios()->detach();
        $videojuego->delete();
        session()->flash('success', 'El videojuego se ha eliminado correctamente.');
        return redirect()->route('videojuegos.index');
    }
}
