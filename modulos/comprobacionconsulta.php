<?php
    session_start();
    //error_reporting(0);
    require '../includes/conexion.php';
    $premiso = [1=>"adm"];
    $varsession=$_SESSION['usuario'];
    $tiposession=$_SESSION['tipo'];
    if ($varsession== null || $varsession = ''){
        echo 'Usted no ha iniciado sesión';
        echo '<br><a href="../index.html">VOLVER<a>';
        die();
    };
    if (array_search($tiposession,$premiso)==false){
        echo 'Usted no tiene permisos para ingresar a este módulo';
        echo '<script> sessionStorage.clear(); </script>';
        echo '<a href="menu.php"> <br> VOLVER </a>';
        die();
    };
    
    $conexion = new Conexion();
             
    $matricula=$_POST["matricula"];
    $modificacionuser=$_SESSION['userchange']=$matricula;
    $query=$conexion->ejecutar("SELECT matricula,empresa_usuario, direccion,ruta FROM rutas WHERE matricula = '".$matricula."'");
    $resultado=mysqli_fetch_array($query);
    $nombres=$conexion->ejecutar("SELECT column_name FROM information_schema.COLUMNS WHERE table_name = 'rutas';");
    $name1=mysqli_fetch_array($nombres);
    $registros=mysqli_num_rows($query);
    $seleccion=$_POST["matricula"];
    $consultaruta=$conexion->ejecutar("SELECT ruta FROM `rutas`  GROUP BY ruta;");
    var_dump($consultaruta);
    

    if(isset($_POST['eliminar'])AND $matricula!="" AND $registros!=0){
        $query1="DELETE FROM rutas WHERE matricula='".$maticula."';";
        $resultado1=$conexion->ejecutar($query1);
        echo '<script type="text/javascript"> alert("La matricula fue eliminada correctamente"); window.location.href = "modificar.php";</script>';
        mysqli_close($conn);
    }else{
       
    }
   
    ?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Pagina de Registro</title>
        <link rel="stylesheet" href="../css/estiloscomprobacion.css">
        <link rel="shortcut icon"
            href="https://habitatlimpio.com/E_H_L/E_H_L/wp-content/uploads/2017/11/empresa-1.png"
            type="image/x-icon">
    </head>
    <body>


        <div class="titulos">
            <img id="logotitulo" src="https://habitatlimpio.com/E_H_L/E_H_L/wp-content/uploads/2017/11/tLogoEHL.png">
        </div>
        <div class="navigation">               
            <a href="/ehl/cerrar_sesion.php" class="button1" > 
            <img src="../imagenes/logout.png">
            <div class="logout" style="position: relative; font-size:12px">
                SALIR
            </div>
        </a>
        </div>
        <div class="cajagrande" style="background-color: transparent;">
            <div class="caja1">
                <p id="titulomenu">
                    MODIFICACION DE USUARIOS CREADOS
                </p>
            </div>
            <div class="container" style="background-color: transparent;">
                <form class="formu1" method="post" action="funcionactualizar.php">
                    <h2>La matricula es : <?php echo $matricula; ?>
                    </h2>
                    <table style="width: 100%;">
                        <tr>
                            <th style="width: 33%;">
                                Tipo de dato
                            </th>
                            <th style="width: 33%;">
                                Datos actuales
                            </th>
                            <th style="width: 33%;">
                                Nuevos datos
                            </th>
                        </tr>
                    </table>
                    <br>
                    <div class="caja11">
                                
                        <?php
                            if($registros==0||$registros==""){   
                                die('El usuario ingresado no se encuentra registrado<a href="../modulos/modificar.php" class="btn-flotante">Volver</a>');
                                }else{
                                for($i=0;$i<mysqli_num_rows($nombres)-1;$i++){
                                $valor= mysqli_fetch_row($nombres);
                                echo '<table><table><tr><th style="width:10vw; text-align:center; text-transform:uppercase">'.$valor[0].'</th></tr></table></table><br>';
                                };
                            }
                        ?>
                    </div>
                    <div class="caja22">
                        <?php
                            $valores=[];    
                            for ($var=0;$var<count($resultado)/2;$var++){
                                echo '<table><table><tr><th><input type="text" readonly="readonly" style="width:10vw;text-align:center" required name='.'input'.$var.'" value="'.$resultado[$var].'"></th></tr></table></table><br>';
                            }
                        ?>
                    </div>   
                    <div class="caja33">    
                        <?php
                            for ($var=0;$var<count($resultado)/2;$var++){
                                if($var==2){
                                echo '
                                <table>
                                    <table>
                                        <tr style="left: 1vw" >
                                            <th>
                                                <select style="width:10.5vw" required name='.'input_'.$var.'>
                                                    <option></option>';
                                                    while($fila=$consultaruta->fetch_assoc()){
                                                        echo '
                                                        <option>'.$fila['ruta'].'</option>
                                                        ';
                                                      };
                                                    echo'
                                                    
                                            </th>
                                        </tr>
                                    </table>
                                </table><br>';
                                }else{
                                echo '
                                <table>
                                    <table>
                                        <tr>
                                            <th ><input required name='.'input_'.$var.' style="width:10vw;text-align:center"></th>
                                        </tr>
                                    </table>
                                </table><br>';
                                }
                            }
                        ?>
                    </div>
                    <div style="position:absolute; bottom:10px; text-align:center;width:30%; left:34% " class="subcaja2">    
                        <input type="submit" value="Modificar" class="botonenviar" >
                    </div>
                </form>
            </div>
            
        </div>
        
        <div>               
        <a href="../modulos/modificar.php" class="btn-flotante">Volver</a>
        </div> 


    </body>

    <footer>
        <div class="piedepagina">
            Ecoprocesos Habitat Limpio. Juntos, trabajando por una mejor calidad
            de vida. Info: ehl.sgi@habitatlimpio.com
        </div>
    </footer>

</html>
