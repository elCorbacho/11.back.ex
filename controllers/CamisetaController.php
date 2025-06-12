<?php
require_once __DIR__ . '/../models/Camiseta.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';
require_once __DIR__ . '/../helpers/TallaHelper.php';

class CamisetaController {

    // GET /camisetas
    public static function index() {
        $camisetas = Camiseta::all();
        // Las tallas ya vienen como IDs por el modelo
        ResponseHelper::json($camisetas);
    }

    // GET /camisetas/{id}
    public static function show($id) {
        $camiseta = Camiseta::find($id);
        if ($camiseta) {
            // Las tallas ya vienen como IDs por el modelo
            ResponseHelper::json($camiseta);
        } else {
            ResponseHelper::error("Camiseta no encontrada", 404);
        }
    }

    // POST /camisetas
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

        // Validar que tallas exista, sea array y tenga al menos un elemento
        if (!isset($data['tallas']) || !is_array($data['tallas']) || count($data['tallas']) === 0) {
            ResponseHelper::error("Debes indicar al menos una talla", 400);
            return;
        }
        // Validar que todas las tallas sean enteros positivos y existan en la base de datos
        foreach ($data['tallas'] as $talla_id) {
            if (!is_int($talla_id) || $talla_id <= 0) {
                ResponseHelper::error("Cada talla debe ser un ID numérico positivo", 400);
                return;
            }
            $talla = Talla::find($talla_id);
            if (!$talla) {
                ResponseHelper::error("La talla con ID $talla_id no existe", 400);
                return;
            }
        }
        // No se hace conversión de nombres a IDs aquí

