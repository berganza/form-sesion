<?php

include_once 'conexion.php';

//echo password_hash("bluuweb", PASSWORD_DEFAULT)."\n";

//Capturar datos por POST
$usuario_nuevo = $_POST['nombre_usuario'];
$contrasena = $_POST['contrasena'];
$contrasena2 = $_POST['contrasena2'];

// VERIFICAR SI USUARIO EXISTE
$sql = 'SELECT * FROM usuarios WHERE nombre = ?';
$sentencia = $pdo->prepare($sql);
$sentencia->execute(array($usuario_nuevo));
$resultado = $sentencia->fetch();

var_dump($resultado);

// SI EXISTE USUARIO MATAMOS LA OPERACION
if($resultado){
    echo '<br> Existe este usuario';
    die();
}

// HASH DE CONTRASEÑA
$contrasena = password_hash($contrasena, PASSWORD_DEFAULT);

echo '<pre>';
var_dump($usuario_nuevo);
var_dump($contrasena);
var_dump($contrasena2);
echo '</pre';


if (password_verify($contrasena2, $contrasena)) {
    echo '<br>Contrasena ok';
    
    //echo '<br> Contrasena ok';

    $sql_agregar = 'INSERT INTO usuarios (nombre, contrasena) VALUES (?,?)';
    $sentencia_agregar = $pdo->prepare($sql_agregar);
    
    if( $sentencia_agregar->execute(array($usuario_nuevo,$contrasena)) ){
        echo '<br>Agregado';
    } else {
        echo '<br>Error';
    }
    
    
    //cerramos conexion base de datos y sentencia
    $sentencia_agregar = null;
    $pdo = null;
    //header('location:index.php');

} else {
    echo 'Contraseña ko';
}

