<?php
function GenTabla($conexion,$consulta){
    //recibe variable con conexión y variable de la consulta
    $query= $conexion->ejecutar($consulta);
    //condicional si hay resultados de consulta
    if($query !== true and $query !== false){
    // creacion de tabla para cada uno de las filas del array
    echo '<center><table class="resultados">';
    $nombres=$query->fetch_fields();
    echo '<tr>';
    foreach($nombres as $field){
        echo '<td><b>'.$field->name.'</b></td>';
    }
    echo '</tr>';

    while ($fila=$query->fetch_assoc()){
        echo'<tr>'; 
        foreach($fila as $campo){
            //resultado de cada una de las columnas del array
            echo '<td>'.$campo.'</td>';    
        }
        echo'</tr>';
    }
    echo'</table></center>';
    }else{
        echo '<tr><td> Ok. No hay resultados para mostrar</td></tr>';
    }
}
function generarCSV($arreglo, $ruta, $delimitador, $encapsulador){
    $file_handle = fopen($ruta, 'w');
    foreach ($arreglo as $linea) {
      fputcsv($file_handle, $linea, $delimitador, $encapsulador);
    }
    rewind($file_handle);
    fclose($file_handle);
    echo '<a class="greport" href="'.$ruta.'">Reporte</a>';
  }
?>