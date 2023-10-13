<?php
//inicio sesion
session_start();
//error_reporting(0);
require '../includes/conexion.php';
// libreria
include("generaconsulta.php");
$premiso = [1=>"pro", 2=> "adm"];
$varsession=$_SESSION['usuario'];
$tiposession=$_SESSION['tipo'];
if ($varsession== null || $varsession = ''){
    echo 'Usted no ha iniciado sesión';
    echo '<script> sessionStorage.clear(); </script>';
    echo '<br><a href="../index.html">VOLVER<a>';
    die();
};
//permisos uso modulo
if (array_search($tiposession,$premiso)==false){
    echo 'Usted no tiene permisos para ingresar a este módulo';
    echo '<a href="menu.php"> <br> VOLVER </a>';
}
//conexion BD
$conexion = new Conexion();
$totalmatriculas= $conexion->ejecutar("select matricula, empresa_usuario from rutas where matricula > 0 order by matricula");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Supervisión y control</title>
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
        .datosform{
            font-family: arial,sans-serif;
            text-align: center;
            align-items: center; 
            margin-bottom: 30px;  
        }
        #grafico{
            width: 70%;
            margin-bottom: 50px;
        }
        #tituloMat{
            font-family: arial,sans-serif;
        }
        .areagrafico{
            align-items:center;
            width:90%;
            margin-left: 5%;
            text-align: center;
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
        .greport{
            width: 300px;
        }
        #mensaje{
            font-size: 9px;
            margin-top: 20px;
        }
    </style>
    
</head>
<body>
<h1>Supervisión y control</h1>
<form class="datosform" action="SupervisionControl.php" method="POST">
    <label >Ingrese Número de matrícula a consultar</label>
    <select name="matricula" id="">
        <option value="">Seleccione o escriba una matricula</option>
        <?PHP
        while($fila=mysqli_fetch_assoc($totalmatriculas)){
            echo "<option value='".$fila['matricula']."'>".$fila['matricula']."</option>";
        }
        ?>
    </select>
<!--     <input   type="number" name="matricula">
 -->    <input type="submit" Value="consultar">
 <br>
 <label for="" id="mensaje"> El aplicativo solo muestra los datos de los últimos 30 días calendario</label>
</form>
<div class="areagrafico">
    <?php
        echo '<h3 id="tituloMat"> Matrícula: '. $_REQUEST['matricula'] .'</h3>';
        if(isset($_POST['matricula'])){
        $_SESSION['matricula']=$_POST['matricula'];
        echo'<img id="grafico" src="imagenphp.php" alt="">';
        $cuadroconsulta= 'select  date(A.fecha_registro) as Fecha, sum(round(B.volumen* A.cantidad,2)) as aforo from registro_aforo A join contenedores B on A.recipiente= B.codigo where A.matricula= '.$_POST['matricula'].' and A.fecha_registro> DATE_SUB(CURDATE(), INTERVAL 2 MONTH) group by date(fecha_registro);';
        $cantidadRegistros= 'select sum(Q) as cantidad from (select count(fecha_registro) Q from registro_aforo where matricula= '.$_POST['matricula'].' and fecha_registro > DATE_SUB(CURDATE(), INTERVAL 2 MONTH) group by date(fecha_registro)) as nuevatabla';
        }
        echo '<h2> Resumen e indicadores para la matrícula: '.$_POST['matricula'].'</h2>';
        GenTabla($conexion, $cantidadRegistros);
        GenTabla($conexion, $cuadroconsulta);
    ?>
</div>
<a href="menu.php" ID="volver">VOLVER</a>
</body>
</html>