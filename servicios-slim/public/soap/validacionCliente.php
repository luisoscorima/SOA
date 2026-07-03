<?php

require_once __DIR__ . '/../../vendor/econea/nusoap/src/nusoap.php';
require_once __DIR__ . '/../../models/ValidacionCliente.php';

$namespace = 'ValidacionClienteSOAP';
$server = new soap_server();
$server->configureWSDL('validacionCliente', $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'RespuestaValidacionCliente',
    'complexType',
    'struct',
    'all',
    '',
    [
        'estado' => ['name' => 'estado', 'type' => 'xsd:string'],
        'mensaje' => ['name' => 'mensaje', 'type' => 'xsd:string'],
        'idCliente' => ['name' => 'idCliente', 'type' => 'xsd:string'],
        'habilitado' => ['name' => 'habilitado', 'type' => 'xsd:boolean'],
        'idRegistro' => ['name' => 'idRegistro', 'type' => 'xsd:int'],
        'servicio' => ['name' => 'servicio', 'type' => 'xsd:string'],
    ]
);

$server->register(
    'validarCliente',
    ['idCliente' => 'xsd:string'],
    ['return' => 'tns:RespuestaValidacionCliente'],
    $namespace,
    false,
    'rpc',
    'encoded',
    'Valida un cliente en el ERP (Svc_ValidacionCliente)'
);

function validarCliente($idCliente)
{
    $model = new ValidacionCliente();
    return $model->validar_cliente($idCliente);
}

$POST_DATA = file_get_contents('php://input');
$server->service($POST_DATA);
