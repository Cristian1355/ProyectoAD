<?php
include 'conexion.php';

class Usuario {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function obtenerUsuarioPorId($id) {
        $query = "SELECT * FROM Usuarios WHERE UsuarioID = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
        $resultado = mysqli_stmt_get_result($stmt);
        $usuario = mysqli_fetch_assoc($resultado);
        mysqli_stmt_close($stmt);
        return $usuario;
    }

    public function actualizarUsuario($id, $nombre, $correoElectronico, $direccion, $telefono, $rol) {
        $query = "UPDATE Usuarios SET Nombre = ?, CorreoElectronico = ?, Direccion = ?, Telefono = ?, RolID = ? WHERE UsuarioID = ?";
        $stmt = mysqli_prepare($this->conn, $query);
        mysqli_stmt_bind_param($stmt, "ssssii", $nombre, $correoElectronico, $direccion, $telefono, $rol, $id);
        $exito = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        return $exito;
    }
}

$usuario = new Usuario($conn);

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $usuario = $usuario->obtenerUsuarioPorId($id);

    if (!$usuario) {
        header('Location: mostrar.php');
        exit;
    }
}

// Verificar si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? '';
    $nombre = $_POST['nombre'] ?? '';
    $correoElectronico = $_POST['correoElectronico'] ?? '';
    $direccion = $_POST['direccion'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $rol = $_POST['rol'] ?? '';

    if ($usuario->actualizarUsuario($id, $nombre, $correoElectronico, $direccion, $telefono, $rol)) {
        echo "<script>alert('Usuario actualizado correctamente.'); window.location.href='mostrar.php';</script>";
    } else {
        echo "Error al actualizar el usuario.";
    }
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Usuario</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow">
                <div class="card-body">
                    <h1 class="card-title text-center">Actualizar Usuario</h1>
                    <form action="" method="POST" onsubmit="return validateForm()">
                        <input type="hidden" name="id" value="<?php echo $usuario['UsuarioID']; ?>">
                        <div class="form-group">
                            <label for="nombre">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required pattern="[A-Za-z ]+" title="Solo letras y espacios son permitidos" value="<?php echo $usuario['Nombre']; ?>">
                            <div class="invalid-feedback">Solo letras y espacios son permitidos.</div>
                        </div>
                        <div class="form-group">
                            <label for="correoElectronico">Correo Electrónico</label>
                            <input type="email" class="form-control" id="correoElectronico" name="correoElectronico" required value="<?php echo $usuario['CorreoElectronico']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="direccion">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion" required value="<?php echo $usuario['Direccion']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="telefono">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required pattern="\d{10}" title="Debe contener 10 dígitos" value="<?php echo $usuario['Telefono']; ?>">
                            <div class="invalid-feedback">Debe contener 10 dígitos.</div>
                        </div>
                        <div class="form-group">
                            <label for="rol">Rol</label>
                            <select class="form-control" id="rol" name="rol" required>
                                <option value="1" <?php if ($usuario['RolID'] == 1) echo "selected"; ?>>Comprador</option>
                                <option value="2" <?php if ($usuario['RolID'] == 2) echo "selected"; ?>>Vendedor</option>
                            </select>
                        </div>
                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">Actualizar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="js/bootstrap.bundle.min.js"></script>
<script>
    function validateForm() {
        let inputs = document.querySelectorAll('input[required]');
        let valid = true;
        inputs.forEach(input => {
            if (!input.checkValidity()) {
                input.classList.add('is-invalid');
                valid = false;
            } else {
                input.classList.remove('is-invalid');
            }
        });
        return valid;
    }
</script>
</body>
</html>
