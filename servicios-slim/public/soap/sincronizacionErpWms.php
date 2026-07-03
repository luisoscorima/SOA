<?php

require_once __DIR__ . '/../../vendor/econea/nusoap/src/nusoap.php';
require_once __DIR__ . '/../../models/SincronizacionErpWms.php';

$namespace = 'SincronizacionErpWmsSOAP';
$server = new soap_server();
$server->configureWSDL('sincronizacionErpWms', $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'RespuestaSincronizacion',
    'complexType',
    'struct',
    'all',
    '',
    [
        'estado' => ['name' => 'estado', 'type' => 'xsd:string'],
        'mensaje' => ['name' => 'mensaje', 'type' => 'xsd:string'],
        'idPedido' => ['name' => 'idPedido', 'type' => 'xsd:string'],
        'estadoWms' => ['name' => 'estadoWms', 'type' => 'xsd:string'],
        'idRegistro' => ['name' => 'idRegistro', 'type' => 'xsd:int'],
        'servicio' => ['name' => 'servicio', 'type' => 'xsd:string'],
    ]
);

$server->register(
    'sincronizarPedido',
    ['idPedido' => 'xsd:string'],
    ['return' => 'tns:RespuestaSincronizacion'],
    $namespace,
    false,
    'rpc',
    'encoded',
    'Sincroniza pedido ERP-WMS (Svc_SincronizacionERP_WMS)'
);

function sincronizarPedido($idPedido)
{
    $model = new SincronizacionErpWms();
    return $model->sincronizar_pedido($idPedido);
}

$POST_DATA = file_get_contents('php://input');
$server->service($POST_DATA);
