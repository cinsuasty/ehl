<?php
     session_start();
     $premiso = [1=>"adm",2=>"pro",3=>"bsc"];
     $varsession=$_SESSION['usuario'];
     $tiposession=$_SESSION['tipo'];
     if ($varsession== null || $varsession = ''){
         echo 'Usted no ha iniciado sesión';
         echo '<script> sessionStorage.clear(); </script>';
         echo '<br><a href="/../../index.html">VOLVER<a>';
         die();
     };
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>menu</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel="shortcut icon" href="https://habitatlimpio.com/E_H_L/E_H_L/wp-content/uploads/2017/11/empresa-1.png" type="image/x-icon">
    <style>
        h1{
            font-family: arial,sans-serif;
            color: white;
            background-color:rgb(1, 27, 143);
            border-radius: 5px;
            width: 100%;
            text-align: center;
            font-size:2rem; 
            padding-top: 10px;
            padding-bottom: 10px;
        }
        h2{
            font-family: arial,sans-serif;
            color: white;
            background-color: rgb(18, 146, 82);
            border-radius: 5px;
            width: 60%;
            text-align: center;
            font-size: 1rem;
            margin-left:20%;
            padding-top: 0.5rem;
            padding-bottom: 0.5rem;
            padding-left: 10px;
            padding-right: 10px;
        }
        ul{
            list-style: none;
            margin-left:20%;
            width: 60%;
            padding: 0px;

        }
        li{
            width: 100%;
            margin-bottom: 15px;
        }
        a{
            background-color: #ABEBC6;
            text-decoration: none;
            color: black;
            padding-top: 5px;
            padding-bottom: 5px;
            font-size: 1rem; 
            width: 100%;
            border-radius: 5px;
            font-family: arial;
            padding-left: 10px;
            padding-right: 10px;
            display: inline-block;
            text-align: center;
        }
        a:hover{
            background-color: #CCD1D1; 
        }
        #volver{
            position:fixed;
            z-index: 1;
            background-color:rgb(18, 146, 82);
            bottom:0.2vh;
            padding:15px;
            border-radius:10px;
            text-decoration: none;
            color: #fff;
            font-weight: bold;
            width: 95%;
            text-align: center;
            font-size: 0.7rem;
        }
        #volver:hover{
            background-color:rgb(16, 102, 59);
            padding: 16px;
            }
    </style>
    
</head>
<body>
<h1>EHL - CONTROL DE AFORO PERMANENTE</h1>
<h2> Seleccione que desea hacer:</h2>
<?php 
switch ($tiposession){
        case 'bsc':
            echo '<script type="text/javascript">
                    window.location="/modulos/registros/aforo_permanente_1.php"
                </script>';
            break;
        case 'pro':
            echo '
            <ul>
                <li>
                    <a href="/modulos/registros/aforo_permanente_1.php">Registro de Aforo Permanente</a>
                </li>
                <li>
                    <a href="revision_supervisor.php">Revisión y firma</a>
                </li>
                <li>
                    <a href="actualizacion_supervisor.php">Correcciones y actualizaciones</a>
                </li>
                <li>
                    <a href="SupervisionControl.php"> Supervisión y control </a>
                </li>
                <li>
                    <a href="SeguimientoSup.php"> Seguimiento a la supervisión </a>
                </li>

            </ul>
            ';
            break;
        case 'adm':
            echo '
            <ul>
                <li>
                    <a href="/modulos/registros/aforo_permanente_1.php">Registro de Aforo Permanente</a>
                </li>
                <li>
                    <a href="/modulos/reporte.php">Generar reporte</a>
                </li>
                <li>
                    <a href="revision_supervisor.php">Revisión y firma</a>
                </li>
                <li>
                    <a href="actualizacion_supervisor.php">Correcciones y actualizaciones</a>
                </li>
                <li>
                    <a href="SupervisionControl.php"> Supervisión y control </a>
                </li>
                <li>
                    <a href="SeguimientoSup.php"> Seguimiento a la supervisión </a>
                </li>
            </ul>
            ';
            break;
            
        default:
            echo 'Usted no tiene permisos para ingresar a este módulo';
            echo '<a href="index.html"> <br> VOLVER </a>';

     }
     
?>
<a href="/../../cerrar_sesion.php" ID="volver">SALIR / CERRAR SESIÓN</a>   
