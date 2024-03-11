<?php
include 'conexion.php'; // Asegúrate de que este archivo contiene la conexión a tu base de datos.

// Consulta SQL para seleccionar todos los productos. Usa ProductoID en lugar de id.
$sql = "SELECT ProductoID, Nombre, Descripcion, Precio, Stock, Categoria FROM productos";
$resultado = $conn->query($sql);

if ($resultado && $resultado->num_rows > 0) {
    // El proceso de iteración y visualización de productos se mantiene igual.
} else {
    echo "No se encontraron productos";
}
$conn->close();
?>
