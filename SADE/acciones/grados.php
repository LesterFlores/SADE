<?php
include('../db_connect.php');

$codigo = $_GET['codigo'];
$descripcion = $_GET['descripcion'];

$sql = "INSERT INTO tbl_grados (codigo_grado, descripcion) VALUES ('$codigo','$descripcion')";

if($conn->query($sql)=== TRUE){
    header('Location: ../grados/grados.php?alerta=registroexitoso');
}else{
    header('Location: ../grados/agregarGrado.php?alerta=Error');
}

$conn->close();

?>