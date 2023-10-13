<?php
  session_start();
  require '../../includes/conexion.php';
  $premiso = [1=>"adm",2=>"pro",3=>"bsc"];
  $varsession=$_SESSION['usuario'];
  $tiposession=$_SESSION['tipo'];
  if ($varsession== null || $varsession = ''){
      echo 'Usted no ha iniciado sesión';
      echo '<br><a href="../index.html">VOLVER<a>';
      die();
  };
  if (array_search($tiposession,$premiso)==false){
      echo 'Usted no tiene permisos para ingresar a este módulo';
      echo '<a href="menu.php"> <br> VOLVER </a>';
  }


  //conexion base de datos
  $conexion = new Conexion();
  echo '<pre>';
  print_r($_POST);
  echo '</pre>';
  $posicion=strpos($_POST['matricula'],' ');
  $numeromat=substr($_POST['matricula'],0,$posicion);
  $insertar= $conexion->ejecutar('INSERT INTO `registro_aforo` (`id`,`supervisor`,`nombre_conductor`, `ruta`, `matricula`, `recipiente`, `cantidad`,`usuario_registro`,`fecha_registro`,`posicion`,`firma`) VALUES (NULL,"'.$_POST['supervisor'].'", "'.$_POST['conductor'].'","'.$_POST['ruta'].'","'.intval($numeromat).'","'.$_POST['recipiente'].'","'.$_POST['cantidad'].'","'.$_SESSION['usuario'].'",CURRENT_TIMESTAMP,"'.$_POST['ubicacion'].'","'.$_POST['firma'].'")');
  echo '<script type="text/javascript"> alert("El aforo se guardó correctamente"); window.location.href = "aforo_permanente.php";</script>';

?>