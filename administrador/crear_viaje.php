<?php
   session_start(); 
   if(empty($_SESSION['id'])){
        header("location: ../login.php");
   }

   include_once("../conexion.php");
   include_once("../controlador/controlador_crear_viaje.php");


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../bootstrap.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" 
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" 
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="../styles.css">
    <title>Portal Administradores</title>
</head>
<body>
    <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div style="padding: 20px;" class="card-body">
                                <h1 style="align-self: center; margin-bottom: 25px;">CREAR VIAJE</h1>
                                <form method="post" style="width: auto;" action="">
                                    <?php echo $msgError;?>
                                    <?php echo $msgSucess;?>
                                <div class="div-lado">
                                    <input class="select-size" type="date" id="fecha" name="fecha"></input>
                                    <br>
                                    <select name="select_grupo" class="select-size" required>
                                        <option value="0">Grupo</option>
                                        <?php
                                        $datos = $conexion->query ("SELECT * FROM grupo");
                                        while ($result = mysqli_fetch_array($datos)) {
                                            echo '<option value="'.$result['id'].'">'.$result['nombre']." Pasajeros ".$result['cantidad'].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <select name="select_vehiculo" class="select-size"required>
                                        <option value="0">Vehiculo</option>
                                        <?php
                                        $datosVehiculo = $conexion->query ("SELECT * FROM vehiculo");
                                        while ($resultVehiculo = mysqli_fetch_array($datosVehiculo)) {
                                            echo '<option value="'.$resultVehiculo['id'].'">'.$resultVehiculo['patente']." Asientos: ".$resultVehiculo['capacidad'].'</option>';
                                        }
                                        ?>
                                    </select>
                                    <br>
                                    <select name="select_conductor" class="select-size" required>
                                        <option value="0">Conductor</option>
                                        <?php
                                        $datosConductor = $conexion->query ("SELECT * FROM usuario WHERE id_rol = 2");
                                        while ($resultConductor = mysqli_fetch_array($datosConductor)) {
                                            echo '<option value="'.$resultConductor['id'].'">'.$resultConductor['nombre']." ".$resultConductor['apellido_paterno'].'</option>';
                                        }
                                        ?>
                                    </select>
                                </div>
                                <br>
                                <input class="btn blue" name="btncrearviaje" type="submit" value="Crear Viaje">
                                <button type="button" class="btn blue" onclick="redirigir_ver_viajes()">Ver Viajes</button>
                                <button type="button" onclick="volver_inicio_admin_transporte()" class="btn red">Volver</button>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
    </div>
    <script src="../main.js"></script>
</body>
</html>