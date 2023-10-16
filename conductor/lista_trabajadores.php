<?php
   session_start(); 
   if(empty($_SESSION['id'])){
        header("location: ../login.php");
   }

   include_once('../conexion.php');

   if (empty($data) && empty($data2)) {
    // Realiza la consulta para obtener el valor de id_grupo
    $consultaGrupo = $conexion->query("SELECT id_grupo FROM viaje WHERE rut_conductor = '$_SESSION[id]'");
    
    if ($consultaGrupo) {
        // Extrae el valor de id_grupo del resultado de la consulta
        $filaGrupo = $consultaGrupo->fetch_assoc();
        $idGrupo = $filaGrupo['id_grupo'];
        
        // Utiliza el valor de id_grupo en las siguientes consultas
        $data = $conexion->query("SELECT * FROM usuario WHERE id_grupo = '$idGrupo'");
        $data2 = $conexion->query("SELECT * FROM grupo WHERE id = '$idGrupo'");
        
        // Asegúrate de verificar si las consultas se ejecutaron correctamente
        if ($data === FALSE || $data2 === FALSE) {
            die("Error en una o ambas consultas: " . $conexion->error);
        }
    } else {
        die("Error en la consulta de grupo: " . $conexion->error);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
        <head>
        <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../styles.css">
            <link rel="stylesheet" href="../bootstrap.css">
            <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" 
            integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" 
            crossorigin="anonymous" referrerpolicy="no-referrer" />
            <title>Portal Conductores</title>
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="title">Sr(a). <?php echo $_SESSION['nombre']." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"] ?> </h2>
                                <h5 class="title">Los trabajadores que deberas recoger están presentes en la siguiente lista:</h5>
                                <?php
                                    //$grupo = $conexion->query("SELECT id_grupo FROM viaje WHERE rut_conductor = '$_SESSION[id]';");

                                    //$data = $conexion->query("SELECT * FROM usuario WHERE id_grupo = '1';");
                                    //$data2 = $conexion->query("SELECT nombre FROM grupo WHERE id = '1';");
                                ?>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Apellidos</th>
                                                <th scope="col">Rut</th>
                                                <th scope="col">Turno</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($data as $row) {
                                            foreach ($data2 as $row2){  ?>
                                            <tr>
                                                <td><?php echo $row['nombre'];?></td>
                                                <td><?php echo $row['apellido_paterno']." ".$row['apellido_materno'];?></td>
                                                <td><?php echo $row['rut'];?></td>
                                                <td><?php echo $row2['nombre'];?></td>
                                            </tr>
                                            <?php } }?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="div-lado">
                                    <button class="btn"><a style="color: black;" href="ruta_conductor.php">Ver Ruta</a></button>
                                    <button style="background-color: #C76868;" class="btn"><a style="color: black;" href="inicio_conductores.php">Inicio</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
</html>