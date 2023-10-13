<?php

use Dompdf\JavascriptEmbedder;
session_start();
$premiso = [1=>"adm",2=>"pro",3=>"bsc"];
$varsession=$_SESSION['usuario'];
$tiposession=$_SESSION['tipo'];
if ($varsession== null || $varsession = ''){
    echo 'Usted no ha iniciado sesión';
    echo '<br><a href="../../index.html">VOLVER<a>';
    die();
};
if (array_search($tiposession,$premiso)==false){
    echo 'Usted no tiene permisos para ingresar a este módulo';
    echo '<a href="../menu.php"> <br> VOLVER </a>';
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel='stylesheet' type='text/css' media='screen' href='../../css/estiloam.css'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../css/estiloaforo.css'>
    <title>Firma</title>
</head>
<body>
<form action="validador.php" name="form_AM" method="post"> 
<div><canvas class="canvas"id="pizarra" style="border: solid 1px; position:relative;"></canvas> <br>
<a id="btnLimpiar" class="boton">Limpiar</a>
<a id="firmar" class="boton">Firmar</a>
<a href="aforo_permanente.php" class="boton">Volver</a>
<input id="btnDescargar" type="submit" style="visibility: hidden;" value="Submit">


</div>
<input id="ubicacion" name="ubicacion" type="hidden" value="<?php echo $_POST['ubicacion']?>">
<input id="supervisor" name="supervisor" type="hidden" value="<?php echo $_POST['supervisor']?>">
<input id="conductor" name="conductor" type="hidden" value="<?php echo $_SESSION['conductor']?>">
<input id="ruta" name="ruta" type="hidden" value="<?php echo $_POST['ruta']?>">
<input id="matricula" name="matricula" type="hidden" value="<?php echo $_POST['matricula']?>">
<input id="recipiente" name="recipiente" type="hidden" value="<?php echo $_POST['recipiente']?>">
<input id="cantidad" name="cantidad" type="hidden" value="<?php echo $_POST['cantidad']?>">
<input id="firma" name="firma" type="hidden" id="firma" value="">
             
             <style>
             canvas {
                 background-color:white;
                 width: 500px;
                 height: 500px;
             } 
             #aviso:visited{
                 background-color:blue;
             }
             </style>
 
 
 
 <script>
    //======================================================================
    // VARIABLES
    //======================================================================
    let miCanvas = document.querySelector('#pizarra');
    let lineas = [];
    let correccionX = 0;
    let correccionY = 0;
    let pintarLinea = false;
    var ctx = miCanvas.getContext('2d')
    const contenedores ={1:'Domestica', 2:'Semi Industrial', 3:'Industrial', 4:'Caneca 20_Gal',5:'Caneca 25_Gal',6:'Caneca 35_Gal',7:'Caneca 50_Gal',8:'Contenedor 2Y3', 9:'Contenedor 3Y3', 46:'Con 770_Lt', 45:'Con 1100_lt', 47:'Con 360_Lt'};
    // Marca el nuevo punto
    let nuevaPosicionX = 0;
    let nuevaPosicionY = 0;
    const COLOR_FONDO = "white",
    $btnDescargar = document.querySelector("#btnDescargar"),
    $btnLimpiar = document.querySelector("#btnLimpiar"),
    $btnGenerarDocumento = document.querySelector("#btnGenerarDocumento");

    let posicion = miCanvas.getBoundingClientRect()
    correccionX = posicion.x;
    correccionY = posicion.y;

    miCanvas.width = 500;
    miCanvas.height = 500;
    //======================================================================
    // FUNCIONES
    //======================================================================

    /**
     * Funcion que empieza a dibujar la linea
     */
    function empezarDibujo () {
        pintarLinea = true;
        lineas.push([]);
    };
    
    /**
     * Funcion que guarda la posicion de la nueva línea
     */
    function guardarLinea() {
        lineas[lineas.length - 1].push({
            x: nuevaPosicionX,
            y: nuevaPosicionY
        });
    }

    /**
     * Funcion dibuja la linea
     */
    function dibujarLinea (event) {
        event.preventDefault();
        if (pintarLinea) {
            // Estilos de linea
            ctx.lineJoin = ctx.lineCap = 'round';
            ctx.lineWidth = 1;
            // Color de la linea
            ctx.strokeStyle = '#black';
            // Marca el nuevo punto
            if (event.changedTouches == undefined) {
                // Versión ratón
                nuevaPosicionX = event.layerX;
                nuevaPosicionY = event.layerY;
            } else {
                // Versión touch, pantalla tactil
                nuevaPosicionX = event.changedTouches[0].pageX - correccionX;
                nuevaPosicionY = event.changedTouches[0].pageY - correccionY;
            }
            // Guarda la linea
            guardarLinea();
            // Redibuja todas las lineas guardadas
            ctx.beginPath();
            lineas.forEach(function (segmento) {
                ctx.moveTo(segmento[0].x, segmento[0].y);
                segmento.forEach(function (punto, index) {
                    ctx.lineTo(punto.x, punto.y);
                });
            });
            ctx.stroke();
        }
    }

    
    /**
     * Funcion que deja de dibujar la linea
     */
    function pararDibujar () {
        pintarLinea = false;
        guardarLinea();
        imgtxt="[";
        lineas.forEach(function(trazo){
                                    imgtxt = imgtxt + "[";
                                    trazo.forEach(function(coord){
                                        imgtxt = imgtxt+"{ x: "+coord.x +', y: '+ coord.y+"},";
                                    })
                                    imgtxt = imgtxt + "],";
        })
        imgtxt= imgtxt + "]";
        imgtxt=imgtxt.replace(/,]/g,"]");
        document.querySelector('#firma').value=imgtxt;

    }
    // Confirmar y validar datos

    const confirmar = () =>{
        
        var matricula =document.querySelector('#matricula').value;
        var recipiente =document.querySelector('#recipiente').value;
        var cantidad =document.querySelector('#cantidad').value;
        var aviso=document.querySelector('#aviso');
        aviso.click();

       if(window.confirm("¿Esta seguro que desea ingresar los siguientes datos?: Matricula: "+ matricula + ", Recipiente: "+ contenedores[recipiente]+", Cantidad: "+cantidad)){
           document.querySelector('#btnDescargar').click();           
       }else{
           location.href="aforo_permanente.php";
       }
    };
    const firmar = document.querySelector('#firmar');
    firmar.onclick = confirmar;

    //======================================================================
    // EVENTOS
    //======================================================================

    // Eventos raton
    miCanvas.addEventListener('mousedown', empezarDibujo, false);
    miCanvas.addEventListener('mousemove', dibujarLinea, false);
    miCanvas.addEventListener('mouseup', pararDibujar, false);

    // Eventos pantallas táctiles
    miCanvas.addEventListener('touchstart', empezarDibujo, false);
    miCanvas.addEventListener('touchmove', dibujarLinea, false);
    miCanvas.addEventListener('touchend',pararDibujar,false);

    const limpiarCanvas = () => {
    // // Colocar color blanco en fondo de canvas
    ctx.fillStyle = COLOR_FONDO;
    ctx.fillRect(0, 0, miCanvas.width, miCanvas.height);
    lineas=[];
};
    limpiarCanvas();
    $btnLimpiar.onclick = limpiarCanvas;

</script>

</form>
<br>
<h6 id="aviso"> <i>Ecoprocesos Habitat Limpio 2022</i> </h6>
</body>
</html>