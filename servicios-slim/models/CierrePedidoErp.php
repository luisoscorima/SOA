<?php

require_once __DIR__ . '/../config/conexion.php';

class CierrePedidoErp extends Conectar
{
    public function cerrar_pedido($idPedido)
    {
        $conexion = parent::conexion();
        parent::set_names();

        $estadoErp = 'COMPLETADO';
        $sql = 'INSERT INTO t_cierre_pedido_erp (id_pedido, estado_erp) VALUES (?, ?)';
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $idPedido);
        $stmt->bindValue(2, $estadoErp);
        $stmt->execute();

        return [
            'estado' => 'OK',
            'mensaje' => 'Pedido cerrado en ERP',
            'idPedido' => $idPedido,
            'estadoErp' => $estadoErp,
            'idRegistro' => (int) $conexion->lastInsertId(),
            'servicio' => 'Svc_CierrePedidoERP',
        ];
    }
}
