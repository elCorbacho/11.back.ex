--USE todocamisetas_db;

-- Poblar tabla clientes
INSERT INTO clientes (nombre_comercial, rut, direccion, categoria, contacto_nombre, contacto_email, porcentaje_oferta) VALUES
('Deportes Plus', '12345678-9', 'Av. Siempre Viva 123', 'Regular', 'Ana Perez', 'ana@deportesplus.com', 5.00),
('Camisetas Pro', '98765432-1', 'Calle Falsa 456', 'Preferencial', 'Luis Gomez', 'luis@camisetaspro.com', 10.00),
('Ropa Sport', '11223344-5', 'Boulevard Central 789', 'Regular', 'Marta Ruiz', 'marta@ropasport.com', 0),
('Fashion Team', '55667788-0', 'Av. Moda 321', 'Preferencial', 'Carlos Soto', 'carlos@fashionteam.com', 8.50),
('Deportes Activos', '99887766-3', 'Calle Deportes 654', 'Regular', 'Sofia Vega', 'sofia@deportesactivos.com', 2.00),
('Elite Camisetas', '44556677-8', 'Av. Elite 987', 'Preferencial', 'Pedro Martinez', 'pedro@elitecamisetas.com', 12.00);

-- Poblar tabla camisetas
INSERT INTO camisetas (titulo, club, pais, tipo, color, precio, detalles, codigo_producto) VALUES
('Camiseta Oficial Barcelona 2024', 'Barcelona', 'España', 'Oficial', 'Azul y Rojo', 85.50, 'Camiseta oficial temporada 2024', 'BAR-2024'),
('Camiseta Replica Real Madrid', 'Real Madrid', 'España', 'Replica', 'Blanco', 70.00, 'Replica con detalles oficiales', 'RMA-2024'),
('Camiseta Selección Brasil', 'Brasil', 'Brasil', 'Oficial', 'Amarillo', 75.00, 'Camiseta oficial selección brasileña', 'BRA-OF'),
('Camiseta Entrenamiento Juventus', 'Juventus', 'Italia', 'Entrenamiento', 'Negro', 60.00, 'Camiseta para entrenamiento oficial', 'JUV-ENT'),
('Camiseta Retro Manchester United', 'Manchester United', 'Inglaterra', 'Retro', 'Rojo', 65.00, 'Camiseta retro temporada 1999', 'MNU-R99'),
('Camiseta Local Argentina', 'Argentina', 'Argentina', 'Oficial', 'Celeste y Blanco', 80.00, 'Camiseta oficial selección argentina', 'ARG-LOC');

-- Poblar tabla tallas
INSERT INTO tallas (talla) VALUES
('S'),
('M'),
('L'),
('XL'),
('XXL'),
('XXXL');

-- Poblar tabla intermedia camiseta_talla
-- Relacionamos cada camiseta con varias tallas, por ejemplo:

INSERT INTO camiseta_talla (camiseta_id, talla_id) VALUES
(1, 1), (1, 2), (1, 3), -- Barcelona S, M, L
(2, 2), (2, 3), (2, 4), -- Real Madrid M, L, XL
(3, 1), (3, 3), (3, 5), -- Brasil S, L, XXL
(4, 2), (4, 4), (4, 6), -- Juventus M, XL, XXXL
(5, 3), (5, 4), (5, 5), -- ManU L, XL, XXL
(6, 1), (6, 2), (6, 3), (6, 4); -- Argentina S, M, L, XL

-- Poblar tabla ofertas (ofertas especiales para clientes y camisetas)
INSERT INTO ofertas (cliente_id, camiseta_id, precio_oferta) VALUES
(1, 1, 80.00), -- Deportes Plus tiene oferta para Barcelona
(2, 3, 68.00), -- Camisetas Pro para Brasil
(3, 5, 60.00), -- Ropa Sport para ManU Retro
(4, 2, 65.00), -- Fashion Team para Real Madrid Replica
(5, 6, 75.00), -- Deportes Activos para Argentina Local
(6, 4, 55.00); -- Elite Camisetas para Juventus Entrenamiento
