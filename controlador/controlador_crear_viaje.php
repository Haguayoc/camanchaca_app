<?php
// Iniciar sesión si no está iniciada
include("../conexion.php");
$msgError = "";
$msgSucess = "";

if (!empty($_POST["btncrearviaje"])) {
    $fecha = $_POST['fecha'];
    $idgrupo = $_POST['select_grupo'];
    $idvehiculo = $_POST['select_vehiculo'];
    $idconductor = $_POST['select_conductor'];

    if (empty($fecha) || empty($idgrupo) || empty($idvehiculo) || empty($idconductor)) {
        $msgError = '<div class="alert alert-danger">Los campos fecha, grupo, vehículo y conductor no pueden estar vacíos</div>';
    } else {
        $sql = "INSERT INTO viaje (fecha, id_grupo, id_vehiculo, rut_conductor) VALUES ('$fecha', '$idgrupo', '$idvehiculo', '$idconductor')";
        $resultado = $conexion->query($sql);

        if ($resultado === TRUE) {
            $_SESSION['mensaje'] = 'El viaje se ha creado correctamente';
            header("location:../administrador/crear_viaje.php");
            exit; // Añadir exit después de redirigir para evitar ejecución adicional del código.
        } else {
            $msgError = '<div class="alert alert-danger">El viaje no se ha creado correctamente</div>';
        }
    }
}
// Después de redirigir, mostrar el mensaje de sesión si existe
if (isset($_SESSION['mensaje'])) {
    $msgSucess = '<div class="alert alert-success">' . $_SESSION['mensaje'] . '</div>';
    unset($_SESSION['mensaje']); // Limpiar el mensaje de sesión
}
?>