<?php
require_once __DIR__ . '/../models/Talla.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class TallaController {
    public static function index() {
        $tallas = Talla::all();
        ResponseHelper::json($tallas);
    }

    public static function show($id) {
        $talla = Talla::find($id);
        if ($talla) {
            ResponseHelper::json($talla);
        } else {
            ResponseHelper::error("Talla no encontrada", 404);
        }
    }

    public static function store() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['talla'])) {
            ResponseHelper::error("El campo talla es obligatorio", 400);
            return;
        }

        $nueva = Talla::create($data);
        ResponseHelper::json($nueva, 201);
    }

    public static function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['talla'])) {
            ResponseHelper::error("El campo talla es obligatorio", 400);
            return;
        }

        $actualizada = Talla::update($id, $data);
        if ($actualizada) {
            ResponseHelper::json($actualizada);
        } else {
            ResponseHelper::error("No se pudo actualizar la talla", 400);
        }
    }

    public static function destroy($id) {
    $talla = Talla::find($id);
        if (!$talla) {
            ResponseHelper::error("Talla no encontrada", 404);
            return;
        }
        $eliminada = Talla::delete($id);
        if ($eliminada) {
            ResponseHelper::json(["mensaje" => "Talla eliminada"]);
        } else {
            ResponseHelper::error("No se pudo eliminar la talla", 400);
        }
    }
}
