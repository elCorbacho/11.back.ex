<?php
require_once __DIR__ . '/../models/Camiseta.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';
require_once __DIR__ . '/../helpers/TallaHelper.php';

class CamisetaController {

    // GET /camisetas
    public static function index() {
        $camisetas = Camiseta::all();
        ResponseHelper::json($camisetas);
    }

    // GET /camisetas/{id}
    public static function show($id) {
        $camiseta = Camiseta::find($id);
        if ($camiseta) {
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
        if (
            !isset($data['tallas']) ||
            !is_array($data['tallas']) ||
            count($data['tallas']) === 0
        ) {
            ResponseHelper::error("Debes indicar al menos una talla", 400);
            return;
        }

        // Lista de tallas válidas
        $validTallas = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];

        // Validar que todas las tallas sean válidas por nombre
        foreach ($data['tallas'] as $talla_nombre) {
            if (!in_array($talla_nombre, $validTallas, true)) {
                ResponseHelper::error("Talla no válida: $talla_nombre. Solo se aceptan: S, M, L, XL, XXL, XXXL", 400);
                return;
            }
        }

        // Convertir tallas a IDs
        if (isset($data['tallas']) && is_array($data['tallas'])) {
            $tallas_ids = [];
            foreach ($data['tallas'] as $talla_nombre) {
                $id = TallaHelper::getIdByNombre($talla_nombre);
                if ($id !== null) {
                    $tallas_ids[] = $id;
                }
            }
            $data['tallas'] = $tallas_ids;
        }

        $nueva = Camiseta::create($data);

        // Convertir tallas a array si existe
        if (isset($nueva['tallas'])) {
            $nueva['tallas'] = $nueva['tallas'] !== null && $nueva['tallas'] !== ''
                ? explode(',', $nueva['tallas'])
                : [];
        }

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
        if (
            !isset($data['tallas']) ||
            !is_array($data['tallas']) ||
            count($data['tallas']) === 0
        ) {
            ResponseHelper::error("Debes indicar al menos una talla", 400);
            return;
        }

        // Lista de tallas válidas
        $validTallas = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];

        // Validar que todas las tallas sean válidas por nombre
        foreach ($data['tallas'] as $talla_nombre) {
            if (!in_array($talla_nombre, $validTallas, true)) {
                ResponseHelper::error("Talla no válida: $talla_nombre. Solo se aceptan: S, M, L, XL, XXL, XXXL", 400);
                return;
            }
        }

        // Convertir tallas a IDs
        if (isset($data['tallas']) && is_array($data['tallas'])) {
            $tallas_ids = [];
            foreach ($data['tallas'] as $talla_nombre) {
                $id = TallaHelper::getIdByNombre($talla_nombre);
                if ($id !== null) {
                    $tallas_ids[] = $id;
                }
            }
            $data['tallas'] = $tallas_ids;
        }

        $actualizada = Camiseta::update($id, $data);

        // Convertir tallas a array si existe
        if (isset($actualizada['tallas'])) {
            $actualizada['tallas'] = $actualizada['tallas'] !== null && $actualizada['tallas'] !== ''
                ? explode(',', $actualizada['tallas'])
                : [];
        }

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

        // Mezclar los datos recibidos con los actuales
        $campos = ['titulo', 'club', 'pais', 'tipo', 'color', 'precio', 'detalles', 'codigo_producto'];
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

            // Lista de tallas válidas
            $validTallas = ['S', 'M', 'L', 'XL', 'XXL', 'XXXL'];

            // Validar que todas las tallas sean válidas por nombre
            foreach ($data['tallas'] as $talla_nombre) {
                if (!in_array($talla_nombre, $validTallas, true)) {
                    ResponseHelper::error("Talla no válida: $talla_nombre. Solo se aceptan: S, M, L, XL, XXL, XXXL", 400);
                    return;
                }
            }
        } else {
            // Si no se envía, no modificar tallas
            unset($data['tallas']);
        }

        // Convertir tallas a IDs
        if (isset($data['tallas']) && is_array($data['tallas'])) {
            $tallas_ids = [];
            foreach ($data['tallas'] as $talla_nombre) {
                $id = TallaHelper::getIdByNombre($talla_nombre);
                if ($id !== null) {
                    $tallas_ids[] = $id;
                }
            }
            $data['tallas'] = $tallas_ids;
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

        // Convertir tallas a array si existe
        if (isset($actualizada['tallas'])) {
            $actualizada['tallas'] = $actualizada['tallas'] !== null && $actualizada['tallas'] !== ''
                ? explode(',', $actualizada['tallas'])
                : [];
        }

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
            ResponseHelper::error("No se pudo eliminar la camiseta", 400);
        }
    }
}
