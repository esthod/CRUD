<?php
require_once '../config/conexion.php';

//ROLES
function crearRol($request) {
    $sql = "INSERT INTO `roles`(`id`, `nom_rol`) 
    VALUES (null,'{$request['nom_rol']}')";  

    $conexion = conectar();

    try {
        $conexion->query($sql);
        if ($conexion->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    } catch (Exception $e) {
        error_log("Error al crear rol: " . $e->getMessage());
        return false; 
    }
}

function listarRoles() {
    $conexion = conectar();
    $resultado = $conexion->query("SELECT * FROM roles");
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

function actualizarRol($request) {
    $sql = "UPDATE roles SET nom_rol = '{$request['nom_rol']}' WHERE id = {$request['id']}";
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    return $resultado;
}


function eliminarRol($id) {
    $conexion = conectar();
    $stmt = $conexion->prepare("DELETE FROM roles WHERE id = ?");
    return $stmt->execute([$id]);
}

function obtenerRol($id) {
    $conexion = conectar();
    $stmt = $conexion->query("SELECT * FROM roles WHERE id = $id");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

// Permisos

function crearPermiso($request) {
    $sql = "INSERT INTO `permisos`(`id`, `nom_permiso`) 
    VALUES (null,'{$request['nom_permiso']}')";  

    $conexion = conectar();

    try {
        $conexion->query($sql);
        if ($conexion->affected_rows > 0) {
            return true; 
        } else {
            return false; 
        }
    } catch (Exception $e) {
        error_log("Error al crear permiso: " . $e->getMessage());
        return false; 
    }
}

function listarPermisos() {
    $conexion = conectar();
    $resultado = $conexion->query("SELECT * FROM permisos");
    return $resultado->fetch_all(MYSQLI_ASSOC);
}

function actualizarPermiso($request) {
    $sql = "UPDATE permisos SET nom_permiso = '{$request['nom_permiso']}' WHERE id = {$request['id']}";
    $conexion = conectar();
    $resultado = $conexion->query($sql);
    return $resultado;
}

function eliminarPermiso($id) {
    $conexion = conectar();
    $stmt = $conexion->prepare("DELETE FROM permisos WHERE id = ?");
    return $stmt->execute([$id]);
}

function obtenerPermiso($id) {
    $conexion = conectar();
    $stmt = $conexion->query("SELECT * FROM permisos WHERE id = $id");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

?>
