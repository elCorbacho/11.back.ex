## 🚀 Cómo Empezar

1. **Clona o copia el proyecto** en la carpeta `htdocs` de XAMPP.
2. **Asegúrate de tener Apache y MySQL activos** desde el panel de XAMPP.
3. Accede a la API desde:  
   `http://localhost/11.back.ex/api/`

---

## 📚 Endpoints Disponibles

Todos los endpoints están bajo el prefijo `/api`.

### Camisetas

| Método | Endpoint                  | Descripción                        |
|--------|---------------------------|------------------------------------|
| GET    | `/api/camisetas`          | Lista todas las camisetas          |
| GET    | `/api/camisetas/{id}`     | Obtiene una camiseta por su ID     |
| POST   | `/api/camisetas`          | Crea una nueva camiseta            |
| PUT    | `/api/camisetas/{id}`     | Actualiza una camiseta existente   |
| DELETE | `/api/camisetas/{id}`     | Elimina una camiseta               |

### Clientes

| Método | Endpoint                  | Descripción                        |
|--------|---------------------------|------------------------------------|
| GET    | `/api/clientes`           | Lista todos los clientes           |
| GET    | `/api/clientes/{id}`      | Obtiene un cliente por su ID       |
| POST   | `/api/clientes`           | Crea un nuevo cliente              |
| PUT    | `/api/clientes/{id}`      | Actualiza un cliente existente     |
| DELETE | `/api/clientes/{id}`      | Elimina un cliente                 |

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

---

## 👨‍💻 Autor

Desarrollado por [Tu Nombre o Equipo].  
¡Contribuciones y sugerencias son bienvenidas!