<?php
// Asume la inclusión de autoload o las clases necesarias
require_once 'tests/Tconexion.php';
require_once 'editar.php';

$conexion = new Tconexion();
$usuario = new Usuario($conexion->getConnection());

// Inicializa variables para el formulario
$datosUsuario = [
    'UsuarioID' => '',
    'Nombre' => '',
    'CorreoElectronico' => '',
    'Direccion' => '',
    'Telefono' => '',
    'RolID' => ''
];

// Verificar si se solicita un usuario por ID para editar
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $datosUsuario = $usuario->obtenerUsuarioPorId($id);
}

// Verificar si se envió el formulario de actualización
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Asume validación de los datos recibidos aquí

    // Extraer datos del formulario
    $id = $_POST['id'] ?? null;
    $nombre = $_POST['nombre'] ?? '';
    $correoElectronico = $_POST['correoElectronico'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $rol = $_POST['rol'] ?? '';

    // Intentar actualizar el usuario
    if ($usuario->actualizarUsuario($id, $nombre, $correoElectronico, $direccion, $telefono, $rol)) {
        // Redirigir a una página de éxito o mostrar un mensaje
        echo "<script>alert('Usuario actualizado correctamente.'); window.location.href='mostrar.php';</script>";
    } else {
        // Manejar el caso de error
        echo "<script>alert('Error al actualizar el usuario.');</script>";
    }
}
?>