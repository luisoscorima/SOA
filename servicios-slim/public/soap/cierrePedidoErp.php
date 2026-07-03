<?php

require_once __DIR__ . '/../../vendor/econea/nusoap/src/nusoap.php';
require_once __DIR__ . '/../../models/CierrePedidoErp.php';

$namespace = 'CierrePedidoErpSOAP';
$server = new soap_server();
$server->configureWSDL('cierrePedidoErp', $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'RespuestaCierre',
    'complexType',
    'struct',
    'all',
    '',
    [
        'estado' => ['name' => 'estado', 'type' => 'xsd:string'],
        'mensaje' => ['name' => 'mensaje', 'type' => 'xsd:string'],
        'idPedido' => ['name' => 'idPedido', 'type' => 'xsd:string'],
        'estadoErp' => ['name' => 'estadoErp', 'type' => 'xsd:string'],
        'idRegistro' => ['name' => 'idRegistro', 'type' => 'xsd:int'],
        'servicio' => ['name' => 'servicio', 'type' => 'xsd:string'],
    ]
);

$server->register(
    'cerrarPedido',
    ['idPedido' => 'xsd:string'],
    ['return' => 'tns:RespuestaCierre'],
    $namespace,
    false,
    'rpc',
    'encoded',
    'Cierra pedido en ERP (Svc_CierrePedidoERP)'
);

function cerrarPedido($idPedido)
{
    $model = new CierrePedidoErp();
    return $model->cerrar_pedido($idPedido);
}

$POST_DATA = file_get_contents('php://input');
$server->service($POST_DATA);
