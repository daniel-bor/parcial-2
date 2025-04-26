<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtener todos los pedidos con sus ítems
        $orders = Order::with('items')->get();

        return response()->json([
            'status' => 'success',
            'data' => $orders
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validar la información básica del pedido
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_address' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        // Iniciar una transacción para garantizar la integridad de los datos
        return DB::transaction(function () use ($request) {
            $total = 0;

            // Calcular el total del pedido basado en los precios de los productos
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);
                $total += $product->price * $item['quantity'];
            }

            // Crear el pedido
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_address' => $request->customer_address,
                'status' => 'pendiente', // Estado inicial por defecto
                'total' => $total,
            ]);

            // Crear los ítems del pedido
            foreach ($request->items as $item) {
                $product = Product::findOrFail($item['product_id']);

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                ]);
            }

            // Cargar los ítems relacionados para la respuesta
            $order->load('items.product');

            return response()->json([
                'status' => 'success',
                'message' => 'Pedido creado exitosamente',
                'data' => $order
            ], 201);
        });
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Buscar el pedido con sus ítems y productos relacionados
        $order = Order::with('items.product')->find($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $order
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Buscar el pedido
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        // Validar los datos de entrada
        $request->validate([
            'customer_name' => 'sometimes|required|string|max:255',
            'customer_address' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:pendiente,en proceso,completado,cancelado',
        ]);

        // Actualizar el pedido (solo estado o dirección, no los ítems)
        $order->update($request->only(['customer_name', 'customer_address', 'status']));

        return response()->json([
            'status' => 'success',
            'message' => 'Pedido actualizado exitosamente',
            'data' => $order
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Buscar el pedido
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'status' => 'error',
                'message' => 'Pedido no encontrado'
            ], 404);
        }

        // Eliminar el pedido (los ítems se eliminarán en cascada gracias a la migración)
        $order->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Pedido eliminado exitosamente'
        ], 200);
    }
}
