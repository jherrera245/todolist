<?php
    require_once "config.php";

    //respuesta
    $datos = array();

    //Estructura de la tabla tareas
    $columnas = [
        "id" => NULL,
        "nombre" => NULL,
        "descripcion" => NULL,
        "fecha"=>NULL,
        "hora"=>NULL,
        "status"=>NULL,
    ];
    
    $accion = "";

    if (isset($_POST["accion"])) {
        $accion = $_POST["accion"];
    }

    //Insertar datos
    if ($accion == "insertar") {
        //guardando datos en el arreglo
        $columnas["nombre"] = $_POST["nombre"];
        $columnas["descripcion"] = $_POST["descripcion"];
        $columnas["fecha"] = $_POST["fecha"];
        $columnas["hora"] = $_POST["hora"];

        if (insertar($columnas) == true) {
            $datos["estado"] = true;
            $datos["resultado"] = "Tarea agregada correctamente";
        }else {
            $datos["estado"] = false;
            $datos["resultado"] = "No se pudo agregar la nueva tarea";
        }

    }
    
    //listar las tareas
    if ($accion == "listar") {
        $filtro = (isset($_POST["filtro"])) ?  $_POST["filtro"] : 0;
        $datos["estado"] = true;
        $datos["resultado"] = listar($filtro);
    }

    
    //actualiza los datos de la tarea
    if ($accion == "actualizar") {

        $columnas["id"] = $_POST["id"];
        $columnas["nombre"] = $_POST["nombre"];
        $columnas["descripcion"] = $_POST["descripcion"];
        $columnas["fecha"] = $_POST["fecha"];
        $columnas["hora"] = $_POST["hora"];
        $columnas["status"] = $_POST["status"];

        if (actualizar($columnas) == true) {
            $datos["estado"] = true;
            $datos["resultado"] = "Tarea actualizada correctamente";
        }else {
            $datos["estado"] = false;
            $datos["resultado"] = "No se pudo actualizar la tarea";
        }
    }
    
    //elimina la tarea
    if ($accion == "eliminar") {
        $id = $_POST["id"];

        if (eliminar($id) == true) {
            $datos["estado"] = true;
            $datos["resultado"] = "Tarea eliminada correctamente";
        }else {
            $datos["estado"] = false;
            $datos["resultado"] = "No se pudo eliminar la tarea";
        }
    } 

    echo json_encode($datos);
?> 