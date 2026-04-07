
<?php
include "conexion.php";

$img = "";
if(isset($_FILES['fotografia_url']) && $_FILES['fotografia_url']['name'] != ""){
    $img = $_FILES['fotografia_url']['name'];
    move_uploaded_file($_FILES['fotografia_url']['tmp_name'], "imagenes/".$img);
}

$sql = "INSERT INTO inventario_repuestos 
(codigo,nombre_repuesto,descripcion,marca,modelo_compatible,cantidad_stock,precio_unitario,proveedor,ubicacion,fecha_ingreso,fotografia_url)
VALUES (
'".$_POST['codigo']."',
'".$_POST['nombre_repuesto']."',
'".$_POST['descripcion']."',
'".$_POST['marca']."',
'".$_POST['modelo_compatible']."',
'".$_POST['cantidad_stock']."',
'".$_POST['precio_unitario']."',
'".$_POST['proveedor']."',
'".$_POST['ubicacion']."',
'".$_POST['fecha_ingreso']."',
'$img'
)";

$conexion->query($sql);
header("Location: index.php");
?>
