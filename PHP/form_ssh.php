<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SSH</title>
    <link rel="stylesheet" href="../Css/ssh_style.css">
    <link rel="shortcut icon" href="../Src/switch1.png" type="image/x-icon">
</head>
<body>
    <div class="head">

        <button class="btn-inicio">
            <a href='../index.html' class="btn-inicio-link">Volver al inicio</a>
        </button>

    </div>
    <div class="main">

    <?php 

    session_start();

    include 'conexion.php';
    $conn = conectar_bd();

    // Preparo la consulta para buscar los switchs ingresados
    $check_stmt = "SELECT nombre FROM switch ORDER BY nombre ASC";

    // Guardo resultado en una variable
    $check_result = $conn->query($check_stmt);
        
        // <!-- Formulario para seleccionar switch -->
        echo '<form action="" method="post">';
        echo '<h2>Seleccionar Switch</h2>';           
        echo '<label for="switch">Selecciona el Switch</label>';
        echo '<select name="switch" class="form-input">';

        // Recorro todos los valores $resultado 
        while ($f = $check_result->fetch_assoc()) {
            echo "<option value='" . $f['nombre'] . "'>" . $f['nombre'] . "</option>";
        }
          
        echo '</select>';
        echo '<input type="submit" value="Elegir Switch" name="elegir">';
        echo '</form>';
 

        if (isset($_POST['elegir'])) {

            // Obtenemos los datos enviados desde el formulario
            $switch = $_POST['switch'];

            // Preparo la consulta para buscar lo usuarios del switch elegido
            $stmt = "SELECT usuario, pass
                    FROM usuario_ssh
                    INNER JOIN switch
                    ON switch.ip_switch = usuario_ssh.ip_switch
                    WHERE nombre = '$switch'
                    ORDER BY usuario ASC";

            // Guardo resultado en una variable
            $resultado = $conn->query($stmt);

            // Verifico que el switch seleccionado tenga usuarios
            if($resultado->num_rows > 0) {

                /*
                Creo la estructura para el formulario,
                el cual aparecera solo si el switch tiene usuarios
                */

                echo '<form action="" method="post">';
                echo '<h2>Seleccionar Usuario</h2>';
                echo "<p class='switch-info'>Switch elegido: $switch</p>";
                echo '<label for="user_switch">Selecciona el Usuario</label>';
                echo '<select name="user_switch" class="form-input">';

                // Recorro todos los valores $resultado 
                while ($fila = $resultado->fetch_assoc()) {
                    echo "<option value='" . $fila['usuario'] . "'>" . $fila['usuario'] . "</option>";
                }

                echo '</select>';

                echo '<label for="pass_user">Ingrese Contraseña</label>';
                echo '<input class="form-input" type="password" name="pass_user" placeholder="Ingrese Contraseña" required>';

                echo '<input type="submit" value="Iniciar Sesión SSH" name="user">';
                echo '</form>';

            } else {
                echo "<div class='resultado-conter'>";
                echo "<h3>Error</h3>";
                echo "<p class='error-message'>❌ No se encontraron usuarios para este switch</p>";
                echo "</div>";
            }   

        }

        if (isset($_POST['user'])) {
            if (!empty($_POST["user_switch"])) {
                $user = $_POST["user_switch"];
                $pass = $_POST["pass_user"];
                
                // Preparo la consulta para traer de la bd la contraseña correspondiente al usuario elegido
                $sql = "SELECT pass, usuario, ip_switch 
                        FROM usuario_ssh
                        WHERE usuario ='$user'";

                // Guardo resultado en una variable
                $result = $conn->query($sql);

                // Verifico que el usuario seleccionado exista
                if ($result->num_rows > 0) {

                    $usuario = $result->fetch_assoc();
                    
                    // Verifico que la contraseña ingresada coincida con la de la BD
                    if (password_verify($pass, $usuario['pass'])) { 

                        $_SESSION['nombre'] = $usuario['usuario'];
                        $_SESSION['switch_ip'] = $usuario['ip_switch'];
                        $_SESSION['pass'] = $pass;

                        /* Creo la estructura HTML, que aparecera solo si las contraseñas coinciden */
                        echo "<div class='resultado-conter'>";
                        echo "<h3>✅ Sesión SSH Iniciada</h3>";
                        echo "<p><strong>Switch IP:</strong> " . $_SESSION['switch_ip'] . "</p>";
                        echo "<p><strong>Usuario:</strong> " . $_SESSION['nombre'] . "</p>";
                        echo "<a href='ssh_switch.php' class='btn-acceso'>Ventana de comandos</a>";
                        echo "</div>";

                    } else {
                        echo "<div class='resultado-conter'>";
                        echo "<h3>Error de Autenticación</h3>";
                        echo "<p class='error-message'>❌ Contraseña incorrecta</p>";
                        echo "</div>";
                    }

                } else {
                    echo "<div class='resultado-conter'>";
                    echo "<h3>Error de Usuario</h3>";
                    echo "<p class='error-message'>❌ Usuario no encontrado</p>";
                    echo "</div>";
                }
            }
        }
        ?>
    </div>
</body>
</html>