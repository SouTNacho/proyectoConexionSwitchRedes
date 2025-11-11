<?php

session_start();

/* 
Archivo: modificar_switch.php,
Modifica los datos de un switch existente.
*/

include 'conexion.php';
$conn = conectar_bd();

//Revisa si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtenemos los datos enviados desde el formulario
    $ip = $_POST['switch-elegido'];
    $name = $_POST['nombre'];
    $location = $_POST['ubicacion'];
    $model = $_POST['modelo'];

    // Preparo esto para saber si la IP del dispositivo a modificar esta en uso
    $stmt = "SELECT ip_switch FROM switch WHERE ip_switch = '$ip'";

    // Guardo el resultado en una variable        
    $resultado = $conn->query($stmt);

    //Verifico si algun registro con esa ip
    if ($resultado->num_rows > 0) {

        /* 
        Revisamos cual de los siguentes no fue enviado,
        nombre, ubicacion, modelo (Para Preparar la Consulta).
        */
 

        if (!empty($name) && empty($location) && empty($model)) {

            // Cambia el nombre
            $sql = "UPDATE switch 
                    SET nombre = '$name' 
                    WHERE ip_switch = '$ip'";
        
        } elseif (empty($name) && !empty($location) && empty($model)) {

            // Cambia la ubicación
            $sql = "UPDATE switch 
                    SET ubicacion = '$location' 
                    WHERE ip_switch = '$ip'";
        
        } elseif (empty($name) && empty($location) && !empty($model)) {

            // Cambia el modelo
            $sql = "UPDATE switch 
                    SET modelo = '$model'
                    WHERE ip_switch = '$ip'";
        
        } elseif (!empty($name) && !empty($location) && empty($model)) {

            // Cambia nombre y ubicación
            $sql = "UPDATE switch 
                    SET nombre = '$name',
                    ubicacion = '$location'
                    WHERE ip_switch = '$ip'";
        
        } elseif (!empty($name) && empty($location) && !empty($model)) {

            // Cambia nombre y modelo
            $sql = "UPDATE switch 
                    SET nombre = '$name',
                    modelo = '$model'
                    WHERE ip_switch = '$ip'";
        
        } elseif (empty($name) && !empty($location) && !empty($model)) {

            // Cambia ubicación y modelo
            $sql = "UPDATE switch
                    SET ubicacion = '$location',
                    modelo = '$model'
                    WHERE ip_switch = '$ip'";
        
        } elseif (!empty($name) && !empty($location) && !empty($model)) {

            // Cambia los tres campos
            $sql = "UPDATE switch 
                    SET nombre = '$name',
                    ubicacion = '$location',
                    modelo = '$model'
                    WHERE ip_switch = '$ip'";
        
        }

        // Ejecutar y verificar la consulta
        if ($conn->query($sql) === TRUE) {
            $_SESSION['mensaje-switch_mod'] = "✅ Switch modificar exitosamente.";
        } else {
            $_SESSION['mensaje-switch_mod'] = "❌ Error al modificar switch: " . $conn->error;
        }

    } else {
        $_SESSION['mensaje-switch_mod'] = "⚠️  El switch con la $ip, no existe";
    }

    header("Location: form_switch.php");
    exit;
}

?>