# Plan de Desarrollo - Plataforma de Gestión de Pedidos

Este documento detalla el plan paso a paso para desarrollar la plataforma de gestión de pedidos según las especificaciones del design-doc.md.

## Fase 1: Configuración del Proyecto

- [x] **Tarea 1.1**: Verificar la configuración de SQLite en el archivo `.env`
  ```
  DB_CONNECTION=sqlite
  DB_DATABASE=/absolute/path/to/database/database.sqlite
  ```
- [x] **Tarea 1.2**: Crear el archivo database.sqlite vacío en la carpeta database
  ```bash
  touch database/database.sqlite
  ```
- [x] **Tarea 1.3**: Verificar conexión a la base de datos
  ```bash
  php artisan tinker
  DB::connection()->getPdo();
  ```

## Fase 2: Migraciones de Base de Datos

- [x] **Tarea 2.1**: Crear migración para la tabla `products`
  ```bash
  php artisan make:migration create_products_table
  ```
- [x] **Tarea 2.2**: Implementar la estructura de la tabla `products` según el diseño
- [x] **Tarea 2.3**: Crear migración para la tabla `orders`
  ```bash
  php artisan make:migration create_orders_table
  ```
- [x] **Tarea 2.4**: Implementar la estructura de la tabla `orders` según el diseño
- [x] **Tarea 2.5**: Crear migración para la tabla `order_items`
  ```bash
  php artisan make:migration create_order_items_table
  ```
- [x] **Tarea 2.6**: Implementar la estructura de la tabla `order_items` según el diseño
- [x] **Tarea 2.7**: Ejecutar las migraciones
  ```bash
  php artisan migrate
  ```

## Fase 3: Creación de Modelos Eloquent

- [x] **Tarea 3.1**: Crear el modelo `Product`
  ```bash
  php artisan make:model Product
  ```
- [x] **Tarea 3.2**: Implementar atributos y relaciones del modelo `Product`
- [x] **Tarea 3.3**: Crear el modelo `Order`
  ```bash
  php artisan make:model Order
  ```
- [x] **Tarea 3.4**: Implementar atributos y relaciones del modelo `Order`
- [x] **Tarea 3.5**: Crear el modelo `OrderItem`
  ```bash
  php artisan make:model OrderItem
  ```
- [x] **Tarea 3.6**: Implementar atributos y relaciones del modelo `OrderItem`

## Fase 4: Desarrollo de la API para Productos

- [x] **Tarea 4.1**: Crear el controlador para productos
  ```bash
  php artisan make:controller API/ProductController --api
  ```
- [x] **Tarea 4.2**: Implementar método `index()` para listar productos
- [x] **Tarea 4.3**: Implementar método `show($id)` para mostrar un producto
- [x] **Tarea 4.4**: Implementar método `store(Request $request)` para crear productos
- [x] **Tarea 4.5**: Implementar método `update(Request $request, $id)` para actualizar productos
- [x] **Tarea 4.6**: Implementar método `destroy($id)` para eliminar productos
- [x] **Tarea 4.7**: Configurar las rutas para el controlador de productos en `routes/api.php`

## Fase 5: Desarrollo de la API para Pedidos

- [x] **Tarea 5.1**: Crear el controlador para pedidos
  ```bash
  php artisan make:controller API/OrderController --api
  ```
- [x] **Tarea 5.2**: Implementar método `index()` para listar pedidos con sus ítems
- [x] **Tarea 5.3**: Implementar método `show($id)` para mostrar un pedido con sus ítems y datos de producto
- [x] **Tarea 5.4**: Implementar método `store(Request $request)` para crear pedidos
  - Validar datos de entrada
  - Calcular total de pedido basado en precios unitarios y cantidades
  - Crear registro de pedido y sus ítems
- [x] **Tarea 5.5**: Implementar método `update(Request $request, $id)` para actualizar estado o dirección
- [x] **Tarea 5.6**: Implementar método `destroy($id)` para eliminar pedidos (y sus ítems en cascada)
- [x] **Tarea 5.7**: Configurar las rutas para el controlador de pedidos en `routes/api.php`

## Fase 6: Pruebas Manuales de la API

- [ ] **Tarea 6.1**: Crear datos de prueba con seeders o Tinker
  ```bash
  php artisan make:seeder ProductSeeder
  php artisan make:seeder OrderSeeder
  ```
- [ ] **Tarea 6.2**: Ejecutar los seeders
  ```bash
  php artisan db:seed
  ```
- [ ] **Tarea 6.3**: Probar el endpoint GET `/api/products`
- [ ] **Tarea 6.4**: Probar el endpoint POST `/api/products`
- [ ] **Tarea 6.5**: Probar el endpoint GET `/api/products/{id}`
- [ ] **Tarea 6.6**: Probar el endpoint PUT `/api/products/{id}`
- [ ] **Tarea 6.7**: Probar el endpoint DELETE `/api/products/{id}`
- [ ] **Tarea 6.8**: Probar el endpoint GET `/api/orders`
- [ ] **Tarea 6.9**: Probar el endpoint POST `/api/orders`
- [ ] **Tarea 6.10**: Probar el endpoint GET `/api/orders/{id}`
- [ ] **Tarea 6.11**: Probar el endpoint PUT `/api/orders/{id}`
- [ ] **Tarea 6.12**: Probar el endpoint DELETE `/api/orders/{id}`

## Fase 7: Documentación y Finalización

- [ ] **Tarea 7.1**: Documentar los endpoints de la API con comentarios o README
- [ ] **Tarea 7.2**: Revisar y optimizar el código existente
- [ ] **Tarea 7.3**: Verificar el manejo de errores y validaciones
- [ ] **Tarea 7.4**: Asegurar que se cumplan todos los requisitos del documento de diseño

## Notas adicionales:

- El proyecto no requiere autenticación según el diseño
- Todas las respuestas de la API deben seguir un formato JSON consistente
- Cada tarea debe ser verificada al completarse para mantener la integridad del proyecto
- Las relaciones entre modelos deben garantizar que las eliminaciones en cascada funcionen correctamente
