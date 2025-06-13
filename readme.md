# Proyecto API Camisetas

API RESTful para la gestión de camisetas, clientes, tallas y ofertas. Pensada para evaluación backend IPSS CIISA 06-2025.

## 📁 Estructura del Proyecto

```
11.back.ex/
│
├── config/                     # Configuración de la base de datos
│   └── database.php            # Archivo de conexión PDO
│
├── controllers/                # Lógica de negocio para cada recurso
│   ├── CamisetaController.php  # Camisetas
│   ├── ClienteController.php   # Clientes
│   ├── TallaController.php     # Tallas
│   ├── OfertaController.php    # Ofertas
│
├── models/                     # Modelos de acceso a datos (ORM manual)
│   ├── Camiseta.php            # Modelo camisetas
│   ├── Cliente.php             # Modelo clientes
│   ├── Talla.php               # Modelo tallas
│   ├── Oferta.php              # Modelo ofertas
│
├── helpers/                    # Funciones auxiliares
│   ├── ResponseHelper.php      # Helper para respuestas JSON y errores
│   ├── TallaHelper.php         # Validaciones de tallas
│
├── routes/                     # Definición de rutas y dispatch principal
│   └── api.php                 # Archivo principal de rutas de la API
│
├── swagger.json                # Documentación OpenAPI/Swagger de la API
│
├── swagger-ui/                 # Interfaz visual para probar la API (Swagger UI)
│   ├── index.html              # Frontend Swagger UI
│   └── ...archivos estáticos
│
├── sql_tablas_poblar/             # Scripts SQL para crear y poblar la base de datos
│   └── Script_crea_ddbb_creatablas.sql
│   └── Script_Poblado_todocamisetas.sql
│
├── index.php                   # Front controller (entry point)
├── readme.md                   # Este archivo
```

## 📝 Notas importantes

- **Tallas**: Siempre se manejan por ID (array de enteros), tanto en entrada como en salida.
- **Ofertas**: Solo tiene los campos `id`, `cliente_id`, `camiseta_id`. No existe el campo `precio_oferta`.
- **Descuentos**: El endpoint `/camisetas/{id}/precio-final?cliente_id=...` valida existencia de camiseta y cliente, y aplica descuento solo si el cliente es Preferencial y existe oferta.
- **Validaciones**: No se pueden crear ofertas duplicadas para el mismo cliente y camiseta. Todos los endpoints validan correctamente los datos obligatorios y las relaciones.
- **Documentación**: La documentación OpenAPI/Swagger (`swagger.json`) está alineada con la estructura real de la API.

## 📚 Endpoints disponibles

### Camisetas
- `GET    /camisetas`                        → Lista todas las camisetas
- `GET    /camisetas/{id}`                   → Obtiene una camiseta por su ID
- `POST   /camisetas`                        → Crea una nueva camiseta
- `PUT    /camisetas/{id}`                   → Actualiza completamente una camiseta
- `PATCH  /camisetas/{id}`                   → Actualiza parcialmente una camiseta
- `DELETE /camisetas/{id}`                   → Elimina una camiseta
- `GET    /camisetas/{id}/precio-final?cliente_id={id}` → Obtiene el precio final de una camiseta para un cliente específico

### Clientes
- `GET    /clientes`                         → Lista todos los clientes
- `GET    /clientes/{id}`                    → Obtiene un cliente por su ID
- `POST   /clientes`                         → Crea un nuevo cliente
- `PUT    /clientes/{id}`                    → Actualiza un cliente existente
- `PATCH  /clientes/{id}`                    → Actualiza parcialmente un cliente
- `DELETE /clientes/{id}`                    → Elimina un cliente (solo si no tiene ofertas asociadas)

### Tallas
- `GET    /tallas`                           → Lista todas las tallas
- `GET    /tallas/{id}`                      → Obtiene una talla por su ID
- `POST   /tallas`                           → Crea una nueva talla
- `PUT    /tallas/{id}`                      → Actualiza una talla existente
- `DELETE /tallas/{id}`                      → Elimina una talla

### Ofertas
- `GET    /ofertas`                          → Lista todas las ofertas
- `GET    /ofertas/{id}`                     → Obtiene una oferta por su ID
- `POST   /ofertas`                          → Crea una nueva oferta
- `PUT    /ofertas/{id}`                     → Actualiza una oferta existente
- `DELETE /ofertas/{id}`                     → Elimina una oferta

