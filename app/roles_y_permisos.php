<?php
require_once '../config/conexion.php';

function asignarPermisoARol($request) {
    $conexion = conectar();

    if (!isset($request['id_rol']) || !isset($request['id_permiso'])) {
        return false;
    }

    $id_rol = $request['id_rol'];
    $id_permiso = $request['id_permiso'];

    $sql = "INSERT INTO roles_has_permisos (id_rol, id_permiso) VALUES (?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $id_rol, $id_permiso);

    try {
        $stmt->execute();
        return $stmt->affected_rows > 0;
    } catch (Exception $e) {
        error_log("Error al asignar permiso: " . $e->getMessage());
        return false;
    }
}

function listarPermisosPorRol($id_rol) {
    $conexion = conectar();
    $sql = "SELECT p.id, p.nom_permiso FROM permisos p
            INNER JOIN roles_has_permisos rp ON p.id = rp.id_permiso
            WHERE rp.id_rol = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_rol);
    $stmt->execute();
    $resultado = $stmt->get_result();

    $permisos = [];
    while ($row = $resultado->fetch_assoc()) {
        $permisos[] = $row;
    }

    return $permisos;
}
