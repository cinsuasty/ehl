<?php
require 'includes/conexion.php';
function incio_sesion ($user){
    ini_set("session.cookie_lifetime","7200");
    ini_set("session.gc_maxlifetime","7200");
    session_start();
    $varsession = $_SESSION['usuario']= $user;
};

$conexion = new Conexion();
$usuario = $_POST["txt_username"];
$password = $_POST["txt_password"];


$query = $conexion->ejecutar("SELECT * FROM login WHERE usuario = '".$usuario."' and password = '".$password."'");
$nr =mysqli_num_rows($query); 
if ($nr == 1)
{
    $nombre_usuario= mysqli_fetch_array($conexion->ejecutar("SELECT nombre FROM login WHERE usuario = '".$usuario."'"));
    incio_sesion($usuario);
    $tipo = mysqli_fetch_array($conexion->ejecutar("SELECT tipo FROM login WHERE usuario = '".$usuario."'"));
    $tiposession = $_SESSION['tipo']= $tipo[0];
    $conexion->ejecutar("insert into ingresos (id,usuario,fecha) values(NULL,'".$usuario."', NULL);");
    echo '<script type="text/javascript">
    alert("Bienvenido: ' . $nombre_usuario[0] . '");
            window.location="/modulos/menu.php"
            sessionStorage.setItem("session", "'.$_SESSION['usuario'].'");
            </script>';
}else if ($nr == 0)
{
    error_reporting(0);
    echo '<script language="javascript">alert("Usuario o contraseña errados");
            window.location="index.html " </script>';
};


?>