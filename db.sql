CREATE DATABASE PRACTICA1;
USE PRACTICA1;
-- TABLA CLIENTE
CREATE TABLE CLIENTE (
    id_cliente INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    direccion VARCHAR(100),
    fecha_nacimiento DATE,
    telefono VARCHAR(20),
    email VARCHAR(100)
) ENGINE=InnoDB;

-- TABLA MODO_PAGO
CREATE TABLE MODO_PAGO (
    num_pago INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    otros_detalles TEXT
) ENGINE=InnoDB;

-- TABLA FACTURA
CREATE TABLE FACTURA (
    num_factura INT AUTO_INCREMENT PRIMARY KEY,
    fecha DATE NOT NULL,
    id_cliente INT NOT NULL,
    num_pago INT NOT NULL,
    FOREIGN KEY (id_cliente) REFERENCES CLIENTE (id_cliente) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (num_pago) REFERENCES MODO_PAGO (num_pago) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- TABLA CATEGORIA
CREATE TABLE CATEGORIA (
    id_categoria INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    descripcion TEXT
) ENGINE=InnoDB;

-- TABLA PRODUCTO
CREATE TABLE PRODUCTO (
    id_producto INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    stock INT NOT NULL,
    id_categoria INT NOT NULL,
    FOREIGN KEY (id_categoria) REFERENCES CATEGORIA (id_categoria) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB;

-- TABLA DETALLE
CREATE TABLE DETALLE (
    id_factura INT NOT NULL,
    num_detalle INT NOT NULL,
    id_producto INT NOT NULL,
    cantidad INT NOT NULL,
    precio DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id_factura, num_detalle),
    FOREIGN KEY (id_factura) REFERENCES FACTURA (num_factura) ON DELETE CASCADE ON UPDATE CASCADE,
    FOREIGN KEY (id_producto) REFERENCES PRODUCTO (id_producto) ON DELETE CASCADE ON UPDATE CASCADE
)

-- TABLA ROLES
CREATE TABLE ROLES (
    id_rol INT AUTO_INCREMENT PRIMARY KEY,
    nombre_rol VARCHAR(50) NOT NULL UNIQUE
) 

-- Insertamos los tres roles solicitados
INSERT INTO ROLES (nombre_rol) VALUES 
('empleado'), 
('administrador'), 
('gerente');

-- TABLA USUARIOS
CREATE TABLE USUARIOS (
    id_usuario INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    id_rol INT NOT NULL,
    FOREIGN KEY (id_rol) REFERENCES ROLES (id_rol) ON DELETE CASCADE ON UPDATE CASCADE
) 

-- ***************************************************************
-- INSERTAR DATOS EN LAS TABLAS
-- ***************************************************************

-- 1. Insertar datos en la tabla CLIENTE
INSERT INTO CLIENTE (nombre, apellido, direccion, fecha_nacimiento, telefono, email) VALUES
('Juan', 'Pérez', 'Calle Falsa 123', '1985-05-15', '555-1234', 'juan.perez@example.com'),
('María', 'García', 'Avenida Siempre Viva 742', '1990-08-22', '555-5678', 'maria.garcia@example.com'),
('Carlos', 'López', 'Boulevard de los Sueños 456', '1978-11-30', '555-8765', 'carlos.lopez@example.com'),
('Ana', 'Martínez', 'Plaza Central 10', '1992-02-10', '555-2345', 'ana.martinez@example.com'),
('Luis', 'Hernández', 'Camino Real 89', '1980-07-25', '555-3456', 'luis.hernandez@example.com'),
('Laura', 'Gómez', 'Ruta del Sol 321', '1988-12-05', '555-4567', 'laura.gomez@example.com'),
('Pedro', 'Díaz', 'Calle Luna 77', '1995-03-18', '555-5678', 'pedro.diaz@example.com'),
('Sofía', 'Ramírez', 'Avenida del Parque 56', '1983-09-12', '555-6789', 'sofia.ramirez@example.com'),
('Jorge', 'Torres', 'Carrera 45', '1975-04-27', '555-7890', 'jorge.torres@example.com'),
('Elena', 'Vargas', 'Sendero de la Montaña 22', '1991-06-09', '555-8901', 'elena.vargas@example.com');

-- 2. Insertar datos en la tabla MODO_PAGO
INSERT INTO MODO_PAGO (nombre, otros_detalles) VALUES
('Efectivo', 'Pago en efectivo al momento de la entrega'),
('Tarjeta de Crédito', 'Visa, MasterCard, American Express'),
('Transferencia Bancaria', 'Cuenta bancaria número 123456789'),
('PayPal', 'Cuenta vinculada a paypal@example.com'),
('Cheque', 'Emitido a nombre de la empresa'),
('Crédito', 'Línea de crédito de 30 días'),
('Débito Automático', 'Cobro mensual a cuenta bancaria'),
('Bitcoin', 'Dirección de wallet: 1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa'),
('Pago Móvil', 'Mediante aplicaciones como MercadoPago o Venmo'),
('Contra Reembolso', 'Pago al recibir el producto');

-- 3. Insertar datos en la tabla CATEGORIA
INSERT INTO CATEGORIA (nombre, descripcion) VALUES
('Electrónica', 'Dispositivos y gadgets electrónicos'),
('Ropa', 'Prendas de vestir para todas las edades'),
('Hogar', 'Artículos para el hogar y decoración'),
('Juguetes', 'Juguetes para niños de todas las edades'),
('Libros', 'Libros de diferentes géneros y autores'),
('Deportes', 'Equipamiento y ropa deportiva'),
('Belleza', 'Productos de cuidado personal y belleza'),
('Automóviles', 'Accesorios y repuestos para vehículos'),
('Alimentos', 'Productos alimenticios y bebidas'),
('Salud', 'Productos y equipos para el cuidado de la salud');

-- 4. Insertar datos en la tabla PRODUCTO
INSERT INTO PRODUCTO (nombre, precio, stock, id_categoria) VALUES
('Smartphone XYZ', 299.99, 50, 1),
('Laptop ABC', 799.99, 30, 1),
('Camiseta Deportiva', 19.99, 100, 2),
('Jeans Clásicos', 49.99, 80, 2),
('Sofá de 3 Plazas', 399.99, 10, 3),
('Lampara LED', 29.99, 60, 3),
('Muñeca Barbie', 15.99, 120, 4),
('Juego de Construcción', 49.99, 70, 4),
('Libro "El Quijote"', 9.99, 200, 5),
('Libro "Cien Años de Soledad"', 14.99, 150, 5);

-- 5. Insertar datos en la tabla FACTURA
-- Asumiendo que los id_cliente van del 1 al 10 y num_pago del 1 al 10
INSERT INTO FACTURA (fecha, id_cliente, num_pago) VALUES
('2024-01-15', 1, 2),
('2024-01-16', 2, 3),
('2024-01-17', 3, 1),
('2024-01-18', 4, 5),
('2024-01-19', 5, 4),
('2024-01-20', 6, 6),
('2024-01-21', 7, 7),
('2024-01-22', 8, 8),
('2024-01-23', 9, 9),
('2024-01-24', 10, 10);

-- 6. Insertar datos en la tabla DETALLE
-- Asumiendo que num_factura van del 1 al 10 y id_producto del 1 al 10
INSERT INTO DETALLE (id_factura, num_detalle, id_producto, cantidad, precio) VALUES
(1, 1, 1, 2, 299.99),
(1, 2, 3, 5, 19.99),
(2, 1, 2, 1, 799.99),
(2, 2, 4, 2, 49.99),
(3, 1, 5, 1, 399.99),
(3, 2, 6, 3, 29.99),
(4, 1, 7, 4, 15.99),
(4, 2, 8, 2, 49.99),
(5, 1, 9, 3, 9.99),
(5, 2, 10, 2, 14.99),
(6, 1, 1, 1, 299.99),
(6, 2, 5, 1, 399.99),
(7, 1, 2, 2, 799.99),
(7, 2, 3, 4, 19.99),
(8, 1, 4, 1, 49.99),
(8, 2, 6, 2, 29.99),
(9, 1, 7, 5, 15.99),
(9, 2, 9, 10, 9.99),
(10, 1, 10, 3, 14.99),
(10, 2, 8, 1, 49.99);

-- 7. Insertar datos en la tabla USUARIOS
-- Asumiendo que los id_rol son:
-- 1 = empleado, 2 = administrador, 3 = gerente
INSERT INTO USUARIOS (username, password, id_rol) VALUES
('empleado1', 'password1', 1),
('empleado2', 'password2', 1),
('empleado3', 'password3', 1),
('empleado4', 'password4', 1),
('empleado5', 'password5', 1),
('administrador1', 'adminpass1', 2),
('administrador2', 'adminpass2', 2),
('gerente1', 'gerentepass1', 3),
('gerente2', 'gerentepass2', 3),
('gerente3', 'gerentepass3', 3);


SELECT 
from usuarios JOIN roles ON usuarios.id_rol = roles.id_rol
WHERE usuarios.username = ? AND usuario.password = ?;

SELECT *
FROM usuarios;