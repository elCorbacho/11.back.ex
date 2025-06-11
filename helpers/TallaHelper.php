<?php
class TallaHelper {
    public static function getIdByNombre($nombre) {
        $db = Database::connect();
        $stmt = $db->prepare("SELECT id FROM tallas WHERE talla = ?");
        $stmt->execute([$nombre]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? (int)$row['id'] : null;
    }

    public static function esTallaValida($talla) {
        $validas = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
        return in_array($talla, $validas, true);
    }
}