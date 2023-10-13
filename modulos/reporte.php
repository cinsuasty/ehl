<?php
    session_start();
    //error_reporting(0);
    require '../includes/conexion.php';
    $premiso = [1=>"adm"];
    $varsession=$_SESSION['usuario'];
    $tiposession=$_SESSION['tipo'];
    if ($varsession== null || $varsession = ''){
        echo 'Usted no ha iniciado sesión';
        echo '<script> sessionStorage.clear(); </script>';
        echo '<br><a href="../index.html">VOLVER<a>';
        die();
    };
    if (array_search($tiposession,$premiso)==false){
        echo 'Usted no tiene permisos para ingresar a este módulo';
        echo '<a href="menu.php"> <br> VOLVER </a>';
    }
  
  
    //conexion base de datos
    $conexion = new Conexion();
    function generarCSV($arreglo, $ruta, $delimitador, $encapsulador){
        $file_handle = fopen($ruta, 'w');
        foreach ($arreglo as $linea) {
          fputcsv($file_handle, $linea, $delimitador, $encapsulador);
        }
        rewind($file_handle);
        fclose($file_handle);
      }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Generación de reporte</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
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
            width: 60%;
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
        label{
            font-family: arial;
        }
        input{
            margin: 15px;
            border-radius: 10px;
            padding-left: 3px;
            height:5vh;
            width: 60%;
            font-family: arial;
        }
        form{
            width: 100%;
        }
        .boton{
            width:100%;
            background-color: #121E71;
            cursor: pointer;
            color:white;
            border:0px;

        }
        .boton:hover{
            background-color: #5264E1 ;  
        }
        #greport{
            position: absolute;
            margin-left:20%;
        }
    </style>
    
</head>
<body>
<h1>EHL - GENERACIÓN DE REPORTES </h1>
<h2> Seleccione las fechas:</h2>
<ul>
    <form action="reporte.php" method="post">
        <center>
            <li><label>Fecha inicial: </label> <input type="date" name="fecha_i" required> </li>
            <li> <label>Fecha Final: </label> <input type="date" name="fecha_f" required> </li>
            <li> <input class="boton" type="submit" value="Generar Reporte"> </li>
        </center>
    </form>
</ul> 
<hr>
<?php
    if(isset($_POST['fecha_i']) and isset($_POST['fecha_f'])){
        $Nom_archivo= "Report.csv";
        $consulta= $conexion->ejecutar('SELECT matricula, MONTH(fecha_registro) AS mes, YEAR(fecha_registro) AS anio, DATE(fecha_registro) as fecha, recipiente, cantidad, ruta as observacion FROM registro_aforo WHERE DATE(fecha_registro) BETWEEN "'.$_POST['fecha_i'].'" AND "'.$_POST['fecha_f'].'";');
        generarCSV($consulta,$Nom_archivo,$delimitador = ',',$encapsulador = '"');
        echo '<a id="greport" href="'.$Nom_archivo.'">Reporte</a>';
    }
?>
<a href="menu.php" ID="volver">VOLVER</a>   
