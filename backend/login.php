<?php
include 'conexion.php';

class Login {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function iniciarSesion($correoElectronico, $contrasena) {
        $sql = "SELECT u.UsuarioID, u.Nombre, u.Contraseña, u.RolID, r.Nombre as NombreRol 
                FROM Usuarios u 
                JOIN Roles r ON u.RolID = r.RolID 
                WHERE u.CorreoElectronico = ?";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $correoElectronico);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $usuarioId, $nombreUsuario, $contrasenaHash, $rolId, $nombreRol);
        mysqli_stmt_fetch($stmt);
        mysqli_stmt_close($stmt);

        if (password_verify($contrasena, $contrasenaHash)) {
            session_start();
            $_SESSION['usuarioId'] = $usuarioId;
            $_SESSION['nombreUsuario'] = $nombreUsuario;
            $_SESSION['rolId'] = $rolId;
            $_SESSION['nombreRol'] = $nombreRol;

            $this->insertarRegistroInicioSesion($usuarioId, $rolId, $nombreUsuario, $nombreRol);

            return "Inicio de sesión exitoso.";
        } else {
            return "Correo electrónico o contraseña incorrectos.";
        }
    }

    private function insertarRegistroInicioSesion($usuarioId, $rolId, $nombreUsuario, $nombreRol) {
        $sql = "INSERT INTO registroiniciosesion (UsuarioID, rolID, fechaHoraInicio, NombreUsuario, NombreRol) VALUES (?, ?, NOW(), ?, ?)";
        $stmt = mysqli_prepare($this->conn, $sql);
        mysqli_stmt_bind_param($stmt, "iiss", $usuarioId, $rolId, $nombreUsuario, $nombreRol);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

$login = new Login($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correoElectronico = $_POST['correoElectronico'] ?? '';
    $contrasena = $_POST['contrasena'] ?? '';

    $mensajeInicioSesion = $login->iniciarSesion($correoElectronico, $contrasena);
    echo $mensajeInicioSesion;
}

mysqli_close($conn);
?>
