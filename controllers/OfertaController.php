<?php
require_once __DIR__ . '/../models/Oferta.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class OfertaController {
    public static function index() {
        $ofertas = Oferta::all();
        ResponseHelper::json($ofertas);
    }

    public static function show($id) {
        $oferta = Oferta::find($id);
        if ($oferta) {
            ResponseHelper::json($oferta);
        } else {
            ResponseHelper::error("Oferta no encontrada", 404);
        }
    }

    public static function store() {
        $data = json_decode(file_get_contents("php://input"), true);

        // Validaciones básicas
        if (!isset($data['cliente_id'], $data['camiseta_id'], $data['precio_oferta'])) {
            ResponseHelper::error("Datos incompletos para crear oferta", 400);
            return;
        }

        $nueva = Oferta::create($data);
        ResponseHelper::json($nueva, 201);
    }

    public static function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['cliente_id'], $data['camiseta_id'], $data['precio_oferta'])) {
            ResponseHelper::error("Datos incompletos para actualizar oferta", 400);
            return;
        }

        $actualizada = Oferta::update($id, $data);
        if ($actualizada) {
            ResponseHelper::json($actualizada);
        } else {
            ResponseHelper::error("No se pudo actualizar la oferta", 400);
        }
    }

    public static function destroy($id) {
        $eliminada = Oferta::delete($id);
        if ($eliminada) {
            ResponseHelper::json(["mensaje" => "Oferta eliminada"]);
        } else {
            ResponseHelper::error("No se pudo eliminar la oferta", 400);
        }
    }
}
