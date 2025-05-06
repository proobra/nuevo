
-- Tabla de configuraciones generales
CREATE TABLE IF NOT EXISTS configuraciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    clave VARCHAR(100) UNIQUE NOT NULL,
    valor DECIMAL(12,2) NOT NULL,
    descripcion TEXT
);

INSERT INTO configuraciones (clave, valor, descripcion) VALUES
('iva', 21.00, 'Porcentaje de IVA'),
('imm_constante', 1200.00, 'Valor multiplicador de IMM'),
('syso', 15000.00, '% estimado de SYSO'),
('rc', 5000.00, '% de responsabilidad civil'),
('inscripcion_obra', 8000.00, 'Costo fijo de inscripción'),
('utilidad_default', 75.00, '% de utilidad sugerido sobre mano de obra'),
('bps_sobre_laudo', 86.00, 'Porcentaje de BPS sobre mano de obra');

-- Tabla de categorías de operarios
CREATE TABLE IF NOT EXISTS categorias_operarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) UNIQUE NOT NULL,
    jornal DECIMAL(10,2) NOT NULL,
    activo BOOLEAN DEFAULT TRUE
);

TRUNCATE TABLE categorias_operarios;

INSERT INTO categorias_operarios (nombre, jornal) VALUES
('Peón', 2016.24),
('Medio Oficial', 2544.22),
('Oficial', 3203.58),
('Finalista', 3375.02),
('Supervisor', 3000.00);
