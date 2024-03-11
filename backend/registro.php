<?php
class UsuarioRegistro {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registrarUsuario($nombre, $correoElectronico, $contrasena, $direccion, $telefono, $rol) {
        $saldoInicial = 10000.00; // Saldo inicial por defecto

        // Validación de RolID
        $rolesPermitidos = ['1', '2'];
        if (!in_array($rol, $rolesPermitidos)) {
            echo "Valor de RolID no válido.";
            return false;
        }

        $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT); // Encripta la contraseña

        // Prepara la consulta SQL para insertar el usuario
        $sql = "INSERT INTO Usuarios (Nombre, CorreoElectronico, Contraseña, Direccion, Telefono, SaldoInicial, RolID) VALUES (?, ?, ?, ?, ?, ?, ?)";

        // Prepara la sentencia
        $stmt = mysqli_prepare($this->conn, $sql);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssssssi", $nombre, $correoElectronico, $contrasenaHash, $direccion, $telefono, $saldoInicial, $rol);

            // Ejecuta la sentencia
            if (mysqli_stmt_execute($stmt)) {
                echo "Usuario registrado con éxito.";
                // Redirige al usuario según su rol
                if ($rol === '1') { // Comprador
                    header("Location: ../index.html"); // Ajusta la ubicación según sea necesario
                    exit;
                } else {
                    // AQUÍ REDIRIGIR AL VENDEDOR A OTRA PÁGINA
                }
            } else {
                echo "Error: " . $sql . "<br>" . mysqli_error($this->conn);
                return false;
            }

            mysqli_stmt_close($stmt);
        } else {
            echo "Error al preparar la consulta: " . mysqli_error($this->conn);
            return false;
        }

        return true;
    }
}

// Uso de la clase UsuarioRegistro
include 'conexion.php'; // Asegúrate de incluir el script de conexión a la base de datos aquí.

$usuarioRegistro = new UsuarioRegistro($conn);

// Recoge los datos del formulario
$nombre = $_POST['nombre'] ?? ''; 
$correoElectronico = $_POST['correoElectronico'] ?? ''; 
$contrasena = $_POST['contrasena'] ?? ''; 
$direccion = $_POST['direccion'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$rol = $_POST['rol'] ?? ''; 

$registroExitoso = $usuarioRegistro->registrarUsuario($nombre, $correoElectronico, $contrasena, $direccion, $telefono, $rol);
if (!$registroExitoso) {
    // Manejar error de registro
}
?>
