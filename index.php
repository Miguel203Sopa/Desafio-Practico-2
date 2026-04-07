<?php include "conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Repuestos - Dark Purple</title>
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
            background-color: var(--bg-body);
            color: var(--text-main);
            padding: 40px 20px;
        }

        .container { max-width: 1100px; margin: 0 auto; }
        h2 { margin-bottom: 24px; font-weight: 600; font-size: 28px; color: #fff; }

        /* Formulario */
        form.main-form {
            background: var(--bg-card);
            padding: 25px;
            border-radius: 12px;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 40px;
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        }

        input {
            padding: 12px;
            background: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            color: white;
            outline: none;
            transition: 0.3s;
        }

        input:focus { border-color: var(--primary); box-shadow: 0 0 0 2px rgba(168, 85, 247, 0.2); }

        button.btn-add {
            grid-column: 1 / -1;
            background: var(--primary);
            color: white;
            border: none;
            padding: 14px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        button.btn-add:hover { background: var(--primary-hover); transform: translateY(-2px); }

        /* Tabla */
        .table-container {
            background: var(--bg-card);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        table { width: 100%; border-collapse: collapse; }
        th { background: #1e293b; color: var(--primary); padding: 15px; text-align: left; font-size: 13px; text-transform: uppercase; }
        td { padding: 15px; border-bottom: 1px solid var(--border-color); font-size: 14px; }
        tr:hover { background: rgba(168, 85, 247, 0.05); cursor: pointer; }

        /* Botones Acción */
        .btn-accion {
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            transition: 0.2s;
            display: inline-block;
        }
        .btn-edit { color: var(--primary); border: 1px solid var(--primary); margin-right: 5px; }
        .btn-edit:hover { background: var(--primary); color: white; }
        .btn-delete { color: var(--danger); border: 1px solid var(--danger); }
        .btn-delete:hover { background: var(--danger); color: white; }

        /* Modal */
        .modal { 
            display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: rgba(0,0,0,0.8); backdrop-filter: blur(4px); z-index: 100;
        }
        .contenido { 
            background: var(--bg-card); margin: 10% auto; padding: 30px; width: 400px; 
            border-radius: 16px; position: relative; border: 1px solid var(--primary);
            transform: scale(0.9); transition: 0.3s;
            text-align: center; /* Centrar contenido del modal */
        }
        .modal.show .contenido { transform: scale(1); }
        .close { position: absolute; right: 20px; top: 15px; cursor: pointer; color: var(--text-muted); font-size: 20px; }
        
        /* Ajuste de imagen en el modal */
        #m_img { 
            width: 100%; 
            max-height: 250px; 
            object-fit: contain; 
            border-radius: 8px; 
            margin-top: 15px; 
            display: none; 
            border: 1px solid var(--border-color); 
            background: #0f172a;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Inventario de Repuestos</h2>

    <form action="insertar.php" method="POST" class="main-form">
        <input type="text" name="codigo" placeholder="Código" required>
        <input type="text" name="nombre_repuesto" placeholder="Nombre" required>
        <input type="text" name="descripcion" placeholder="Descripción">
        <input type="text" name="marca" placeholder="Marca">
        <input type="text" name="modelo_compatible" placeholder="Modelo">
        <input type="number" name="cantidad_stock" placeholder="Stock">
        <input type="number" step="0.01" name="precio_unitario" placeholder="Precio ($)">
        <input type="text" name="proveedor" placeholder="Proveedor">
        <input type="text" name="ubicacion" placeholder="Ubicación">
        <input type="date" name="fecha_ingreso">
        <input type="url" name="fotografia_url" placeholder="URL de la imagen (https://...)">
        <button type="submit" class="btn-add">Agregar al Inventario</button>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Código</th><th>Nombre</th><th>Stock</th><th>Precio</th><th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resultado = $conexion->query("SELECT * FROM inventario_repuestos");
                while($row = $resultado->fetch_assoc()){
                ?>
                <tr onclick='verDetalle(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)'>
                    <td style="color:var(--primary); font-weight:600;"><?php echo $row['codigo']; ?></td>
                    <td><?php echo $row['nombre_repuesto']; ?></td>
                    <td><?php echo $row['cantidad_stock']; ?></td>
                    <td>$<?php echo number_format($row['precio_unitario'], 2); ?></td>
                    <td onclick="event.stopPropagation();">
                        <a href="editar.php?codigo=<?php echo $row['codigo']; ?>" class="btn-accion btn-edit">Editar</a>
                        <a href="eliminar.php?id=<?php echo $row['codigo']; ?>" class="btn-accion btn-delete" onclick="return confirm('¿Eliminar?')">Eliminar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modal" class="modal" onclick="cerrar()">
    <div class="contenido" onclick="event.stopPropagation()">
        <span class="close" onclick="cerrar()">✕</span>
        <h3 id="m_nombre" style="color:var(--primary); margin-bottom: 5px;"></h3>
        <p id="m_marca" style="font-size: 12px; color: var(--primary); font-weight: bold; margin-bottom: 10px;"></p>
        <p id="m_desc" style="color:var(--text-muted); margin: 10px 0; font-size: 14px;"></p>
        <hr style="border: 0; border-top: 1px solid var(--border-color); margin: 15px 0;">
        <img id="m_img" src="" alt="Vista previa del repuesto">
    </div>
</div>

<script>
function verDetalle(data){
    // Llenar datos de texto
    document.getElementById("m_nombre").innerText = data.nombre_repuesto;
    document.getElementById("m_marca").innerText = "Marca: " + (data.marca || "N/A");
    document.getElementById("m_desc").innerText = data.descripcion || "Sin descripción adicional.";
    
    const img = document.getElementById("m_img");
    
    // Lógica para mostrar la imagen desde la URL
    if(data.fotografia_url && data.fotografia_url.trim() !== "") {
        img.src = data.fotografia_url;
        img.style.display = "block";
    } else { 
        img.style.display = "none"; 
    }
    
    // Mostrar el modal con animación
    const m = document.getElementById("modal");
    m.style.display = "block";
    setTimeout(()=> m.classList.add("show"), 10);
}

function cerrar(){
    const m = document.getElementById("modal");
    m.classList.remove("show");
    setTimeout(()=> m.style.display = "none", 300);
}

// Cerrar modal con la tecla Esc
document.addEventListener('keydown', (e) => {
    if (e.key === "Escape") cerrar();
});
</script>
</body>
</html>