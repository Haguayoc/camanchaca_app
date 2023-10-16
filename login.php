<?php
include_once("conexion.php");
include_once("controlador/controlador_login.php");


?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="styles.css">
        <link rel="stylesheet" href="bootstrap.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" 
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" 
        crossorigin="anonymous" referrerpolicy="no-referrer" />
        <title>Login</title>
    </head>
    <body>
        <main class="container-form">
            <form style="display:flex; align-items: center; justify-content: center; width: auto;" id="miFormulario" method="post" action="">
                <img  id="logo" src="img/image.png" width="234"/>
                <div id="mensajeRut" ></div>
                <label for="">
                    <i class="fa-solid fa-user"></i>
                    <input  type="text" maxlength="10" placeholder="RUT" id="rut" name="rut">
                </label>
                <div id="mensajeContraseña"></div>
                <label for="">
                    <i class="fa-solid fa-lock"></i>
                    <input  type="password" placeholder="Contraseña" id="password" name="password">
                </label>
                <input style="width: 100%;" class="btn" name="btningresar" type="submit" value="Ingresar"><br>
            
            </form>
            <?= $msgError ?>
            <?= $sent ?>
        </main>
       
        <script src="validar.js"></script>
    </body>
</html>