<?php

require_once __DIR__ . '/../config/conexion.php';

class ValidacionCliente extends Conectar
{
    public function validar_cliente($idCliente)
    {
        $conexion = parent::conexion();
        parent::set_names();

        $sql = 'INSERT INTO t_validacion_cliente (id_cliente, habilitado) VALUES (?, ?)';
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $idCliente);
        $stmt->bindValue(2, 1);
        $stmt->execute();

        return [
            'estado' => 'OK',
            'mensaje' => 'Cliente validado correctamente',
            'idCliente' => $idCliente,
            'habilitado' => true,
            'idRegistro' => (int) $conexion->lastInsertId(),
            'servicio' => 'Svc_ValidacionCliente',
        ];
    }
}
