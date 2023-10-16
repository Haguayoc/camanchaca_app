<?php
   session_start(); 
   if(empty($_SESSION['id'])){
        header("location: ../login.php");
   }

   include_once('../conexion.php');
   
   

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
            <title>Portal Administradores</title>
        </head>
        <body>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h2 class="title">Sr(a). <?php echo $_SESSION['nombre']." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"] ?> </h2>
                                <h5 class="title">Acá puede buscar los viajes con filtros:</h5>
                                <form action="./ver_viaje.php" method="POST">

                                    <div class="div-lado">
                                        <input class="select-size" type="date" id="select_fecha" name="select_fecha"></input>
                                        <br>
                                        <select name="select_grupo" id="select_grupo" class="select-size" required>
                                            <option value="0">Grupo</option>
                                            <?php
                                            $datos = $conexion->query ("SELECT * FROM grupo");
                                            while ($result = mysqli_fetch_array($datos)) {
                                                echo '<option value="'.$result['id'].'">'.$result['nombre'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <select name="select_vehiculo" id="select_vehiculo" class="select-size"required>
                                            <option value="0">Vehiculo</option>
                                            <?php
                                            $datosVehiculo = $conexion->query ("SELECT * FROM vehiculo");
                                            while ($resultVehiculo = mysqli_fetch_array($datosVehiculo)) {
                                                echo '<option value="'.$resultVehiculo['id'].'">'.$resultVehiculo['patente'].'</option>';
                                            }
                                            ?>
                                        </select>
                                        <br>
                                        <select name="select_conductor" id="select_conductor" class="select-size" required>
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
                                    <input class="btn" style="color:black" name="btnBuscarViaje" type="submit" value="Buscar">
                                </form>
                                <br>

                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                $(document).ready(function() {
                                    $("#btnBuscarViaje").click(function() {
                                        var selectFecha = $("#select_fecha").val();
                                        var selectGrupo = $("#select_grupo").val();
                                        var selectVehiculo = $("#select_vehiculo").val();
                                        var selectConductor = $("#select_conductor").val();

                                        // Enviar los valores al mismo archivo PHP a través de una solicitud AJAX
                                        $.ajax({
                                            url: "", // Deja el URL en blanco para que se refiera a la misma página
                                            method: "POST",
                                            data: {
                                                selectFecha: selectFecha,
                                                selectGrupo: selectGrupo,
                                                selectVehiculo: selectVehiculo,
                                                selectConductor: selectConductor
                                            },
                                            success: function(response) {
                                                // Manejar la respuesta del servidor si es necesario
                                                console.log(response);
                                            },
                                            error: function(error) {
                                                // Manejar errores si es necesario
                                                console.error(error);
                                            }
                                        });
                                    });
                                });
                                </script>

                                
                                <?php

                                    $sql = 'SELECT v.id_grupo, v.fecha,(SELECT nombre FROM grupo WHERE id=v.id_grupo) grupo,(SELECT patente FROM vehiculo WHERE id=v.id_vehiculo) vehiculo, (SELECT CONCAT(nombre," ",apellido_paterno," ", apellido_materno) conductor FROM usuario WHERE id=v.rut_conductor) nombre FROM viaje v ';
                                    $resultado = $conexion->query($sql);
                                    if(isset($_POST['btnBuscarViaje'])){
                                        $fecha = $_POST['select_fecha'];
                                        $grupo = $_POST['select_grupo'];
                                        $conductor = $_POST['select_conductor'];
                                        $vehiculo = $_POST['select_vehiculo'];
                                        
                                        $datos = array();
                                        if (!empty($fecha)) {
                                        
                                            $datos[] = " v.fecha = '$fecha' ";
                                        }
                                        
                                        if (!empty($grupo)) {
                                        
                                            $datos[] = " v.id_grupo = $grupo ";
                                        }
                                        
                                        if (!empty($vehiculo)) {
                                            
                                            $datos[] = " v.id_vehiculo = $vehiculo ";
                                        }
                                        
                                        if (!empty($conductor)) {
                                        
                                            $datos[] = " v.rut_conductor = $conductor";
                                        }
                                    
                                        $sql = 'SELECT v.id_grupo, v.fecha,(SELECT nombre FROM grupo WHERE id=v.id_grupo) grupo,(SELECT patente FROM vehiculo WHERE id=v.id_vehiculo) vehiculo, (SELECT CONCAT(nombre," ",apellido_paterno," ", apellido_materno) conductor FROM usuario WHERE id=v.rut_conductor) nombre FROM viaje v ';
                                        if(!empty($datos)){
                                            $sql.=' WHERE '. implode(' AND ', $datos);
                                        }
                                        $resultado = $conexion->query($sql);

                                    }
                                ?>


                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Fecha</th>
                                                <th scope="col">Conductor</th>
                                                <th scope="col">Patente</th>
                                                <th scope="col">Turno de Ruta</th>
                                                <th scope="col">Ver</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($resultado as $resultados){
                                                $date = explode('-', $resultados['fecha']);
                                                $date = $date[2] . '-' . $date[1] . '-' . $date[0];
                                            ?>
                                            <tr>
                                                <td><?= $date ?></td>
                                                <td><?= $resultados['nombre'] ?></td>
                                                <td><?= $resultados['vehiculo'] ?></td>
                                                <td><?= $resultados['grupo'] ?></td>
                                                <td><button id="btnVerPasajerosViaje" data-id-grupo="<?= $resultados['id_grupo'] ?>" class="btn verde">Ver Pasajeros</button></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>

                                <?php 

                                $idGrupoBoton = 1;
                                
                                $sql1 = "SELECT * FROM usuario WHERE id_grupo = '$idGrupoBoton';";
                                $data = $conexion->query($sql1);

                                $sql2 = "SELECT nombre FROM grupo WHERE id = '$idGrupoBoton';";
                                $data2 = $conexion->query($sql2);
                                
                                ?>    
                                <div class="div-lado">
                                    <button class="btn blue"><a style="color: black;" href="crear_viaje.php">Crear viaje</a></button>
                                    <button class="btn red"><a style="color: black;" href="inicio_administradores.php">Volver</a></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
           
  
            <div id="miPopup" class="modal-container" style="display: none;">
                <div class="modal-contenido">
                    <div class="tabla-container">
                        <div class="tabla-bg">
                            <div class="title-table">
                                <span id="cerrarPopup" class="cerrar">&times;</span>
                                <h2 >Trabajadores del grupo</h2>
                            </div>
                            <table id="miTabla" class="table tabla-trabajador">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre</th>
                                        <th scope="col">Rut</th>
                                        <th scope="col">Grupo</th>
                                        <th scope="col">Turno</th>
                                        <th scope="col">Área</th>
                                    </tr>
                                </thead>
                                <tbody id="data">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-table">
                
                
            </div> -->
            <script src="../verPasajerosViaje.js"></script>
        </body>
</html>