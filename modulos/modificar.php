<?php
    session_start();
    //error_reporting(0);
    $premiso = [1=>"adm"];
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
        echo '<a href="index.html"> <br> VOLVER </a>';
        die();
    };

?>


<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta http-equiv='X-UA-Compatible' content='IE=edge'>
        <title>Pagina de Modificación</title>
        <link rel="stylesheet" href="../css/estilosmodificar.css">
        <link rel="shortcut icon"
            href="https://habitatlimpio.com/E_H_L/E_H_L/wp-content/uploads/2017/11/empresa-1.png"
            type="image/x-icon">
    </head>
    <body>


        <div class="titulos">
            <img id="logotitulo" src="https://habitatlimpio.com/E_H_L/E_H_L/wp-content/uploads/2017/11/tLogoEHL.png">
        </div>

        <div class="navigation">               
            <a href="/ehl/cerrar_sesion.php" class="button1"> 
            <img src="../imagenes/logout.png">
            <div class="logout" style="position: relative; font-size:12px">
                SALIR
            </div>
        </a>
        </div>

        <div class="cajagrande">
            <div class="caja1">
                <p id="titulomenu">
                    CONSULTA DE RUTAS
                </p>
            </div>
            <div class="container">
                <form class="formu1" method="post" action="comprobacionconsulta.php">
                    <div>
                        <div class="subcaja1">
                        <h3>Por favor ingrese la matricula que<br> desea modificar o eliminar</h3><br> 
                        <label for="user"><span> Matricula:</span></label><br>
                        <input class="user" name="matricula"><br>
                        <div>
                        </div>
                        </div>
                        <div class="subcaja2">
                            <img src="../imagenes/logo.png" alt="" class="imagen2"><br>
                            <br><br>
                            <input type="submit" value="Consultar" class="botonenviar" name="consultar">
                            <br><br>
                            <input type="submit" value="Eliminar" class="botonenviar" name="eliminar"  onclick="preguntar()">
                            <script type="text/javascript">
                                function preguntar(){
                                    var opcion = confirm("Esta seguro de eliminar el usuario ingresado?");
                                    if (!opcion){
                                        event.preventDefault();
                                    }
                                }
                            </script>
                        </div>
                        
                    </div>
                </form>
                
            </div>
        </div>
        <div>               
        <a href="../modulos/menu.php" class="btn-flotante">Volver</a>
        </div> 

    </body>

    <footer>
        <div class="piedepagina">
            Ecoprocesos Habitat Limpio. Juntos, trabajando por una mejor calidad
            de vida. Info: ehl.sgi@habitatlimpio.com
        </div>
    </footer>

</html>