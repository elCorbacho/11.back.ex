<?php
require_once __DIR__ . '/../config/database.php';


// PERMITE MANEJAR CLIENTES
// Permite manejar los clientes en la base de datos
class Cliente {
    // Permite obtener todos los clientes
    // GET /clientes >> Obtener todos los clientes
    public static function all() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM clientes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Permite obtener un cliente por su ID
    // GET /clientes/{id} >> Obtener un cliente por su ID
    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Permite crear un nuevo cliente
    // POST /clientes >> Crear un nuevo cliente
    public static function create($data) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO clientes (nombre_comercial, rut, direccion, categoria, contacto_nombre, contacto_email, porcentaje_oferta) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['nombre_comercial'],
            $data['rut'],
            $data['direccion'],
            $data['categoria'],
            $data['contacto_nombre'],
            $data['contacto_email'],
            $data['porcentaje_oferta']
        ]);
        $data['id'] = $db->lastInsertId();
        return $data;
    }

    // Permite actualizar un cliente existente
    // PUT /clientes/{id} >> Actualizar un cliente existente
    public static function update($id, $data) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE clientes SET nombre_comercial = ?, rut = ?, direccion = ?, categoria = ?, contacto_nombre = ?, contacto_email = ?, porcentaje_oferta = ? WHERE id = ?");
        $stmt->execute([
            $data['nombre_comercial'],
            $data['rut'],
            $data['direccion'],
            $data['categoria'],
            $data['contacto_nombre'],
            $data['contacto_email'],
            $data['porcentaje_oferta'],
            $id
        ]);
        return $stmt->rowCount() > 0 ? self::find($id) : null;
    }

    // Permite actualizar parcialmente un cliente
    // PATCH /clientes/{id} >> Actualizar parcialmente un cliente
    public static function patch($id, $data) {
        $db = Database::connect();
        $camposValidos = [
            'nombre_comercial',
            'rut',
            'direccion',
            'categoria',
            'contacto_nombre',
            'contacto_email',
            'porcentaje_oferta'
        ];
        $set = [];
        $params = [];
        foreach ($camposValidos as $campo) {
            if (array_key_exists($campo, $data)) {
                $set[] = "$campo = ?";
                $params[] = $data[$campo];
            }
        }
        if (empty($set)) {
            return null; // Nada para actualizar
        }
        $params[] = $id;
        $sql = "UPDATE clientes SET " . implode(', ', $set) . " WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($params);
        return $stmt->rowCount() > 0 ? self::find($id) : null;
    }

    // Permite eliminar un cliente
    // DELETE /clientes/{id} >> Eliminar un cliente por su ID
    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM clientes WHERE id = ?");
        return $stmt->execute([$id]);
    }


    //===================================================================
    //GET CAMISETA Y PRECIO FINAL SEGUN CLIENTE Y DESCUENTO
    //===================================================================
    public static function findByIdentificador($identificador) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM clientes WHERE nombre_comercial = ?");
        $stmt->execute([$identificador]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
