<?php
$hostname='localhost';
$database='camanchaca_app';
$username='root';
$password='';

$conexion=new mysqli($hostname,$username,$password,$database);
$conexion->set_charset("utf8");
if($conexion->connect_errno){
    echo "El sitio web esta experimentando problemas";
}


?>