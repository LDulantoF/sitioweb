<?php 

include 'global/config.php';
include 'global/conexion.php';
include 'comprobante.php';
include 'template/cabecera.php';

?>


<?php 

print_r($_POST);
echo  nl2br (" \n ");

if($_POST){
    $IDPRESTAMO=$_POST['IDPRESTAMO'];
    $IDLIBRO=$_POST['IDLIBRO'];
    
    print_r($IDPRESTAMO);
    
     $sentencia=$pdo->prepare("SELECT * FROM tbldetalleprestamo 
                              WHERE IDPRESTAMO=:IDPRESTAMO
                              AND IDLIBRO=:IDLIBRO
                              AND descargado<1");
    
                              $sentencia->bindParam(":IDPRESTAMO",$IDPRESTAMO);
                              $sentencia->bindParam(":IDLIBRO",$IDLIBRO);
                              $sentencia->execute();
    
                              $listaLibros=$sentencia->fetchAll(PDO::FETCH_ASSOC);
    
    
                              print_r($listaLibros);

                              if($sentencia->rowCount()>0){

                                echo "Descagando archivo ...";

                                $nombrelibro="archivos/".$listaLibros[0]['IDLIBRO'].".jpg";

                                $nuevonombre=$_POST['IDPRESTAMO'].$_POST['IDLIBRO'].".jpg";
                                echo  nl2br (" \n ");
                                echo $nuevonombre;

                                header("Content-Transfer-Encoding: binary");
                                header("Content-type: application/force-download");
                                header("Content-Disposition: attachment; filename=$nuevonombre");
                                readfile("$nuevonombre");

/*
                                $sentencia=$pdo->prepare("UPDATE tbldetalleprestamo SET descargado=descargado+1 
                              WHERE IDPRESTAMO=:IDPRESTAMO
                              AND IDLIBRO=:IDLIBRO");
    
                              $sentencia->bindParam(":IDPRESTAMO",$IDPRESTAMO);
                              $sentencia->bindParam(":IDLIBRO",$IDLIBRO);
                              $sentencia->execute();

                     */

                              }else{
                           

                                echo "<br><br><br><h2>Descargas agotadas</h2>";
                             

                              }
}


                        ?>

<?php include 'template/pie.php';?>
