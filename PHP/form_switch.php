<?php session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ABM / Switch</title>
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
        
        <!-- Formulario para agregar switch -->
        <form action="alta_switch.php" method="post">

            <h2>Alta de Switch</h2>

            <label for="">Ingrese IP</label>
            <input class="form-input" type="text" 
                   name="ip_switch-agregar"
                   placeholder="Ingrese IP"
                   required>


            <label for="">Ingrese Nombre</label>
            <input class="form-input" type="text" 
                   name="nombre"
                   placeholder="Ingrese Nombre"
                   required>


            <label for="">Ingrese Modelo</label>
            <input class="form-input" type="text" 
                   name="modelo"
                   placeholder="Ingrese Modelo"
                   required>
  
        
            <label for="">Ingrese Ubicación</label>
            <input class="form-input" type="text" 
                   name="ubicacion"
                   placeholder="Ingrese Ubicación"
                   required>
   

            <input type="submit" 
               value="Insertar Switch" 
               name="btn-enviar">

            <div class="message">
                <?php   if (isset($_SESSION['mensaje-switch_alta'])) {
                        echo "<p style='color:white; margin-top:10px'>" . $_SESSION['mensaje-switch_alta'] . "</p>";
                        unset($_SESSION['mensaje-switch_alta']);
                        }
                ?>
            </div>

        </form>

        <!-- Formulario para Modificar switch -->
        <form action="modificar_switch.php" method="post" class="form"> 

            <h2>Modificacion de Switch</h2>
            
            <label for="">Ingrese IP de Switch</label>
            <input class="form-input" type="text" 
                   name="switch-elegido" 
                   placeholder="IP del Switch a editar">
            
            <label for="">Nombre</label>
            <input class="form-input" type="text" 
                   name="nombre" 
                   placeholder="Ingrese Nombre"> 

            <label for="">Ubicación</label>
            <input class="form-input" type="text" 
                   name="ubicacion" 
                   placeholder="Ingrese Ubicacion">

            <label for="">Modelo</label>
            <input class="form-input" type="text" 
                   name="modelo" 
                   placeholder="Ingrese Modelo">

            <input type="submit" 
                   value="Modificar Switch" 
                   name="btn-enviar">

            <div class="message">
                <?php   if (isset($_SESSION['mensaje-switch_mod'])) {
                        echo "<p style='color:white; margin-top:10px'>" . $_SESSION['mensaje-switch_mod'] . "</p>";
                        unset($_SESSION['mensaje-switch_mod']);
                        }
                ?>
            </div>

        </form>
    </div>
</body>
</html>