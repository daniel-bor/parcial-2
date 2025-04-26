<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Laptop HP Pavilion',
            'description' => 'Laptop HP Pavilion 15.6", Intel Core i7, 16GB RAM, 512GB SSD',
            'price' => 899.99
        ]);

        Product::create([
            'name' => 'Monitor Samsung',
            'description' => 'Monitor Samsung 24" Full HD LED',
            'price' => 149.99
        ]);

        Product::create([
            'name' => 'Teclado Mecánico RGB',
            'description' => 'Teclado mecánico con retroiluminación RGB y switches Blue',
            'price' => 79.99
        ]);

        Product::create([
            'name' => 'Mouse Gaming',
            'description' => 'Mouse Gaming con 6 botones programables y 12000 DPI',
            'price' => 45.99
        ]);

        Product::create([
            'name' => 'Auriculares Bluetooth',
            'description' => 'Auriculares inalámbricos con cancelación de ruido y 20h de batería',
            'price' => 129.99
        ]);
    }
}
