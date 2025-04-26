## Sistema de gestion de pedidos
### Examen Parcial 2
### Programacion 3

# Documentación de la API - Sistema de Gestión de Pedidos

Esta documentación detalla los endpoints disponibles en la API REST del sistema de gestión de pedidos, su estructura y cómo utilizarlos.

## Estructura del Proyecto

El sistema está desarrollado en Laravel y utiliza SQLite como base de datos. La estructura principal incluye:

- **Modelos**: `Product`, `Order` y `OrderItem` (ubicados en `app/Models/`)
- **Controladores API**: `ProductController` y `OrderController` (ubicados en `app/Http/Controllers/API/`)
- **Migraciones**: Definición de tablas de base de datos (ubicadas en `database/migrations/`)

## Endpoints API

### Productos

#### Listar todos los productos

- **URL**: `/api/products`
- **Método**: `GET`
- **Respuesta exitosa**:
  ```json
  {
    "status": "success",
    "data": [
      {
        "id": 1,
        "name": "Producto ejemplo",
        "description": "Descripción del producto",
        "price": "19.99",
        "created_at": "2025-04-26T14:30:00.000000Z",
        "updated_at": "2025-04-26T14:30:00.000000Z"
      },
      // ... más productos
    ]
  }
  ```

#### Obtener un producto específico

- **URL**: `/api/products/{id}`
- **Método**: `GET`
- **Parámetros de URL**:
  - `{id}`: ID del producto a consultar
- **Respuesta exitosa**:
  ```json
  {
    "status": "success",
    "data": {
      "id": 1,
      "name": "Producto ejemplo",
      "description": "Descripción del producto",
      "price": "19.99",
      "created_at": "2025-04-26T14:30:00.000000Z",
      "updated_at": "2025-04-26T14:30:00.000000Z"
    }
  }
  ```
- **Respuesta de error (404)**:
  ```json
  {
    "status": "error",
    "message": "Producto no encontrado"
  }
  ```

#### Crear un nuevo producto

- **URL**: `/api/products`
- **Método**: `POST`
- **Cabeceras**:
  - `Content-Type: application/json`
- **Cuerpo de la solicitud**:
  ```json
  {
    "name": "Nuevo producto",
    "description": "Descripción del nuevo producto",
    "price": 29.99
  }
  ```
- **Validaciones**:
  - `name`: Obligatorio, string, máximo 255 caracteres
  - `description`: Obligatorio, string
  - `price`: Obligatorio, numérico, mínimo 0
- **Respuesta exitosa (201)**:
  ```json
  {
    "status": "success",
    "message": "Producto creado exitosamente",
    "data": {
      "id": 2,
      "name": "Nuevo producto",
      "description": "Descripción del nuevo producto",
      "price": "29.99",
      "created_at": "2025-04-26T15:30:00.000000Z",
      "updated_at": "2025-04-26T15:30:00.000000Z"
    }
  }
  ```

#### Actualizar un producto existente

- **URL**: `/api/products/{id}`
- **Método**: `PUT`
- **Parámetros de URL**:
  - `{id}`: ID del producto a actualizar
- **Cabeceras**:
  - `Content-Type: application/json`
- **Cuerpo de la solicitud** (todos los campos son opcionales):
  ```json
  {
    "name": "Producto actualizado",
    "description": "Descripción actualizada",
    "price": 39.99
  }
  ```
- **Validaciones**:
  - `name` (opcional): string, máximo 255 caracteres
  - `description` (opcional): string
  - `price` (opcional): numérico, mínimo 0
- **Respuesta exitosa**:
  ```json
  {
    "status": "success",
    "message": "Producto actualizado exitosamente",
    "data": {
      "id": 1,
      "name": "Producto actualizado",
      "description": "Descripción actualizada",
      "price": "39.99",
      "created_at": "2025-04-26T14:30:00.000000Z",
      "updated_at": "2025-04-26T15:45:00.000000Z"
    }
  }
  ```
- **Respuesta de error (404)**:
  ```json
  {
    "status": "error",
    "message": "Producto no encontrado"
  }
  ```

#### Eliminar un producto

- **URL**: `/api/products/{id}`
- **Método**: `DELETE`
- **Parámetros de URL**:
  - `{id}`: ID del producto a eliminar
- **Respuesta exitosa**:
  ```json
  {
    "status": "success",
    "message": "Producto eliminado exitosamente"
  }
  ```
- **Respuesta de error (404)**:
  ```json
  {
    "status": "error",
    "message": "Producto no encontrado"
  }
  ```

### Pedidos

