-- Crear tabla Habitaciones
CREATE TABLE Habitaciones (
    habitacion_id INT AUTO_INCREMENT PRIMARY KEY,
    numero INT NOT NULL,
    tipo VARCHAR(50) NOT NULL,
    precio DECIMAL(10, 2) NOT NULL,
    estado VARCHAR(20) NOT NULL
);

-- Crear tabla Huespedes
CREATE TABLE Huespedes (
    huesped_id VARCHAR(20) PRIMARY KEY,
    tipo_identificacion VARCHAR(50) NOT NULL,
    nombre VARCHAR(50) NOT NULL,
    apellido VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    telefono VARCHAR(20)
);

-- Crear tabla Reservaciones
CREATE TABLE Reservaciones (
    reservacion_id INT AUTO_INCREMENT PRIMARY KEY,
    huesped_id VARCHAR(20) NOT NULL,
    fecha_entrada DATETIME NOT NULL,
    fecha_salida DATETIME NOT NULL,
    total DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (huesped_id) REFERENCES Huespedes(huesped_id)
);

-- Crear tabla Detalle_Reservaciones
CREATE TABLE Detalle_Reservaciones (
    detalle_id INT AUTO_INCREMENT PRIMARY KEY,
    reservacion_id INT NOT NULL,
    habitacion_id INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (reservacion_id) REFERENCES Reservaciones(reservacion_id),
    FOREIGN KEY (habitacion_id) REFERENCES Habitaciones(habitacion_id)
);

