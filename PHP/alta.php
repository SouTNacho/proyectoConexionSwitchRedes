<?php

session_start();

/* 
Archivo: alta.php,
Agrega Usuarios a la tabla correspondiente.
*/

include 'conexion.php';
$conn = conectar_bd();
$usuarios = [];

//Revisa si el formulaio fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Otenemos IP para preparar consulta
    $ip = $_POST['ip_switch'];

    // Preparamos consulta para ver si hay algun switch que este usando la IP ingresada
    $check_stmt = "SELECT nombre FROM switch WHERE ip_switch = '$ip'";

    // Guardo el resultado en una variable
    $check_resultado = $conn->query($check_stmt);

    //Verifico si existe switch asociado
    if ($check_resultado->num_rows > 0) {

        // Obtenemos los demas datos enviados desde el formulario
        $user = $_POST['usuario'];
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

        // Preparo consulta para buscar los usuarios existentes de la IP ingresada
        $stmt = "SELECT usuario 
                 FROM usuario_ssh 
                 WHERE ip_switch = '$ip'";

        // Guardo el resultado en una variable        
        $resultado = $conn->query($stmt);

        /*
        Recorro fila hasta que coincida con la cantidad total de usuarios de esa IP,
        Y guardo cada usuario en el array usuarios[]anteriormente declarado
        */
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila['usuario'];
        }

        // Verifico si el usuario a ingresar no esta en la bd
        if (!in_array($user, $usuarios)) {

            //Preparo la consulta para insertar un nuevo usuario
            $sql = "INSERT INTO usuario_ssh (ip_switch, usuario, pass, fecha_registro) VALUES ('$ip', '$user', '$pass', NOW())";

            // Ejecutar y verificar la consulta
            if ($conn->query($sql) === TRUE) {
                $_SESSION['mensaje_alta'] = "✅ Usuario agregado exitosamente.";

            } else {
                $_SESSION['mensaje_alta'] = "❌ Error al agregar usuario: " . $conn->error;
            }

        } else {
            $_SESSION['mensaje_alta'] = "⚠️ El usuario '$user' ya existe para la IP $ip.";
        }

    } else {
         $_SESSION['mensaje_alta'] = "⚠️ No existe ningun Switch asociado a la IP $ip.";
    }

    header("Location: form_usuarios.php");
    exit;
}

?>