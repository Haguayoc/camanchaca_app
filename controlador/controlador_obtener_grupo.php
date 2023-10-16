<?php
include("../conexion.php");



$id = $_GET['id_grupo'];
$sql = "SELECT rut, CONCAT(nombre,' ',apellido_paterno,' ',apellido_materno) nombre, (SELECT nombre FROM grupo WHERE id=u.id_grupo) grupo, (SELECT nombre FROM area WHERE id=u.id_area) area, (SELECT nombre FROM turno WHERE id=u.id_turno) turno FROM usuario u WHERE id_grupo = " . $id;
$res = $conexion->query($sql);
header('Content-Type: application/json');

echo json_encode($res->fetch_all());
?>