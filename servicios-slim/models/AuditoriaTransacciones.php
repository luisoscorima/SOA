<?php

require_once __DIR__ . '/../config/conexion.php';

class AuditoriaTransacciones extends Conectar
{
    public function registrar_auditoria($operacion, $idPedido)
    {
        $conexion = parent::conexion();
        parent::set_names();

        $sql = 'INSERT INTO t_auditoria (operacion, id_pedido) VALUES (?, ?)';
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $operacion);
        $stmt->bindValue(2, $idPedido);
        $stmt->execute();

        return [
            'estado' => 'OK',
            'mensaje' => 'Transaccion auditada correctamente',
            'idAuditoria' => (int) $conexion->lastInsertId(),
            'operacion' => $operacion,
            'idPedido' => $idPedido,
            'servicio' => 'Svc_AuditoriaTransacciones',
        ];
    }
}
