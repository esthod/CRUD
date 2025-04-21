<?php

//crear un usuario

function crearUsuario($request)
{
    $passwordHash = password_hash($request['password'], PASSWORD_BCRYPT);
    $sql = "INSERT INTO `usuarios`(`id`, `nombre`,
 `apellido`, `email`, `password`)
 VALUES (null,'{$request['nombre']}','{$request['apellido']}',
 '{$request['email']}','{$passwordHash}')";
    $conexion = conectar();
    $conexion->query($sql);
    return true;

    try {

    } catch (\Throwable $th) {
        return false;
    }
}

function listarUsuarios()
{

    $sql = "SELECT * FROM usuarios";        
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    $usuarios = $resultado->fetch_all(MYSQLI_ASSOC); //fetch_all trae todos los registros
    return $usuarios;
    //fetch_assoc trae un solo registro
    //ejem´plp de fetch_assoc
    // $usuarios = $resultado->fetch_assoc();
    //llenar un array con los datos de la base de datos
    /*  while ($usuario = $resultado->fetch_assoc()) {
        $usuarios[] = $usuario;
    } */
    
    //echo json_encode($sql);
}

function obtenerUsuario($id) {
    $conexion = conectar();
    $stmt = $conexion->query("SELECT * FROM usuarios WHERE id = $id");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function actualizarUsuario($request) {
    $sql = "UPDATE usuarios SET nombre = '{$request['nombre']}', apellido = '{$request['apellido']}', email = '{$request['email']}' WHERE id = {$request['id']}";
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    return $resultado;
}

function eliminarUsuario($id) {
    $conexion = conectar();
    $stmt = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    return $stmt->execute([$id]);
}