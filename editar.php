<?php
include "conexion.php";
$codigo = $_GET['codigo'];

$result = $conexion->query("SELECT * FROM inventario_repuestos WHERE codigo=$codigo");
$data = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #f5f7fa, #e4ecf3);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .contenedor {
            background: #ffffffcc;
            backdrop-filter: blur(10px);
            padding: 30px;
            border-radius: 12px;
            width: 400px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
            border: 1px solid #ddd;
            border-radius: 6px;
            outline: none;
            transition: 0.3s;
        }

        input:focus {
            border-color: #6c9cff;
            box-shadow: 0 0 5px rgba(108,156,255,0.3);
        }

        button {
            width: 100%;
            padding: 10px;
            background: #6c9cff;
            border: none;
            color: white;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        button:hover {
            background: #4a7de0;
        }
    </style>
</head>
<body>

<div class="contenedor">
    <h2>Editar Repuesto</h2>
    <form action="actualizar.php" method="POST">
        <input type="hidden" name="codigo" value="<?php echo $data['codigo']; ?>">

        <input type="text" name="nombre_repuesto" placeholder="Nombre" value="<?php echo $data['nombre_repuesto']; ?>">
        <input type="text" name="descripcion" placeholder="Descripción" value="<?php echo $data['descripcion']; ?>">
        <input type="text" name="marca" placeholder="Marca" value="<?php echo $data['marca']; ?>">
        <input type="text" name="modelo_compatible" placeholder="Modelo Compatible" value="<?php echo $data['modelo_compatible']; ?>">
        <input type="number" name="cantidad_stock" placeholder="Stock" value="<?php echo $data['cantidad_stock']; ?>">
        <input type="number" step="0.01" name="precio_unitario" placeholder="Precio" value="<?php echo $data['precio_unitario']; ?>">
        <input type="text" name="proveedor" placeholder="Proveedor" value="<?php echo $data['proveedor']; ?>">
        <input type="text" name="ubicacion" placeholder="Ubicación" value="<?php echo $data['ubicacion']; ?>">
        <input type="date" name="fecha_ingreso" value="<?php echo $data['fecha_ingreso']; ?>">
        <input type="url" name="fotografia_url" placeholder="URL de la imagen" value="<?php echo $data['fotografia_url']; ?>">
        

        <button type="submit">Actualizar</button>
    </form>
</div>

</body>
</html>