<?php
include '../../includes/conectar.php';

$conexion = conectar();

$user_id = $_POST['user_id'];
$oferta_laboral_id = $_POST['oferta_laboral_id'];
$fecha_hora_postulacion = $_POST['fecha_hora_postulacion'];
$tipo = $_POST['tipo'];
$seleccionado = $_POST['seleccionado'];

// Insertar los datos en la base de datos utilizando una consulta INSERT
$sql = "INSERT INTO postulacions (user_id, oferta_laboral_id, fecha_hora_postulacion, tipo, seleccionado) VALUES ('$user_id', '$oferta_laboral_id', '$fecha_hora_postulacion', '$tipo', '$seleccionado')";
mysqli_query($conexion, $sql) or die('Error al guardar la postulación.');

// Redirigir a la página de listado de postulaciones después de insertar la nueva postulación
header('location:listar_postulante.php');
?>
