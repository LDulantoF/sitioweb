<?php include("../template/cabecera.php"); ?>

<?php 

$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtAutor=(isset($_POST['txtAutor']))?$_POST['txtAutor']:"";
$txtCategoria=(isset($_POST['txtCategoria']))?$_POST['txtCategoria']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion']))?$_POST['accion']:"";

include("../config/db.php");

switch($accion){
        case "Agregar":
            $sentenciaSQL=$conexion->prepare("INSERT INTO libros (nombre,autor,categoria,imagen) VALUES (:nombre,:autor,:categoria, :imagen);");
            $sentenciaSQL->bindParam(':nombre',$txtNombre);
            $sentenciaSQL->bindParam(':autor',$txtAutor);
            $sentenciaSQL->bindParam(':categoria',$txtCategoria);

            $fecha=new Datetime();
            $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";

            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
            
            if($tmpImagen!=""){
            //copiar la imagen en el archivo
                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);
            }

            $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
            $sentenciaSQL->execute();
            header("Location.productos.php");
            break;

        case "Modificar":
            $sentenciaSQL=$conexion->prepare("UPDATE libros SET nombre=:nombre WHERE id=:id");
            $sentenciaSQL->bindParam(':nombre',$txtNombre);
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();

            if($txtImagen!=""){

                $fecha=new Datetime();
                $nombreArchivo=($txtImagen!="")?$fecha->getTimestamp()."_".$_FILES["txtImagen"]["name"]:"imagen.jpg";
                
                $tmpImagen=$_FILES["txtImagen"]["tmp_name"];
                move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

                $sentenciaSQL=$conexion->prepare("SELECT imagen  FROM libros WHERE id=:id");
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
                $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);  
    
                if(isset($libro["imagen"]) &&  ($libro["imagen"]!="imagen.jpg")){
    
    
                    if(file_exists("../../img/".$libro["imagen"])){
                        unlink("../../img/".$libro["imagen"]);
                    }
                }




                $sentenciaSQL=$conexion->prepare("UPDATE libros SET imagen=:imagen WHERE id=:id");
                $sentenciaSQL->bindParam(':imagen',$nombreArchivo);
                $sentenciaSQL->bindParam(':id',$txtID);
                $sentenciaSQL->execute();
            }
            header("Location.productos.php");
            break;

        case "Cancelar":
            header("Location.productos.php");
            break;

        case "Seleccionar":
            $sentenciaSQL=$conexion->prepare("SELECT *  FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);  
            
            $txtNombre=$libro['nombre'];
            $txtAutor=$libro['autor'];
            $txtCategoria=$libro['categoria'];
            $txtImagen=$libro['imagen'];
            break;

        case "Borrar":

            $sentenciaSQL=$conexion->prepare("SELECT imagen  FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY);  

            if(isset($libro["imagen"])&&($libro["imagen"]!="imagen.jpg") ){

                 if(file_exists("../../img/".$libro["imagen"])){
                     unlink("../../img/".$libro["imagen"]);
                 }

            }

            $sentenciaSQL=$conexion->prepare("DELETE FROM libros WHERE id=:id");
            $sentenciaSQL->bindParam(':id',$txtID);
            $sentenciaSQL->execute();
            header("Location.productos.php");
            break;        
}

        $sentenciaSQL=$conexion->prepare("SELECT * FROM libros");
        $sentenciaSQL->execute();
        $listaLibros=$sentenciaSQL->fetchAll(PDO::FETCH_ASSOC);


?>
 
<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Datos de Libro
        </div>
        <div class="card-body">
           
        <form method="POST" enctype="multipart/form-data">

<div class = "form-group">
<label for="txtID">ID:</label>
<input type="text" required readonly class="form-control" value="<?php echo $txtID?>" name="txtID" id="txtID"  placeholder="ID">
</div>

<div class = "form-group">
<label for="txtNombre">Nombre:</label>
<input type="text" required class="form-control" value="<?php echo $txtNombre?>" name="txtNombre" id="txtNombre"  placeholder="Nombre del libro">
</div>

<div class = "form-group">
<label for="txtAutor">Autor:</label>
<input type="text" required class="form-control" value="<?php echo $txtAutor?>" name="txtAutor" id="txtAutor"  placeholder="Nombre del Autor">
</div>

<div class = "form-group">
<label for="txtNombre">Categoria:</label>
<input type="text" required class="form-control" value="<?php echo $txtCategoria?>" name="txtCategoria" id="txtCategoria"  placeholder="Ingrese Categoria">
</div>

<div class = "form-group">
<label for="txtNombre">Imagen:</label>
<br/>


<?php if($txtImagen!=""){?>

    <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>" width="50" alt="" srcset="">

<?php } ?>

<input type="file"   class="form-control" name="txtImagen" id="txtIamgen"  placeholder="Nombre del libro">
</div>



 <div class="btn-group" role="group" aria-label="">
     <button type="submit" name="accion" <?php echo($accion=="Seleccionar")?"disabled":""; ?> value="Agregar" class="btn btn-success"> Agregar</button>
     <button type="submit" name="accion" <?php echo($accion!="Seleccionar")?"disabled":""; ?> value="Modificar" class="btn btn-warning"> Modificar</button>
     <button type="submit" name="accion" <?php echo($accion!="Seleccionar")?"disabled":""; ?>value="Cancelar" class="btn btn-info"> Cancelar</button>
 </div>


</form>




        </div>
       
    </div>

    
    
</div>








<div class="col-md-7">
    <table class="table table-bordered" id="tabla">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Autor</th>
                <th>Categoria</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($listaLibros as $libro) { ?>
            <tr>
                <td ><?php echo $libro['id'];?></td>
                <td><?php echo $libro['nombre'];?></td>
                <td><?php echo $libro['autor'];?></td>
                <td><?php echo $libro['categoria'];?></td>
                 <td>

                <img class="img-thumbnail rounded" src="../../img/<?php echo $libro['imagen'];?>" width="50" alt="" srcset="">
                </td>
                <td>

                <form  method="post">
                <input type="hidden" name="txtID" id="textID" value="<?php echo $libro['id'];?>">
                <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary">
                <input type="submit" name="accion" value="Borrar" class="btn btn-danger">
                </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


/* script de búsqueda */
<script>

    var tabla=document.querySelector("#tabla");

    var dataTable = new DataTable(tabla);

</script>


/* script de filtrado*/
<script>
    $('.tabla').DataTable({
        initComplete: function  () {
            this.api().columns().every( function () {
                var column=this;
                var select = $('<select><option value=""></option></select>')
                .appendTo( $(column.header()).empty() )
                .on('change', function(){
                var val = $.fn.dataTable.util.escapeRegex(    
                    $(this).val()
                );
                  column
                  .search(val ? '^'+val+'$':'',true,false)
                  .draw(); 
                
            });
            column.data().unique().sort().each( function( d , j ) {
                select.append('<option value="'+d+'">'+d+'</option>')
            }); 
        }); 
    }
                
    });
</script>

<?php include("../template/pie.php");?>