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
    }
    if (array_search($tiposession,$premiso)== false){
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
        <title>Pagina de Registro</title>
        <link rel="stylesheet" href="../css/estilos1.css">
        <link rel="shortcut icon"
            href="https://habitatlimpio.com/E_H_L/E_H_L/wp-content/uploads/2017/11/empresa-1.png"
            type="image/x-icon">
    </head>
    <body>


        <div class="titulos">
            <img id="logotitulo" src="https://habitatlimpio.com/E_H_L/E_H_L/wp-content/uploads/2017/11/tLogoEHL.png">
        </div>
        <div class="navigation">               
            <a href="/cerrar_sesion.php" class="button1" > 
            <img src="../imagenes/logout.png">
            <div class="logout"style="position: relative; font-size:12px">
                SALIR
            </div>
            </a>
        </div>
        <div class="cajagrande">
            <div class="caja1">
                <p id="titulomenu">
                    REGISTRO DE NUEVOS USUARIOS
                </p>
            </div>
            <div class="container">
                <form class="formu1" method="post" action="comprobacion.php">
                    <div>
                        <div class="subcaja1">
                        <h3>Por favor diligencie los siguientes campos</h3>
                        <label for="user"><span> Usuario:</span></label><br>
                        <input class="user" name="user" type="email" required><br>
                        <label for="clave1">Ingrese la contraseña:</label><br>
                        <input class="clave1" type="password" minlenght="4" name="clave1" required id="p1"><br>
                        <label for="clave2">Confirme la contraseña:</label><br>
                        <input class="clave2" type="password" minlenght="4" name="clave2" required  id="p2" onchange="validar()"><br>
                        <h4></h4>
                        <script type="text/javascript"> 
                        function validar(){
                        var v1 = document.getElementById('p1').value;
                        var v2 = document.getElementById('p2').value;
                        let aviso = document.querySelector('h4');
                        if (v1==v2){
                            aviso.innerHTML = "<p style='color:green'>Las contraseñas coinciden</p>";
                        } else {
                            aviso.innerHTML = "<p style='color:red'>Las contraseñas no coinciden</p>";
                        }
                        };
                        </script>
                        <label for="tipo">Tipo de usuario:</label><br>
                        <select name="select" class="tipousuario"><br>
                            <option title="Basico">bsc</option>
                            <option title="Profesional">pro</option>
                            <option title="Administrador">adm</option>
                        </select><br><br>
                        <label for="nombres">Nombres:</label><br>
                        <input class="nombre" name="nombre" required><br><br>
                        
                        </div>
                        <div class="subcaja2">
                            <img src="../imagenes/logo.png" alt="" class="imagen2"><br>
                            <script type="text/javascript">
                                function preguntar(){
                                    var opcion = confirm("Desea enviar el formulario?");
                                    if (!opcion){
                                        event.preventDefault();
                                    }
                                }
                            </script>
                            <input type="submit" value="Continuar" class="botonenviar" onclick="preguntar()">
                            
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