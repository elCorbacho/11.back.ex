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
    // Camisetas
    case preg_match('/^\/camisetas$/', $uri) && $method === 'GET':
        CamisetaController::index();
        break;
    case preg_match('/^\/camisetas\/([\w-]+)$/', $uri, $matches) && $method === 'GET':
        CamisetaController::show($matches[1]);
        break;
    case preg_match('/^\/camisetas$/', $uri) && $method === 'POST':
        CamisetaController::store();
        break;
    case preg_match('/^\/camisetas\/([\w-]+)$/', $uri, $matches) && $method === 'PUT':
        CamisetaController::update($matches[1]);
        break;
    case preg_match('/^\/camisetas\/([\w-]+)$/', $uri, $matches) && $method === 'DELETE':
        CamisetaController::destroy($matches[1]);
        break;

    // Clientes
    case preg_match('/^\/clientes$/', $uri) && $method === 'GET':
        ClienteController::index();
        break;
    case preg_match('/^\/clientes\/([\w-]+)$/', $uri, $matches) && $method === 'GET':
        ClienteController::show($matches[1]);
        break;
    case preg_match('/^\/clientes$/', $uri) && $method === 'POST':
        ClienteController::store();
        break;
    case preg_match('/^\/clientes\/([\w-]+)$/', $uri, $matches) && $method === 'PUT':
        ClienteController::update($matches[1]);
        break;
    case preg_match('/^\/clientes\/([\w-]+)$/', $uri, $matches) && $method === 'DELETE':
        ClienteController::destroy($matches[1]);
        break;

    // Tallas
    case preg_match('/^\/tallas$/', $uri) && $method === 'GET':
        TallaController::index();
        break;
    case preg_match('/^\/tallas\/([\w-]+)$/', $uri, $matches) && $method === 'GET':
        TallaController::show($matches[1]);
        break;
    case preg_match('/^\/tallas$/', $uri) && $method === 'POST':
        TallaController::store();
        break;
    case preg_match('/^\/tallas\/([\w-]+)$/', $uri, $matches) && $method === 'PUT':
        TallaController::update($matches[1]);
        break;
    case preg_match('/^\/tallas\/([\w-]+)$/', $uri, $matches) && $method === 'DELETE':
        TallaController::destroy($matches[1]);
        break;

    // Ofertas
    case preg_match('/^\/ofertas$/', $uri) && $method === 'GET':
        OfertaController::index();
        break;
    case preg_match('/^\/ofertas\/([\w-]+)$/', $uri, $matches) && $method === 'GET':
        OfertaController::show($matches[1]);
        break;
    case preg_match('/^\/ofertas$/', $uri) && $method === 'POST':
        OfertaController::store();
        break;
    case preg_match('/^\/ofertas\/([\w-]+)$/', $uri, $matches) && $method === 'PUT':
        OfertaController::update($matches[1]);
        break;
    case preg_match('/^\/ofertas\/([\w-]+)$/', $uri, $matches) && $method === 'DELETE':
        OfertaController::destroy($matches[1]);
        break;

    default:
        ResponseHelper::error('Ruta no encontrada', 404);
        break;
}