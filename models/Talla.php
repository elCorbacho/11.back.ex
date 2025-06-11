<?php
require_once __DIR__ . '/../config/database.php';

class Talla {
    public static function all() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM tallas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM tallas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO tallas (talla) VALUES (?)");
        $stmt->execute([
            $data['talla']
        ]);
        $data['id'] = $db->lastInsertId();
        return $data;
    }

    public static function update($id, $data) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE tallas SET talla = ? WHERE id = ?");
        $stmt->execute([
            $data['talla'],
            $id
        ]);
        return $stmt->rowCount() > 0 ? self::find($id) : null;
    }

    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM tallas WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
