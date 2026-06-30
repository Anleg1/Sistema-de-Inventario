<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Compra;
use Illuminate\Http\Request;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(
            Compra::with('proveedor','detalles')->get(),
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'total' => 'required|numeric',
            'proveedor_id' => 'required|exists:proveedores,id'
        ]);

        $compra = Compra::create($request->all());

        return response()->json([
            'message' => 'Compra registrada correctamente',
            'data' => $compra
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $compra = Compra::with('proveedor','detalles')->find($id);

        if (!$compra) {
            return response()->json([
                'message' => 'Compra no encontrada'
            ], 404);
        }

        return response()->json($compra,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $compra = Compra::find($id);

        if (!$compra) {
            return response()->json([
                'message' => 'Compra no encontrada'
            ],404);
        }

        $request->validate([
            'fecha' => 'required|date',
            'total' => 'required|numeric',
            'proveedor_id' => 'required|exists:proveedores,id'
        ]);

        $compra->update($request->all());

        return response()->json([
            'message' => 'Compra actualizada correctamente',
            'data' => $compra
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $compra = Compra::find($id);

        if(!$compra){
            return response()->json([
                'message'=>'Compra no encontrada'
            ],404);
        }

        $compra->delete();

        return response()->json([
            'message'=>'Compra eliminada correctamente'
        ],200);
    }
}
