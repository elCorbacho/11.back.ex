# Proyecto API Camisetas

## 📁 Estructura del Proyecto (comentada)

```
11.back.ex/
│
├── api/                        # Carpeta para endpoints RESTful (si usas subrutas físicas)
│   ├── camisetas/              # (Opcional) Subcarpeta para endpoints de camisetas
│   ├── clientes/               # (Opcional) Subcarpeta para endpoints de clientes
│   ├── tallas/                 # (Opcional) Subcarpeta para endpoints de tallas
│   ├── ofertas/                # (Opcional) Subcarpeta para endpoints de ofertas
│   └── ...otros recursos
│
├── config/                     # Configuración de la base de datos y otros parámetros
│   └── database.php            # Archivo de conexión a la base de datos
│
├── controllers/                # Controladores de la lógica de negocio para cada recurso
│   ├── CamisetaController.php  # Controlador para camisetas
│   ├── ClienteController.php   # Controlador para clientes
│   ├── TallaController.php     # Controlador para tallas
│   ├── OfertaController.php    # Controlador para ofertas
│   └── ...otros controladores
│
├── models/                     # Modelos de acceso a datos (ORM manual)
│   ├── Camiseta.php            # Modelo de camisetas
│   ├── Cliente.php             # Modelo de clientes
│   ├── Talla.php               # Modelo de tallas
│   ├── Oferta.php              # Modelo de ofertas
│   └── ...otros modelos
│
├── helpers/                    # Funciones auxiliares y utilidades
│   ├── ResponseHelper.php      # Helper para respuestas JSON y manejo de errores
│   ├── TallaHelper.php         # Helper para validaciones de tallas
│   └── ...otros helpers
│
├── routes/                     # Definición de rutas y dispatch principal
│   └── api.php                 # Archivo principal de rutas de la API
│
├── public/                     # Carpeta pública para el punto de entrada de la API
│   └── index.php               # Front controller (entry point)
│
├── sql_base_jesus/             # Scripts SQL para crear y poblar la base de datos
│   └── Script_crea_ddbb_creatablas.sql
│
├── vendor/                     # Dependencias externas (si usas Composer)
│   └── ...dependencias
│
├── .htaccess                   # Configuración de Apache para URLs amigables
├── composer.json               # Configuración de Composer (si aplica)
└── readme.md                   # Este archivo de documentación
```

---

**Explicación de carpetas principales:**

- **api/**: (Opcional) Puedes organizar aquí subrutas físicas si tu estructura lo requiere.
- **config/**: Configuración de la base de datos y otros parámetros globales.
- **controllers/**: Lógica de negocio y manejo de peticiones HTTP para cada recurso.
- **models/**: Acceso a la base de datos y lógica de datos para cada entidad.
- **helpers/**: Funciones auxiliares reutilizables (validaciones, respuestas, etc).
- **routes/**: Archivo principal de rutas y dispatch de la API.
- **public/**: Punto de entrada de la aplicación (index.php).
- **sql_base_jesus/**: Scripts SQL para crear y poblar la base de datos.
- **vendor/**: Dependencias externas instaladas con Composer (si aplica).
- **.htaccess**: Para URLs amigables y redirección a index.php.
- **composer.json**: Archivo de configuración de Composer.
- **readme.md**: Documentación del proyecto.

---

**Recomendación:**  
Mantén esta estructura para facilitar el mantenimiento, escalabilidad y comprensión del proyecto por parte de otros desarrolladores.

---

## 🚀 Cómo Empezar

1. **Clona o copia el proyecto** en la carpeta `htdocs` de XAMPP.
2. **Asegúrate de tener Apache y MySQL activos** desde el panel de XAMPP.
3. **Importa el script SQL** de la carpeta `/sql_base_jesus` para crear las tablas necesarias.
4. Accede a la API desde:  
   `http://localhost/11.back.ex/api/`

---

## 📚 Endpoints Disponibles

Todos los endpoints están bajo el prefijo `/api`.

### Camisetas

| Método | Endpoint                                 | Descripción                                                        |
|--------|------------------------------------------|--------------------------------------------------------------------|
| GET    | `/api/camisetas`                        | Lista todas las camisetas                                          |
| GET    | `/api/camisetas/{id}`                   | Obtiene una camiseta por su ID                                     |
| POST   | `/api/camisetas`                        | Crea una nueva camiseta                                            |
| PUT    | `/api/camisetas/{id}`                   | Actualiza completamente una camiseta                               |
| PATCH  | `/api/camisetas/{id}`                   | Actualiza parcialmente una camiseta                                |
| DELETE | `/api/camisetas/{id}`                   | Elimina una camiseta                                               |
| GET    | `/api/camisetas/{id}/precio-final?cliente_id={id}` | Obtiene el precio final de una camiseta para un cliente específico |

#### Notas para camisetas:
- Para crear o actualizar una camiseta, debes enviar todos los campos obligatorios y un array de tallas por nombre, por ejemplo:  
  `"tallas": ["S", "M", "L"]`
- Solo se aceptan las tallas: **S, M, L, XL, XXL, XXXL**.
- El método PATCH permite actualizar solo los campos que envíes en el body.
- El endpoint `/api/camisetas/{id}/precio-final?cliente_id={id}` calcula el precio final considerando ofertas personalizadas y porcentaje de descuento del cliente.

### Clientes

| Método | Endpoint                  | Descripción                        |
|--------|---------------------------|------------------------------------|
| GET    | `/api/clientes`           | Lista todos los clientes           |
| GET    | `/api/clientes/{id}`      | Obtiene un cliente por su ID       |
| POST   | `/api/clientes`           | Crea un nuevo cliente              |
| PUT    | `/api/clientes/{id}`      | Actualiza un cliente existente     |
| PATCH  | `/api/clientes/{id}`      | Actualiza parcialmente un cliente  |
| DELETE | `/api/clientes/{id}`      | Elimina un cliente (solo si no tiene ofertas asociadas) |

### Tallas

| Método | Endpoint                  | Descripción                        |
|--------|---------------------------|------------------------------------|
| GET    | `/api/tallas`             | Lista todas las tallas             |
| GET    | `/api/tallas/{id}`        | Obtiene una talla por su ID        |
| POST   | `/api/tallas`             | Crea una nueva talla               |
| PUT    | `/api/tallas/{id}`        | Actualiza una talla existente      |
| DELETE | `/api/tallas/{id}`        | Elimina una talla                  |

### Ofertas

| Método | Endpoint                  | Descripción                        |
|--------|---------------------------|------------------------------------|
| GET    | `/api/ofertas`            | Lista todas las ofertas            |
| GET    | `/api/ofertas/{id}`       | Obtiene una oferta por su ID       |
| POST   | `/api/ofertas`            | Crea una nueva oferta              |
| PUT    | `/api/ofertas/{id}`       | Actualiza una oferta existente     |
| DELETE | `/api/ofertas/{id}`       | Elimina una oferta                 |

---

## ℹ️ Notas

- Todas las respuestas están en formato **JSON**.
- Puedes probar los endpoints con [Postman](https://www.postman.com/) o [Insomnia](https://insomnia.rest/).
- Si mueves el proyecto a otra subcarpeta, asegúrate de acceder usando la ruta correcta en el navegador o Postman.
- Si necesitas agregar autenticación o más recursos, puedes extender la estructura fácilmente.
- **No se puede eliminar un cliente si tiene ofertas asociadas a camisetas.**

---

## 👨‍💻 Autor

Desarrollado por [Tu Nombre o Equipo].  
¡Contribuciones y sugerencias son bienvenidas!