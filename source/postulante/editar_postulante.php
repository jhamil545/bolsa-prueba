<?php
include '../../includes/conectar.php';

$conexion = conectar();

// Asegúrate de recibir el ID de la postulación a editar
$id = $_POST['idPostulacionEditar'];

$user_id = $_POST['user_id'];
$oferta_laboral_id = $_POST['oferta_laboral_id'];
$fecha_hora_postulacion = $_POST['fecha_hora_postulacion'];
$tipo = $_POST['tipo'];
$seleccionado = $_POST['seleccionado'];

// Verificar si se ha enviado un nuevo archivo
if (isset($_FILES['nuevo_archivo']) && $_FILES['nuevo_archivo']['error'] === UPLOAD_ERR_OK) {
    // Obtener información del archivo
    $nombre_archivo = $_FILES['nuevo_archivo']['name'];
    $ruta_temporal = $_FILES['nuevo_archivo']['tmp_name'];

    // Directorio donde se guardarán los archivos
    $directorio_archivos = '../../archivos/';

    // Obtener el nombre del archivo antiguo de la base de datos
    $sql_archivo_antiguo = "SELECT archivo FROM postulacions WHERE id='$id'";
    $resultado_archivo_antiguo = mysqli_query($conexion, $sql_archivo_antiguo);
    $fila_archivo_antiguo = mysqli_fetch_assoc($resultado_archivo_antiguo);
    $nombre_archivo_antiguo = $fila_archivo_antiguo['archivo'];

    // Eliminar el archivo antiguo si existe
    if ($nombre_archivo_antiguo !== '') {
        $ruta_archivo_antiguo = $directorio_archivos . $nombre_archivo_antiguo;
        if (file_exists($ruta_archivo_antiguo)) {
            unlink($ruta_archivo_antiguo);
        }
    }

    // Mover el nuevo archivo al directorio deseado
    $ruta_nuevo_archivo = $directorio_archivos . $nombre_archivo;
    if (move_uploaded_file($ruta_temporal, $ruta_nuevo_archivo)) {
        // Actualizar el nombre del archivo en la base de datos
        $sql_actualizar = "UPDATE postulacions SET archivo='$nombre_archivo' WHERE id='$id'";
        $resultado_actualizar = mysqli_query($conexion, $sql_actualizar);

        if ($resultado_actualizar) {
            // Redirigir a la página de listado de postulaciones si la actualización fue exitosa
            header('Location: listar_postulante.php');
            exit();
        } else {
            // Mostrar un mensaje de error si la actualización en la base de datos falló
            echo "Error al actualizar el nombre del archivo en la base de datos.";
        }
    } else {
        // Mostrar un mensaje de error si no se pudo mover el archivo
        echo "Error al mover el nuevo archivo.";
    }
} else {
    // Si no se envió un nuevo archivo, simplemente actualiza los otros campos en la base de datos
    $sql = "UPDATE postulacions SET user_id='$user_id', oferta_laboral_id='$oferta_laboral_id', fecha_hora_postulacion='$fecha_hora_postulacion', tipo='$tipo', seleccionado='$seleccionado' WHERE id='$id'";
    $resultado = mysqli_query($conexion, $sql);

    if ($resultado) {
        // Redirigir a la página de listado de postulaciones si la actualización fue exitosa
        header('Location: listar_postulante.php');
        exit();
    } else {
        // Mostrar un mensaje de error si la actualización en la base de datos falló
        echo "Error al actualizar la postulación.";
    }
}
?>
