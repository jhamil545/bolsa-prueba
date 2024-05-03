<?php
include '../../includes/head.php';
include '../../includes/conectar.php';
$conexion = conectar();
// Manejar el filtro de roles
if (isset($_POST['filtro_rol']) && !empty($_POST['filtro_rol'])) {
    $filtro_rol = $_POST['filtro_rol'];
    $sql = "SELECT u.*, IFNULL(e.razon_social, 'Sin Asignar') AS empresa_nombre, 
        CASE WHEN u.id_rol = 4 THEN 'Sin autorización' ELSE 'Autorizado' END AS Estado,
        r.name AS nombre_rol
        FROM users u 
        LEFT JOIN empresas e ON u.id = e.user_id
        LEFT JOIN roles r ON u.id_rol = r.id
        WHERE r.name = '$filtro_rol';";
} else {
    // Si no se ha seleccionado ningún filtro, obtener todos los usuarios
    $sql = "SELECT u.*, IFNULL(e.razon_social, 'Sin Asignar') AS empresa_nombre, 
        CASE WHEN u.id_rol = 4 THEN 'Sin autorización' ELSE 'Autorizado' END AS Estado,
        r.name AS nombre_rol
        FROM users u 
        LEFT JOIN empresas e ON u.id = e.user_id
        LEFT JOIN roles r ON u.id_rol = r.id;";
}
?>

