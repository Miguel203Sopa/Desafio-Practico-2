<?php include "conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario de Repuestos</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <style>
        :root {
            --bg-body: #0f172a;
            --bg-card: #1e293b;
            --bg-input: #334155;
            --text-main: #f1f5f9;
            --text-muted: #94a3b8;
            --primary: #a855f7;
            --primary-hover: #c084fc;
            --border-color: #334155;
            --danger: #ef4444;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-body);
            color: var(--text-main);
            padding: 40px 20px;
        }

        .container { max-width: 1100px; margin: auto; }

        h2 {
            margin-bottom: 20px;
        }

        /* FORM */
        form {
            background: var(--bg-card);
            padding: 25px;
            border-radius: 12px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-bottom: 30px;
        }

        input {
            padding: 10px;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: white;
        }

        button {
            grid-column: 1 / -1;
            padding: 12px;
            background: var(--primary);
            border: none;
            border-radius: 8px;
            color: white;
            cursor: pointer;
        }

        /* TABLE */
        table {
            width: 100%;
            border-collapse: collapse;
            background: var(--bg-card);
            border-radius: 10px;
            overflow: hidden;
        }

        th, td {
            padding: 12px;
        }

        th {
            color: var(--primary);
        }

        tr:hover {
            background: rgba(168, 85, 247, 0.1);
            cursor: pointer;
        }

        .btn {
            padding: 5px 10px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
        }

        .edit { border: 1px solid var(--primary); color: var(--primary); }
        .delete { border: 1px solid var(--danger); color: var(--danger); }

        /* MODAL */
        .modal {
            display: none;
            position: fixed;
            top:0; left:0;
            width:100%; height:100%;
            background: rgba(0,0,0,0.8);
        }

        .contenido {
            background: var(--bg-card);
            margin: 10% auto;
            padding: 20px;
            width: 400px;
            border-radius: 12px;
        }

        .close {
            float: right;
            cursor: pointer;
        }

        #m_img {
            width: 100%;
            margin-top: 10px;
            border-radius: 8px;
            display: none;
        }

        #m_url {
            width: 100%;
            margin-top: 10px;
            padding: 10px;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: white;
        }

    </style>
</head>
<body>

<div class="container">

<h2>Inventario de Repuestos</h2>

<form action="insertar.php" method="POST">
    <input type="text" name="codigo" placeholder="Código">
    <input type="text" name="nombre_repuesto" placeholder="Nombre">
    <input type="text" name="descripcion" placeholder="Descripción">
    <input type="text" name="marca" placeholder="Marca">
    <input type="text" name="modelo_compatible" placeholder="Modelo">
    <input type="number" name="cantidad_stock" placeholder="Stock">
    <input type="number" step="0.01" name="precio_unitario" placeholder="Precio">
    <input type="text" name="proveedor" placeholder="Proveedor">
    <input type="text" name="ubicacion" placeholder="Ubicación">
    <input type="date" name="fecha_ingreso">
    <input type="url" name="fotografia_url" placeholder="URL de la imagen">
    <button>Agregar</button>
</form>

<table>
<tr>
    <th>Código</th><th>Nombre</th><th>Stock</th><th>Precio</th><th>Acciones</th>
</tr>

<?php
$result = $conexion->query("SELECT * FROM inventario_repuestos");
while($row = $result->fetch_assoc()){
?>
<tr onclick='verDetalle(<?php echo json_encode($row); ?>)'>
    <td><?php echo $row['codigo']; ?></td>
    <td><?php echo $row['nombre_repuesto']; ?></td>
    <td><?php echo $row['cantidad_stock']; ?></td>
    <td>$<?php echo $row['precio_unitario']; ?></td>
    <td onclick="event.stopPropagation();">
        <a href="editar.php?codigo=<?php echo $row['codigo']; ?>" class="btn edit">Editar</a>
        <a href="eliminar.php?id=<?php echo $row['codigo']; ?>" class="btn delete">Eliminar</a>
    </td>
</tr>
<?php } ?>

</table>

</div>

<!-- MODAL -->
<div id="modal" class="modal">
    <div class="contenido">
        <span class="close" onclick="cerrar()">X</span>

        <h3 id="m_nombre"></h3>
        <p id="m_desc"></p>

        <!-- INPUT DEL LINK -->
        <input id="m_url" type="text" readonly onclick="this.select()">

        <!-- IMAGEN -->
        <img id="m_img">

    </div>
</div>

<script>
function verDetalle(data){
    document.getElementById("m_nombre").innerText = data.nombre_repuesto;
    document.getElementById("m_desc").innerText = data.descripcion;

    const img = document.getElementById("m_img");
    const url = document.getElementById("m_url");

    if(data.fotografia_url){
        img.src = data.fotografia_url;
        img.style.display = "block";
        url.value = data.fotografia_url;
    }else{
        img.style.display = "none";
        url.value = "Sin imagen";
    }

    document.getElementById("modal").style.display = "block";
}

function cerrar(){
    document.getElementById("modal").style.display = "none";
}
</script>

</body>
</html>