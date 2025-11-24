<?php

class Database {

    private $connection;

    public function __construct() {
        // Cargamos configuración desde /config/config.php
        $config = require __DIR__ . '/../../config/config.php';

        $host = $config['db_host'];
        $dbname = $config['db_name'];
        $user = $config['db_user'];
        $pass = $config['db_pass'];

        try {
            $this->connection = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                $user,
                $pass
            );

            // Opciones recomendadas
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}