## 📦 Ejemplo de request/response

### Crear camiseta (POST /camisetas)
```json
{
  "titulo": "Camiseta Oficial Uruguay 2024",
  "club": "Uruguay",
  "pais": "Uruguay",
  "tipo": "Oficial",
  "color": "Celeste",
  "precio": 79.00,
  "detalles": "Edición Copa América 2024",
  "codigo_producto": "URU-2024",
  "tallas": [1, 2, 3]
}
```

### Respuesta ejemplo
```json
{
  "id": 1,
  "titulo": "Camiseta Oficial Uruguay 2024",
  "club": "Uruguay",
  "pais": "Uruguay",
  "tipo": "Oficial",
  "color": "Celeste",
  "precio": 79.00,
  "detalles": "Edición Copa América 2024",
  "codigo_producto": "URU-2024",
  "tallas": [1, 2, 3]
}
```

### Precio final (GET /camisetas/{id}/precio-final?cliente_id=...)
```json
{
  "id_camiseta": 1,
  "titulo": "Camiseta Oficial Uruguay 2024",
  "club": "Uruguay",
  "tallas_disponibles": [1, 2, 3],
  "tipo": "Oficial",
  "color": "Celeste",
  "PRECIO_INICIAL": 79.00,
  "id_cliente": 1,
  "categoria_cliente": "Preferencial",
  "PRECIO_FINAL": 75.05,
  "existe_oferta": true,
  "PORCENTAJE_DESCUENTO_CLIENTE": 5.00
}
```

## 🚀 Cómo probar la API

1. Importa el archivo `swagger.json` en [Swagger Editor](https://editor.swagger.io/) o abre `swagger-ui/index.html` en tu navegador.
2. Usa Postman, Insomnia o curl para probar los endpoints.
3. Consulta los scripts SQL en `sql_tablas_poblar/` para crear y poblar la base de datos.

## 🗄️ Scripts SQL: creación y poblamiento de la base de datos

Los scripts SQL necesarios para crear y poblar la base de datos se encuentran en la carpeta `sql_tablas_poblar/`.

### 1. Script_crea_ddbb_creatablas.sql
- **Propósito:** Crea la base de datos y todas las tablas necesarias para la API.
- **Tablas creadas:**
  - `clientes`: Almacena los datos de los clientes (id, nombre, rut, categoria).
  - `tallas`: Almacena las tallas disponibles (id, nombre).
  - `camisetas`: Almacena las camisetas (id, titulo, club, pais, tipo, color, precio, detalles, codigo_producto).
  - `camiseta_talla`: Tabla intermedia para la relación muchos a muchos entre camisetas y tallas (camiseta_id, talla_id).
  - `ofertas`: Almacena las ofertas (id, cliente_id, camiseta_id).
- **Relaciones foráneas:**
  - `camiseta_talla.camiseta_id` → `camisetas.id`
  - `camiseta_talla.talla_id` → `tallas.id`
  - `ofertas.cliente_id` → `clientes.id`
  - `ofertas.camiseta_id` → `camisetas.id`
- **Cómo usarlo:**
  1. Abre tu gestor de base de datos (por ejemplo, phpMyAdmin o consola MySQL).
  2. Ejecuta el script `Script_crea_ddbb_creatablas.sql` para crear la base de datos y las tablas.

### 2. Script_Poblado_todocamisetas.sql
- **Propósito:** Inserta datos de ejemplo en todas las tablas para pruebas y desarrollo.
- **Contenido:**
  - Inserta clientes de ejemplo.
  - Inserta tallas estándar.
  - Inserta camisetas de ejemplo.
  - Inserta relaciones entre camisetas y tallas.
  - Inserta ofertas de ejemplo.
- **Cómo usarlo:**
  1. Una vez creadas las tablas, ejecuta el script `Script_Poblado_todocamisetas.sql` para poblar la base de datos con datos de prueba.

### 3. Scripts adicionales (opcional)
- En la carpeta `sql_testing_adicional/` puedes encontrar scripts para pruebas automatizadas o datos alternativos.

**Recomendación:** Ejecuta primero el script de creación de tablas y luego el de poblamiento. Si necesitas reiniciar la base de datos, puedes borrar todas las tablas y volver a ejecutar ambos scripts en orden.

---

Desarrollado para fines académicos. Si tienes dudas o sugerencias, revisa la documentación o contacta al autor.




