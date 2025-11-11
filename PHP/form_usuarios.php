<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABM / Usuarios</title>
    <link rel="stylesheet" href="../Css/form_style.css">
    <link rel="shortcut icon" href="../Src/switch1.png" type="image/x-icon">
</head>
<body>
    <div class="head">
            
        <button class="btn-inicio">
            <a href='../index.html' class="btn-inicio-link">Volver al inicio</a>
        </button>

    </div>
    <div class="main">

        <!-- Formulario para agregar usuarios -->
        <form action="alta.php" method="post">
        
            <h2>Alta de Usuarios</h2>

            <label for="">Ingrese IP</label>
            <input class="form-input" type="text"            
                   name="ip_switch"
                   placeholder="Ingrese IP"
                   required>

            <label for="">Ingrese Usuario</label>
            <input class="form-input" type="text"
                   name="usuario"
                   placeholder="Ingrese Usuario"
                   required>

            <label for="">Ingrese Contrasenha</label>
            <input class="form-input" type="text"
                   name="pass"
                   placeholder="Ingrese Contasenha"
                   required>

            <input type="submit" 
                   value="Insertar Usuarios" 
                   name="btn-enviar">

            <div class="message">
                <?php   if (isset($_SESSION['mensaje_alta'])) {
                        echo "<p style='color:white; margin-top:10px'>" . $_SESSION['mensaje_alta'] . "</p>";
                        unset($_SESSION['mensaje_alta']);
                        }
                ?>
            </div>

        </form>

        <!-- Formulario para modificar usuarios -->
        <form action="modificar.php" method="post">
        
            <h2>Modificacion de Usuarios</h2>

            <label for="">Ingrese Usuario a Modificar</label>
            <input class="form-input" type="text" 
                    name="old_user" 
                    placeholder="Ingrese el usuario a editar">

            <label for="">Ingrese Usuario</label> 
            <input class="form-input" type="text" 
                    name="usuario" 
                    placeholder="Complete Campo a Modificar">

            <label for="">Ingrese Contrasenha</label>
            <input class="form-input" type="text" 
                   name="pass" 
                   placeholder="Complete Campo a Modificar">

            <input type="submit" 
                   value="Modificar Usuarios" 
                   name="btn-enviar">

            <div class="message">
                <?php   if (isset($_SESSION['mensaje_mod'])) {
                        echo "<p>" . $_SESSION['mensaje_mod'] . "</p>";
                        unset($_SESSION['mensaje_mod']);
                        }
                ?>
            </div>
            
        </form>

        <!-- Formulario para borrar usuarios -->
        <form action="baja.php" method="post" class="form-borrar">
        
            <h2>Baja de Usuarios</h2>
        
            <label for="">Ingrese Usuario</label>
            <input class="form-input" type="text"
                   name="usuario"
                   placeholder="Usuario a Eliminar"
                   required>

            <input type="submit" 
                   value="Eliminar Usuarios" 
                   name="btn-enviar">

            <div class="message">
                <?php   if (isset($_SESSION['mensaje_baja'])) {
                        echo "<p style='color:white; margin-top:10px'>" . $_SESSION['mensaje_baja'] . "</p>";
                        unset($_SESSION['mensaje_baja']);
                        }
                ?>
            </div>
        
        </form>
    </div>
</body>
</html>