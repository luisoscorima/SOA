<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();

/**
 * Helper: responde JSON.
 */
function jsonResponse(Response $response, array $data, int $status = 200): Response
{
    $response->getBody()->write(json_encode($data, JSON_UNESCAPED_UNICODE));
    return $response
        ->withHeader('Content-Type', 'application/json')
        ->withStatus($status);
}

// ---------------------------------------------------------------------------
// Health / catálogo de servicios
// ---------------------------------------------------------------------------

$app->get('/', function (Request $request, Response $response): Response {
    return jsonResponse($response, [
        'proyecto' => 'Arca Continental Lindley - Servicios SOA',
        'stack' => [
            'rest' => 'Slim Framework',
            'soap' => 'NuSOAP (econea/nusoap) + MySQL',
        ],
        'rest' => [
            'GET  /api/wms/inventario/validar',
            'POST /api/wms/picking',
            'POST /api/logistica/bahias',
            'POST /api/tms/rutas/optimizar',
            'POST /api/cliente/recepciones',
        ],
        'soap_wsdl' => [
            'GET  /soap/validacionCliente.php?wsdl',
            'GET  /soap/sincronizacionErpWms.php?wsdl',
            'GET  /soap/generacionGuia.php?wsdl',
            'GET  /soap/cierrePedidoErp.php?wsdl',
            'GET  /soap/auditoria.php?wsdl',
        ],
    ]);
});

// ---------------------------------------------------------------------------
// REST (5) — Slim Framework
// ---------------------------------------------------------------------------

/**
 * Svc_ValidacionInventario
 */
$app->get('/api/wms/inventario/validar', function (Request $request, Response $response): Response {
    $q = $request->getQueryParams();

    return jsonResponse($response, [
        'estado' => 'OK',
        'mensaje' => 'Inventario validado',
        'id_producto' => $q['id_producto'] ?? null,
        'cantidad' => isset($q['cantidad']) ? (int) $q['cantidad'] : null,
        'id_almacen' => $q['id_almacen'] ?? 'ALM-PUCUSANA',
        'disponible' => true,
        'servicio' => 'Svc_ValidacionInventario',
    ]);
});

/**
 * Svc_GeneracionPicking
 */
$app->post('/api/wms/picking', function (Request $request, Response $response): Response {
    $datos = $request->getParsedBody() ?? [];

    return jsonResponse($response, [
        'estado' => 'OK',
        'mensaje' => 'Lista de picking generada',
        'idPicking' => 'PICK-' . strtoupper(substr(md5(($datos['idPedido'] ?? '0') . time()), 0, 8)),
        'datos_recibidos' => $datos,
        'servicio' => 'Svc_GeneracionPicking',
    ], 201);
});

/**
 * Svc_AsignacionBahia
 */
$app->post('/api/logistica/bahias', function (Request $request, Response $response): Response {
    $datos = $request->getParsedBody() ?? [];

    return jsonResponse($response, [
        'estado' => 'OK',
        'mensaje' => 'Bahia asignada correctamente',
        'idBahia' => 'BAH-' . (abs(crc32((string) ($datos['idPedido'] ?? 'PED-001'))) % 10 + 1),
        'datos_recibidos' => $datos,
        'servicio' => 'Svc_AsignacionBahia',
    ], 201);
});

/**
 * Svc_OptimizacionRutas
 */
$app->post('/api/tms/rutas/optimizar', function (Request $request, Response $response): Response {
    $datos = $request->getParsedBody() ?? [];

    return jsonResponse($response, [
        'estado' => 'OK',
        'mensaje' => 'Ruta optimizada correctamente',
        'idRuta' => 'RUT-' . strtoupper(substr(md5(($datos['idPedido'] ?? '0')), 0, 8)),
        'distanciaKm' => 42.5,
        'datos_recibidos' => $datos,
        'servicio' => 'Svc_OptimizacionRutas',
    ], 201);
});

/**
 * Svc_RecepcionCliente
 */
$app->post('/api/cliente/recepciones', function (Request $request, Response $response): Response {
    $datos = $request->getParsedBody() ?? [];

    return jsonResponse($response, [
        'estado' => 'OK',
        'mensaje' => 'Recepcion del cliente registrada',
        'idRecepcion' => 'REC-' . strtoupper(substr(md5(($datos['idPedido'] ?? '0') . 'rec'), 0, 8)),
        'datos_recibidos' => $datos,
        'servicio' => 'Svc_RecepcionCliente',
    ], 201);
});

$app->run();
