<?php

require_once __DIR__ . '/../../vendor/econea/nusoap/src/nusoap.php';
require_once __DIR__ . '/../../models/GeneracionGuia.php';

$namespace = 'GeneracionGuiaSOAP';
$server = new soap_server();
$server->configureWSDL('generacionGuia', $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'RespuestaGuia',
    'complexType',
    'struct',
    'all',
    '',
    [
        'estado' => ['name' => 'estado', 'type' => 'xsd:string'],
        'mensaje' => ['name' => 'mensaje', 'type' => 'xsd:string'],
        'idPedido' => ['name' => 'idPedido', 'type' => 'xsd:string'],
        'numeroGuia' => ['name' => 'numeroGuia', 'type' => 'xsd:string'],
        'idRegistro' => ['name' => 'idRegistro', 'type' => 'xsd:int'],
        'servicio' => ['name' => 'servicio', 'type' => 'xsd:string'],
    ]
);

$server->register(
    'generarGuia',
    ['idPedido' => 'xsd:string'],
    ['return' => 'tns:RespuestaGuia'],
    $namespace,
    false,
    'rpc',
    'encoded',
    'Genera guia de remision SUNAT (Svc_GeneracionGuia)'
);

function generarGuia($idPedido)
{
    $model = new GeneracionGuia();
    return $model->generar_guia($idPedido);
}

$POST_DATA = file_get_contents('php://input');
$server->service($POST_DATA);