#### Listar todos los pedidos

- **URL**: `/api/orders`
- **Método**: `GET`
- **Respuesta exitosa**:
  ```json
  {
    "status": "success",
    "data": [
      {
        "id": 1,
        "customer_name": "Cliente Ejemplo",
        "customer_address": "Dirección del cliente",
        "status": "pendiente",
        "total": "49.98",
        "created_at": "2025-04-26T16:00:00.000000Z",
        "updated_at": "2025-04-26T16:00:00.000000Z",
        "items": [
          {
            "id": 1,
            "order_id": 1,
            "product_id": 1,
            "quantity": 2,
            "unit_price": "19.99",
            "created_at": "2025-04-26T16:00:00.000000Z",
            "updated_at": "2025-04-26T16:00:00.000000Z"
          },
          {
            "id": 2,
            "order_id": 1,
            "product_id": 2,
            "quantity": 1,
            "unit_price": "10.00",
            "created_at": "2025-04-26T16:00:00.000000Z",
            "updated_at": "2025-04-26T16:00:00.000000Z"
          }
        ]
      },
      // ... más pedidos
    ]
  }
  ```

#### Obtener un pedido específico

- **URL**: `/api/orders/{id}`
- **Método**: `GET`
- **Parámetros de URL**:
  - `{id}`: ID del pedido a consultar
- **Respuesta exitosa**:
  ```json
  {
    "status": "success",
    "data": {
      "id": 1,
      "customer_name": "Cliente Ejemplo",
      "customer_address": "Dirección del cliente",
      "status": "pendiente",
      "total": "49.98",
      "created_at": "2025-04-26T16:00:00.000000Z",
      "updated_at": "2025-04-26T16:00:00.000000Z",
      "items": [
        {
          "id": 1,
          "order_id": 1,
          "product_id": 1,
          "quantity": 2,
          "unit_price": "19.99",
          "created_at": "2025-04-26T16:00:00.000000Z",
          "updated_at": "2025-04-26T16:00:00.000000Z",
          "product": {
            "id": 1,
            "name": "Producto ejemplo",
            "description": "Descripción del producto",
            "price": "19.99",
            "created_at": "2025-04-26T14:30:00.000000Z",
            "updated_at": "2025-04-26T14:30:00.000000Z"
          }
        },
        {
          "id": 2,
          "order_id": 1,
          "product_id": 2,
          "quantity": 1,
          "unit_price": "10.00",
          "created_at": "2025-04-26T16:00:00.000000Z",
          "updated_at": "2025-04-26T16:00:00.000000Z",
          "product": {
            "id": 2,
            "name": "Producto 2",
            "description": "Descripción del producto 2",
            "price": "10.00",
            "created_at": "2025-04-26T15:30:00.000000Z",
            "updated_at": "2025-04-26T15:30:00.000000Z"
          }
        }
      ]
    }
  }
  ```
- **Respuesta de error (404)**:
  ```json
  {
    "status": "error",
    "message": "Pedido no encontrado"
  }
  ```

#### Crear un nuevo pedido

- **URL**: `/api/orders`
- **Método**: `POST`
- **Cabeceras**:
  - `Content-Type: application/json`
- **Cuerpo de la solicitud**:
  ```json
  {
    "customer_name": "Nuevo Cliente",
    "customer_address": "Dirección del nuevo cliente",
    "items": [
      {
        "product_id": 1,
        "quantity": 2
      },
      {
        "product_id": 2,
        "quantity": 3
      }
    ]
  }
  ```
- **Validaciones**:
  - `customer_name`: Obligatorio, string, máximo 255 caracteres
  - `customer_address`: Obligatorio, string
  - `items`: Obligatorio, array con al menos 1 elemento
  - `items.*.product_id`: Obligatorio, debe existir en la tabla de productos
  - `items.*.quantity`: Obligatorio, entero, mínimo 1
