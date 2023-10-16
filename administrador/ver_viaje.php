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
                            <div class="card-body boxBlanco">
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
                                    <input class="btn blue" name="btnBuscarViaje" type="submit" value="Buscar">
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

                                    $sql = 'SELECT v.id_grupo, v.fecha,(SELECT nombre FROM grupo WHERE id=v.id_grupo) grupo,(SELECT hora_entrada FROM turno WHERE id=(SELECT id_turno FROM grupo WHERE id = v.id_grupo)) turno ,(SELECT patente FROM vehiculo WHERE id=v.id_vehiculo) vehiculo, (SELECT CONCAT(nombre," ",apellido_paterno," ", apellido_materno) conductor FROM usuario WHERE id=v.rut_conductor) nombre FROM viaje_ida v WHERE fecha =  CURDATE()';
                                    $resultado = $conexion->query($sql);
                                    $sql2 = 'SELECT v.id_grupo, v.fecha,(SELECT nombre FROM grupo WHERE id=v.id_grupo) grupo,(SELECT hora_salida FROM turno WHERE id=(SELECT id_turno FROM grupo WHERE id = v.id_grupo)) turno ,(SELECT patente FROM vehiculo WHERE id=v.id_vehiculo) vehiculo, (SELECT CONCAT(nombre," ",apellido_paterno," ", apellido_materno) conductor FROM usuario WHERE id=v.rut_conductor) nombre FROM viaje_vuelta v WHERE fecha = CURDATE()';
                                    $resultado2 = $conexion->query($sql2);
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
                                    
                                        $sql = 'SELECT v.id_grupo, v.fecha,(SELECT nombre FROM grupo WHERE id=v.id_grupo) grupo,(SELECT hora_entrada FROM turno WHERE id=(SELECT id_turno FROM grupo WHERE id=v.id_grupo)) turno ,(SELECT patente FROM vehiculo WHERE id=v.id_vehiculo) vehiculo, (SELECT CONCAT(nombre," ",apellido_paterno," ", apellido_materno) conductor FROM usuario WHERE id=v.rut_conductor) nombre FROM viaje_ida v ';
                                        $sql2 = 'SELECT v.id_grupo, v.fecha,(SELECT nombre FROM grupo WHERE id=v.id_grupo) grupo,(SELECT hora_salida FROM turno WHERE id=(SELECT id_turno FROM grupo WHERE id=v.id_grupo)) turno ,(SELECT patente FROM vehiculo WHERE id=v.id_vehiculo) vehiculo, (SELECT CONCAT(nombre," ",apellido_paterno," ", apellido_materno) conductor FROM usuario WHERE id=v.rut_conductor) nombre FROM viaje_vuelta v ';
                                        if(!empty($datos)){
                                            $sql.=' WHERE '. implode(' AND ', $datos);
                                            $sql2.=' WHERE '. implode(' AND ', $datos);
                                        }
                                        $resultado = $conexion->query($sql);
                                        $resultado2 = $conexion->query($sql2);

                                    }
                                ?>

                                <div class="btn-group">
                                    <button class="btn blue" id="ida">Ida</button>
                                    <button class="btn blue" id="vuelta">Vuelta</button>
                                    <button class="btn blue" id="todos">Todos</button>
                                </div>
                                <div style="margin-bottom: 10px;" class="div-lado" >
                                    <div class="table-responsive" style="padding-top: 10px; border-radius: 15px; box-shadow: 0px 0px 4px 3px rgba(0, 0, 0, 0.2);">
                                    <h4 class="textoViaje">Viajes de Ida</h4>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Conductor</th>
                                                    <th scope="col">Patente</th>
                                                    <th scope="col">Grupo</th>
                                                    <th scope="col">Hora Entrada</th>
                                                    <th scope="col">Ver Pasajeros</th>
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
                                                    <td><?= $resultados['turno'] ?></td>
                                                    <td><button id="btnVerPasajerosViaje" data-id-grupo="<?= $resultados['id_grupo'] ?>" class="btn verde">Ver</button></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive" style="padding-top: 10px; border-radius: 15px; box-shadow: 0px 0px 4px 3px rgba(0, 0, 0, 0.2);">
                                    <h4 class="textoViaje">Viajes de Vuelta</h4>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Fecha</th>
                                                    <th scope="col">Conductor</th>
                                                    <th scope="col">Patente</th>
                                                    <th scope="col">Grupo</th>
                                                    <th scope="col">Hora Salida</th>
                                                    <th scope="col">Ver Pasajeros</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                foreach ($resultado2 as $resultados2){
                                                    $date = explode('-', $resultados2['fecha']);
                                                    $date = $date[2] . '-' . $date[1] . '-' . $date[0];
                                                ?>
                                                <tr>
                                                    <td><?= $date ?></td>
                                                    <td><?= $resultados2['nombre'] ?></td>
                                                    <td><?= $resultados2['vehiculo'] ?></td>
                                                    <td><?= $resultados2['grupo'] ?></td>
                                                    <td><?= $resultados2['turno'] ?></td>
                                                    <td><button id="btnVerPasajerosViaje" data-id-grupo="<?= $resultados2['id_grupo'] ?>" class="btn verde">Ver</button></td>
                                                </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <?php 

                                $idGrupoBoton = 1;
                                
                                $sql1 = "SELECT * FROM usuario WHERE id_grupo = '$idGrupoBoton';";
                                $data = $conexion->query($sql1);

                                $sql2 = "SELECT nombre FROM grupo WHERE id = '$idGrupoBoton';";
                                $data2 = $conexion->query($sql2);
                                
                                ?>    
                                <div class="div-lado">
                                    <button class="btn blue" onclick="redirigir_crear_viaje()">Ver Viaje</button>
                                    <button class="btn red" onclick="volver_inicio_admin_transporte()">Volver</button>
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
                                <div class="info">
                                    <span id="fechaViaje" class="fecha"></span>
                                    <span id="conductorViaje" class="conductor"></span>
                                </div>
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
            <script src="../main.js"></script>
        </body>
</html>