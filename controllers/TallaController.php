<?php
require_once __DIR__ . '/../models/Talla.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

// metodo 
class TallaController {
    // GET /tallas >> Obtener todas las tallas
    public static function index() {
        $tallas = Talla::all();
        ResponseHelper::json($tallas);
    }

    // GET /tallas/{id} >> Obtener una talla por su ID
    public static function show($id) {
        $talla = Talla::find($id);
        if ($talla) {
            ResponseHelper::json($talla);
        } else {
            ResponseHelper::error("Talla no encontrada", 404);
        }
    }

    // POST /tallas >> Crear una nueva talla
    public static function store() {
        $data = json_decode(file_get_contents("php://input"), true);

        if (empty($data['talla'])) {
            ResponseHelper::error("El campo talla es obligatorio", 400);
            return;
        }
        // Validar que no exista una talla igual (única)
        $tallaExistente = Talla::findByNombre($data['talla']);
        if ($tallaExistente) {
            ResponseHelper::error("La talla ya existe", 409);
            return;
        }
        $nueva = Talla::create($data);
        ResponseHelper::json($nueva, 201);
    }

    // PUT /tallas/{id} >> Actualizar una talla por su ID
    public static function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        // Validar que la talla exista
        if (empty($data['talla'])) {
            ResponseHelper::error("El campo talla es obligatorio", 400);
            return;
        }
        // Validar que no exista una talla igual (única), pero solo si el nombre es diferente al actual
        $tallaActual = Talla::find($id);
        if (!$tallaActual) {
            ResponseHelper::error("Talla no encontrada", 404);
            return;
        }
        if ($tallaActual['talla'] !== $data['talla']) {
            $tallaExistente = Talla::findByNombre($data['talla']);
            if ($tallaExistente) {
                ResponseHelper::error("La talla ya existe", 409);
                return;
            }
        }
        $actualizada = Talla::update($id, $data);
        if ($actualizada) {
            ResponseHelper::json($actualizada);
        } else {
            ResponseHelper::error("No se pudo actualizar la talla", 400);
        }
    }

    // DELETE /tallas/{id} >> Eliminar una talla por su ID
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
