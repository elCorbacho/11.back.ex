<?php
require_once __DIR__ . '/../config/database.php';

class Camiseta {
    public static function all() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM camisetas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM camisetas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO camisetas (titulo, club, pais, tipo, color, precio, detalles, codigo_producto) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['titulo'],
            $data['club'],
            $data['pais'],
            $data['tipo'],
            $data['color'],
            $data['precio'],
            $data['detalles'],
            $data['codigo_producto']
        ]);
        $data['id'] = $db->lastInsertId();
        return $data;
    }

    public static function update($id, $data) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE camisetas SET titulo = ?, club = ?, pais = ?, tipo = ?, color = ?, precio = ?, detalles = ?, codigo_producto = ? WHERE id = ?");
        $stmt->execute([
            $data['titulo'],
            $data['club'],
            $data['pais'],
            $data['tipo'],
            $data['color'],
            $data['precio'],
            $data['detalles'],
            $data['codigo_producto'],
            $id
        ]);
        return $stmt->rowCount() > 0 ? self::find($id) : null;
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM camisetas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
