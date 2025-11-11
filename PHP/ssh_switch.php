<?php
session_start();

// Verificación CORRECTA de sesión
if (!isset($_SESSION['nombre']) || !isset($_SESSION['switch_ip']) || !isset($_SESSION['pass'])) {
    echo "<div style='padding: 20px; text-align: center;'>";
    echo "Sesión no iniciada. <a href='form_ssh.php'>Volver al ingreso con un usuario válido</a>";
    echo "</div>";
    exit;
}

include 'conexion.php';
require 'vendor/autoload.php';

use phpseclib3\Net\SSH2;

$usuario = $_SESSION['nombre'];
$ip = $_SESSION['switch_ip'];
$pass = $_SESSION['pass'];
$output = "";
$error = "";

if (isset($_POST['enviar_comando'])) {
    $comando = trim($_POST['comando']);
    
    if (!empty($comando)) {
        $ssh = new SSH2($ip);
        
        if (!$ssh->login($usuario, $pass)) {
            $error = "Error, No se pudo conectar al switch";
        } else {
            $output = $ssh->exec($comando);
            if ($output === false) {
                $error = "Error al ejecutar el comando";
            }
        }
    } else {
        $error = "Por favor, ingrese un comando";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conexión SSH</title>
    <link rel="stylesheet" href="../Css/ssh_style.css">
</head>
<body>
    <div class="main">
        <form action="" method="post">
            <h2>CONEXIÓN SSH IP: <?php echo htmlspecialchars($ip); ?></h2>
            <p>Usuario: <?php echo htmlspecialchars($usuario); ?></p>
            
            <label for="comando">Comando:</label>
            <input type="text" name="comando" placeholder="Ingrese comando SSH" required>
            <input type="submit" name="enviar_comando" value="Ejecutar Comando">
            
            <?php if (!empty($error)): ?>
                <div class='error-message'>
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <?php if (isset($_POST['enviar_comando']) && empty($error)): ?>
                <div class='resultado'>
                    <h3>Resultado:</h3>
                    <pre><?php echo htmlspecialchars($output); ?></pre>
                    <a href='logout.php'>Cerrar Sesión / Ingresar con otro usuario</a>
                </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>