<?php
session_start();
//error_reporting(0);
require '../../includes/conexion.php';
$varsession = $_SESSION['usuario'];
$tiposession = $_SESSION['tipo'];
if ($varsession == null || $varsession = '') {

    echo 'Usted no ha iniciado sesión <br> <a href="/../../index.html">VOLVER</a>';
    die();
};

if (isset($_POST['ruta']) or isset($_POST['supervisor']) or isset($_POST['conductor'])) {
    $_SESSION['ruta'] = $_POST['ruta'];
    $_SESSION['supervisor'] = $_POST['supervisor'];
    $_SESSION['conductor'] = $_POST['conductor'];
} elseif (!(isset($_SESSION['ruta']) or isset($_SESSION['supervisor']) or isset($_SESSION['conductor']))) {
    echo 'error';
    die();
};

//conexion base de datos
$conexion = new Conexion();
$supervisor = $_SESSION['supervisor'];
$ruta = $_SESSION['ruta'];
$conductor = $_SESSION['conductor'];
$query = $conexion->ejecutar('SELECT `matricula`,`empresa_usuario`,`direccion`,`ruta` FROM `rutas` WHERE `ruta`="' . $ruta . '"');
$query1 = $conexion->ejecutar('SELECT `codigo`,`tipo`,`capacidad` FROM `contenedores`');
$ultimoRegistroRuta = $conexion->ejecutar('select concat("Ultimo registro ingresado Mat: ",matricula,"_",empresa_usuario)as usuario from rutas where matricula=(select matricula from registro_aforo where ruta="' . $_SESSION['ruta'] . '" and date(fecha_registro)= date(now()) order by id desc limit 1);');

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Aforo Permanente</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../css/estiloam.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../css/estiloaforo.css'>
    <link rel="shortcut icon" href="https://habitatlimpio.com/E_H_L/E_H_L/wp-content/uploads/2017/11/empresa-1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <script src="geolocalizacion.js"></script>

</head>

<body>



    <a href="aforo_permanente_1.php" ID="volver">VOLVER</a>
    <form action="guardar_aforo.php" name="form_AM" method="post">
        <input id="ubicacion" name="ubicacion" type="hidden">
        <div class="titulos">
            <img id="logotitulo" src="https://habitatlimpio.com/E_H_L/E_H_L/wp-content/uploads/2017/11/tLogoEHL.png">
        </div>
        <div class="navigation">
            <a href="/../../cerrar_sesion.php" class="button1">
                <img src="../../imagenes/logout.png">
                <div class="logout">
                    SALIR
                </div>
            </a>
        </div>

        <div class="grid-container">
            <div class="grid-item" id="grid-titulo">
                <h1> Aforo Permanente</h1>
            </div>
            <div class="grid-item" id="grid-subtitulo">
                <h3><label>SUPERVISOR:</label><input name="supervisor" class="entradas" readonly value="<?php echo $_SESSION['supervisor'] ?>"></h3>
                <h3><label>CONDUCTOR:</label><input name="responsable" class="entradas" readonly value="<?php echo $_SESSION['conductor'] ?>"></h3>
                <h3><label>RUTA:</label><input name="ruta" class="entradas" readonly value="<?php echo $_SESSION['ruta'] ?>"></h3>
            </div>
            <div class="grid-item" id="item1">
                <li>
                    <h2>SELECCIONE LA MATRICULA</h2>
                    <p style="color: green;"><?php $nombreultima = mysqli_fetch_array($ultimoRegistroRuta);
                                                echo $nombreultima[0]; ?></p>
                </li>
                <select name="matricula" class="entradas" required>
                    <option value="" default>Matricula</option>
                    <?php
                    while ($fila = $query->fetch_assoc()) {
                        echo '<option>' . $fila['matricula'] . ' - ' . $fila['empresa_usuario'] . '</option>';
                    }
                    ?>
                </select>
                <li>
                    <h2>
                        RECIPIENTE
                    </h2>
                </li>
                <select id="selector" name="recipiente" class="entradas" required>
                    <option value="" default>
                        Por favor seleccione el recipiente
                    </option>
                    <?php
                    while ($fila1 = $query1->fetch_assoc()) {
                        echo '<option id="' . $fila1['codigo'] . '", value="' . $fila1['codigo'] . '">' . $fila1['tipo'] . $fila1['capacidad'] . '</option>';
                    }
                    ?>
                </select>

                <script type="text/javascript">
                    selector.addEventListener("change", () => {

                        imagenbolsa.setAttribute("src", "../registros/imagenesbolsas/" + selector.value + ".jpg")
                    })
                </script>




                <li>
                    <h2>
                        CANTIDAD
                    </h2>
                </li>
                <li>
                    <input type="number" class="entradas" style="text-align: center;" name="cantidad" min="1" required>
                </li>



            </div>
            <div class="grid-item" id="item2"> <img name="cambio" id="imagenbolsa">

            </div>







            <div class="grid-item" id="item3">
                <input type="submit" value="Continuar y firmar" id="boton_envio" class="entradas">
                <input type="image" value="Continuar y firmar" src="../../imagenes/save.png" id="imagen_enviar">
            </div>


        </div>





    </form>



</body>

</html>