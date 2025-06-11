<?php
require_once __DIR__ . '/../config/database.php';


// Modelo Camiseta
// Este modelo interactúa con la base de datos para realizar operaciones CRUD sobre camisetas
class Camiseta {

    // GET /camisetas >> Obtener todas las camisetas
    public static function all() {
        $db = Database::connect();
        $stmt = $db->query("
            SELECT c.*, 
                   GROUP_CONCAT(t.talla ORDER BY t.talla) AS tallas
            FROM camisetas c
            LEFT JOIN camiseta_talla ct ON c.id = ct.camiseta_id
            LEFT JOIN tallas t ON ct.talla_id = t.id
            GROUP BY c.id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET /camisetas/{id} >> Obtener una camiseta por su ID
    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("
            SELECT c.*, 
                   GROUP_CONCAT(t.talla ORDER BY t.talla) AS tallas
            FROM camisetas c
            LEFT JOIN camiseta_talla ct ON c.id = ct.camiseta_id
            LEFT JOIN tallas t ON ct.talla_id = t.id
            WHERE c.id = ?
            GROUP BY c.id
        ");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // POST /camisetas >> Crear una nueva camiseta 
    public static function create($data) {
        $db = Database::connect();
        $db->beginTransaction();

        // Insertar la camiseta
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
        $camiseta_id = $db->lastInsertId();

        // Insertar tallas en la tabla intermedia
        if (!empty($data['tallas']) && is_array($data['tallas'])) {
            $stmtTalla = $db->prepare("INSERT INTO camiseta_talla (camiseta_id, talla_id) VALUES (?, ?)");
            foreach ($data['tallas'] as $talla_id) {
                $stmtTalla->execute([$camiseta_id, $talla_id]);
            }
        }

        $db->commit();
        return self::find($camiseta_id);
    }

    // PUT /camisetas/{id} >> Actualizar una camiseta por su ID
    public static function update($id, $data) {
        $db = Database::connect();
        $db->beginTransaction();

        // Actualizar datos de la camiseta
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

        // Actualizar tallas: eliminar las actuales y agregar las nuevas
        if (isset($data['tallas']) && is_array($data['tallas'])) {
            // Eliminar tallas actuales
            $stmtDel = $db->prepare("DELETE FROM camiseta_talla WHERE camiseta_id = ?");
            $stmtDel->execute([$id]);
            // Insertar nuevas tallas
            $stmtTalla = $db->prepare("INSERT INTO camiseta_talla (camiseta_id, talla_id) VALUES (?, ?)");
            foreach ($data['tallas'] as $talla_id) {
                $stmtTalla->execute([$id, $talla_id]);
            }
        }

        $db->commit();
        return self::find($id);
    }

    // DELETE /camisetas/{id} >> Eliminar una camiseta por su ID
    public static function delete($id) {
        $db = Database::connect();
        $stmt = $db->prepare("DELETE FROM camisetas WHERE id = ?");
        return $stmt->execute([$id]);
    }

    // GET /camisetas/codigo_producto/{codigo} >> Obtener una camiseta por su código de producto
    public static function findByCodigoProducto($codigo) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM camisetas WHERE codigo_producto = ?");
        $stmt->execute([$codigo]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
