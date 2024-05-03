<?php
include("../../includes/conectar.php");
$conexion = conectar();

$id = $_GET['id'];

$sql = "DELETE FROM postulacions WHERE id='$id'";

mysqli_query($conexion, $sql) or die("Error al eliminar la postulacion.");

header("Location: listar_postulante.php");
?>