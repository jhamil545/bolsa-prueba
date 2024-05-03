<?php
include("../../includes/head.php");
include("../../includes/conectar.php");
$conexion = conectar();
?>

<script src="<?php echo RUTAGENERAL; ?>/templates/vendor/jquery/jquery.min.js"></script>

<script>
    // Función para redirigir a la página de edición con el ID de la postulación
    function f_editar(pid) {
        // Redireccionamos hacia el archivo "modificar_postulacion.php" con el ID de la postulación
        window.location.href = "modificar_postulante.php?pid=" + pid;
    }

    // Función para eliminar una postulación
    function eliminarPostulacion(id) {
        if (confirm("¿Estás seguro de que deseas eliminar esta postulación?")) {
            window.location.href = "eliminar_postulante.php?id=" + id;
        }
    }
</script>

<!-- Begin Page Content -->
<div class="container-fluid" align="center">
    <!-- Inicio de la zona central del sistema -->
    <!-- Todo -->
    <h1>Lista de postulaciones</h1>

    <div class="overflow-auto shadow-sm" style="border-radius: 0.75rem/* 8px */; border: 1px solid ; border-color: #d1d5db;">
        <table class="table table-hover table-bordered mb-0">
            <tr class="table-active bg-primary text-white text-center">
                <th>Usuario ID</th>
                <th>Oferta Laboral ID</th>
                <th>Fecha y Hora de Postulación</th>
                <th>Tipo</th>
                <th>Seleccionado</th>
                <th>Acciones</th>
            </tr>
            <?php
            // Determinar el rol del usuario
            $rol_usuario = $_SESSION['SESSION_ROL'] ?? null;
            $usuario_id = $_SESSION['SESSION_USER_ID'];

            // Definir la consulta SQL según el rol del usuario
            if ($rol_usuario == '1') {
                // Administrador: listar todas las postulaciones
                $sql = "SELECT * FROM postulacions";
            } elseif ($rol_usuario == '2') {
                // Ofrecer postulaciones de sus propias ofertas para el Empleador
                $sql = "SELECT * FROM postulacions WHERE oferta_laboral_id IN (SELECT id FROM oferta_laborals WHERE user_id = '$usuario_id')";
            } elseif ($rol_usuario == '3') {
                // Listar las postulaciones del Postulante
                $sql = "SELECT * FROM postulacions WHERE user_id = '$usuario_id'";
            }

            // Ejecutar la consulta
            $registros = mysqli_query($conexion, $sql);

            while ($fila = mysqli_fetch_array($registros)) {
                echo "<tr>";
                echo "<td>" . $fila['user_id'] . "</td>";
                echo "<td>" . $fila['oferta_laboral_id'] . "</td>";
                echo "<td>" . $fila['fecha_hora_postulacion'] . "</td>";
                echo "<td>" . $fila['tipo'] . "</td>";
                echo "<td>" . $fila['seleccionado'] . "</td>";
                echo "<td>";

                // Otros botones (Editar y Eliminar) se mantienen igual
                ?>

                <button onclick="f_editar('<?php echo $fila['id']; ?>')" type="button" class="btn btn-success" title="Editar"><i class="fas fa-edit"></i></button>
                <button onclick="eliminarPostulacion('<?php echo $fila['id']; ?>')" type="button" class="btn btn-danger" title="Eliminar"><i class="far fa-trash-alt"></i></button>
                </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</div>

<!-- Fin de la lista usuarios -->
<?php
include("../../includes/food.php");
?>
