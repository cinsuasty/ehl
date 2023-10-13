<?php
     session_start();
     require '../includes/conexion.php';
     $premiso = [1=>"adm"];
     $varsession=$_SESSION['usuario'];
     $tiposession=$_SESSION['tipo'];
     if ($varsession== null || $varsession = ''){
         echo 'Usted no ha iniciado sesión';
         echo '<script> sessionStorage.clear(); </script>';
         echo '<br><a href="/../../index.html">VOLVER<a>';
         die();
     };
     //conexion base de datos
     $conexion = new Conexion();
    $contenedores=[1=>'Domestica', 2=>'Semi Industrial', 3=>'Industrial', 4=>'Caneca 20_Gal',5=>'Caneca 25_Gal',6=>'Caneca 35_Gal',7=>'Caneca 55_Gal',8=>'Contenedor 2Y3', 10=>'Contenedor 3Y3', 46=>'Con 770_Lt', 45=>'Con 1100_lt', 47=>'Con 360_Lt'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Correcciones y actualizaciones</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../css/estiloam.css'>

    <link rel="shortcut icon" href="https://habitatlimpio.com/E_H_L/E_H_L/wp-content/uploads/2017/11/empresa-1.png" type="image/x-icon">
    <style>
        h1{
            font-family: arial,sans-serif;
            color: white;
            background-color:rgb(1, 27, 143);
            border-radius: 5px;
            width: 100%;
            text-align: center;
            font-size:2rem; 
            padding-top: 10px;
            padding-bottom: 10px;
        }
        h2{
            font-family: arial,sans-serif;
            color: white;
            background-color: rgb(18, 146, 82);
            border-radius: 5px;
            width: 60%;
            text-align: center;
            font-size: 1rem;
            margin-left:20%;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            padding-left: 10px;
            padding-right: 10px;
        }
        ul{
            list-style: none;
            margin-left:20%;
            width: 60%;
            padding: 0px;

        }
        li{
            width: 100%;
            margin-bottom: 15px;
        }
        a{
            background-color: #ABEBC6;
            text-decoration: none;
            color: black;
            padding-top: 5px;
            padding-bottom: 5px;
            font-size: 1rem; 
            width: 100%;
            border-radius: 5px;
            font-family: arial;
            padding-left: 10px;
            padding-right: 10px;
            display: inline-block;
            text-align: center;
        }
        a:hover{
            background-color: #CCD1D1; 
        }
        #volver{
            position:fixed;
            z-index: 1;
            background-color:rgb(18, 146, 82);
            bottom:0.2vh;
            padding:15px;
            border-radius:10px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            width: 95%;
            text-align: center;
            font-size: 0.7rem;
        }
        #volver:hover{
            background-color:rgb(16, 102, 59);
            padding: 16px;
            }
        form{
            width:90%;
            height:auto;
            margin-left: 5%;
            padding:0px;
        }
       
        #boton_consulta{
            width:100%;
            margin-top: 1%;
            height:30px;
        }
        hr{
            width:90%;
            margin-left:5%;
            margin-top: 3%;
        }
        .resultados{
            border: 1px solid #000;
            border-spacing: 0;
            margin-top: 2%;
            margin-bottom: 5%;
        }
        .resultados tr{
            border: 1px solid #000;
            border-spacing: 0;
        }
        .resultados td{
            text-align: center;
            font-family: arial;
            padding: 10px;
            border: 1px solid #000;
            border-spacing: 0;
        }
        input{
            width:100%;
            
        }
        #validar{
            margin-bottom: 15vh;
            padding:3vh;
            
        }
        .BtnActualizar{
            width:20px;
            height: 20px    ;
        }
       
        @media all and (orientation:landscape) {
            ul{
                display: block;
                padding:none;
                width:100%;
                margin: 0px;
                margin-left:10% ;
            }
            li{
                display: inline;
                padding: none;
                margin: none;
                width:30%;
            }
            input{
            width:31%;
            margin-left:1%;
            margin-right:1%;
            text-align: center;
            }
            select{
            width:150px;
            margin-left:1%;
            margin-right:1%;
            height:22px;
            }
            #boton_consulta{
            width:30%;
            margin-top: 1%;
            margin-left: 1%;
            margin-right: 1%;
            height:30px;
        }
        #correccion{
            margin-top:5vh;
            padding: 10px;
        }
        }

    </style>
    
