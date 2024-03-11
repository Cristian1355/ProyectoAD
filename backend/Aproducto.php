<?php
// Importar la clase de conexión
require_once 'conexion.php'; 

class Producto {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function agregarProducto($nombre, $descripcion, $precio, $categoria, $imagen) {
        $stmt = $this->conn->prepare("INSERT INTO Productos (Nombre, Descripcion, Precio, Categoria, Imagen) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdss", $nombre, $descripcion, $precio, $categoria, $imagen);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }

        $stmt->close();
    }
}

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = htmlspecialchars($_POST['nombre']);
    $descripcion = htmlspecialchars($_POST['descripcion']);
    $precio = $_POST['precio'];
    $categoria = htmlspecialchars($_POST['categoria']);

    // Verificar si se envió una imagen
    if(isset($_FILES["imagen"])) {
        $archivoImagen = $_FILES["imagen"]["name"];
    } else {
        // Maneja el caso en que no se envió ninguna imagen
        echo "No se ha enviado ninguna imagen.";
        exit(); // Salir del script
    }

    // Crear instancia de la clase de conexión
    $conexion = new Conexion();
    $conn = $conexion->getConnection();

    // Crear instancia de Producto y agregar producto a la base de datos
    $producto = new Producto($conn);
    if ($producto->agregarProducto($nombre, $descripcion, $precio, $categoria, $archivoImagen)) {
        echo "Producto agregado exitosamente";
    } else {
        echo "Error al agregar el producto";
    }

}
?>



