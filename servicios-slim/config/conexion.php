<?php

class Conectar
{
    protected $dbh;

    protected function conexion()
    {
        try {
            $conectar = $this->dbh = new PDO(
                'mysql:host=localhost;dbname=arca_soa_db;charset=utf8mb4',
                'root',
                ''
            );
            $conectar->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $conectar;
        } catch (Exception $err) {
            print 'Error: ' . $err->getMessage() . '<br/>';
            die();
        }
    }

    protected function set_names()
    {
        return $this->dbh->query("SET NAMES 'utf8mb4'");
    }
}
