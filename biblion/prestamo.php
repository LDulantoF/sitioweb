<?php 

include 'global/config.php';
include 'global/conexion.php';
include 'comprobante.php';
include 'template/cabecera.php';

?>


<?php

if($_POST){
    $totaldelibros=0;
    $listalibros="";
    $SID=session_id();
    $Correo=$_POST['email'];
    $TIPO='prestamos';
    $ESTADO='no revisado';
    $clavevoucher=$_POST;
    //var_dump($_POST);

     foreach($_SESSION['VOUCHER'] as $indice=> $producto) { 
        $totaldelibros=$totaldelibros+$producto['CANTIDAD'];
        $listalibros= $listalibros."  ".$producto['NOMBRE'];
          
     }
      //sentencia para insertar los datos ingresamos en el formulario
   $sentencia = $pdo->prepare("INSERT INTO tblprestamo ( ClaveTransaccion, Fecha, Correo, Total, Estatus)
        VALUES (:ClaveTransaccion, NOW(), :Correo, :Total, 'pendiente' );");

        $sentencia->bindParam(":ClaveTransaccion", $SID);
        $sentencia->bindParam(":Correo", $Correo);
        $sentencia->bindParam(":Total", $totaldelibros);
        $sentencia->execute();
        $idPrestamo=$pdo->lastInsertId();

        //

        var_dump($idPrestamo);//porque aquí,sí
    
//BUSCAMOS LA LLAVE:

//
$sql = "SELECT ClaveTransaccion FROM tblprestamo WHERE ClaveTransaccion = '$SID'";
//var_dump($sql);
$llavecita=$pdo->prepare($sql);

$llavecita->execute();

$resultado=$llavecita->fetchAll(PDO::FETCH_ASSOC);
var_dump($resultado);








      //  $clavevoucher=$clavevoucher." ".$producto['ClaveTransaccion'];     
/*
       $sentencia1 = $pdo->prepare("I INSERT INTO tbldetalleprestamo ( IDPRESTAMO, IDLIBRO, TIPO, CANTIDAD, ESTADO) VALUES ( '2', '1', 'Ampliacion', '2', 'Rechazado'); ");

        $sentencia1->bindParam(":IDPRESTAMO", $idPrestamo);
        $sentencia1->bindParam(":IDLIBRO", $producto['ID']);
        $sentencia1->bindParam(":TIPO", $TIPO);
        $sentencia1->bindParam(":CANTIDAD", $producto['CANTIDAD']);
        $sentencia1->bindParam(":ESTADO", $ESTADO);
        $sentencia1->execute();

*/
       
         
    foreach($_SESSION['VOUCHER'] as $indice=> $producto) { 

      $sentencia1 = $pdo->prepare("INSERT INTO tbldetalleprestamo ( IDPRESTAMO, IDLIBRO, TIPO, CANTIDAD, ESTADO)
       VALUES ( :IDPRESTAMO, :IDLIBRO, :TIPO, :CANTIDAD, :ESTADO);");

          $sentencia1->bindParam(":IDPRESTAMO", $idPrestamo);
          $sentencia1->bindParam(":IDLIBRO", $producto['ID']);
          $sentencia1->bindParam(":TIPO", $TIPO);
          $sentencia1->bindParam(":CANTIDAD", $producto['CANTIDAD']);
          $sentencia1->bindParam(":ESTADO", $ESTADO);
          $sentencia1->execute();

  }
       
     
    


    echo "<br/><h3>".$totaldelibros."</h3>";
    echo "<br/><h3>".$listalibros."</h3>";
    
   }?>

<div class="jumbotron text-center">
   <h1 class="display-4">! Paso Final!</h1>
   <hr clas="my-4">
   <p class="lead">Estas a punto de retirar la cantidad de <?php echo number_format($totaldelibros,0);"<br/>" ?> copias de los libros :
      <h4>  <?php echo $listalibros;"<br/>" ?> </h4>

   </p>
      <p>La clave asignada a su transacción de  prestamo es : </br>
      <strong><?php echo "$SID"; ?> </strong>
      <a href="<?php echo "validar.php?clavevoucher=" . $SID; ?>&nombre=<?php echo "".$idPrestamo; ?>&estado=<?php echo "".$ESTADO; ?>">Enlace</a>
   </p>
</div>


<?php include 'template/pie.php'; ?>