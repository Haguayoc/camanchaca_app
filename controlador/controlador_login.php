<?php

/* Funciones para validar el inicio de sesion y tipo de usuario */
session_start();
$msgError="";
$sent='';
if (!empty($_POST["btningresar"])) {
    if (empty($_POST["rut"]) and empty($_POST["password"])){
        $msgError= '<div class="alert alert-danger">Los Campos Rut y Password no pueden estar vacios</div>';
        
    } else {
        $rut = $_POST["rut"];

        $rut_list = array_reverse(str_split($rut));
        $x = 2;
        $aux = 0;
        for($i=0; $i<count($rut_list); $i++){
            if($x==8) $x=2;
            $aux += (int)$rut_list[$i] * $x;
            $x++;
        }
        $total = $aux;
        $dv_valido = 11 - ($total - (floor($aux/11) * 11));
        if($dv_valido==11) $dv_valido = 0;
        if($dv_valido==10) $dv_valido = 'K';


        $rutFinal = $rut."-".$dv_valido;
        $sent = $dv_valido;
        
        $password = $_POST["password"];
        $hashedPassword = hash('sha256', $password); // Encripta la contraseña en SHA-256
        $result = $conexion->query("SELECT * FROM usuario WHERE rut = '$rutFinal' and pass = '$hashedPassword'");
        $user = $result->fetch_assoc();
        if($user != NULL){
            $_SESSION['id']=$user['id'];
            $_SESSION['rut']=$user['rut'];
            $_SESSION['nombre']=$user['nombre'];
            $_SESSION['apellido_paterno']=$user['apellido_paterno'];
            $_SESSION['apellido_materno']=$user['apellido_materno'];
            $_SESSION['longitud']=$user['longitud'];
            $_SESSION['latitud']=$user['latitud'];
            $_SESSION['id_grupo']=$user['id_grupo'];
            $_SESSION['id_area']=$user['id_area'];
            $_SESSION['id_turno']=$user['id_turno'];
            $_SESSION['id_rol']=$user['id_rol'];
            switch($user['id_rol']){
                case '0':
                    $msgError= '<div class="alert alert-danger">Error en RUT o Contraseña</div>';
                    break;
                case '1':
                    header("Location: administrador/inicio_administradores.php");
                    break;
                case '2':
                    header("Location: conductor/inicio_conductores.php");
                    break;
                case '3':
                    header("Location: trabajador/inicio_trabajador.php");
                    break;
            }
          } else {
                $msgError = '<div class="alert alert-danger">Error en RUT o Contraseña</div>';
            }
    }
}
?>
