<?php

$host="localhost";
$bd="sitio";//nombreBD
$usuario="Franco";
$contrasenia="x-RHNBnj3gZ7h/.(";

try {
    $conexion=new PDO("mysql:host=$host;dbname=$bd",$usuario,$contrasenia); 
       if($conexion){echo "";}
    } catch (Exception $ex) {

      echo $ex->getMessage();
    }

    ?>

    