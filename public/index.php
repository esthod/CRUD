<?php
require_once '../config/conexion.php';
require_once '../config/jwt.php';
require_once '../app/auth.php';
require_once '../app/rols.php';
require_once '../app/usuarios.php';
require_once '../app/roles_y_permisos.php';

header('Content-Type: application/json');

$request = json_decode(file_get_contents("php://input"), true);

// USUARIO - Crear
if (
    $_SERVER['REQUEST_URI'] == '/crearusuario' &&
    $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $respuesta = crearUsuario($request);
    if ($respuesta) {
        echo json_encode(['mensaje' => 'Usuario creado correctamente']);
    } else {
        echo json_encode(['mensaje' => 'Error al crear el usuario']);
    }
    exit;
}

// USUARIO - Listar
if (
    $_SERVER['REQUEST_URI'] == '/listarusuario' &&
    $_SERVER['REQUEST_METHOD'] == 'GET'
) {
    $token = obtenerToken();
    $isValid = validateToken($token);
    if ($isValid != false) {
        $usuarios = listarUsuarios();
        echo json_encode($usuarios);
    } else {
        echo json_encode(['error' => 'Token inválido']);
    }
    exit;
}

// USUARIO - Obtener
if (
    $_SERVER['REQUEST_URI'] == '/obtenerusuario' &&
    $_SERVER['REQUEST_METHOD'] == 'GET'
) {
    $usuarios = obtenerUsuario($request['id']);
    echo json_encode($usuarios);
    exit;
}

// USUARIO - Actualizar
if (
    $_SERVER['REQUEST_URI'] == '/actualizarusuario' &&
    $_SERVER['REQUEST_METHOD'] == 'PUT'
) {
    $usuarios = actualizarUsuario($request);
    if ($usuarios) {
        echo json_encode(['mensaje' => 'Usuario actualizado correctamente']);
    } else {
        echo json_encode(['mensaje' => 'Error al actualizar el usuario']);
    }
}

// USUARIO - Eliminar
if (
    $_SERVER['REQUEST_URI'] == '/eliminarusuario' &&
    $_SERVER['REQUEST_METHOD'] == 'DELETE'
) {
    $resultado = eliminarUsuario($request['id']);
    echo json_encode([
        'mensaje' => $resultado ? 'Usuario eliminado' : 'Error al eliminar usuario'
    ]);
    exit;
}

// LOGIN
if (
    $_SERVER['REQUEST_URI'] == '/login' &&
    $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $usuario = iniciarSesion($request);
    if ($usuario) {
        $token = generarJWTToken($usuario);
        echo json_encode([
            'usuario' => $usuario,
            'token' => $token
        ]);
    } else {
        echo json_encode([
            'error' => 'Usuario o contraseña incorrectos'
        ]);
    }
    exit;
}

// ROL - Crear
if (
    $_SERVER['REQUEST_URI'] == '/crearol' &&
    $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $respuesta = crearRol($request);
    if ($respuesta) {
        echo json_encode(['mensaje' => 'Rol creado correctamente']);
    } else {
        echo json_encode(['mensaje' => 'Error al crear el rol']);
    }
}

// ROL - Listar
if (
    $_SERVER['REQUEST_URI'] == '/listarrol' &&
    $_SERVER['REQUEST_METHOD'] == 'GET'
) {
    $roles = listarRoles();
    echo json_encode($roles);
    exit;
}

// ROL - Obtener
if (
    $_SERVER['REQUEST_URI'] == '/obtenerrol' &&
    $_SERVER['REQUEST_METHOD'] == 'GET'
) {
    $roles = obtenerRol($request['id']);
    echo json_encode($roles);
    exit;
}

// ROL - Actualizar
if (
    $_SERVER['REQUEST_URI'] == '/actualizarol'&&
    $_SERVER['REQUEST_METHOD'] == 'PUT'
) {
    $rol = actualizarRol($request);
    if ($rol) {
        echo json_encode(['mensaje' => 'Rol actualizado correctamente']);
    } else {
        echo json_encode(['mensaje' => 'Error al actualizar el rol']);
    }
}

// ROL - Eliminar
if (
    $_SERVER['REQUEST_URI'] == '/eliminarrol' &&
    $_SERVER['REQUEST_METHOD'] == 'DELETE'
) {
    $resultado = eliminarRol($request['id']);
    echo json_encode([
        'mensaje' => $resultado ? 'Rol eliminado' : 'Error al eliminar rol'
    ]);
    exit;
}

// PERMISOS - Listar todos
if (
    $_SERVER['REQUEST_URI'] == '/listar/permisos' &&
    $_SERVER['REQUEST_METHOD'] == 'GET'
) {
    $permisos = listarPermiso();
    echo json_encode($permisos);
    exit;
}

// PERMISOS - Asignar a Rol
if (
    $_SERVER['REQUEST_URI'] == '/asignar/permiso' &&
    $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $respuesta = asignarPermisoARol($request);
    if ($respuesta) {
        echo json_encode(['mensaje' => 'Permiso asignado al rol correctamente']);
    } else {
        echo json_encode(['mensaje' => 'Error al asignar permiso']);
    }
    exit;
}

// PERMISOS - Listar por Rol
if (
    preg_match('/\/listar\/permisos\/rol\/(\d+)/', $_SERVER['REQUEST_URI'], $matches) &&
    $_SERVER['REQUEST_METHOD'] == 'GET'
) {
    $id_rol = intval($matches[1]);
    $permisos = listarPermisosPorRol($id_rol);
    echo json_encode($permisos);
    exit;
}

// PERMISOS - Crear
if (
    $_SERVER['REQUEST_URI'] == '/crearpermiso'
    and $_SERVER['REQUEST_METHOD'] == 'POST'
) {
    $respuesta = crearPermiso($request);
    if ($respuesta) {
        echo json_encode(['mensaje' => 'Permiso creado correctamente']);
    } else {
        echo json_encode(['mensaje' => 'Error al crear el permiso']);
    }
}


// PERMISOS - Listar
if (
    $_SERVER['REQUEST_URI'] == '/listarpermiso' &&
    $_SERVER['REQUEST_METHOD'] == 'GET'
) {
    $permisos = listarPermisos();
    echo json_encode($permisos);
    exit;
}

// PERMISOS - Actualizar
if (
    $_SERVER['REQUEST_URI'] == '/actualizarpermiso' &&
    $_SERVER['REQUEST_METHOD'] == 'PUT'
) {
    $permiso = actualizarPermiso($request);
    if ($permiso) {
        echo json_encode(['mensaje' => 'Permiso actualizado correctamente']);
    } else {
        echo json_encode(['mensaje' => 'Error al actualizar el permiso']);
    }
}

// PERMISOS - Eliminar
if (
    $_SERVER['REQUEST_URI'] == '/eliminarpermiso' &&
    $_SERVER['REQUEST_METHOD'] == 'DELETE'
) {
    $resultado = eliminarPermiso($request['id']);
    echo json_encode([
        'mensaje' => $resultado ? 'Permiso eliminado' : 'Error al eliminar permiso'
    ]);
    exit;
}

// PERMISOS - Obtener
if (
    $_SERVER['REQUEST_URI'] == '/obtenerpermiso' &&
    $_SERVER['REQUEST_METHOD'] == 'GET'
) {
    $permisos = obtenerPermiso($request['id']);
    echo json_encode($permisos);
    exit;
}

