<?php
include '../../includes/head.php';
?>
<!-- Begin Page Content -->
<div class="container-fluid">
  <!-- Inicio de la zona central del sistema -->
  <!-- Todo -->
  <h1>Registro de nuevas postulaciones diversas</h1>

  <form method="POST" action="guardar_postulante.php">
    <div>
      <div class="form-row">
        <div class="col">
          <label for="user_id" class="form-label">Usuario ID</label>
          <input type="text" class="form-control" name="user_id" value="<?php echo $_SESSION['SESSION_USER_ID']; ?>">
        </div>
        <div class="col">
          <label for="oferta_laboral_id" class="form-label">Oferta Laboral ID</label>
          <input type="text" class="form-control" name="oferta_laboral_id">
        </div>
      </div>
     
      <div class="form-row">
        <div class="col">
          <label for="fecha_hora_postulacion" class="form-label">Fecha y Hora de Postulación</label>
          <input type="datetime-local" class="form-control" name="fecha_hora_postulacion">
        </div>
        <div class="col">
          <label for="tipo" class="form-label">Tipo</label>
          <input type="text" class="form-control" name="tipo">
        </div>
      </div>
      <div class="col">
          <label for="seleccionado" class="form-label">Seleccionado</label>
          <input type="text" class="form-control" name="seleccionado">
        </div>
      </div>

    <div style="width: 100%; display: grid; justify-content: center;">
      <button type="submit" class="btn btn-primary" style="margin: 1rem;" id="submitButton">Registrar Postulación</button>
    </div>
  </form>

  <!-- Fin  de la zona central del sistema -->
</div>
<!-- /.container-fluid -->
<?php
include '../../includes/food.php';
?>