</head>
<body>
    
    <div class="titulos">
            <img id="logotitulo" src="https://habitatlimpio.com/E_H_L/E_H_L/wp-content/uploads/2017/11/tLogoEHL.png">
        </div>  
        <div class="navigation">               
            <a href="/../../cerrar_sesion.php" class="button1" > 
                <img src="../../imagenes/logout.png" >
                <div class="logout">
                    SALIR
                </div>
            </a>
        </div>
    <h2> Correcciones y actualizaciones:</h2>

    <form action="actualizacion_supervisor.php" method="POST">
        <ul>
            <li> <label for="">Seleccione el Número del Id a corregir o eliminar:</label> </li>
            <li> <input type="number" name="id" required></li>
            <li><input id="boton_consulta" type="submit" value="Consultar"></li>
        </ul>
    </form>
    <hr>
    <center><form method="post" action="actualizacion_supervisor.php"><table class="resultados">
        <?php
        if(isset($_POST['id'])){
            //falta campo firma, se quita porque ocupa mucho espacio en la ventana
            $_SESSION['id']=$_POST['id'];
            $consultaSup= $conexion->ejecutar('select a.id, a.supervisor, a.nombre_conductor, a.ruta, a.matricula, r.empresa_usuario, a.recipiente, a.cantidad, a.fecha_registro, a.posicion from registro_aforo as a LEFT join rutas as r on a.matricula = r.matricula  where a.id='.$_POST['id'].';');
            if($consultaSup !== true and $consultaSup !== false){
                // creacion de tabla para cada uno de las filas del array
                    
                    $nombres=$consultaSup->fetch_fields();
                    echo '<tr>';
                    foreach($nombres as $field){
                        echo '<td><b>'.$field->name.'</b></td>';
                    }
                    echo '</tr>';

                while ($fila=$consultaSup->fetch_assoc()){
                    $conta=0;
                    echo'<tr>'; 
                   
                    foreach($fila as $campo){

                        switch($conta){
                            case 0:
                                echo '<td id="'.$fila['id'].'_'.$conta.'"> <input style="border: 0px; width:30px" name="cantidadN" value="'.$campo.'" required</td>';
                                break;
                            case 6:
                                echo '<td id="'.$fila['id'].'_'.$conta.'">
                                            <select name="recipienteN">
                                                    <option value="'.array_search($contenedores[$campo],$contenedores).'">'.$contenedores[$campo].'</option>
                                                    <option value="1"> Domestica</option>
                                                    <option value="2"> Semi Industrial</option>
                                                    <option value="3"> Industrial</option>
                                                    <option value="4"> Caneca de 20 Gal</option>
                                                    <option value="5"> Caneca de 25 Gal</option>
                                                    <option value="6"> Caneca de 35 Gal</option>
                                                    <option value="7"> Caneca de 55 Gal</option>
                                                    <option value="8"> Contenedor 2 Y3</option>
                                                    <option value="10"> Contenedor 3 Y3</option>
                                                    <option value="46"> Contenedor de 770 lt</option>
                                                    <option value="45"> Contenedor de 1100 lt</option>
                                                    <option value="47"> Contenedor de 360 lt</option>
                                            </select>  </td>';
                                break;
                            case 7:
                                echo '<td id="'.$fila['id'].'_'.$conta.'"> <input name="cantidadN" value="'.$campo.'" type="number" required</td>';
                                break;
                            case 8:
                                echo '<td id="'.$fila['id'].'_'.$conta.'"> <input style="border: 0px; width: 130px" name="fecha_registro" value="'.$campo.'" required</td>';
                                break;
                            default:
                                echo '<td id="'.$fila['id'].'_'.$conta.'">'.$campo.'</td>';
                        };
                        $conta++;   
                    }
                }
            }else{
                echo '<tr><td> Ok. No hay resultados para mostrar</td></tr>';
            }
        }
       
        ?>
    </table>
   
   
    <hr>
    
    <?php
         if(isset($_POST['id'])){
            $consulta_firma= $conexion->ejecutar('select fecha_revision from firma_supervisor where ruta=(select ruta from registro_aforo where id='.$_POST['id'].') and fecha=(select date(fecha_registro) as fecha2 from registro_aforo where id='.$_POST['id'].');');
            $nr =mysqli_num_rows($consulta_firma);
            if($nr==0){
                
                echo '
                <label>¿Desea eliminar el registro?<input name="eliminar" type="checkbox" style="width:20px"> </label> <br>
                <input type="submit" value="Actualizar" id="correccion">
                ';
            }else{
                echo '<center><h3 style="margin-bottom:15vh;">La planilla de aforo del id: '.$_SESSION['id'].', ya ha sido firmada</h3></center>';
            }
        }
        
        if( isset($_POST['cantidadN']) and isset($_POST['recipienteN'])){
            if(isset($_POST['eliminar']) and $_POST['eliminar']==True){
                $conexion->ejecutar('delete from registro_aforo where id='.$_SESSION['id'].';');
            }else{
                $conexion->ejecutar('update registro_aforo set recipiente= '.$_POST['recipienteN'].', cantidad='.$_POST['cantidadN'].', fecha_registro="'.$_POST['fecha_registro'].'" where id='.$_SESSION['id'].';');
            }
            echo '<script> alert("El registro ha sido actualizado"); window.location.href = "actualizacion_supervisor.php"; </script>';
        }
    ?>
    </form>
    </center>
    <a href="menu.php" ID="volver">VOLVER</a>
</body>

</html>