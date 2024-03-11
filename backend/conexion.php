<?php
class Conexion {
    private $host = 'localhost';
    private $dbname = 'EASYBUY';
    private $user = 'root';
    private $password = '';
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
        echo "Conexión establecida correctamente.";
    }

    public function getConnection() {
        return $this->conn;
    }

    public function closeConnection() {
        $this->conn->close();
    }
}

$conexion = new Conexion();
$conn = $conexion->getConnection();
?>