        $nueva = Camiseta::create($data);
        // Las tallas ya vienen como IDs por el modelo
        ResponseHelper::json($nueva, 201);
    }

    // PUT /camisetas/{id}
    public static function update($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        // Validar que todos los campos obligatorios estén presentes y no vacíos
        $required = ['titulo', 'club', 'pais', 'tipo', 'color', 'precio', 'detalles', 'codigo_producto'];
        foreach ($required as $field) {
            if (!isset($data[$field]) || $data[$field] === '') {
                ResponseHelper::error("Campo obligatorio: $field", 400);
                return;
            }
        }

        // Validar que tallas exista, sea array y tenga al menos un elemento
        if (!isset($data['tallas']) || !is_array($data['tallas']) || count($data['tallas']) === 0) {
            ResponseHelper::error("Debes indicar al menos una talla", 400);
            return;
        }
        // Validar que todas las tallas sean enteros positivos y existan en la base de datos
        foreach ($data['tallas'] as $talla_id) {
            if (!is_int($talla_id) || $talla_id <= 0) {
                ResponseHelper::error("Cada talla debe ser un ID numérico positivo", 400);
                return;
            }
            $talla = Talla::find($talla_id);
            if (!$talla) {
                ResponseHelper::error("La talla con ID $talla_id no existe", 400);
                return;
            }
        }
        // No se hace conversión de nombres a IDs aquí

        $actualizada = Camiseta::update($id, $data);
        // Las tallas ya vienen como IDs por el modelo
        if ($actualizada) {
            ResponseHelper::json($actualizada);
        } else {
            ResponseHelper::error("No se pudo actualizar la camiseta", 400);
        }
    }

    // PATCH /camisetas/{id}
    public static function patch($id) {
        $data = json_decode(file_get_contents("php://input"), true);

        // Obtener la camiseta actual
        $camisetaActual = Camiseta::find($id);
        if (!$camisetaActual) {
            ResponseHelper::error("Camiseta no encontrada", 404);
            return;
        }

        // No permitir campos en blanco o null
        $campos = ['titulo', 'club', 'pais', 'tipo', 'color', 'precio', 'detalles', 'codigo_producto'];
        foreach ($campos as $campo) {
            if (array_key_exists($campo, $data) && ($data[$campo] === '' || $data[$campo] === null)) {
                ResponseHelper::error("El campo '$campo' no puede estar en blanco ni null en PATCH", 400);
                return;
            }
        }
        // Completar con valores actuales si no se envía el campo
        foreach ($campos as $campo) {
            if (!isset($data[$campo])) {
                $data[$campo] = $camisetaActual[$campo] ?? null;
            }
        }

        // Solo validar tallas si VIENEN en el PATCH
        if (array_key_exists('tallas', $data)) {
            if (!is_array($data['tallas']) || count($data['tallas']) === 0) {
                ResponseHelper::error("Si envías 'tallas', debe ser un array con al menos una talla", 400);
                return;
            }
            // Validar que todas las tallas sean enteros positivos y existan en la base de datos
            foreach ($data['tallas'] as $talla_id) {
                if (!is_int($talla_id) || $talla_id <= 0) {
                    ResponseHelper::error("Cada talla debe ser un ID numérico positivo", 400);
                    return;
                }
                $talla = Talla::find($talla_id);
                if (!$talla) {
                    ResponseHelper::error("La talla con ID $talla_id no existe", 400);
                    return;
                }
            }
        } else {
            // Si no se envía, no modificar tallas
            unset($data['tallas']);
        }

        // Validar unicidad de codigo_producto solo si fue modificado
        if (isset($data['codigo_producto']) && $data['codigo_producto'] !== $camisetaActual['codigo_producto']) {
            $codigo = $data['codigo_producto'];
            $camisetaExistente = Camiseta::findByCodigoProducto($codigo);
            if ($camisetaExistente && $camisetaExistente['id'] != $id) {
                ResponseHelper::error("El código de producto ya existe en otra camiseta", 400);
                return;
            }
        }

        $actualizada = Camiseta::update($id, $data);
        // Las tallas ya vienen como IDs por el modelo
        if ($actualizada) {
            ResponseHelper::json($actualizada);
        } else {
            ResponseHelper::error("No se pudo actualizar la camiseta", 400);
        }
    }

    // DELETE /camisetas/{id}
    public static function destroy($id) {
        $eliminada = Camiseta::delete($id);
        if ($eliminada) {
            ResponseHelper::json(["mensaje" => "Camiseta eliminada"]);
        } else {
            ResponseHelper::error("No se pudo eliminar la camiseta o no existe ID", 400);
        }
    }

    //====================================================================
    //GET CAMISETA Y PRECIO FINAL SEGUN CLIENTE Y DESCUENTO
     //===================================================================
    public static function showPrecioFinal($id) {
        require_once __DIR__ . '/../models/Cliente.php';
        require_once __DIR__ . '/../models/Talla.php';

        $camiseta = Camiseta::find($id);
        if (!$camiseta) {
            ResponseHelper::error("Camiseta no encontrada", 404);
            return;
        }

        // Obtener tallas disponibles como IDs
        $tallas_disponibles = Talla::findByCamisetaId($id);

        // Obtener cliente_id desde query param (debe ser ID numérico)
        $cliente_id = $_GET['cliente_id'] ?? null;
        $cliente = null;
        $porcentaje_oferta = "sin descuento";
        $precio_inicial = $camiseta['precio'];
        $precio_final = $precio_inicial;

        if ($cliente_id) {
            $cliente = Cliente::find($cliente_id); // Buscar por ID
            if ($cliente) {
                // Si el cliente tiene porcentaje_oferta y es mayor a 0, mostrarlo
                if (!empty($cliente['porcentaje_oferta']) && $cliente['porcentaje_oferta'] > 0) {
                    $porcentaje_oferta = $cliente['porcentaje_oferta'];
                }
                // Si el cliente es Preferencial y hay precio_oferta, usarlo
                if ($cliente['categoria'] === 'Preferencial' && !empty($camiseta['precio_oferta'])) {
                    $precio_final = $camiseta['precio_oferta'];
                }
                // Si el cliente tiene porcentaje_oferta, úsalo como descuento
                elseif (!empty($cliente['porcentaje_oferta'])) {
                    $precio_final = $precio_inicial - round($precio_inicial * ($cliente['porcentaje_oferta'] / 100));
                }
            }
        }

        $respuesta = [
            "id_camiseta" => $camiseta['id'],
            "titulo" => $camiseta['titulo'],
            "club" => $camiseta['club'],
            "tallas_disponibles" => $tallas_disponibles,
            "tipo" => $camiseta['tipo'],
            "color" => $camiseta['color'],
            "PRECIO_INICIAL" => $precio_inicial,
        ];

        if ($cliente) {
            $respuesta["id_cliente"] = $cliente['id'];
            $respuesta["nombre_comercial_cliente"] = $cliente['nombre_comercial'];
            $respuesta["PORCENTAJE_OFERTA_CLIENTE"] = $porcentaje_oferta;
        }

        $respuesta["PRECIO_FINAL"] = $precio_final;

        ResponseHelper::json($respuesta);
    }
}
