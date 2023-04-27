<?php

//Inicio de sesion
function incio_sesion ($user){
    ini_set("session.cookie_lifetime","7200");
    ini_set("session.gc_maxlifetime","7200");
    session_start();
    $varsession = $_SESSION['usuario'] = $user;
};

//Datos de conexion a la base de datos
$dbhost = "";
$dbuser = "";
$dbpass = "";
$dbname = "";

//Conexion a la base de datos
$conn=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

//Verificar conexion a la base de datos
if (!$conn){
    die("No hay conexión: ".mysqli_connect_error());
}
//Captura de datos del formulario
$usuario = $_POST["txt_username"];
$password = $_POST["txt_password"];

//Consulta a la base de datos del usuario y contraseña
//TODO: encryptar contraseña
$query=mysqli_query($conn,"SELECT * FROM login WHERE usuario = '".$usuario."' and password = '".$password."'");
$nr =mysqli_num_rows($query);

//Valida si el usuario y contraseña son correctos
if ($nr == 1)
{
    // Se busca el nombre del usuario para mostrarlo en el mensaje de bienvenida
    $nombre_usuario = mysqli_fetch_array(mysqli_query($conn,"SELECT nombre FROM login WHERE usuario = '".$usuario."'"));
    // Se inicia la sesion y se guarda el tipo de usuario
    incio_sesion($usuario);
    $tipo = mysqli_fetch_array(mysqli_query($conn,"SELECT tipo FROM login WHERE usuario = '".$usuario."'"));
    $tiposession = $_SESSION['tipo']= $tipo[0];
    // Se guarda el ingreso del usuario en la tabla ingresos
    mysqli_query($conn,"insert into ingresos (id,usuario,fecha) values(NULL,'".$usuario."', NULL);");
    // Se redirecciona a la pagina de menu
    echo '<script type="text/javascript">
            alert("Bienvenido: ' . $nombre_usuario[0] . '");
            window.location="/modulos/menu.php"
            sessionStorage.setItem("session", "'.$_SESSION['usuario'].'");
            </script>
    ';
}else if ($nr == 0)
{
    // Si el usuario y contraseña son incorrectos se muestra un mensaje de error
    error_reporting(0);
    echo '<script language="javascript">alert("Usuario o contraseña errados");
            window.location="index.html " </script>
    ';
};


?>