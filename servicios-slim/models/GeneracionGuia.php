<?php

require_once __DIR__ . '/../config/conexion.php';

class GeneracionGuia extends Conectar
{
    public function generar_guia($idPedido)
    {
        $conexion = parent::conexion();
        parent::set_names();

        $numeroGuia = 'GRE-' . strtoupper(substr(md5($idPedido . microtime()), 0, 8));
        $sql = 'INSERT INTO t_generacion_guia (id_pedido, numero_guia) VALUES (?, ?)';
        $stmt = $conexion->prepare($sql);
        $stmt->bindValue(1, $idPedido);
        $stmt->bindValue(2, $numeroGuia);
        $stmt->execute();

        return [
            'estado' => 'OK',
            'mensaje' => 'Guia de remision electronica generada',
            'idPedido' => $idPedido,
            'numeroGuia' => $numeroGuia,
            'idRegistro' => (int) $conexion->lastInsertId(),
            'servicio' => 'Svc_GeneracionGuia',
        ];
    }
}
