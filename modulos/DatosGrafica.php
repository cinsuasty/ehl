<?php
//inicio sesion
session_start();
require '../includes/conexion.php';
$premiso = [1=>"pro", 2=> "adm"];
$varsession=$_SESSION['usuario'];
$tiposession=$_SESSION['tipo'];
if ($varsession== null || $varsession = ''){
    echo 'Usted no ha iniciado sesión';
    echo '<br><a href="../index.html">VOLVER<a>';
    die();
};

//consultar 

function MatriculaMes($matricula){
    //conexion BD
    $conexion = new Conexion();
    // $mesVigente
    $mesVigente = $conexion->ejecutar('select  sum(round(B.volumen* A.cantidad,2)) as aforo from registro_aforo A join contenedores B on A.recipiente= B.codigo where A.matricula= '.$matricula.' and A.fecha_registro> DATE_SUB(CURDATE(), INTERVAL 2 MONTH) group by fecha_registro;');
    // etiquetas
    $etiquetas= $conexion->ejecutar("select day(fecha_registro) as dato from registro_aforo where matricula= ".$matricula." and fecha_registro > DATE_SUB(CURDATE(), INTERVAL 2 MONTH) GROUP BY fecha_registro");
    //$promedio
    $promedio= $conexion->ejecutar('select round(avg(aforo),2) promedio from (select  sum(round(B.volumen* A.cantidad,2)) as aforo from registro_aforo A join contenedores B on A.recipiente= B.codigo where A.matricula= '.$matricula.' and A.fecha_registro> DATE_SUB(CURDATE(), INTERVAL 2 MONTH) group by fecha_registro)as nuevatabla');
    $promedio1= mysqli_fetch_array($promedio);
    $Qdatos=0;
    $datos1= array();
    $datos2= array();
    $datos3= array();
     if($mesVigente->num_rows >0){
        while($row=$mesVigente->fetch_assoc()){
            $datos1[]=floatval($row['aforo']);
            $Qdatos++;
        }
     }
     if($etiquetas->num_rows >0){
        while($row=$etiquetas->fetch_assoc()){
            $datos2[]=floatval($row['dato']);
        }
     }
   
     if($promedio->num_rows >0){
        for($i=0 ;$i < $Qdatos;$i++){
            $datos3[]=floatval($promedio1[0]);
        }
     }
      return [$datos1, $datos2, $datos3]; 
  
}