<?php
   session_start(); 
   if(empty($_SESSION['id'])){
        header("location: ../login.php");
   }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Portal Conductores</title>
        <link rel="stylesheet" href="../styles.css">
        <link rel="stylesheet" href="../bootstrap.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" 
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    </head>
     <body>
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                            <h1 class="title">Bienvenido <?php echo $_SESSION['nombre']." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"] ?></h1>
                                  <button class="btn" onclick="redirigir_crear_viaje()"><a>Crear Viaje</a></button>
                                  <button  class="btn" onclick="redirigir_ver_viajes()">Ver Viajes</button>
                                  <button  id="btnsalir" class="btn" onclick="cerrar_sesion()" ><a>Cerrar sesión</a></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    
        <script src="../main.js"></script>
    </body>
</html>