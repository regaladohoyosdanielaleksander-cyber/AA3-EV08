CREATE DATABASE IF NOT EXISTS sistema_inventario;
USE sistema_inventario;

CREATE TABLE IF NOT EXISTS categorias (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre_categoria VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS productos (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    cantidad INT NOT NULL DEFAULT 0,
    estado VARCHAR(30) NOT NULL DEFAULT 'Disponible',
    categoria_id INT NOT NULL,
    FOREIGN KEY (categoria_id) REFERENCES categorias(id_categoria)
);

INSERT INTO categorias (nombre_categoria)
SELECT 'Tecnología' WHERE NOT EXISTS (SELECT 1 FROM categorias WHERE nombre_categoria='Tecnología');
INSERT INTO categorias (nombre_categoria)
SELECT 'Hogar' WHERE NOT EXISTS (SELECT 1 FROM categorias WHERE nombre_categoria='Hogar');
INSERT INTO categorias (nombre_categoria)
SELECT 'Moda' WHERE NOT EXISTS (SELECT 1 FROM categorias WHERE nombre_categoria='Moda');

INSERT INTO productos (nombre, precio, cantidad, estado, categoria_id)
SELECT 'Laptop HP Pavilion', 1200.00, 10, 'Activo', id_categoria FROM categorias WHERE nombre_categoria='Tecnología' AND NOT EXISTS (SELECT 1 FROM productos WHERE nombre='Laptop HP Pavilion');
INSERT INTO productos (nombre, precio, cantidad, estado, categoria_id)
SELECT 'Televisor Samsung 55', 850.50, 5, 'Disponible', id_categoria FROM categorias WHERE nombre_categoria='Tecnología' AND NOT EXISTS (SELECT 1 FROM productos WHERE nombre='Televisor Samsung 55');
INSERT INTO productos (nombre, precio, cantidad, estado, categoria_id)
SELECT 'Licuadora Oster', 75.00, 0, 'Sin Stock', id_categoria FROM categorias WHERE nombre_categoria='Hogar' AND NOT EXISTS (SELECT 1 FROM productos WHERE nombre='Licuadora Oster');
INSERT INTO productos (nombre, precio, cantidad, estado, categoria_id)
SELECT 'Camisa Manga Larga', 45.00, 100, 'Disponible', id_categoria FROM categorias WHERE nombre_categoria='Moda' AND NOT EXISTS (SELECT 1 FROM productos WHERE nombre='Camisa Manga Larga');
