# Plataforma de Gestión de Pedidos - Design Doc

Este documento describe la prueba de concepto para una API REST basada en microservicios (Productos y Pedidos) usando Laravel (última versión) con SQLite y Eloquent ORM, sin autenticación.

---

## 1. Visión General

Construir una plataforma simple de gestión de pedidos donde:

- **Clientes**: Pueden consultar productos y crear pedidos.
- **Restaurantes**: Pueden ver y actualizar el estado de los pedidos.
- **Repartidores**: Pueden listar pedidos listos y marcar entregas.

Se implementan dos microservicios lógicos:

1. **Productos**: CRUD de productos.
2. **Pedidos**: Gestión de pedidos y sus ítems.

Todo dentro de un único proyecto Laravel, pero separando rutas, controladores y modelos por bounded context.

---

## 2. Estructura del Proyecto

```text
app/
├── Http/
│   └── Controllers/
│       └── API/
│           ├── ProductController.php
│           └── OrderController.php
├── Models/
│   ├── Product.php
│   ├── Order.php
│   └── OrderItem.php
database/
├── migrations/
│   ├── 2025_04_26_000000_create_products_table.php
│   ├── 2025_04_26_000001_create_orders_table.php
│   └── 2025_04_26_000002_create_order_items_table.php
└── database.sqlite
routes/
└── api.php
```

---

## 3. Base de Datos y Migraciones

### 3.1 Tabla `products`

- `id` (PK)
- `name` (string)
- `description` (text, opcional)
- `price` (decimal)
- `created_at`, `updated_at`

### 3.2 Tabla `orders`

- `id` (PK)
- `customer_name` (string)
- `customer_address` (string)
- `status` (enum: `pending`, `preparing`, `ready`, `delivered`)
- `total` (decimal)
- `created_at`, `updated_at`

### 3.3 Tabla `order_items`

- `id` (PK)
- `order_id` (FK → `orders.id`)
- `product_id` (FK → `products.id`)
- `quantity` (integer)
- `unit_price` (decimal)
- `created_at`, `updated_at`

---

## 4. Modelos (Eloquent)

### 4.1 `Product`

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price'];
}
```

### 4.2 `Order`

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'customer_name',
        'customer_address',
        'status',
        'total'
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
```

### 4.3 `OrderItem`

```php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'unit_price'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
```

---

## 5. Rutas y Endpoints

Definidas en `routes/api.php`.

### 5.1 Microservicio Productos

| Método | Endpoint              | Descripción                      |
|--------|-----------------------|----------------------------------|
| GET    | `/api/products`       | Listar todos los productos       |
| GET    | `/api/products/{id}`  | Obtener un producto por ID       |
| POST   | `/api/products`       | Crear un nuevo producto          |
| PUT    | `/api/products/{id}`  | Actualizar producto existente    |
| DELETE | `/api/products/{id}`  | Eliminar un producto             |

### 5.2 Microservicio Pedidos

| Método | Endpoint             | Descripción                                   |
|--------|----------------------|-----------------------------------------------|
| GET    | `/api/orders`        | Listar todos los pedidos                      |
| GET    | `/api/orders/{id}`   | Ver detalles de un pedido (con ítems)        |
| POST   | `/api/orders`        | Crear nuevo pedido con arreglo de `items[]`   |
| PUT    | `/api/orders/{id}`   | Actualizar estado (`status`) o info de pedido |
| DELETE | `/api/orders/{id}`   | Cancelar pedido (eliminar registro)           |

---

## 6. Controladores y Lógica Básica

### 6.1 `ProductController`

- `index()`: devolver todos los productos.
- `show($id)`: producto por ID.
- `store(Request $r)`: validar `name`, `price`, crear producto.
- `update(Request $r, $id)`: validar, actualizar.
- `destroy($id)`: eliminar.

### 6.2 `OrderController`

- `index()`: devolver pedidos con `items`.
- `show($id)`: pedido con items y datos de producto.
- `store(Request $r)`:
  1. Validar `customer_name`, `customer_address`, `items`.
  2. Calcular subtotal por ítem (`quantity * unit_price`), sumar total.
  3. Crear `Order`, luego `OrderItem` para cada elemento.
  4. Responder con recurso creado y estado `pending`.
- `update(Request $r, $id)`: solo para modificar `status` o `customer_address`.
- `destroy($id)`: eliminar orden y cascada ítems.

---

## 7. Configuración de SQLite

En `.env`:

```dotenv
DB_CONNECTION=sqlite
DB_DATABASE=${PATH_TO_PROJECT}/database/database.sqlite
```

Crear archivo vacío `database/database.sqlite` y ejecutar migraciones:

```bash
php artisan migrate
```
