
<?php
   session_start(); 
   if(empty($_SESSION['id'])){
        header("location: ../login.php");
   }

   include_once("../conexion.php");
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
                            <h2 class="title">Hola, <?php echo $_SESSION['nombre']." ".$_SESSION["apellido_paterno"]." ".$_SESSION["apellido_materno"] ?> </h2>
                            <h4 class="title">Este es el punto donde debes esperar:</h4>
                            <img style="align-self:center;width: 40%; height: 40%;" id="logo" src="../img/mapa1.png"/>
                            <div class="div-lado">
                                <button class="btn"><a style="color: black;" href="ver_turno.php">Ver Turno</a></button>
                                <button style="background-color: #C76868;" class="btn"><a style="color: black;" href="inicio_trabajador.php">Inicio</a></button>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
</html>