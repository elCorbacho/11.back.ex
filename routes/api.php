<?php
require_once __DIR__ . '/../controllers/CamisetaController.php';
require_once __DIR__ . '/../controllers/ClienteController.php';
require_once __DIR__ . '/../controllers/TallaController.php';
require_once __DIR__ . '/../controllers/OfertaController.php';

// Obtén el path base del proyecto (por ejemplo, '/11.back.ex')
$basePath = dirname($_SERVER['SCRIPT_NAME']);

// Elimina el path base y '/api' del inicio de la URI
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = preg_replace('#^' . preg_quote($basePath, '#') . '/api/?#', '', $uri);

if ($uri === '') {
    $uri = '/';
} else if ($uri[0] !== '/') {
    $uri = '/' . $uri;
}
$method = $_SERVER['REQUEST_METHOD'];

switch (true) {
    //=============================================
    // Camisetas
    //=============================================
    //metodo GET para obtener todas las camisetas
    case preg_match('/^\/camisetas\/?$/', $uri) && $method === 'GET':
        CamisetaController::index();
        break;

    //metodo GET para obtener una camiseta por su id
    case preg_match('/^\/camisetas\/([\w-]+)\/?$/', $uri, $matches) && $method === 'GET':
        CamisetaController::show($matches[1]);
        break;

    //metodo POST para crear una nueva camiseta
    case preg_match('/^\/camisetas\/?$/', $uri) && $method === 'POST':
        CamisetaController::store();
        break;

    //metodo PUT para actualizar una camiseta por su id
    case preg_match('/^\/camisetas\/([\w-]+)\/?$/', $uri, $matches) && $method === 'PUT':
        CamisetaController::update($matches[1]);
        break;
        
    //metodo DELETE para eliminar una camiseta por su id
    case preg_match('/^\/camisetas\/([\w-]+)\/?$/', $uri, $matches) && $method === 'DELETE':
        CamisetaController::destroy($matches[1]);
        break;

    //metodo PATCH para actualizar parcialmente una camiseta por su id
    case preg_match('/^\/camisetas\/([\w-]+)\/?$/', $uri, $matches) && $method === 'PATCH':
        CamisetaController::patch($matches[1]);
        break;

    //---------------------------------------------------------
    //GET CAMISETA Y PRECIO FINAL SEGUN CLIENTE Y DESCUENTO
    //---------------------------------------------------------
    // GET /camisetas/{id}/precio-final?cliente_id=nombre_comercial
    case preg_match('/^\/camisetas\/([\w-]+)\/precio-final$/', $uri, $matches) && $method === 'GET':
        CamisetaController::showPrecioFinal($matches[1]);
        break;


    //=============================================
    // Clientes
    //=============================================
    //metodo GET para obtener todos los clientes
    case preg_match('/^\/clientes$/', $uri) && $method === 'GET':
        ClienteController::index();
        break;
    //metodo GET para obtener un cliente por su id
    case preg_match('/^\/clientes\/([\w-]+)$/', $uri, $matches) && $method === 'GET':
        ClienteController::show($matches[1]);
        break;
    //metodo POST para crear un nuevo cliente
    case preg_match('/^\/clientes$/', $uri) && $method === 'POST':
        ClienteController::store();
        break;
    //metodo PUT para actualizar un cliente por su id
    case preg_match('/^\/clientes\/([\w-]+)$/', $uri, $matches) && $method === 'PUT':
        ClienteController::update($matches[1]);
        break;
    //metodo DELETE para eliminar un cliente por su id
    case preg_match('/^\/clientes\/([\w-]+)$/', $uri, $matches) && $method === 'DELETE':
        ClienteController::destroy($matches[1]);
        break;
    //metodo PATCH para actualizar parcialmente un cliente por su id
    case preg_match('/^\/clientes\/([\w-]+)$/', $uri, $matches) && $method === 'PATCH':
        ClienteController::patch($matches[1]);
        break;

    ////=============================================
    // Tallas
    //=============================================
    //metodo GET para obtener todas las tallas
    case preg_match('/^\/tallas$/', $uri) && $method === 'GET':
        TallaController::index();
        break;
    //metodo GET para obtener una talla por su id
    case preg_match('/^\/tallas\/([\w-]+)$/', $uri, $matches) && $method === 'GET':
        TallaController::show($matches[1]);
        break;
    //metodo POST para crear una nueva talla
    case preg_match('/^\/tallas$/', $uri) && $method === 'POST':
        TallaController::store();
        break;
    //metodo PUT para actualizar una talla por su id
    case preg_match('/^\/tallas\/([\w-]+)$/', $uri, $matches) && $method === 'PUT':
        TallaController::update($matches[1]);
        break;
    //metodo DELETE para eliminar una talla por su id
    case preg_match('/^\/tallas\/([\w-]+)$/', $uri, $matches) && $method === 'DELETE':
        TallaController::destroy($matches[1]);
        break;



    ////=============================================
    // Ofertas
    //=============================================
    //metodo GET para obtener todas las ofertas
    // endpoint /ofertas
    case preg_match('/^\/ofertas$/', $uri) && $method === 'GET':
        OfertaController::index();
        break;

    //metodo GET para obtener una oferta por su id
    // endpoint /ofertas/{id}
    case preg_match('/^\/ofertas\/([\w-]+)$/', $uri, $matches) && $method === 'GET':
        OfertaController::show($matches[1]);
        break;
        
    //metodo POST para crear una nueva oferta
    // endpoint /ofertas
    case preg_match('/^\/ofertas$/', $uri) && $method === 'POST':
        OfertaController::store();
        break;

    //metodo PUT para actualizar una oferta por su id
    // endpoint /ofertas/{id}
    case preg_match('/^\/ofertas\/([\w-]+)$/', $uri, $matches) && $method === 'PUT':
        OfertaController::update($matches[1]);
        break;

    //metodo DELETE para eliminar una oferta por su id
    // endpoint /ofertas/{id}
    case preg_match('/^\/ofertas\/([\w-]+)$/', $uri, $matches) && $method === 'DELETE':
        OfertaController::destroy($matches[1]);
        break;

    //=============================================
    // Ruta por defecto
    //============================================
    default:
        ResponseHelper::error('Ruta no encontrada', 404);
        break;
}