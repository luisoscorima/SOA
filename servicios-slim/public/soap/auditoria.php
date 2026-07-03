<?php

require_once __DIR__ . '/../../vendor/econea/nusoap/src/nusoap.php';
require_once __DIR__ . '/../../models/AuditoriaTransacciones.php';

$namespace = 'AuditoriaTransaccionesSOAP';
$server = new soap_server();
$server->configureWSDL('auditoria', $namespace);
$server->wsdl->schemaTargetNamespace = $namespace;

$server->wsdl->addComplexType(
    'RespuestaAuditoria',
    'complexType',
    'struct',
    'all',
    '',
    [
        'estado' => ['name' => 'estado', 'type' => 'xsd:string'],
        'mensaje' => ['name' => 'mensaje', 'type' => 'xsd:string'],
        'idAuditoria' => ['name' => 'idAuditoria', 'type' => 'xsd:int'],
        'operacion' => ['name' => 'operacion', 'type' => 'xsd:string'],
        'idPedido' => ['name' => 'idPedido', 'type' => 'xsd:string'],
        'servicio' => ['name' => 'servicio', 'type' => 'xsd:string'],
    ]
);

$server->register(
    'registrarAuditoria',
    [
        'operacion' => 'xsd:string',
        'idPedido' => 'xsd:string',
    ],
    ['return' => 'tns:RespuestaAuditoria'],
    $namespace,
    false,
    'rpc',
    'encoded',
    'Registra auditoria de transacciones (Svc_AuditoriaTransacciones)'
);

function registrarAuditoria($operacion, $idPedido)
{
    $model = new AuditoriaTransacciones();
    return $model->registrar_auditoria($operacion, $idPedido);
}

$POST_DATA = file_get_contents('php://input');
$server->service($POST_DATA);
