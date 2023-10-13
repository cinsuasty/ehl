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
    $rutas= $conexion->ejecutar("SELECT ruta FROM rutas GROUP BY ruta");
    $contenedores=[1=>'Domestica', 2=>'Semi Industrial', 3=>'Industrial', 4=>'Caneca 20_Gal',5=>'Caneca 25_Gal',6=>'Caneca 35_Gal',7=>'Caneca 55_Gal',8=>'Contenedor 2Y3', 10=>'Contenedor 3Y3', 46=>'Con 770_Lt', 45=>'Con 1100_lt', 47=>'Con 360_Lt'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Supervisión</title>
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
            }
            li{
                display: inline;
                padding: none;
                margin: none;
            }
            input{
            width:31%;
            margin-left:1%;
            margin-right:1%;
            }
            select{
            width:31%;
            margin-left:1%;
            margin-right:1%;
            height:22px;
            }
            #boton_consulta{
            width:25%;
            margin-top: 1%;
            margin-left: 1%;
            margin-right: 1%;
            height:30px;
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
    <h2> Supervisión y firma:</h2>

    <form action="revision_supervisor.php" method="POST">
       
        <ul>
            <li>Fecha:<input type="date" name="fecha" required></li>
            <li><select name="ruta" required>
                    <option> Seleccione una ruta</option>
                    <?php
                        while($campo= $rutas->fetch_assoc() ){
                            echo '<option value="'.$campo['ruta'].'">'.$campo['ruta'].'</option>';    
                        }
                        
                    ?>
                </select>
            </li>
            <li><input id="boton_consulta" type="submit" value="Consultar"></li>
        </ul>
    </form>
    <hr>
    <center><table class="resultados">
        <?php
        if(isset($_POST['fecha']) and isset($_POST['ruta'])){
            //falta campo firma, se quita porque ocupa mucho espacio en la ventana
            $consultaSup= $conexion->ejecutar('select a.id, a.supervisor, a.nombre_conductor, a.ruta, a.matricula, r.empresa_usuario, a.recipiente, a.cantidad, a.fecha_registro, a.posicion from registro_aforo as a inner join rutas as r on a.matricula = r.matricula  where date(a.fecha_registro)="'.$_POST['fecha'].'" and a.ruta="'.$_POST['ruta'].'"');
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
                    
                        if($conta==6){
                            echo '<td id="'.$fila['id'].'_'.$conta.'">'.$contenedores[$campo].'</td>';
                        }elseif($conta==9){
                            echo '<td id="'.$fila['id'].'_'.$conta.'"> <a href="https://www.google.es/maps?q='.$campo.'" style="background-color:transparent; font-size:12px" target="_blank">'.$campo.'</a></td>';
                        }else{
                       //resultado de cada una de las columnas del array
                            echo '<td id="'.$fila['id'].'_'.$conta.'">'.$campo.'</td>';
                        }
                        $conta++;   
                    }
                    echo '</tr>';
                }
            }else{
                echo '<tr><td> Ok. No hay resultados para mostrar</td></tr>';
            }
        }
       
        ?>
    </table>
   
    </center>
    <hr>
    
    <?php
         if(isset($_POST['fecha']) and isset($_POST['ruta'])){
            $consulta_firma= $conexion->ejecutar('SELECT * FROM firma_supervisor WHERE fecha="'.$_POST['fecha'].'" AND ruta="'.$_POST['ruta'].'";');
            $nr =mysqli_num_rows($consulta_firma);
            if($nr==0){
                $_SESSION['ruta_sup']=$_POST['ruta'];
                $_SESSION['fecha_sup']=$_POST['fecha'];
                echo '<a id="validar" href="firma_sup.php">Validar y firmar</a>
                /* <script type="text/javascript">
                function editor(ide){
                    var etiqueta = ide + "_" + 7;
                    var ValorEtiqueta = document.getElementById(etiqueta);
                    var TextoEtiqueta = ValorEtiqueta.innerText; 
                    ValorEtiqueta.innerHTML= '."'".'<input type='.'"text"'.'name='."'".'+ etiqueta +'."'".' value='."'".'+ TextoEtiqueta +'."'".' style='.'"width:30px; height:auto; margin:0px;"'.'>'."'".';
                        
                };
            </script> */
                ';
            }else{
                echo '<center><h3 style="margin-bottom:15vh;">La planilla de aforo de la ruta '.$_POST['ruta'].' para el día '.$_POST['fecha'].', ya ha sido firmada</h3></center>';
            }
        }
        
    ?>
    <a href="menu.php" ID="volver">VOLVER</a>
</body>

</html>