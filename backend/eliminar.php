<?php
include 'conexion.php';

class Usuario {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function eliminarUsuario($usuarioId) {
        $query = "DELETE FROM Usuarios WHERE UsuarioID = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $usuarioId);

        if(mysqli_stmt_execute($stmt)) {
            return true;
        } else {
            return false;
        }
    }
}

$usuario = new Usuario($conn);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $usuarioId = $_GET['id'];

    if ($usuario->eliminarUsuario($usuarioId)) {
        echo "<script>alert('Usuario eliminado correctamente.');window.location.href='mostrar.php';</script>";
    } else {
        echo "<script>alert('Ocurrió un error al eliminar el usuario.');window.location.href='mostrar.php';</script>";
    }
} else {
    header('Location: mostrar.php');
}

mysqli_close($conn);
?>
