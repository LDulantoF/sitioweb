<?php  


session_start();
$mensaje="";

if(isset($_POST['btnAccion'])){


    switch($_POST['btnAccion']){
        Case 'Agregar':
            if(is_numeric($_POST['id'])){
                $ID=$_POST['id'];
                
                $mensaje.="Ok ID correcto ".$ID."<br/>";
            }else{
                $mensaje.="Upss ... ID incorrecto".$ID."<br/>";
            }

            //(1er attributo)
        



        if(is_string($_POST['nombre'])){
            $NOMBRE=$_POST['nombre'];
            $mensaje.="OK NOMBRE".$NOMBRE."<br/>";
        }else{ $mensaje.="Upps ...algo pasa con el nombre del libro"."<br/>"; break;}
//(2do attr)
        if(is_string($_POST['autor'])){
            $AUTOR=$_POST['autor'];
            $mensaje.="OK AUTOR".$AUTOR."<br/>";
        }else{ $mensaje.="Upps ...algo pasa con el autor del libro"."<br/>"; break;}
//(3er attr)
        if(is_string($_POST['categoria'])){
            $CATEGORIA=$_POST['categoria'];
            $mensaje.="OK CATEGORIA".$CATEGORIA."<br/>";
        }else{ $mensaje.="Upps ...algo pasa con la categoria del libro"."<br/>"; break;}
//(4to attr)
        if(is_numeric($_POST['cantidad'])){
            $CANTIDAD=$_POST['cantidad'];
            $mensaje.="OK CANTIDAD".$CANTIDAD."<br/>";
        }else{ $mensaje.="Upps ...algo pasa con la cantidad"."<br/>"; break;}

       
        //validamos lavariable de session 'voucher' para agregar libros  al voucher
        if(!isset($_SESSION['VOUCHER'])){ // si no hay info recupera los datos
            //guardrar info en el arreglo "producto"
            $producto=array(
                'ID_VOUCHER' => str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_LEFT),
                'ID'=>$ID,
                'NOMBRE'=>$NOMBRE,
                'AUTOR'=>$AUTOR,
                'CATEGORIA'=>$CATEGORIA,
                'CANTIDAD'=>$CANTIDAD                
            ); //str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_LEFT),
            $_SESSION['VOUCHER'][0]=$producto;
            $mensaje=print_r($_SESSION,true);
        }else{//para agregar mas libros al voucher
            $idProductos=array_column($_SESSION['VOUCHER'],"ID");
            if(in_array($ID,$idProductos)){
                    echo "<script>alert('El producto ya ha sido seleccionado ...');</script>";
                    $mensaje="";
            }else{
                $NumeroProductos=count($_SESSION['VOUCHER']);
                $producto=array(
                 'ID_VOUCHER' => str_pad(rand(0, pow(10, 4)-1), 4, '0', STR_PAD_LEFT),
                 'ID'=>$ID,
                 'NOMBRE'=>$NOMBRE,
                 'AUTOR'=>$AUTOR,
                 'CATEGORIA'=>$CATEGORIA,
                 'CANTIDAD'=>$CANTIDAD                  
                 );
 
                  $_SESSION['VOUCHER'][$NumeroProductos]=$producto;
                  $mensaje=print_r($_SESSION,true);
                }
            }
        break;
        case "Eliminar":
            if(is_numeric($_POST['id'])){
                    $ID=$_POST['id'];
                    //var_dump($ID);exit();
                    $primero = true;
                  foreach($_SESSION['VOUCHER'] as $indice=>$producto){
                      if($primero){
                        if($producto['ID']==$ID){
                            //var_dump($_SESSION['VOUCHER']);
                            //var_dump(($_SESSION['VOUCHER'][$indice]));exit();
                            
                            unset($_SESSION['VOUCHER'][$indice]);
                            $_SESSION['VOUCHER']=array_values($_SESSION['VOUCHER']); 
                           
                            //echo "<script>alert('Elemento borrado ...');</script>";
                           $primero = false;
                        }
                      }

                }    
    
            }else{
                $mensaje.="Upss ... ID incorrecto".$ID."<br/>";
            }
        break;
    }

}

?>
