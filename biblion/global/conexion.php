<?php


$servidor="mysql:dbname=".BD.";host=".SERVIDOR;


try {

  //creando el objeto pdo para acceder a la BD
    $pdo= new PDO($servidor,USUARIO,PASSWORD,
             array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8")
            ); 
  //  echo "<script>alert('Conectado...')</script>";

    } catch (Exception $e) {

 //    echo "<script>alert('Error...')</script>";
    }

      
?>