CREATE DATABASE IF NOT EXISTS todocamisetas_db;
USE todocamisetas_db;

-- Tabla de Clientes
CREATE TABLE clientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre_comercial VARCHAR(100) NOT NULL,
    rut VARCHAR(15) NOT NULL UNIQUE,
    direccion VARCHAR(100),
    categoria ENUM('Regular', 'Preferencial') DEFAULT 'Regular',
    contacto_nombre VARCHAR(100),
    contacto_email VARCHAR(100),
    porcentaje_oferta DECIMAL(5,2) DEFAULT 0
);

-- Tabla de Camisetas
CREATE TABLE camisetas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(150) NOT NULL,
    club VARCHAR(100),
    pais VARCHAR(50),
    tipo VARCHAR(50),
    color VARCHAR(50),
    precio DECIMAL(10,2) NOT NULL,
    detalles TEXT,
    codigo_producto VARCHAR(50) UNIQUE NOT NULL
);

-- Tabla de Tallas
CREATE TABLE tallas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    talla VARCHAR(10) NOT NULL UNIQUE
);

-- Tabla intermedia para relación muchos a muchos entre camisetas y tallas
CREATE TABLE camiseta_talla (
    camiseta_id INT,
    talla_id INT,
    PRIMARY KEY (camiseta_id, talla_id),
    FOREIGN KEY (camiseta_id) REFERENCES camisetas(id) ON DELETE CASCADE,
    FOREIGN KEY (talla_id) REFERENCES tallas(id) ON DELETE CASCADE
);

-- Tabla para ofertas personalizadas por cliente (si se requiere una excepción al porcentaje general)
CREATE TABLE ofertas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    cliente_id INT,
    camiseta_id INT,
    FOREIGN KEY (cliente_id) REFERENCES clientes(id) ON DELETE CASCADE,
    FOREIGN KEY (camiseta_id) REFERENCES camisetas(id) ON DELETE CASCADE
);