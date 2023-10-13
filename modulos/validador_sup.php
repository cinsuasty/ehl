<?php
  session_start();
  //error_reporting(0);
  require '../includes/conexion.php';
  $premiso = [1=>"adm",2=>"pro"];
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
  $consulta_verificacion= $conexion->ejecutar('SELECT * FROM firma_supervisor WHERE fecha="'.$_POST['fecha'].'" AND ruta="'.$_POST['ruta'].'";');
  $insertar=$conexion->ejecutar('INSERT INTO `firma_supervisor` (`nombre`,`ruta`,`fecha`, `fecha_revision`, `firma`) VALUES ("'.$_SESSION['usuario'].'","'.$_POST['ruta'].'", "'.$_POST['fecha'].'", CURRENT_TIMESTAMP,"'.$_POST['firma'].'");');
  echo '<script type="text/javascript"> alert("El registro se guardó correctamente"); window.location.href = "revision_supervisor.php";</script>';

?>