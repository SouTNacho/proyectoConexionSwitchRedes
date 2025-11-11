<?php

session_start();

/* 
Archivo: baja.php,
Elimina Usuarios de la tabla correspondiente.
*/

include 'conexion.php';
$conn = conectar_bd();

//Revisa si el formulaio fue enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Obtenemos los datos enviados desde el formulario
    $user = $_POST['usuario'];

    // Preparo consulta para buscar los usuarios existentes de la IP ingresada
    $stmt = "SELECT usuario 
            FROM usuario_ssh
            WHERE usuario = '$user'";

    // Guardo el resultado en una variable        
    $resultado = $conn->query($stmt);

    // Verifico si el usuario a eliminar esta en la bd
    if ($resultado->num_rows > 0) {

        // Preparamos la consulta para eliminar el usuario
        $sql = "DELETE FROM usuario_ssh WHERE usuario = '$user'";

        // Ejecutar y verificar la consulta
        if ($conn -> query($sql) === TRUE) {
            $_SESSION['mensaje_baja'] = "✅ Usuario agregado exitosamente.";

        } else {
            $_SESSION['mensaje_baja'] = "❌ Error al agregar usuario: " . $conn->error;
        }

    } else {
        $_SESSION['mensaje_baja'] = "⚠️ El usuario '$user' no existe.";
    }

    header("Location: form_usuarios.php");
    exit;
}

?>