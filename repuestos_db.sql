CREATE DATABASE IF NOT EXISTS repuestos_db;
USE repuestos_db;

CREATE TABLE inventario_repuestos (
   
    codigo INT NOT NULL AUTO_INCREMENT, 
    nombre_repuesto VARCHAR(150) NOT NULL,
    descripcion VARCHAR(355),
    marca VARCHAR(90),
    modelo_compatible VARCHAR(200),
    cantidad_stock INT NOT NULL DEFAULT 0,
    precio_unitario DECIMAL(10,2) NOT NULL,
    
    -- Columna Generada: Se calcula sola y no permite errores manuales
    precio_total DECIMAL(12,2) AS (cantidad_stock * precio_unitario) STORED,
    
    proveedor VARCHAR(200),
    ubicacion VARCHAR(90),
    fecha_ingreso DATE DEFAULT (CURRENT_DATE), 
    fotografia_url VARCHAR(355),
    
    PRIMARY KEY (codigo)
) ENGINE=InnoDB;