<?php
require_once __DIR__ . '/../models/Oferta.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';


// Controlador Oferta
class OfertaController {
    // GET /ofertas >> Obtener todas las ofertas
    public static function index() {
        $ofertas = Oferta::all();
        ResponseHelper::json($ofertas);
    }

    // GET /ofertas/{id} >> Obtener una oferta por su ID
    public static function show($id) {
        $oferta = Oferta::find($id);
        if ($oferta) {
            ResponseHelper::json($oferta);
        } else {
            ResponseHelper::error("Oferta no encontrada", 404);
        }
    }
    // Buscar una oferta por cliente y camiseta
    public static function store() {
        $data = json_decode(file_get_contents("php://input"), true);

        // Validaciones básicas
        if (!isset($data['cliente_id'], $data['camiseta_id'])) {
            ResponseHelper::error("Datos incompletos para crear oferta", 400);
            return;
        }
        // Validar que no exista una oferta para el mismo cliente y camiseta
        $ofertaExistente = Oferta::findByClienteYCamiseta($data['cliente_id'], $data['camiseta_id']);
        if ($ofertaExistente) {
            ResponseHelper::error("Ya existe una oferta para este cliente y camiseta", 409);
            return;
        }
        $nueva = Oferta::create($data);
        ResponseHelper::json($nueva, 201);
    }

    // POST /ofertas >> Crear una nueva oferta
    public static function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if (!isset($data['cliente_id'], $data['camiseta_id'])) {
            ResponseHelper::error("Datos incompletos para actualizar oferta", 400);
            return;
        }

        // Validar existencia de cliente y camiseta
        require_once __DIR__ . '/../models/Cliente.php';
        require_once __DIR__ . '/../models/Camiseta.php';
        $cliente = Cliente::find($data['cliente_id']);
        if (!$cliente) {
            ResponseHelper::error("El cliente no existe", 400);
            return;
        }
        $camiseta = Camiseta::find($data['camiseta_id']);
        if (!$camiseta) {
            ResponseHelper::error("La camiseta no existe", 400);
            return;
        }

        $actualizada = Oferta::update($id, $data);
        if ($actualizada) {
            ResponseHelper::json($actualizada);
        } else {
            ResponseHelper::error("No se pudo actualizar la oferta", 400);
        }
    }

    // DELETE /ofertas/{id} >> Eliminar una oferta por su ID
    public static function destroy($id) {
        $eliminada = Oferta::delete($id);
        if ($eliminada) {
            ResponseHelper::json(["mensaje" => "Oferta eliminada"]);
        } else {
            ResponseHelper::error("No se pudo eliminar la oferta", 400);
        }
    }
}
