
<?php include "conexion.php"; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Repuestos</title>
    <style>
        body { font-family: Arial; }
        table { border-collapse: collapse; width: 100%; }
        th, td { border: 1px solid #ccc; padding: 8px; }
        .modal { display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:#0008; }
        .contenido { background:white; margin:10% auto; padding:20px; width:300px; }
    </style>
</head>
<body>

<h2>Inventario de Repuestos</h2>

<form action="insertar.php" method="POST" enctype="multipart/form-data">
    <input type="number" name="codigo" placeholder="Código" required>
    <input type="text" name="nombre_repuesto" placeholder="Nombre" required>
    <input type="text" name="descripcion" placeholder="Descripción">
    <input type="text" name="marca" placeholder="Marca">
    <input type="text" name="modelo_compatible" placeholder="Modelo">
    <input type="number" name="cantidad_stock" placeholder="Cantidad">
    <input type="number" step="0.01" name="precio_unitario" placeholder="Precio Unitario">
    <input type="text" name="proveedor" placeholder="Proveedor">
    <input type="text" name="ubicacion" placeholder="Ubicación">
    <input type="date" name="fecha_ingreso">
    <input type="file" name="fotografia_url">
    <button type="submit">Agregar</button>
</form>

<table>
<tr>
<th>Código</th><th>Nombre</th><th>Cantidad</th><th>Precio</th><th>Acciones</th>
</tr>

<?php
$resultado = $conexion->query("SELECT * FROM inventario_repuestos");

if(!$resultado){
    die("Error en consulta: " . $conexion->error);
}

while($row = $resultado->fetch_assoc()){
?>
<tr onclick='verDetalle(<?php echo json_encode($row); ?>)'>
    <td><?php echo $row['codigo']; ?></td>
    <td><?php echo $row['nombre_repuesto']; ?></td>
    <td><?php echo $row['cantidad_stock']; ?></td>
    <td><?php echo $row['precio_unitario']; ?></td>
    <td>
        <a href="eliminar.php?id=<?php echo $row['codigo']; ?>">Eliminar</a>
    </td>
</tr>
<?php } ?>
</table>

<div id="modal" class="modal">
    <div class="contenido">
        <span onclick="cerrar()">X</span>
        <h3 id="m_nombre"></h3>
        <p id="m_desc"></p>
        <img id="m_img" width="100">
    </div>
</div>

<script>
function verDetalle(data){
    document.getElementById("m_nombre").innerText = data.nombre_repuesto;
    document.getElementById("m_desc").innerText = data.descripcion;
    document.getElementById("m_img").src = "imagenes/" + data.fotografia_url;
    document.getElementById("modal").style.display = "block";
}

function cerrar(){
    document.getElementById("modal").style.display = "none";
}
</script>

</body>
</html>