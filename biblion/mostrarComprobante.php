<?php 

include 'global/config.php';
include 'comprobante.php';
include 'template/cabecera.php';
?>


<br>



<h3>Lista de Prestamos</h3>


<?php if(!empty($_SESSION['VOUCHER'])) { ?>

<table class="table table-light table-bordered">
    <tbody> <!-- plantilla -->
        <tr>
            <th width="%40">Nombre</th>      
            <th width="%15" class="text-center">Autor</th>
            <th width="%20" class="text-center">Categoria</th>
            <th width="%10" class="text-center">Cantidad</th>
            <th width="%10" class="text-center">Total de copias </th>
            <th width="%5" class="text-center">---</th>
        </tr>
 <!-- registro traido de la variable session --> 
   <!-- indice de cada posicion en el arreglo producto --> 

   <?php $total=0; ?>
      <?php foreach($_SESSION['VOUCHER'] as $indice=>$producto){?>    
      <tr>
            <td width="%40"><?php echo $producto['NOMBRE'] ?></td>
            <td width="%15" class="text-center"><?php echo $producto['AUTOR'] ?></td>
            <td width="%20" class="text-center"><?php echo $producto['CATEGORIA'] ?></td>
            <td width="%10" class="text-center"><?php echo $producto['CANTIDAD'] ?></td>
            <td width="%10" class="text-center"><?php echo number_format($producto['CANTIDAD']); ?></td>
            <td width="%5">
          <!-- seteando el boton eliminar -->  
            <form action="" method="post">
            
            <input type="hidden" 
            name="id" 
            id="id" 
            value="<?php echo $producto['ID'];?>">

             <button
             class="btn btn-danger"
             type="submit"
             name="btnAccion" 
             value="Eliminar" 
             >Eliminar</button>
            

             </form> 




            </th>     
        </tr>
  <?php $total=$total+($producto['CANTIDAD']); ?>      
  <?php } ?>
        <tr>
            <td colspan="3" align="right"><h3>Total de Prestamos</h3></td>
            <td align="right"><h3><?php echo number_format($total);?></h3></td>
            <td></td>
        </tr>

        <tr>
            <td colspan="5">    
            <form action="prestamo.php" method="post">
        <div class="alert alert-success">

        
            <div class="form-group">
                        <label for="my-input">Porfavor, ingresa tu correo:</label>
                        <input id="email" class="form-control" type="text" name="email"
                        placerholder="escribe tu correo" required>
                    </div>
                    <small id=emailHelp
                    class="form-text text-muted"
                    >
                    Los libros se enviarán a este correo.
                    </small>
        </div>
                <button class="btn btn-primary btn-lg btn-block" type="submit" name="btnAccion" value="solicitar">
                    Solicitar prestamo>>
                </button>


            </form>

               
            </td>
        </tr>
 <!--  -->       
    </tbody>
</table>

<?php }else{ ?>

    <div class="alert alert-success">

       No hay libros regristados  ...
    </div>

<?php } ?>
<?php include 'template/pie.php'; ?>