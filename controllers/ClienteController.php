<?php
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class ClienteController {
    public static function index() {
        $clientes = Cliente::all();
        ResponseHelper::json($clientes);
    }

    public static function show($id) {
        $cliente = Cliente::find($id);
        if ($cliente) {
            ResponseHelper::json($cliente);
        } else {
            ResponseHelper::error("Cliente no encontrado", 404);
        }
    }

    public static function store() {
        $data = json_decode(file_get_contents("php://input"), true);

        // Validación simple campos obligatorios
        $required = ['nombre_comercial', 'rut'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                ResponseHelper::error("Campo obligatorio: $field", 400);
                return;
            }
        }

        $nuevo = Cliente::create($data);
        ResponseHelper::json($nuevo, 201);
    }

    public static function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);
        $actualizado = Cliente::update($id, $data);
        if ($actualizado) {
            ResponseHelper::json($actualizado);
        } else {
            ResponseHelper::error("No se pudo actualizar el cliente", 400);
        }
    }

    public static function destroy($id) {
        $eliminado = Cliente::delete($id);
        if ($eliminado) {
            ResponseHelper::json(["mensaje" => "Cliente eliminado"]);
        } else {
            ResponseHelper::error("No se pudo eliminar el cliente", 400);
        }
    }
}
