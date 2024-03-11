<?php

class TConexion {
    private $host = 'localhost';
    private $dbname = 'EASYBUY';
    private $user = 'root';
    private $password = '';
    private $conn;

    public function __construct() {
        // Inicializa la conexión solo si no se ha inyectado una aún
        if (!$this->conn) {
            $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);
            if ($this->conn->connect_error) {
                die("Conexión fallida: " . $this->conn->connect_error);
            } else {
                echo "Conexión establecida correctamente.";
            }
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    // Método para inyectar una conexión (real o simulada)
    public function setConnection(mysqli $conn) {
        $this->conn = $conn;
    }

    public function closeConnection() {
        if ($this->conn !== null) {
            $this->conn->close();
        }
    }
}
