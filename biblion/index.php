<?php 

include 'global/config.php';
include 'global/conexion.php';
include 'comprobante.php';
include 'template/cabecera.php';

?>




<div class="alert alert-success">

<?php echo ($mensaje); ?>

</div>



<div class="row">

<?php 

  $sentencia=$pdo->prepare("SELECT * FROM `libros` ");
  $sentencia->execute();
  $listaProductos=$sentencia->fetchAll(PDO::FETCH_ASSOC);
  print_r($listaProductos);
?>


<?php foreach($listaProductos as $producto) { ?> <!-- para recorrer cada 1 de los casillero y luego imprimir.
 para recorrer cada 1 de los casillero y luego imprimir.// 4 libros en 3 columnas-->
    <div class="col-3">
  <div class="card">
    <img
      tittle="<?php echo $producto['nombre']; ?>"
      alt="<?php echo $producto['nombre']; ?>"
      class="card-img-top"
      src="img/<?php echo $producto['imagen']; ?>"
      height="317px"
      >


      <div class="card-body">
        <span><?php echo  $producto['nombre'];?></span>
        <h5 class="card-title"><?php echo $producto['autor']; ?></h5>
        <p class="card-text"><?php echo  $producto['categoria']; ?></p>

        <form action="" method="post">
<!-- encriptando el texto plano -->
         <input type="text" name="id" id="id" value="<?php echo  $producto['id'];?>">
         
         <input type="text" name="nombre" id="nombre" value="<?php echo  $producto['nombre'];?>">
         <input type="text" name="autor" id="autor" value="<?php echo  $producto['autor'];?>">
         <input type="text" name="categoria" id="categoria" value="<?php echo  $producto['categoria'];?>">   
         <input type="text" name="cantidad" id="cantidad" value="<?php echo  $producto['cantidad'];?>">
        
            <button class="btn btn-primary"
            name="btnAccion"
            value="Agregar"
            type="submit"
            >
            Pedir Prestamo
            </button>

        </form>


      </div>
  </div>







</div>
<?php } ?> 

<?php include 'template/pie.php'; ?>