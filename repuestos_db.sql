CREATE DATABASE repuestos_db;

USE repuestos_db;

CREATE TABLE inventario_repuestos (
 codigo INT PRIMARY KEY,
 nombre_repuesto VARCHAR(150) NOT NULL,
 descripcion VARCHAR(355),
 marca VARCHAR(90),
 modelo_compatible VARCHAR(200),
 cantidad_stock INT NOT NULL DEFAULT 0,
 precio_unitario DECIMAL(10,2) NOT NULL,
 precio_total DECIMAL(12,2),
 proveedor VARCHAR(200),
 ubicacion VARCHAR(90),
 fecha_ingreso DATE,
 fotografia_url VARCHAR(355));