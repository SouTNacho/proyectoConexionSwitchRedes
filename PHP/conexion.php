<?php

function conectar_bd() {

    $conn = mysqli_connect("localhost", "root", "", "redes_bd");

    if ($conn -> connect_error) {
    die("Error al conectar: " . $conn -> connect_error);
}

    return $conn;

}

?>