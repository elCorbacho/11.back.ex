<?php
require_once __DIR__ . '/../models/Camiseta.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class CamisetaController {
    public static function index() {
        $camisetas = Camiseta::all();
        ResponseHelper::json($camisetas);
    }

    public static function show($id) {
        $camiseta = Camiseta::find($id);
        if ($camiseta) {
            ResponseHelper::json($camiseta);
        } else {
            ResponseHelper::error("Camiseta no encontrada", 404);
        }
    }

    public static function store() {
        $data = json_decode(file_get_contents("php://input"), true);

        // Validación básica de campos obligatorios
        $required = ['titulo', 'club', 'pais', 'tipo', 'color', 'precio', 'detalles', 'codigo_producto'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                ResponseHelper::error("Campo obligatorio: $field", 400);
                return;
            }
        }

        $nueva = Camiseta::create($data);
        ResponseHelper::json($nueva, 201);
    }

    public static function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $actualizada = Camiseta::update($id, $data);
        if ($actualizada) {
            ResponseHelper::json($actualizada);
        } else {
            ResponseHelper::error("No se pudo actualizar la camiseta", 400);
        }
    }

    public static function destroy($id) {
        $eliminada = Camiseta::delete($id);
        if ($eliminada) {
            ResponseHelper::json(["mensaje" => "Camiseta eliminada"]);
        } else {
            ResponseHelper::error("No se pudo eliminar la camiseta", 400);
        }
    }
}
