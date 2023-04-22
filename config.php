<?php

#funcion para la conexion a base de datos
function conectar() {
    $server = "localhost";
    $database = "db_todolist";
    $user = "root";
    $password = "";
    // Create connection
    $conexion = mysqli_connect($server, $user, $password, $database);
    $conexion->set_charset("utf8mb4");

    // Check connection
    if (!$conexion) {
       $conexion = mysqli_error($conexion);
    }

    return $conexion;
}

# Funcion para deconectar
function desconectar($conexion) {
    try {
        mysqli_close($conexion);
        $estado = true;
    } catch (Exception $e) {
        $estado = false;
    }
    return $estado;
}

# funcion para insertar datos a la DB
function insertar($tarea) {
    
    $conexion = conectar();
    
    $query = "
        INSERT INTO tareas (id, nombre, descripcion, fecha, hora, status) 
        VALUES(NULL, '{$tarea["nombre"]}', '{$tarea["descripcion"]}', '{$tarea["fecha"]}', '{$tarea["hora"]}', 0)
    ";   
    
    if (mysqli_query($conexion, $query)) {
        $estado = true; 
    }else {
        $estado = false;
    }

    desconectar($conexion);
    
    return $estado;
}

# funcion para actualizar los datos de la DB
function actualizar($tarea) {
    $conexion = conectar();
    $query = "
        UPDATE tareas SET nombre = '{$tarea["nombre"]}', descripcion='{$tarea["descripcion"]}', fecha = '{$tarea["fecha"]}', 
        hora = '{$tarea["hora"]}', status = {$tarea["status"]} WHERE id = {$tarea["id"]}
    ";   
    
    if (mysqli_query($conexion, $query)) {
        $estado = true; 
    }else {
        $estado = false;
    }

    desconectar($conexion);
    return $estado;
}

# funcion para actualizar datos a la base de datos
function eliminar($id) {
    $conexion = conectar();
    $query = "DELETE FROM tareas WHERE id = '$id'";   
    
    if (mysqli_query($conexion, $query)) {
        $estado = true; 
    }else {
        $estado = false;
    }

    desconectar($conexion);
    return $estado;
}

# funcion para listar tareas
function listar($filtro) {
    $conexion = conectar();
    $json = array();
    $param = ($filtro == 0 || $filtro == 1) ?  "WHERE status = '$filtro'" : "";
    $query = "SELECT * FROM tareas  $param ORDER BY fecha ASC";
    
    $result = mysqli_query($conexion, $query);
    
    if (mysqli_num_rows($result) > 0) {
        while ($tarea = mysqli_fetch_array($result)) {
            $row = array();
            $row['id'] = $tarea['id'];
            $row['nombre'] = $tarea['nombre'];
            $row['descripcion'] = $tarea['descripcion'];
            $row['fecha'] = $tarea['fecha'];
            $row['hora'] = $tarea['hora'];
            $row['status'] = $tarea['status'];
            $json[] = $row;
        }
    }
    
    desconectar($conexion);
    return array_values($json);
}