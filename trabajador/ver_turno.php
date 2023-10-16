<?php
   session_start(); 
   if(empty($_SESSION['id'])){
        header("location: ../login.php");
   }

   include_once('../conexion.php');

   if(empty($data)){
    $consulta = "SELECT * FROM usuario WHERE id = '$_SESSION[id]'";
    $resultado= $conexion->query($consulta);
    $data=$resultado->fetch_all(MYSQLI_ASSOC);
}

if(empty($data2)){
    $consulta = "SELECT * FROM turno WHERE id = '$_SESSION[id_turno]'";
    $resultado= $conexion->query($consulta);
    $data2=$resultado->fetch_all(MYSQLI_ASSOC);
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
            <title>Portal Trabajadores</title>
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="title">Sr(a). <?php echo $_SESSION['nombre']." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"] ?> </h2>
                                <h5 class="title">Los trabajadores que deberas recoger están presentes en la siguiente lista:</h5>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Apellidos</th>
                                                <th scope="col">Rut</th>
                                                <th scope="col">Horario</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($data as $row) {
                                            foreach ($data2 as $row2){  
                                            ?>
                                            <tr>
                                                <td><?php echo $row['nombre'];?></td>
                                                <td><?php echo $row['apellido_paterno']." ".$row['apellido_materno'];?></td>
                                                <td><?php echo $row['rut'];?></td>
                                                <td><?php echo $row2['nombre']." ".$row2['hora_entrada']." ".$row2['hora_salida'];?></td>
                                            </tr>
                                            <?php } }?>
                                        </tbody>
                                    </table>
                                </div>
                                
                                <div class="div-lado">
                                    <button class="btn"><a style="color: black;" href="punto_espera.php">Ver Ruta</a></button>
                                    <button style="background-color: #C76868;" class="btn"><a style="color: black;" href="inicio_trabajador.php">Volver</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
</html>