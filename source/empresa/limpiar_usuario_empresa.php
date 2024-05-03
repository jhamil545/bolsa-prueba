<?php
include("../../includes/conectar.php");
$conexion = conectar();
// Verificar si se recibió el ID de la empresa
if(isset($_POST['id_empresa'])) {

    $id_empresa = $_POST['id_empresa'];

    // Consulta para obtener el ID del usuario asociado con la empresa
    $sql_obtener_usuario = "SELECT user_id FROM empresas WHERE id = '$id_empresa'";
    $resultado_obtener_usuario = mysqli_query($conexion, $sql_obtener_usuario);
    
    if ($resultado_obtener_usuario) {
        $fila = mysqli_fetch_assoc($resultado_obtener_usuario);
        $id_usuario = $fila['user_id'];

        $sql = "UPDATE empresas SET user_id = NULL WHERE id = '$id_empresa'";
        // Ejecutar la consulta para limpiar el usuario de la empresa
        if (mysqli_query($conexion, $sql)) {
            // Actualizar el rol del usuario a 3 (o el valor que necesites)
            $sql_actualizar_rol = "UPDATE users SET id_rol = '3' WHERE id = '$id_usuario'";
            if (mysqli_query($conexion, $sql_actualizar_rol)) {
                echo "Usuario limpiado correctamente de la empresa y rol actualizado.";
            } else {
                echo "Error al actualizar el rol del usuario: " . mysqli_error($conexion);
            }
            
        } else {
            echo "Error al limpiar usuario de la empresa: " . mysqli_error($conexion);
        }
    } else {
        echo "Error al obtener el usuario asociado con la empresa: " . mysqli_error($conexion);
    }

    // Cerrar la conexión
    mysqli_close($conexion);
} else {
    echo "ID de empresa no recibido.";
}

