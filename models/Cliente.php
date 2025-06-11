<?php
require_once __DIR__ . '/../config/database.php';

class Cliente {
    public static function all() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM clientes");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM clientes WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

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

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM clientes WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
