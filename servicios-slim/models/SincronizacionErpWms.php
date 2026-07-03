<?php

require_once __DIR__ . '/../config/conexion.php';

class SincronizacionErpWms extends Conectar
{
    public function sincronizar_pedido($idPedido)
    {
        $conexion = parent::conexion();
        parent::set_names();

        $estadoWms = 'RECIBIDO';
        $sql = 'INSERT INTO t_sincronizacion_erp_wms (id_pedido, estado_wms) VALUES (?, ?)';
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $idPedido);
        $stmt->bindValue(2, $estadoWms);
        $stmt->execute();

        return [
            'estado' => 'OK',
            'mensaje' => 'Pedido sincronizado de ERP a WMS',
            'idPedido' => $idPedido,
            'estadoWms' => $estadoWms,
            'idRegistro' => (int) $conexion->lastInsertId(),
            'servicio' => 'Svc_SincronizacionERP_WMS',
        ];
    }
}
