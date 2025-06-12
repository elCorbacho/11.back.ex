<?php
require_once __DIR__ . '/../config/database.php';

class Talla {
    // Modelo Talla
    // Este modelo interactúa con la base de datos para realizar operaciones CRUD sobre tallas
    // GET /tallas >> Obtener todas las tallas
    public static function all() {
        $db = Database::connect();
        $stmt = $db->query("SELECT * FROM tallas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // GET /tallas/{id} >> Obtener una talla por su ID
    public static function find($id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT * FROM tallas WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // POST /tallas >> Crear una nueva talla
    public static function create($data) {
        $db = Database::connect();
        $stmt = $db->prepare("INSERT INTO tallas (talla) VALUES (?)");
        $stmt->execute([
            $data['talla']
        ]);
        $data['id'] = $db->lastInsertId();
        return $data;
    }

    // PUT /tallas/{id} >> Actualizar una talla por su ID
    public static function update($id, $data) {
        $db = Database::connect();
        $stmt = $db->prepare("UPDATE tallas SET talla = ? WHERE id = ?");
        $stmt->execute([
            $data['talla'],
            $id
        ]);
        return $stmt->rowCount() > 0 ? self::find($id) : null;
    }

    // DELETE /tallas/{id} >> Eliminar una talla por su ID
    public static function delete($id) {
    $db = Database::connect();
    $stmt = $db->prepare("DELETE FROM tallas WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->rowCount() > 0;
}


    //====================================================================
    //GET CAMISETA Y PRECIO FINAL SEGUN CLIENTE Y DESCUENTO
    //===================================================================
    public static function findByCamisetaId($camiseta_id) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT t.id FROM tallas t INNER JOIN camiseta_talla ct ON ct.talla_id = t.id WHERE ct.camiseta_id = ?");
        $stmt->execute([$camiseta_id]);
        return array_map(function($row) { return (int)$row['id']; }, $stmt->fetchAll(PDO::FETCH_ASSOC));
    }



}
