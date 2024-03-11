<?php
include 'conexion.php'; 

class Usuario {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getUsuarios() {
        $query = "SELECT UsuarioID, Nombre, CorreoElectronico, Telefono, RolID FROM Usuarios";
        $resultado = mysqli_query($this->conn, $query);
        $usuarios = [];
        while ($fila = mysqli_fetch_assoc($resultado)) {
            $usuarios[] = $fila;
        }
        return $usuarios;
    }

    public function generarTablaUsuarios() {
        $usuarios = $this->getUsuarios();
        $html = '<div class="container mt-5">';
        $html .= '<h2>Listado de Usuarios</h2>';
        $html .= '<table class="table">';
        $html .= '<thead>';
        $html .= '<tr>';
        $html .= '<th>ID</th>';
        $html .= '<th>Nombre</th>';
        $html .= '<th>Correo Electrónico</th>';
        $html .= '<th>Teléfono</th>';
        $html .= '<th>Rol</th>';
        $html .= '<th>Acciones</th>';
        $html .= '</tr>';
        $html .= '</thead>';
        $html .= '<tbody>';
        foreach ($usuarios as $usuario) {
            $html .= '<tr>';
            $html .= '<td>' . $usuario['UsuarioID'] . '</td>';
            $html .= '<td>' . $usuario['Nombre'] . '</td>';
            $html .= '<td>' . $usuario['CorreoElectronico'] . '</td>';
            $html .= '<td>' . $usuario['Telefono'] . '</td>';
            $html .= '<td>' . ($usuario['RolID'] == 1 ? 'Comprador' : 'Vendedor') . '</td>';
            $html .= '<td>';
            $html .= '<a href="editar.php?id=' . $usuario['UsuarioID'] . '" class="btn btn-primary">Editar</a>';
            $html .= '<a href="eliminar.php?id=' . $usuario['UsuarioID'] . '" class="btn btn-danger" onclick="return confirm(\'¿Estás seguro de querer eliminar este usuario?\');">Eliminar</a>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        $html .= '</tbody>';
        $html .= '</table>';
        $html .= '</div>';
        return $html;
    }
}

$usuario = new Usuario($conn);
$htmlTablaUsuarios = $usuario->generarTablaUsuarios();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado de Usuarios</title>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>

<?php echo $htmlTablaUsuarios; ?>

<script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>

