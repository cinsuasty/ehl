<?php
 session_start();
      ini_set('display_errors', 1);
      ini_set('display_startup_errors', 1);
      error_reporting(E_ALL);
      $premiso = [1=>"adm",2=>"pro",3=>"bsc"];
      $varsession=$_SESSION['usuario'];
      $tiposession=$_SESSION['tipo'];
      if ($varsession== null || $varsession = ''){
          echo 'Usted no ha iniciado sesión';
          echo '<br><a href="/../../index.html">VOLVER<a>';
          die();
      };
      if (array_search($tiposession,$premiso)==false){
          echo 'Usted no tiene permisos para ingresar a este módulo';
          echo '<a href="index.html"> <br> VOLVER </a>';
      }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Ingreso de aforo permanente</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../../css/estiloam.css'>
    <link rel="shortcut icon" href="https://habitatlimpio.com/E_H_L/E_H_L/wp-content/uploads/2017/11/empresa-1.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    
    
</head>
<body>
 
<form action="aforo_permanente.php" name="form_AP" method="post">  
    <div class="titulos">
        <img id="logotitulo" src="https://habitatlimpio.com/E_H_L/E_H_L/wp-content/uploads/2017/11/tLogoEHL.png">
    </div>  
    <div class="navigation">               
        <a href="/../../cerrar_sesion.php" class="button1" > 
            <img src="../../imagenes/logout.png" >
            <div class="logout">
                SALIR
            </div>
        </a>
    </div>
    <div class="titulo_formulario">
        <h1> AFORO PERMANENTE</h1> 
    </div>
    <div class="formulario" style="text-align: center;" > 
        
            <ul class="gran_listado">
                <li>
                    <ul class="listado_horizontal">
                        <li> <label for="form_AP">Supervisor: </label> <input type="text" required name="supervisor" class="entradas"></li>
                        <li> <label for="form_AP">Nombre del conductor: </label> <input type="text" name="conductor" required class="entradas"> </li><br>
                        <li><label for="form_AP">Ruta: </label> 
                            <select name="ruta" required class="entradas" id="proceso" >
                                <option value="">Elija una opción</option>
                                <option value="CENTRO">CENTRO</option>
                                <option value="MONTANA">MONTANA</option>
                                <option value="VILLA LADY">VILLA LADY</option>
                                <option value="HERRADURA">HERRADURA</option>
                                <option value="BALSILLAS">BALSILLAS</option>
                                <option value="RESIDUOS VERDES">RESIDUOS VERDES</option>
                                <option value="CC TREBOL">CC TREBOL</option>
                                <option value="CAJAS">CAJAS</option>
                                <option value="NOCHE 1">NOCHE 1</option>
                                <option value="NOCHE 2">NOCHE 2</option>
                                <option value="ECOPLAZA">ECOPLAZA</option>
                                <option value="SENDEROS DE SAN ISIDRO">SENDEROS DE SAN ISIDRO</option>
                                <option value="NOCHE 3">NOCHE 3</option>
                                <option value="NOGAL Y CIPRES">NOGAL Y CIPRES</option>
                                <option value="CC VILLA NUEVA">CC VILLA NUEVA</option>
                                <option value="MARIE CURIE">MARIE CURIE</option>
                                <option value="FESTIVO 1">FESTIVO 1</option>
                                <option value="COLEGIOS">COLEGIOS</option>
                                <option value="RESIDUOS VERDES">RESIDUOS VERDES</option>
                            </select>
                    </li>
                    
                        <!-- <li><label for="form_AM">No: </label> <input type="number" name="no" required id="no" class="entradas"></li> -->
                    </ul>
                </li>
                <hr class="division">
    </div>
    <div class="Envio">
        <input type="submit" value="Guargar informacion y continuar con Actividades de la acción" id="boton_envio">
        <input type="image" value="Guargar informacion y continuar con Actividades de la acción" src="../../imagenes/save.png"id="imagen_enviar">
    </div>
    
    </form>
    <?php
        if($_SESSION['tipo']=='pro' or $_SESSION['tipo']=='adm'){
            echo '<a href="../menu.php" ID="volver">VOLVER</a>'; 
        }else{
            echo '<a href="/../../index.html" ID="volver">VOLVER</a>';
        }
    ?> 
</body>
</html>

