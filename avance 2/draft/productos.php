<?php include("template/cabecera.php");?>



<?php include("admin/config/db.php"); 

        $sentenciaSQL=$conexion->prepare("SELECT * FROM libros");
        $sentenciaSQL->execute();
        $listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($listaLibros as $libro) { ?>
     
<div class="col-md-3">

<table class="table table-bordered" id="tabla">

    <img class="card-img-top" src="./img/<?php echo $libro['imagen'];?>" alt="">
    <div class="card-body">
        <h4 class="card-title"><?php echo $libro['nombre']; ?></h4>
        <a name="" id="" class="btn btn-primary" href="#" role="button"> Ver más</a>   
    </div>

</table>

</div>



<?php } ?> 

<script>
 var tabla= document.querySelector("#tabla");

 var dataTable= new DataTable(tabla);

</script>

<?php include("template/pie.php");?>