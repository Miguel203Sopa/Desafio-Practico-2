<?php
include "conexion.php";

// Capturamos la URL enviada por el formulario
$url_imagen = isset($_POST['fotografia_url']) ? $_POST['fotografia_url'] : "";

// Preparar los datos (idealmente deberías usar prepared statements para seguridad, 
// pero manteniendo tu estructura actual, agregamos real_escape_string para evitar errores de sintaxis)
$codigo = $conexion->real_escape_string($_POST['codigo']);
$nombre = $conexion->real_escape_string($_POST['nombre_repuesto']);
$descripcion = $conexion->real_escape_string($_POST['descripcion']);
$marca = $conexion->real_escape_string($_POST['marca']);
$modelo = $conexion->real_escape_string($_POST['modelo_compatible']);
$cantidad = (int)$_POST['cantidad_stock'];
$precio = (float)$_POST['precio_unitario'];
$proveedor = $conexion->real_escape_string($_POST['proveedor']);
$ubicacion = $conexion->real_escape_string($_POST['ubicacion']);
$fecha = $conexion->real_escape_string($_POST['fecha_ingreso']);
$url_imagen_escaped = $conexion->real_escape_string($url_imagen);

$sql = "INSERT INTO inventario_repuestos 
(codigo, nombre_repuesto, descripcion, marca, modelo_compatible, cantidad_stock, precio_unitario, proveedor, ubicacion, fecha_ingreso, fotografia_url)
VALUES (
'$codigo',
'$nombre',
'$descripcion',
'$marca',
'$modelo',
'$cantidad',
'$precio',
'$proveedor',
'$ubicacion',
'$fecha',
'$url_imagen_escaped'
)";

if ($conexion->query($sql) === TRUE) {
    header("Location: index.php");
} else {
    echo "Error: " . $sql . "<br>" . $conexion->error;
}
?>
