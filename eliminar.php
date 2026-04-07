<?php
include "conexion.php";
$id = $_GET['id'];
$conexion->query("DELETE FROM inventario_repuestos WHERE codigo=$id");
header("Location: index.php");
?>
