<?php

// Copia este archivo como database.php y ajusta los valores
if (!class_exists('Database')) {
    class Database
    {
        private $host     = "127.0.0.1";
        private $port     = "3306";       // Puerto por defecto MySQL; Laragon usa 3306 o 3320
        private $db_name  = "bdalpes";
        private $username = "root";
        private $password = "";           // Cambia si tienes contraseña

        public function conectar()
        {
            try {
                $dsn  = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4";
                $conn = new PDO($dsn, $this->username, $this->password);
                $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return $conn;
            } catch (PDOException $e) {
                throw new Exception("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }
    }
}
