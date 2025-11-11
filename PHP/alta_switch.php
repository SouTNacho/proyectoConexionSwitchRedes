<?php

session_start();

/* 
Archivo: alta_switch.php,
Agrega switch ingresados a la tabla correspondiente.
*/

include 'conexion.php';
$conn = conectar_bd();
$ips = [];

//Revisa si el formulaio fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtenemos los datos enviados desde el formulario
    $ip = $_POST['ip_switch-agregar'];
    $name = $_POST['nombre'];
    $model = $_POST['modelo'];
    $location = $_POST['ubicacion'];

    // Preparo consulta para buscar las IPs existentes
    $stmt = "SELECT ip_switch FROM switch";

    // Guardo el resultado en una variable        
    $resultado = $conn->query($stmt);

    /*
    Recorro fila hasta que coincida con la cantidad total IPs de la talba,
    Y guardo cada IP en el array ips[]anteriormente declarado
    */
    while ($fila = $resultado->fetch_assoc()) {
        $ips[] = $fila["ip_switch"];
    }

    // Verifico si la IP ya esta en uso
    if (!in_array($ip, $ips)) {

        // Verificamos si el usuario cargo todos los datos (Ninguno Vacio)
        if (empty($ip) || empty($name) || empty($model) || empty($location)) {
            die("Error: Todos los campos son obligatorios");
        }

        // Generamos consulta SQL
        $sql = "INSERT INTO switch (ip_switch, nombre, ubicacion, modelo) VALUES ('$ip', '$name', '$location', '$model')";   
        
        // Ejecutar y verificar la consulta
        if ($conn->query($sql)) {
            $_SESSION['mensaje-switch_alta'] = "✅ Switch agregado exitosamente.";
        } else {
            $_SESSION['mensaje-switch_alta'] = "❌ Error al agregar switch: " . $conn->error;
        }

    } else {
        $_SESSION['mensaje-switch_alta'] = "⚠️  La IP $ip, ya esta en uso";
    }

    header("Location: form_switch.php");
    exit;
}

?>