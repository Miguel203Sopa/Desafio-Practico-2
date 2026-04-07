<?php include "conexion.php"; ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Repuestos - Dark Edition</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        :root {
            /* Paleta Dark & Purple */
            --bg-body: #121212;          /* Fondo muy oscuro, no negro puro */
            --bg-card: #1e1e1e;          /* Fondo de tarjetas y formulario */
            --bg-input: #2a2a2a;         /* Fondo de inputs */
            
            --text-main: #e0e0e0;        /* Texto principal */
            --text-muted: #a0a0a0;       /* Texto secundario */
            
            --primary: #9d4edd;          /* Morado principal brillante */
            --primary-hover: #7b2cbf;    /* Morado más oscuro para hover */
            --border-color: #333333;     /* Bordes sutiles */
            
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.3);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-body);
            color: var(--text-main);
            padding: 40px 20px;
            line-height: 1.6;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        h2 {
            font-weight: 600;
            color: #ffffff;
            margin-bottom: 24px;
            font-size: 28px;
            letter-spacing: -0.5px;
        }

        /* --- FORMULARIO MINIMALISTA --- */
        form {
            background: var(--bg-card);
            padding: 30px;
            border-radius: 12px;
            box-shadow: var(--shadow);
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 16px;
            margin-bottom: 40px;
            border: 1px solid var(--border-color);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        form:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(157, 78, 221, 0.1); /* Brillo morado sutil */
        }

        input {
            width: 100%;
            padding: 12px 15px;
            background-color: var(--bg-input);
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 14px;
            color: var(--text-main);
            transition: all 0.2s ease;
            outline: none;
        }

        input::placeholder {
            color: #666;
        }

        input:focus {
            border-color: var(--primary);
            background-color: #2d2d2d;
            box-shadow: 0 0 0 3px rgba(157, 78, 221, 0.2);
        }

        /* Ajuste para inputs específicos */
        input[type="date"] {
            color: var(--text-muted);
        }

        button {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 15px;
            cursor: pointer;
            transition: background-color 0.2s ease, transform 0.1s ease;
            grid-column: 1 / -1; /* Ocupa todo el ancho al final */
            margin-top: 10px;
        }

        button:hover {
            background-color: var(--primary-hover);
        }

        button:active {
            transform: scale(0.98);
        }

        /* --- TABLA MODERNA DARK --- */
        .table-container {
            background: var(--bg-card);
            border-radius: 12px;
            box-shadow: var(--shadow);
            overflow: hidden;
            border: 1px solid var(--border-color);
        }

        table { 
            border-collapse: collapse; 
            width: 100%; 
            text-align: left;
            font-size: 15px;
        }

        th { 
            background-color: #252525; /* Ligeramente más claro que la tarjeta */
            color: var(--primary); /* Cabeceras moradas */
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            padding: 18px 16px;
        }

        td { 
            padding: 16px; 
            border-bottom: 1px solid var(--border-color); 
            color: var(--text-main);
        }

        tr {
            transition: background-color 0.2s ease;
            cursor: pointer;
        }

        tr:hover {
            background-color: rgba(157, 78, 221, 0.05); /* Fondo morado muy tenue */
        }

        tr:last-child td {
            border-bottom: none;
        }

        .action-link {
            color: #ff5252; /* Rojo brillante para contraste en modo oscuro */
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }

        .action-link:hover {
            color: #ff1744;
            text-decoration: underline;
        }

        /* --- MODAL CON ANIMACIÓN (DARK) --- */
        .modal { 
            display: none; 
            position: fixed; 
            top: 0; left: 0; 
            width: 100%; height: 100%; 
            background: rgba(0, 0, 0, 0.8); /* Fondo negro opaco */
            backdrop-filter: blur(5px); /* Desenfoque moderno */
            z-index: 1000;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            opacity: 1;
        }

        .contenido { 
            background: var(--bg-card); 
            margin: 10% auto; 
            padding: 35px; 
            width: 90%;
            max-width: 450px; 
            border-radius: 16px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            position: relative;
            transform: translateY(-30px);
            transition: transform 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); /* Efecto rebote suave */
            border: 1px solid var(--primary); /* Borde morado */
        }

        .modal.show .contenido {
            transform: translateY(0);
        }

        .close-btn {
            position: absolute;
            top: 18px;
            right: 20px;
            cursor: pointer;
            color: var(--text-muted);
            font-size: 22px;
            transition: color 0.2s;
        }

        .close-btn:hover {
            color: var(--primary);
        }

        #m_nombre {
            margin-top: 0; 
            color: #ffffff; 
            font-size: 22px; 
            margin-bottom: 10px;
            border-bottom: 2px solid var(--primary);
            display: inline-block;
            padding-bottom: 5px;
        }

        #m_desc {
            color: var(--text-muted); 
            line-height: 1.6;
            font-size: 15px;
            margin-bottom: 20px;
        }

        #m_img {
            width: 100%;
            height: auto;
            max-height: 250px;
            border-radius: 8px;
            object-fit: contain; /* Muestra la imagen completa */
            display: none; 
            background-color: #121212;
            padding: 5px;
            border: 1px solid var(--border-color);
        }

        /* Scrollbar personalizado morado */
        ::-webkit-scrollbar {
            width: 10px;
        }
        ::-webkit-scrollbar-track {
            background: var(--bg-body);
        }
        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 5px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary);
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Inventario de Repuestos</h2>

    <form action="insertar.php" method="POST">
        <input type="text" name="codigo" placeholder="Código único" required>
        <input type="text" name="nombre_repuesto" placeholder="Nombre del repuesto" required>
        <input type="text" name="descripcion" placeholder="Descripción breve">
        <input type="text" name="marca" placeholder="Marca">
        <input type="text" name="modelo_compatible" placeholder="Modelo Compatible">
        <input type="number" name="cantidad_stock" placeholder="Cantidad">
        <input type="number" step="0.01" name="precio_unitario" placeholder="Precio ($)">
        <input type="text" name="proveedor" placeholder="Proveedor">
        <input type="text" name="ubicacion" placeholder="Pasillo/Estante">
        <input type="date" name="fecha_ingreso" title="Fecha de Ingreso">
        <input type="url" name="fotografia_url" placeholder="URL de la imagen (https://...)">
        <button type="submit">Guardar en Inventario</button>
    </form>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Cant.</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $resultado = $conexion->query("SELECT * FROM inventario_repuestos");

                if(!$resultado){
                    die("Error en consulta: " . $conexion->error);
                }

                while($row = $resultado->fetch_assoc()){
                ?>
                <tr onclick='verDetalle(<?php echo htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); ?>)'>
                    <td style="color: var(--primary); font-weight: 500;"><?php echo htmlspecialchars($row['codigo']); ?></td>
                    <td><?php echo htmlspecialchars($row['nombre_repuesto']); ?></td>
                    <td><?php echo htmlspecialchars($row['cantidad_stock']); ?></td>
                    <td>$<?php echo number_format($row['precio_unitario'], 2); ?></td>
                    <td onclick="event.stopPropagation();">
                        <a href="eliminar.php?id=<?php echo urlencode($row['codigo']); ?>" class="action-link">Eliminar</a>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div id="modal" class="modal">
    <div class="contenido">
        <span class="close-btn" onclick="cerrar()">✕</span>
        <h3 id="m_nombre"></h3>
        <p id="m_desc"></p>
        <img id="m_img" alt="Vista del repuesto">
    </div>
</div>

<script>
function verDetalle(data){
    document.getElementById("m_nombre").innerText = data.nombre_repuesto || "Sin nombre";
    document.getElementById("m_desc").innerText = data.descripcion || "No hay descripción disponible para este artículo.";
    
    const imgElement = document.getElementById("m_img");
    
    if(data.fotografia_url && data.fotografia_url.trim() !== "") {
        imgElement.src = data.fotografia_url;
        imgElement.style.display = "block";
    } else {
        imgElement.style.display = "none";
        imgElement.src = "";
    }

    const modal = document.getElementById("modal");
    modal.style.display = "block";
    setTimeout(() => modal.classList.add("show"), 10);
}

function cerrar(){
    const modal = document.getElementById("modal");
    modal.classList.remove("show");
    setTimeout(() => modal.style.display = "none", 300);
}

// Cerrar modal si se hace clic fuera del contenido
window.onclick = function(event) {
    const modal = document.getElementById("modal");
    if (event.target == modal) {
        cerrar();
    }
}
</script>

</body>
</html>
