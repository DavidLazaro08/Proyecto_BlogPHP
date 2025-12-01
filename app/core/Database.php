<?php

class Database
{
    private $connection;

    public function __construct()
    {
        // ================================
        //  Cargar configuración
        // ================================
        $config = require __DIR__ . '/../../config/config.php';

        $host   = $config['db_host'];
        $dbname = $config['db_name'];
        $user   = $config['db_user'];
        $pass   = $config['db_pass'];

        try {
            // ================================
            //  Crear conexión PDO
            // ================================
            $this->connection = new PDO(
                "mysql:host=$host;dbname=$dbname;charset=utf8",
                $user,
                $pass
            );

            // ================================
            //  Opciones recomendadas
            // ================================
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {

            // Error crítico - detener ejecución
            die("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    // ================================
    //  Obtener la conexión activa
    // ================================
    public function getConnection()
    {
        return $this->connection;
    }
}
