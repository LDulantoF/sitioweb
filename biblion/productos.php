<?php include("template/cabecera.php");?>


<?php include("admin/config/db.php"); 
//jalando la llave de usuario y cclave de carpeta admim
    $sql = "SELECT * FROM libros";
?>
<form method="post" action="productos.php">
<label>Buscar Libro</label>
<input type="text" name="search" value="<?php if(isset($_POST["search"])){echo $_POST["search"];}?>">
<input type="submit" name="submit">
<a href="/draft/productos.php">Limpiar</a>
<br/>
 <br/>
 </form>   

<?php 
if($_POST){
    if($_POST["search"]!=""){
        $palabra = $_POST["search"];
        $sql = $sql . " WHERE nombre LIKE '%" . $palabra . "%'";
    }
}
$sentenciaSQL=$conexion->prepare($sql);
$sentenciaSQL->execute();
$listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);
?>

<?php foreach($listaLibros as $libro) { ?>
     
<div class="col-md-3">

<table class="table table-bordered" id="tabla">

    <img class="card-img-top" src="./img/<?php echo $libro['imagen'];?>" alt="">
    <div class="card-body">
        <h4 class="card-title"><?php echo $libro['nombre']; ?></h4>
        <a name="" id="" class="btn btn-primary" href="http://localhost/datosvermasy/" role="button"> Ver más</a>   
    </div>

</table>

</div>


<?php } ?> 


<?php include("template/pie.php");?>

