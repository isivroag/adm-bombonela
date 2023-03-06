<?php
//filter.php  

include_once 'conexion.php';
$objeto = new conn();
$conexion = $objeto->connect();

// Recepción de los datos enviados mediante POST desde el JS   


$inicio = (isset($_POST['inicio'])) ? $_POST['inicio'] : '';
$final = (isset($_POST['final'])) ? $_POST['final'] : '';
$sucursal = (isset($_POST['sucursal'])) ? $_POST['sucursal'] : '';

if ($sucursal==0){
    $consulta = "SELECT * FROM vcaja WHERE fecha BETWEEN '$inicio' AND '$final' ORDER BY fecha,id_sucursal";
}else{
    $consulta = "SELECT * FROM vcaja WHERE fecha BETWEEN '$inicio' AND '$final' and id_sucursal='$sucursal' ORDER BY fecha,id_sucursal";
}

    


$resultado = $conexion->prepare($consulta);
$resultado->execute();
$data = $resultado->fetchAll(PDO::FETCH_ASSOC);
print json_encode($data, JSON_UNESCAPED_UNICODE);
$conexion = NULL;
