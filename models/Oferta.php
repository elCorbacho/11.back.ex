<?php
require_once __DIR__ . '/../config/database.php';

class Oferta {
    public static function all() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM ofertas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM ofertas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function create($data) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO ofertas (cliente_id, camiseta_id, precio_oferta) VALUES (?, ?, ?)");
        $stmt->execute([
            $data['cliente_id'],
            $data['camiseta_id'],
            $data['precio_oferta']
        ]);
        return self::find($db->lastInsertId());
    }

    public static function update($id, $data) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE ofertas SET cliente_id = ?, camiseta_id = ?, precio_oferta = ? WHERE id = ?");
        $updated = $stmt->execute([
            $data['cliente_id'],
            $data['camiseta_id'],
            $data['precio_oferta'],
            $id
        ]);
        if ($updated) {
            return self::find($id);
        }
        return false;
    }

    public static function existeOfertaPorCliente($cliente_id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM ofertas WHERE cliente_id = ?");
        $stmt->execute([$cliente_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && $row['total'] > 0;
    }

    public static function delete($id) {
    $db = Database::connect();
    $stmt = $db->prepare("DELETE FROM ofertas WHERE id = ?");
    return $stmt->execute([$id]);
}

}
