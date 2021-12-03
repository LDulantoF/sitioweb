<?php 

include 'global/config.php';
include 'global/conexion.php';
include 'comprobante.php';
include 'template/cabecera.php';

?>


<?php
//recuperando las variables
print_r($_GET);

$token=$_GET['clavevoucher'];

print_r($token);

$idprestamo=$_GET['nombre'];

echo  nl2br (" \n ");
print_r($idprestamo);

$estatuz=$_GET['estado'];

echo  nl2br (" \n ");




echo  nl2br (" \n ");

print_r($estatuz);

if($estatuz=="no revisado"){
 
    $mensaje="<h3> Prestamo aprobado</h3>";

    $sentencia=$pdo->prepare("UPDATE tblprestamo 
    SET Estatus = 'aprobado'
     WHERE tblprestamo.ID = :ID;");

    $sentencia->bindParam(":ID",$idprestamo);
   // $sentencia->bindParam(":",$idprestamo);
    $sentencia->execute();
    $completado=$sentencia->rowCount();
    
}else{
    $mensaje="<h3> Prestamo aprobado</h3>";
    $mensaje="<h3>Hay un problema en el prestamo</h3>";
}

echo $mensaje;

?>

<div class="jumbotron">
    <h1 class="display-4">! Listo !</h1>

    <hr class="my-4">

    <p class="lead"><?php echo $token; ?></p>

    <p>
<?php
    if($completado>=1){

        


        $sentencia=$pdo->prepare("SELECT * FROM tbldetalleprestamo,libros WHERE tbldetalleprestamo.IDLIBRO=libros.ID AND tbldetalleprestamo.IDPRESTAMO=:ID" );

    $sentencia->bindParam(":ID",$idprestamo);
   // $sentencia->bindParam(":",$idprestamo);
    $sentencia->execute();


   $listalibros=$sentencia->fetchAll(PDO::FETCH_ASSOC);
   print_r($listalibros);

    }
    ?>

<div class="row">
    <?php foreach($listalibros as $producto){ ?>
    <div class="col-2">
        <div class="card">
        <img clas="card-img-top" src="img/<?php echo $producto['imagen']; ?>">
        <div class="card-body">
                
        <p class="card-text"><?php echo $producto['nombre']; ?></p>




        

  <form action="retirar.php" method="post">



    <input type="text" name="IDPRESTAMO" id="" value="<?php echo $idprestamo; ?>">
    <input type="text" name="IDLIBRO" id="" value="<?php echo $producto['IDLIBRO']; ?>"> 

                <button class="btn btn-success" type="submit">Descargar</button>         

   </form>     


        </div>
        </div>

    </div>
    <?php } ?>
</div>

    </p>
</div>
