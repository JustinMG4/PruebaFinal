-- Crear tabla Tipos_Habitaciones
CREATE TABLE tipos_Habitaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR(50) NOT NULL
);

-- Crear tabla Habitaciones
CREATE TABLE habitaciones (
    id_habitacion INT AUTO_INCREMENT PRIMARY KEY,
    numero INT NOT NULL,
    id_tipo INT NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    estado VARCHAR(20) NULL DEFAULT TRUE,
    FOREIGN KEY (id_tipo) REFERENCES Tipos_Habitaciones(id)
);

-- Crear tabla Huespedes
CREATE TABLE huespedes (
    id_huesped VARCHAR(20) PRIMARY KEY,
    tipo_identificacion VARCHAR(50) NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(20)
);

-- Crear tabla Reservaciones
CREATE TABLE reservaciones (
    id_reservacion INT AUTO_INCREMENT PRIMARY KEY,
    id_huesped VARCHAR(20) NOT NULL,
    fecha_entrada DATE NOT NULL,
    fecha_salida DATE NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_huesped) REFERENCES Huespedes(id_huesped)
);

-- Crear tabla Detalle_Reservaciones
CREATE TABLE detalle_reservaciones (
    id_detalle INT AUTO_INCREMENT PRIMARY KEY,
    id_reservacion INT NOT NULL,
    id_habitacion INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (id_reservacion) REFERENCES Reservaciones(id_reservacion),
    FOREIGN KEY (id_habitacion) REFERENCES Habitaciones(id_habitacion)
);

