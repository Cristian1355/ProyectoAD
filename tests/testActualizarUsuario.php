<?php

use PHPUnit\Framework\TestCase;

// Asume que Usuario.php es la definición de tu clase Usuario que incluye la lógica de negocio.
require_once __DIR__ . '/../backend/editar.php';

class UsuarioEdicionTest extends TestCase {
    private $usuario;
    private $mockConn;

    protected function setUp(): void {
        // Mockea la conexión a la base de datos
        $this->mockConn = $this->createMock(mysqli::class);

        // Si la clase Usuario espera una conexión mysqli en su constructor,
        // inyecta el mock directamente.
        $this->usuario = new Usuario($this->mockConn);
    }

    public function testActualizarUsuario() {
        // Prepara el mock para simular el comportamiento esperado.
        // Esto es crucial si tu método hace uso de métodos específicos de mysqli.
        $stmtMock = $this->createMock(mysqli_stmt::class);
        $stmtMock->method('execute')->willReturn(true);
        $this->mockConn->method('prepare')->willReturn($stmtMock);

        // Define los datos de prueba
        $id = 24;
        $nombre = "Usuario Actualizado";
        $correoElectronico = "actualizado@example.com";
        $direccion = "Nueva Direccion 123";
        $telefono = "1234567891";
        $rol = '1';

        // Ejecuta el método a probar
        $result = $this->usuario->actualizarUsuario(
            $id,
            $nombre,
            $correoElectronico,
            $direccion,
            $telefono,
            $rol
        );

        // Verifica que el resultado sea el esperado
        $this->assertTrue($result);
    }
}
