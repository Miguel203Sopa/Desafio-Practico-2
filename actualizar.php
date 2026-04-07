<?php
include "conexion.php";

$sql = "UPDATE inventario_repuestos SET
nombre_repuesto='".$_POST['nombre_repuesto']."',
descripcion='".$_POST['descripcion']."',
marca='".$_POST['marca']."',
modelo_compatible='".$_POST['modelo_compatible']."',
cantidad_stock='".$_POST['cantidad_stock']."',
precio_unitario='".$_POST['precio_unitario']."',
proveedor='".$_POST['proveedor']."',
ubicacion='".$_POST['ubicacion']."',
fecha_ingreso='".$_POST['fecha_ingreso']."',
fotografia_url='".$_POST['fotografia_url']."' 
WHERE codigo='".$_POST['codigo']."'";

$conexion->query($sql);
header("Location: index.php");
?>