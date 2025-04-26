<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener productos para crear items de pedidos
        $products = Product::all();

        // Crear primer pedido
        $order1 = Order::create([
            'customer_name' => 'Juan Pérez',
            'customer_address' => 'Av. Principal 123, Ciudad',
            'status' => 'pending', // Valor correcto según la migración
            'total' => 0, // Se calculará después
        ]);

        // Crear items para el primer pedido
        $total1 = 0;

        // Agregar laptop
        $product1 = $products->where('name', 'Laptop HP Pavilion')->first();
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product1->id,
            'quantity' => 1,
            'unit_price' => $product1->price,
        ]);
        $total1 += $product1->price * 1;

        // Agregar teclado
        $product3 = $products->where('name', 'Teclado Mecánico RGB')->first();
        OrderItem::create([
            'order_id' => $order1->id,
            'product_id' => $product3->id,
            'quantity' => 2,
            'unit_price' => $product3->price,
        ]);
        $total1 += $product3->price * 2;

        // Actualizar el total del primer pedido
        $order1->update(['total' => $total1]);

        // Crear segundo pedido
        $order2 = Order::create([
            'customer_name' => 'María López',
            'customer_address' => 'Calle Secundaria 456, Ciudad',
            'status' => 'delivered', // Valor correcto según la migración
            'total' => 0, // Se calculará después
        ]);

        // Crear items para el segundo pedido
        $total2 = 0;

        // Agregar monitor
        $product2 = $products->where('name', 'Monitor Samsung')->first();
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product2->id,
            'quantity' => 1,
            'unit_price' => $product2->price,
        ]);
        $total2 += $product2->price * 1;

        // Agregar mouse
        $product4 = $products->where('name', 'Mouse Gaming')->first();
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product4->id,
            'quantity' => 1,
            'unit_price' => $product4->price,
        ]);
        $total2 += $product4->price * 1;

        // Agregar auriculares
        $product5 = $products->where('name', 'Auriculares Bluetooth')->first();
        OrderItem::create([
            'order_id' => $order2->id,
            'product_id' => $product5->id,
            'quantity' => 1,
            'unit_price' => $product5->price,
        ]);
        $total2 += $product5->price * 1;

        // Actualizar el total del segundo pedido
        $order2->update(['total' => $total2]);
    }
}
