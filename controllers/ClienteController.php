<?php
require_once __DIR__ . '/../models/Cliente.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

class ClienteController {

    //=======================================
    // GET /clientes >> Obtener todos los clientes
    //=======================================
    public static function index() {
        $clientes = Cliente::all();
        ResponseHelper::json($clientes);
    }

    //=======================================
    // GET /clientes/{id} >> Obtener cliente por ID
    //=======================================
    public static function show($id) {
        $cliente = Cliente::find($id);
        if ($cliente) {
            ResponseHelper::json($cliente);
        } else {
            ResponseHelper::error("Cliente no encontrado", 404);
        }
    }

    //=======================================
    // POST /clientes >> Crear cliente
    //=======================================
    public static function store() {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($data === null) {
            ResponseHelper::json(["error" => "El cuerpo de la petición no es un JSON válido"], 400);
            return;
        }

        $errores = self::validarCliente($data);
        if (!empty($errores)) {
            ResponseHelper::json(["errores" => $errores], 400);
            return;
        }

        try {
            $nuevo = Cliente::create($data);
            if ($nuevo) {
                ResponseHelper::json($nuevo, 201);
            } else {
                ResponseHelper::error("No se pudo crear el cliente", 500);
            }
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                ResponseHelper::error("El RUT ya existe en la base de datos", 409);
            } else {
                ResponseHelper::error("Error al crear cliente: " . $e->getMessage(), 500);
            }
        }
    }

    //=======================================
    // PUT /clientes/{id} >> Actualizar cliente
    //=======================================
    public static function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($data === null) {
            ResponseHelper::json(["error" => "El cuerpo de la petición no es un JSON válido"], 400);
            return;
        }

        $errores = self::validarCliente($data);
        if (!empty($errores)) {
            ResponseHelper::json(["errores" => $errores], 400);
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

    //=======================================
    // PATCH /clientes/{id} >> Actualización parcial
    //=======================================
    public static function patch($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        if ($data === null || !is_array($data)) {
            ResponseHelper::json(["error" => "El cuerpo de la petición no es un JSON válido"], 400);
            return;
        }

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
            ResponseHelper::json(["error" => "No se enviaron campos válidos para actualizar"], 400);
            return;
        }

        $errores = self::validarClienteParcial($actualizar);
        if (!empty($errores)) {
            ResponseHelper::json(["errores" => $errores], 400);
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
    // DELETE /clientes/{id} >> Eliminar cliente
    //=======================================
    public static function destroy($id) {
        $cliente = Cliente::find($id);
        if (!$cliente) {
            ResponseHelper::error("Cliente no encontrado", 404);
            return;
        }

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

    //=======================================
    // VALIDACIONES COMPLETAS (POST/PUT)
    //=======================================
    private static function validarCliente($data) {
        $errores = [];
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
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                $faltantes[] = $field;
            }
        }

        if (!empty($faltantes)) {
            $errores[] = ["error" => "Faltan campos obligatorios", "faltantes" => $faltantes];
        }

        if (isset($data['contacto_email']) && !filter_var($data['contacto_email'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = ["error" => "El correo de contacto no es válido"];
        }

        if (isset($data['porcentaje_oferta']) &&
            (!is_numeric($data['porcentaje_oferta']) || $data['porcentaje_oferta'] < 0 || $data['porcentaje_oferta'] > 100)) {
            $errores[] = ["error" => "El porcentaje de oferta debe ser un número entre 0 y 100"];
        }

        if (isset($data['rut']) && !preg_match('/^\d{7,8}-[0-9kK]$/', $data['rut'])) {
            $errores[] = ["error" => "El RUT no tiene un formato válido (ej: 12345678-9)"];
        }

        if (isset($data['categoria']) &&
            !in_array(strtolower($data['categoria']), ['regular', 'preferencial'])) {
            $errores[] = ["error" => "La categoría debe ser 'regular' o 'preferencial'"];
        }

        return $errores;
    }

    //=======================================
    // VALIDACIONES PARCIALES (PATCH)
    //=======================================
    private static function validarClienteParcial($data) {
        $errores = [];

        if (isset($data['contacto_email']) && !filter_var($data['contacto_email'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = ["error" => "El correo de contacto no es válido"];
        }

        if (isset($data['porcentaje_oferta']) &&
            (!is_numeric($data['porcentaje_oferta']) || $data['porcentaje_oferta'] < 0 || $data['porcentaje_oferta'] > 100)) {
            $errores[] = ["error" => "El porcentaje de oferta debe ser un número entre 0 y 100"];
        }

        if (isset($data['rut']) && !preg_match('/^\d{7,8}-[0-9kK]$/', $data['rut'])) {
            $errores[] = ["error" => "El RUT no tiene un formato válido (ej: 12345678-9)"];
        }

        if (isset($data['categoria']) &&
            !in_array(strtolower($data['categoria']), ['regular', 'preferencial'])) {
            $errores[] = ["error" => "La categoría debe ser 'regular' o 'preferencial'"];
        }

        return $errores;
    }
}

