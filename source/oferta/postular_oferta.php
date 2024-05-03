<?php
include '../../includes/head.php';

$oferta_id = $_GET['id']; // ID de la oferta obtenido de la URL
$usuario_id = $_SESSION['SESSION_USER_ID']; // ID del usuario logueado obtenido de la sesión
?>

<div>
    <h1>Postular Oferta</h1>
    <p>Por favor, complete el siguiente formulario para postularse a esta oferta.</p>
    <form method="POST" action="guardar_postular_oferta.php" enctype="multipart/form-data">
        <!-- Input oculto para pasar el ID de la oferta -->
        <input type="text" name="oferta_id" value="<?php echo $oferta_id; ?>">
        <!-- Input oculto para pasar el ID del usuario -->
        <input type="text" name="usuario_id" value="<?php echo $usuario_id; ?>">
        <!-- Otros campos del formulario -->
        <div class="form-row">
            <div class="col">
                <label for="fecha_hora_postulacion" class="form-label">Fecha y Hora de Postulación</label>
                <input type="datetime-local" class="form-control" name="fecha_hora_postulacion" required>
            </div>
            <div class="col">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" name="tipo" required>
            </div>
        </div>
        <!-- Campo de archivo -->
        <div class="form-row">
            <div class="col">
                <label for="archivo" class="form-label">Archivo Adjunto</label>
                <input type="file" class="form-control" name="archivo" required>
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <label for="seleccionado" class="form-label">Seleccionado</label>
                <input type="text" class="form-control" name="seleccionado" required>
            </div>
        </div>
        <!-- Botón de envío -->
        <input type="submit" name="submit" value="Postularse">
    </form>
</div>

<!-- Fin de la lista usuarios -->
<?php
include '../../includes/food.php';
?>
