<?php
include("../../includes/head.php");
include("../../includes/conectar.php");

$conexion = conectar();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $idPostulacion = $_POST['idPostulacionEditar'];
    $user_id = $_POST['user_id'];
    $oferta_laboral_id = $_POST['oferta_laboral_id'];
    $fecha_hora_postulacion = $_POST['fecha_hora_postulacion'];
    $tipo = $_POST['tipo'];
    $seleccionado = $_POST['seleccionado'];
    
    // Verificar si se ha subido un nuevo archivo
    if ($_FILES['archivo']['name']) {
        $archivo_nombre = $_FILES['archivo']['name'];
        $archivo_tmp = $_FILES['archivo']['tmp_name'];
        $carpeta_destino = "../../archivos/";

        // Mover el archivo a la carpeta de destino
        if (move_uploaded_file($archivo_tmp, $carpeta_destino . $archivo_nombre)) {
            // Actualizar la base de datos con el nombre del nuevo archivo
            $sql = "UPDATE postulacions SET user_id='$user_id', oferta_laboral_id='$oferta_laboral_id', fecha_hora_postulacion='$fecha_hora_postulacion', tipo='$tipo', seleccionado='$seleccionado', archivo='$archivo_nombre' WHERE id='$idPostulacion'";
            $resultado = mysqli_query($conexion, $sql);

            if ($resultado) {
                // Redirigir a una página de éxito si la actualización se realiza correctamente
                header('Location: ../postulante/listar_postulante.php');
                exit();
            } else {
                // Manejar cualquier error en la actualización de la postulación
                echo "Error al actualizar la postulación.";
            }
        } else {
            echo "Error al subir el archivo.";
        }
    } else {
        // Si no se ha subido un nuevo archivo, actualizar solo los demás campos
        $sql = "UPDATE postulacions SET user_id='$user_id', oferta_laboral_id='$oferta_laboral_id', fecha_hora_postulacion='$fecha_hora_postulacion', tipo='$tipo', seleccionado='$seleccionado' WHERE id='$idPostulacion'";
        $resultado = mysqli_query($conexion, $sql);

        if ($resultado) {
            // Redirigir a una página de éxito si la actualización se realiza correctamente
            header('Location: ../postulante/listar_postulante.php');
            exit();
        } else {
            // Manejar cualquier error en la actualización de la postulación
            echo "Error al actualizar la postulación.";
        }
    }
}

// Recibimos el id a modificar
$pid = $_REQUEST['pid'];
// Recibimos los datos del formulario    
$sql = "SELECT * FROM postulacions WHERE id='$pid'";
$registro = mysqli_query($conexion, $sql);
// En la variable fila tenemos todos los datos que queremos modificar
$fila = mysqli_fetch_array($registro);
?>

<!-- Begin Page Content -->
<div class="container-fluid">
    <!-- Inicio de la zona central del sistema -->
    <!-- Todo -->
    <h1>Modificación de la Postulación</h1>
    <form method="POST" action="editar_postulante.php" enctype="multipart/form-data">

        <!-- Agrega un campo oculto para pasar el ID de la postulación -->
        <input type="hidden" name="idPostulacionEditar" value="<?php echo $pid; ?>">
        <div class="row mb-3">
            <label for="user_id" class="form-label">Usuario ID</label>
            <input type="text" class="form-control" name="user_id" value="<?php echo $fila['user_id'] ?>">
        </div>
        <div class="row mb-3">
            <label for="oferta_laboral_id" class="form-label">Oferta Laboral ID</label>
            <input type="text" class="form-control" name="oferta_laboral_id" value="<?php echo $fila['oferta_laboral_id'] ?>">
        </div>
        <div class="row mb-3">
            <label for="fecha_hora_postulacion" class="form-label">Fecha y Hora de Postulación</label>
            <input type="text" class="form-control" name="fecha_hora_postulacion" value="<?php echo $fila['fecha_hora_postulacion'] ?>">
        </div>
        <div class="row mb-3">
            <label for="tipo" class="form-label">Tipo</label>
            <input type="text" class="form-control" name="tipo" value="<?php echo $fila['tipo'] ?>">
        </div>
        <div class="row mb-3">
            <label for="seleccionado" class="form-label">Seleccionado</label>
            <input type="text" class="form-control" name="seleccionado" value="<?php echo $fila['seleccionado'] ?>">
        </div>
        <div class="row mb-3">
            <label for="archivo" class="form-label">Archivo Actual</label><br>
            <?php if (!empty($fila['archivo'])): ?>
                <a href="<?php echo $ruta_archivos . $fila['archivo']; ?>" target="_blank"><?php echo $fila['archivo']; ?></a>
            <?php else: ?>
                <span>No hay archivo asociado</span>
            <?php endif; ?>
        </div>
        <div class="row mb-3">
            <label for="nuevo_archivo" class="form-label">Nuevo Archivo</label>
            <input type="file" class="form-control" name="nuevo_archivo">
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Postulación</button>
    </form>

    <!-- Fin de la zona central del sistema -->
</div>

<!-- /.container-fluid -->
<?php
include("../../includes/food.php");
?>
