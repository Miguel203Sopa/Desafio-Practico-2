<?php
include "conexion.php";
$codigo = $_GET['codigo'];

$result = $conexion->query("SELECT * FROM inventario_repuestos WHERE codigo=$codigo");
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head><title>Editar</title></head>
<body>
<h2>Editar Repuesto</h2>
<form action="actualizar.php" method="POST">
    <input type="hidden" name="codigo" value="<?php echo $data['codigo']; ?>">
    <input type="text" name="nombre_repuesto" value="<?php echo $data['nombre_repuesto']; ?>">
    <input type="text" name="descripcion" value="<?php echo $data['descripcion']; ?>">
    <input type="text" name="marca" value="<?php echo $data['marca']; ?>">
    <input type="text" name="modelo_compatible" value="<?php echo $data['modelo_compatible']; ?>">
    <input type="number" name="cantidad_stock" value="<?php echo $data['cantidad_stock']; ?>">
    <input type="number" step="0.01" name="precio_unitario" value="<?php echo $data['precio_unitario']; ?>">
    <input type="text" name="proveedor" value="<?php echo $data['proveedor']; ?>">
    <input type="text" name="ubicacion" value="<?php echo $data['ubicacion']; ?>">
    <input type="date" name="fecha_ingreso" value="<?php echo $data['fecha_ingreso']; ?>">
    <button type="submit">Actualizar</button>
</form>
</body>
</html>
