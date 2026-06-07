<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()  //En esta parte me guie del ejemplo que mando para la clases
    {
        return response()->json(Producto::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $request->validate([
        'nombre' => 'required|max:100',
        'precio' => 'required',
        'stock' => 'required'
        ]);

        $producto = Producto::create($request->all());

        return response()->json([
            'message' => 'Producto registrado correctamente',
            'data' => $producto
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
