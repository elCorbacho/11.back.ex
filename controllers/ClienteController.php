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

        if ($data === null) {
            ResponseHelper::json([
                "error" => "El cuerpo de la petición no es un JSON válido"
            ], 400);
            return;
        }

        // Validación de todos los campos obligatorios
        $required = [
            'nombre_comercial',
            'rut',
            'direccion',
            'categoria',
            'contacto_nombre',
            'contacto_email',
            'porcentaje_oferta'
        ];
        $faltantes = [];
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === '' || $data[$field] === null) {
                $faltantes[] = $field;
            }
        }
        if (!empty($faltantes)) {
            ResponseHelper::json([
                "error" => "Faltan campos obligatorios",
                "faltantes" => $faltantes
            ], 400);
            return;
        }

        // Validar categoría
        if (!in_array($data['categoria'], ['Regular', 'Preferencial'], true)) {
            ResponseHelper::error("La categoría solo puede ser 'Regular' o 'Preferencial'", 400);
            return;
        }

        // Validar que el RUT no esté vacío
        if (!isset($data['rut']) || trim($data['rut']) === '') {
            ResponseHelper::error("El campo 'rut' no puede estar vacío", 400);
            return;
        }

        try {
            $nuevo = Cliente::create($data);
            ResponseHelper::json($nuevo, 201);
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                ResponseHelper::error("El RUT ya existe en la base de datos", 409);
            } else {
                ResponseHelper::error("Error al crear cliente: " . $e->getMessage(), 500);
            }
        }
    }

    public static function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($data === null) {
            ResponseHelper::json([
                "error" => "El cuerpo de la petición no es un JSON válido"
            ], 400);
            return;
        }

        // Validación de todos los campos obligatorios
        $required = [
            'nombre_comercial',
            'rut',
            'direccion',
            'categoria',
            'contacto_nombre',
            'contacto_email',
            'porcentaje_oferta'
        ];
        $faltantes = [];
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === '' || $data[$field] === null) {
                $faltantes[] = $field;
            }
        }
        if (!empty($faltantes)) {
            ResponseHelper::json([
                "error" => "Faltan campos obligatorios",
                "faltantes" => $faltantes
            ], 400);
            return;
        }

        // Validar categoría
        if (!in_array($data['categoria'], ['Regular', 'Preferencial'], true)) {
            ResponseHelper::error("La categoría solo puede ser 'Regular' o 'Preferencial'", 400);
            return;
        }

        // Validar que el RUT no esté vacío
        if (!isset($data['rut']) || trim($data['rut']) === '') {
            ResponseHelper::error("El campo 'rut' no puede estar vacío", 400);
            return;
        }

        try {
            $actualizado = Cliente::update($id, $data);
            if ($actualizado) {
                ResponseHelper::json($actualizado);
            } else {
                ResponseHelper::error("No se pudo actualizar el cliente", 400);
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                ResponseHelper::error("El RUT ya existe en la base de datos", 409);
            } else {
                ResponseHelper::error("Error al actualizar cliente: " . $e->getMessage(), 500);
            }
        }
    }

    public static function patch($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($data === null || !is_array($data)) {
            ResponseHelper::json([
                "error" => "El cuerpo de la petición no es un JSON válido"
            ], 400);
            return;
        }

        // Solo permite campos válidos
        $camposValidos = [
            'nombre_comercial',
            'rut',
            'direccion',
            'categoria',
            'contacto_nombre',
            'contacto_email',
            'porcentaje_oferta'
        ];
        $actualizar = array_intersect_key($data, array_flip($camposValidos));
        if (empty($actualizar)) {
            ResponseHelper::json([
                "error" => "No se enviaron campos válidos para actualizar"
            ], 400);
            return;
        }

        // Validar categoría si viene en el PATCH
        if (isset($data['categoria']) && !in_array($data['categoria'], ['Regular', 'Preferencial'], true)) {
            ResponseHelper::error("La categoría solo puede ser 'Regular' o 'Preferencial'", 400);
            return;
        }

        try {
            $actualizado = Cliente::patch($id, $actualizar);
            if ($actualizado) {
                ResponseHelper::json($actualizado);
            } else {
                ResponseHelper::error("No se pudo actualizar el cliente o no hubo cambios", 400);
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                ResponseHelper::error("El RUT ya existe en la base de datos", 409);
            } else {
                ResponseHelper::error("Error al actualizar cliente: " . $e->getMessage(), 500);
            }
        }
    }

    //=======================================
    // Permite eliminar un cliente y verificar si tiene camisetas asociadas
    // DELETE /clientes/{id} >> Eliminar un cliente
    //=======================================

    public static function destroy($id) {
    $cliente = Cliente::find($id);
    if (!$cliente) {
        ResponseHelper::error("Cliente no encontrado", 404);
        return;
    }

    // Verificar si tiene camisetas asociadas por ofertas
    require_once __DIR__ . '/../models/Oferta.php';
    if (Oferta::existeOfertaPorCliente($id)) {
        ResponseHelper::error("No se puede eliminar el cliente porque tiene ofertas asociadas a camisetas", 400);
        return;
    }

    $eliminado = Cliente::delete($id);
    if ($eliminado) {
        ResponseHelper::json(["mensaje" => "Cliente eliminado exitosamente"]);
    } else {
        ResponseHelper::error("No se pudo eliminar el cliente", 400);
    }
}
}
