<?php

use PHPUnit\Framework\TestCase;


require_once __DIR__ . '/../backend/registro.php'; 
require_once __DIR__ . '/TConexion.php';

class UsuarioRegistroTest extends TestCase
{
    private $usuarioRegistro;
    private $conexion;

    protected function setUp(): void
    {
   
        $this->conexion = new TConexion(true);

        
        $this->usuarioRegistro = new UsuarioRegistro($this->conexion->getConnection());
    }

    public function testRegistrarUsuario()
    {
      
        $nombre = "Nuevo UsuarioDOS";
        $correoElectronico = "nuevo1@example.com";
        $contrasena = "contrasena";
        $direccion = "Direccion 123";
        $telefono = "1234567890";
        $rol = '2'; 

        // Ejecuta el método registrarUsuario
        $result = $this->usuarioRegistro->registrarUsuario(
            $nombre, 
            $correoElectronico, 
            $contrasena, 
            $direccion, 
            $telefono, 
            $rol
        );

        // Afirma que la ejecución fue exitosa
        $this->assertTrue($result);
    }
}

?>