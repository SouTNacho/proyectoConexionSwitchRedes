<?php

session_start();

/* 
Archivo: modificar.php,
Modifica los datos de un usuario existente.
*/

include 'conexion.php';
$conn = conectar_bd();

//Revisa si el formulario fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Obtenemos los datos enviados desde el formulario
    $old_user = $_POST['old_user'];
    $user = $_POST['usuario'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

    // Preparo consulta para buscar los usuarios existentes de la IP ingresada
    $stmt = "SELECT usuario 
            FROM usuario_ssh";

    // Guardo el resultado en una variable        
    $resultado = $conn->query($stmt);

    /*
    Recorro fila hasta que coincida con la cantidad total de usuarios de esa IP,
    Y guardo cada usuario en el array usuarios[]anteriormente declarado
    */
    while ($fila = $resultado->fetch_assoc()) {
        $usuarios[] = $fila['usuario'];
    }

    // Verifico si el usuario a ingresar esta en la bd
    if (in_array($old_user, $usuarios)) {

        /* 
        Revisamos cual de los siguentes no fue enviado,
        usuario, contrasena (Para Preparar la Consulta).
        */
 
        if (!empty($user) && empty($pass)) {

            // Cambia el usuario
            $sql = "UPDATE usuario_ssh
                    SET usuario = '$user' 
                    WHERE usuario = '$old_user'";

        } elseif (!empty($pass) && empty($user)) {

            // Cambia la contraseña
            $sql = "UPDATE usuario_ssh 
                    SET pass = '$pass'
                    WHERE usuario = '$old_user'";

        } elseif (!empty($user) && !empty($pass)) {

            // Cambia ambos campos
            $sql = "UPDATE usuario_ssh 
                    SET usuario = '$user',
                    pass = '$pass' 
                    WHERE usuario = '$old_user'";

        }

        // Ejecutar y verificar la consulta
        if ($conn -> query($sql) === TRUE) {
            $_SESSION['mensaje_mod'] = "✅ Usuario modificado exitosamente.";

        } else {
            $_SESSION['mensaje_mod'] = "❌ Error al modificar usuario: " . $conn->error;
        }

    } else {
        $_SESSION['mensaje_mod'] = "⚠️ El usuario '$old_user' no existe";
    }

    header("Location: form_usuarios.php");
    exit;
}

?>