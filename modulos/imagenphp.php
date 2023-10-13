<?php
//inicio sesion
session_start();
//error_reporting(0);
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
$dbhost = "localhost";
$dbuser = "archa_odin";
$dbpass = "root";
$dbname = "archa_user_ehl_sgi";
$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);
if (!$conn){
    die("No hay conexión: ".mysqli_connect_error());
}
// incluir hoja con funcion que actualiza arrays
include 'DatosGrafica.php';
//libreria graficadora
require_once ('src/jpgraph.php');
require_once ('src/jpgraph_line.php');
//variable del formulario
$matricula=$_SESSION['matricula'];

//datos a grafica
list($datay1,$datay2,$datay3)= MatriculaMes($matricula);
array_unshift($datay1,0);
array_unshift($datay2,0);
array_unshift($datay3,0);
/* $datay1 = MatriculaMes($matricula); */
 
// Setup the graph
$graph = new Graph(800,600);
$graph->SetScale("textlin");
 
$theme_class=new UniversalTheme;
 
$graph->SetTheme($theme_class);
$graph->img->SetAntiAliasing(false);
$graph->title->Set('Historico mensual de aforo por matricula');
$graph->SetBox(false);
 
$graph->img->SetAntiAliasing();
 
$graph->yaxis->HideZeroLabel();
$graph->yaxis->HideLine(false);
$graph->yaxis->HideTicks(false,false);
 
$graph->xgrid->Show();
$graph->xgrid->SetLineStyle("solid");
//etiquetas
$graph->xaxis->SetTickLabels($datay2);
$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->SetLabelFormat('%0.1f%%');
$graph->xgrid->SetColor('#E3E3E3');
 
// Create the first line
$p2 = new LinePlot($datay3);
$graph->Add($p2);
$p2->SetColor("#B22222");
$p2->SetLegend('promedio');
$p2->SetWeight(3);
 
// Create the second line
$p1 = new LinePlot($datay1);
$graph->Add($p1);
$p1->SetColor("#6495ED");
$p1->SetLegend('Mes actual');

 
/* // Create the third line
$p3 = new LinePlot($datay3);
$graph->Add($p3);
$p3->SetColor("#FF1493");
$p3->SetLegend('Tienda 3'); */
 
$graph->legend->SetFrameWeight(1);
$graph->legend->SetPos(0.5,0.98,'center','bottom');
 
// Output line
$graph->Stroke();
//BYdaniel

?>