- **Respuesta exitosa (201)**:
  ```json
  {
    "status": "success",
    "message": "Pedido creado exitosamente",
    "data": {
      "id": 2,
      "customer_name": "Nuevo Cliente",
      "customer_address": "Dirección del nuevo cliente",
      "status": "pendiente",
      "total": "69.97",
      "created_at": "2025-04-26T17:00:00.000000Z",
      "updated_at": "2025-04-26T17:00:00.000000Z",
      "items": [
        {
          "id": 3,
          "order_id": 2,
          "product_id": 1,
          "quantity": 2,
          "unit_price": "19.99",
          "created_at": "2025-04-26T17:00:00.000000Z",
          "updated_at": "2025-04-26T17:00:00.000000Z",
          "product": {
            "id": 1,
            "name": "Producto ejemplo",
            "description": "Descripción del producto",
            "price": "19.99",
            "created_at": "2025-04-26T14:30:00.000000Z",
            "updated_at": "2025-04-26T14:30:00.000000Z"
          }
        },
        {
          "id": 4,
          "order_id": 2,
          "product_id": 2,
          "quantity": 3,
          "unit_price": "10.00",
          "created_at": "2025-04-26T17:00:00.000000Z",
          "updated_at": "2025-04-26T17:00:00.000000Z",
          "product": {
            "id": 2,
            "name": "Producto 2",
            "description": "Descripción del producto 2",
            "price": "10.00",
            "created_at": "2025-04-26T15:30:00.000000Z",
            "updated_at": "2025-04-26T15:30:00.000000Z"
          }
        }
      ]
    }
  }
  ```

#### Actualizar un pedido existente

- **URL**: `/api/orders/{id}`
- **Método**: `PUT`
- **Parámetros de URL**:
  - `{id}`: ID del pedido a actualizar
- **Cabeceras**:
  - `Content-Type: application/json`
- **Cuerpo de la solicitud** (todos los campos son opcionales):
  ```json
  {
    "customer_name": "Cliente Actualizado",
    "customer_address": "Dirección actualizada",
    "status": "en proceso"
  }
  ```
- **Validaciones**:
  - `customer_name` (opcional): string, máximo 255 caracteres
  - `customer_address` (opcional): string
  - `status` (opcional): string, debe ser uno de: 'pendiente', 'en proceso', 'completado', 'cancelado'
- **Nota**: Este endpoint solo permite actualizar información básica del pedido, no los items.
- **Respuesta exitosa**:
  ```json
  {
    "status": "success",
    "message": "Pedido actualizado exitosamente",
    "data": {
      "id": 1,
      "customer_name": "Cliente Actualizado",
      "customer_address": "Dirección actualizada",
      "status": "en proceso",
      "total": "49.98",
      "created_at": "2025-04-26T16:00:00.000000Z",
      "updated_at": "2025-04-26T17:30:00.000000Z"
    }
  }
  ```
- **Respuesta de error (404)**:
  ```json
  {
    "status": "error",
    "message": "Pedido no encontrado"
  }
  ```

#### Eliminar un pedido

- **URL**: `/api/orders/{id}`
- **Método**: `DELETE`
- **Parámetros de URL**:
  - `{id}`: ID del pedido a eliminar
- **Respuesta exitosa**:
  ```json
  {
    "status": "success",
    "message": "Pedido eliminado exitosamente"
  }
  ```
- **Respuesta de error (404)**:
  ```json
  {
    "status": "error",
    "message": "Pedido no encontrado"
  }
  ```

## Modelo de datos

### Producto (Product)

- **id**: Identificador único (integer, auto-incrementable)
- **name**: Nombre del producto (string, máximo 255 caracteres)
- **description**: Descripción del producto (text)
- **price**: Precio del producto (decimal, 2 decimales)
- **created_at**: Fecha de creación (timestamp)
- **updated_at**: Fecha de última actualización (timestamp)

### Pedido (Order)

- **id**: Identificador único (integer, auto-incrementable)
- **customer_name**: Nombre del cliente (string, máximo 255 caracteres)
- **customer_address**: Dirección del cliente (text)
- **status**: Estado del pedido (string: 'pendiente', 'en proceso', 'completado', 'cancelado')
- **total**: Importe total del pedido (decimal, 2 decimales)
- **created_at**: Fecha de creación (timestamp)
- **updated_at**: Fecha de última actualización (timestamp)

### Item de Pedido (OrderItem)

- **id**: Identificador único (integer, auto-incrementable)
- **order_id**: ID del pedido al que pertenece (foreign key)
- **product_id**: ID del producto asociado (foreign key)
- **quantity**: Cantidad de productos (integer)
- **unit_price**: Precio unitario en el momento de la compra (decimal, 2 decimales)
- **created_at**: Fecha de creación (timestamp)
- **updated_at**: Fecha de última actualización (timestamp)

## Relaciones

1. **Un pedido (Order) tiene muchos items (OrderItem)**: Relación uno a muchos
2. **Un producto (Product) puede estar en muchos items de pedido (OrderItem)**: Relación uno a muchos
3. **Un item de pedido (OrderItem) pertenece a un pedido (Order)**: Relación muchos a uno
4. **Un item de pedido (OrderItem) pertenece a un producto (Product)**: Relación muchos a uno
