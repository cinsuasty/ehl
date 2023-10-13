<?php
// libreria
include("generaconsulta.php");
//inicio sesion
session_start();
//error_reporting(0);
require '../includes/conexion.php';
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
    die();
}
//conexion BD
$conexion = new Conexion();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Seguimiento a la Supervisión</title>
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
        h3{
            font-family: arial,sans-serif;
            color: white;
            background-color: #9797CB;
            border-radius: 5px;
            width: 66%;
            text-align: center;
            font-size: 1rem;
            margin-left:17%;
            padding-top: 0.2rem;
            padding-bottom: 0.2rem;
            padding-left: 10px;
            padding-right: 10px;
        }
    </style>
    
</head>
<body>
<h1>Seguimiento a la supervisión</h1>
<form class="datosform" action="SeguimientoSup.php" method="POST">
    <label >Ingrese fecha de inicio: </label>
    <input type="date" name="fechainicio" required id="fechainicio" max= <?php echo date("Y-m-d"); ?>>
    <label >Ingrese fecha fin: </label>
    <input type="date" name="fechafin" required id="fechafin" max= <?php echo date("Y-m-d"); ?> >
    <input type="submit" Value="consultar">
 <br>
</form>
<h2> Resumen de firmas de supervisor por fecha: </h2>
<div class="areagrafico">
<?php

if(isset($_POST['fechainicio'])){
    $fechaN=$_POST['fechainicio'];
    while($fechaN <= $_POST['fechafin']){
        $cuadroconsulta='select date(a.fecha_registro) fecha, a.ruta, count(a.id) cantidad, b.fecha_revision, b.nombre from registro_aforo as a left join firma_supervisor as b on a.ruta=b.ruta and b.fecha= date("'.$fechaN.'") where date(a.fecha_registro)= date("'.$fechaN.'")  group by a.ruta';
        echo '<h3>'.$fechaN.'</h3>';
        GenTabla($conexion,$cuadroconsulta);
        $fechaN=date("Y-m-d",strtotime($fechaN."+ 1 day"));
    }
}
?>
</div>
<a href="menu.php" ID="volver">VOLVER</a>
</body>
<script>
    const fechafin= document.querySelector("#fechafin");
    const fechainicio= document.querySelector("#fechainicio");
    fechafin.addEventListener("change",alertafecha);
    fechainicio.addEventListener("change",alertafecha2);
    function alertafecha(){
        if( fechafin.value < fechainicio.value){
            alert("La fecha final no puede ser mayor a la fecha de hoy ni debe ser antes a la fecha de inicio");
            fechafin.value="";
        }
    }
    function alertafecha2(){
        if(fechafin.value != 0){
            if(fechainicio.value > fechafin.value){
                alert("La fecha final no puede ser mayor a la fecha de hoy ni debe ser antes a la fecha de inicio");
                fechainicio.value="";
            }
        }
    }
</script>
</html>