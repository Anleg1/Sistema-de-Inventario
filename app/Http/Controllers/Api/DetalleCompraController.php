<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DetalleCompra;
use Illuminate\Http\Request;

class DetalleCompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            DetalleCompra::with('compra','producto')->get(),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'compra_id' => 'required|exists:compras,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric|min:0'
        ]);

        $detalle = DetalleCompra::create($request->all());

        return response()->json([
            'message' => 'Detalle de compra registrado correctamente',
            'data' => $detalle
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $detalle = DetalleCompra::with('compra','producto')->find($id);

        if (!$detalle) {
            return response()->json([
                'message' => 'Detalle de compra no encontrado'
            ], 404);
        }

        return response()->json($detalle, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $detalle = DetalleCompra::find($id);

        if(!$detalle){
            return response()->json([
                'message'=>'Detalle no encontrado'
            ],404);
        }

        $request->validate([
            'compra_id' => 'required|exists:compras,id',
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio' => 'required|numeric'
        ]);

        $detalle->update($request->all());

        return response()->json([
            'message'=>'Detalle actualizado correctamente',
            'data'=>$detalle
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $detalle = DetalleCompra::find($id);

        if(!$detalle){
            return response()->json([
                'message'=>'Detalle no encontrado'
            ],404);
        }

        $detalle->delete();

        return response()->json([
            'message'=>'Detalle eliminado correctamente'
        ],200);
    }
}