<!-- Begin Page Content -->
<div class="container-fluid" align="center">

    <!-- Inicio de la zona central del sistema -->
    <!-- Todo -->
    <h1>Lista de usuarios</h1>
    <div class="filtrados">
        <!-- Agrega el campo de búsqueda -->
        <div class="form-group text-left buscar_nombre">
            <label for="buscar">Buscar por nombre:</label>
            <input type="text" class="form-control" id="buscar" placeholder="Ingrese el nombre">
        </div>
        <form action="" method="POST" class="filtro-form" id="filtro-form">
            <div class="form-group text-left buscar_nombre">
                <label for="buscar">Filtrar por rol:</label>
                <div class="label_select">
                    <select name="filtro_rol" id="filtro_rol" class="form-control filtro-rol-select"
                        onchange="submitForm()">
                        <option value="" <?php if (isset($_POST['filtro_rol']) && $_POST['filtro_rol'] == '') {
                            echo 'selected';
                        } ?>>Todos los roles</option>
                        <option value="Super-Admin" <?php if (isset($_POST['filtro_rol']) && $_POST['filtro_rol'] == 'Super-Admin') {
                            echo 'selected';
                        } ?>>Super-Admin</option>
                        <option value="Administrador" <?php if (isset($_POST['filtro_rol']) && $_POST['filtro_rol'] == 'Administrador') {
                            echo 'selected';
                        } ?>>Administrador</option>
                        <option value="Postulante" <?php if (isset($_POST['filtro_rol']) && $_POST['filtro_rol'] == 'Postulante') {
                            echo 'selected';
                        } ?>>Postulante</option>
                    </select>
                </div>
            </div>
            <!-- <div class="div_button">
                <div class="label_select">
                    <label for="filtro_rol" class="filtro-rol-label">Filtrar por rol:</label>
                    <select name="filtro_rol" id="filtro_rol" class="form-control filtro-rol-select"
                        onchange="submitForm()">
                        <option value="" <?php if (isset($_POST['filtro_rol']) && $_POST['filtro_rol'] == '') {
                            echo 'selected';
                        } ?>>Todos los roles</option>
                        <option value="Super-Admin" <?php if (isset($_POST['filtro_rol']) && $_POST['filtro_rol'] == 'Super-Admin') {
                            echo 'selected';
                        } ?>>Super-Admin</option>
                        <option value="Administrador" <?php if (isset($_POST['filtro_rol']) && $_POST['filtro_rol'] == 'Administrador') {
                            echo 'selected';
                        } ?>>Administrador</option>
                        <option value="Postulante" <?php if (isset($_POST['filtro_rol']) && $_POST['filtro_rol'] == 'Postulante') {
                            echo 'selected';
                        } ?>>Postulante</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary filtrar-btn">Filtrar</button>
            </div> -->
        </form>

        <script>
            function stopPropagation(event) {
                event.stopPropagation();
            }

            function submitForm() {
                document.getElementById('filtro-form').submit();
            }
        </script>

    </div>

    <div class="p-3 shadow" style="border-radius: 0.75rem;">
        <div class="overflow-auto" style="border-radius: 0.75rem;">
            <table class="table table-hover table-bordered mb-0">
                <thead>
                    <tr class="table-active bg-primary text-white text-center">
                        <th>DNI</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Teléfono</th>
                        <th>Empresa</th>
                        <th>Rol</th>
                        <th>Estado</th> <!-- Nueva columna -->
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $registros = mysqli_query($conexion, $sql);

                    while ($fila = mysqli_fetch_array($registros)) {
                        echo "<tr class='";
                        // Determinar la clase CSS según el valor de id_rol
                        if ($fila['nombre_rol'] == "Super-Admin") {
                            echo "rol-super-administrador";
                        } elseif ($fila['nombre_rol'] == "Administrador") {
                            echo "rol-administrador";
                        } elseif ($fila['nombre_rol'] == "Postulante") {
                            echo "rol-postulante";
                        }
                        echo "'>";
                        echo "<td>" . $fila['dni'] . "</td>";
                        echo "<td>" . $fila['nombres'] . "</td>";
                        echo "<td>" . $fila['apellidos'] . "</td>";
                        echo "<td>" . $fila['telefono'] . "</td>";
                        echo "<td>" . $fila['empresa_nombre'] . "</td>";
                        echo "<td>" . $fila['nombre_rol'] . "</td>";
                        echo "<td>" . $fila['Estado'] . "</td>";
                        echo "<td>";
                    ?>
                    <button title="Autorizar" type="button" class="btn btn-primary"
                        onclick="f_autorizar('<?php echo $fila['id']; ?>')" title="Autorizar"><i
                            class="fas fa-user-check"></i></button>
                    <button onclick="f_editar('<?php echo $fila['id']; ?>')" type="button" class="btn btn-success"
                        title="Editar"><i class="fas fa-edit"></i></button>
                    <button onclick="eliminarUsuario('<?php echo $fila['id']; ?>')" type="button" class="btn btn-danger"
                        title="Eliminar"><i class="far fa-trash-alt"></i></button>
                    <?php
                        echo "</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <div class="mt-3" id="found"> No se encontraron resultados coincidentes</div>
        </div>
    </div>

    <!-- Fin de la zona central del sistema -->
</div>
<!-- /.container-fluid -->
<!-- Lista de usuarios -->
<div id="div_usuarios" style="display: none;">
    <h1>Lista de usuarios</h1>

    <?php
    // Consulta para obtener la lista de usuarios que no son responsables de ninguna empresa
    $sql_usuarios = 'SELECT * FROM users WHERE id NOT IN (SELECT DISTINCT user_id FROM empresas WHERE user_id IS NOT NULL)';
    $registros_usuarios = mysqli_query($conexion, $sql_usuarios);
    
    // Verificar si hay algún error en la consulta
    if (!$registros_usuarios) {
        echo 'Error al obtener la lista de usuarios: ' . mysqli_error($conexion);
    } else {
        // Verificar si se encontraron usuarios
        if (mysqli_num_rows($registros_usuarios) > 0) {
            // Mostrar la lista de usuarios
            while ($fila_user = mysqli_fetch_array($registros_usuarios)) {
                echo '<a href="#" onclick="f_asignar(' . $fila_user['id'] . ')">';
                echo $fila_user['dni'] . ' --- ' . $fila_user['nombres'] . ' ---- ' . $fila_user['apellidos'] . '<br>';
                echo '</a>';
            }
        } else {
            echo 'No se encontraron usuarios disponibles.';
        }
    }
    ?>

    <button type="button" class="btn btn-primary" onclick="f_limpiar_usuario(ID_EMPRESA)">Limpiar
        usuario</button>
</div>

<?php
include '../../includes/food.php';
?>
<style>
    /* .filtrar {
        display: none;
    }

    @media screen and (min-width: 1280px) {
        .filtrar {
            display: block;
        }
    } */
    .label_select {
        width: auto;
        max-width: 150px;
    }

    .div_button {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .buscar_nombre {
        width: 100%;
        max-width: 580px;
        min-width: 150px;
    }

    .filtro-form {
        width: auto;
        display: flex;
        gap: 1rem;
    }

    .filtro-rol-label {
        margin-bottom: 0rem;
        margin-right: 10px;
    }

    .filtro-rol-select {
        flex: 1;
        cursor: pointer;
        padding-right: 0rem;
    }

    .filtrar-btn {
        min-width: 100px;
    }

    .filtrados {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 3rem;
    }

    .rol-super-administrador {
        background-color: #ffe6e6;
        /* Color de fondo para el rol de administrador */
    }

    .rol-administrador {
        background-color: #e6ffe6;
        /* Color de fondo para el rol de usuario */
    }

    .rol-postulante {
        background-color: #e6e6ff;
        /* Color de fondo para cualquier otro rol */
    }

    .rol-usuario {
        background-color: black;
    }
</style>

<script>
    $(document).ready(function() { // inicio de jQuery
        $('#div_usuarios').dialog({
            width: 600,
            height: 400,
            title: "Lista usuarios"
        });
        $('#div_usuarios').dialog("close");

        $('#found').hide();

        $('#buscar').on('input', function() {
            var searchTerm = $(this).val().toLowerCase();
            $('table tbody tr').each(function() {
                var title = $(this).find('td:eq(1)').text().toLowerCase();
                if (title.includes(searchTerm)) {
                    $(this).show();
                    $('#found').hide();
                } else {
                    $(this).hide();
                    $('#found').show();
                }
            });
        });
    }); // fin de jQuery

    // Función para redirigir a la página de edición con el ID del usuario
    function f_editar(pid) {
        window.location.href = "modificar_usuario.php?pid=" + pid;
    }

    // Función para eliminar un usuario
    function eliminarUsuario(id) {
        if (confirm("¿Estás seguro de que deseas eliminar este usuario?")) {
            window.location.href = "eliminar_usuario.php?id=" + id;
        }
    }

    function f_autorizar(id) {
        if (confirm("Se va autorizar este usuario, desea continuar?")) {
            window.location.href = "autorizar_usuario.php?id=" + id;

        }
    }
</script>
