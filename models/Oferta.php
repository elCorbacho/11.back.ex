<?php
require_once __DIR__ . '/../config/database.php';

class Oferta {
    // Modelo Oferta
    // Este modelo interactúa con la base de datos para realizar operaciones CRUD sobre ofertas
    // GET /ofertas >> Obtener todas las ofertas
    public static function all() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM ofertas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET /ofertas/{id} >> Obtener una oferta por su ID
    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM ofertas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Buscar una oferta por cliente y camiseta
    public static function findByClienteYCamiseta($cliente_id, $camiseta_id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM ofertas WHERE cliente_id = ? AND camiseta_id = ? LIMIT 1");
        $stmt->execute([$cliente_id, $camiseta_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
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

    // POST /ofertas >> Crear una nueva oferta
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

    // DELETE /ofertas/{id} >> Eliminar una oferta por su ID
    public static function existeOfertaPorCliente($cliente_id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT COUNT(*) as total FROM ofertas WHERE cliente_id = ?");
        $stmt->execute([$cliente_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row && $row['total'] > 0;
    }
}
