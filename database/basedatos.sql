

-- ==========================================
-- BASE DE DATOS: Sistema Distrital de Actividades y Pagos
-- ==========================================
CREATE DATABASE IF NOT EXISTS iglesia;
USE iglesia;

-- =======================
-- TABLAS BASE
-- =======================

CREATE TABLE departamento (
  iddepartamento INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL
);

CREATE TABLE distrito (
  iddistrito INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  iddepartamento INT,
  FOREIGN KEY (iddepartamento) REFERENCES departamento(iddepartamento)
);

CREATE TABLE iglesia (
  idiglesia INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  iddistrito INT,
  FOREIGN KEY (iddistrito) REFERENCES distrito(iddistrito)
);


-- =======================
-- USUARIOS Y PERSONAS
-- =======================

CREATE TABLE talla_de_camisa (
  idtalla_de_camisa INT AUTO_INCREMENT PRIMARY KEY,
  talla VARCHAR(10) NOT NULL
);

CREATE TABLE persona (
  idpersona INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  genero ENUM('Masculino','Femenino') NOT NULL,
  fecha_nacimiento DATE,
  edad INT,
  idtalla_de_camisa INT,
  idiglesia INT,
  iddistrito INT,
  iddepartamento INT,
  FOREIGN KEY (idtalla_de_camisa) REFERENCES talla_de_camisa(idtalla_de_camisa),
  FOREIGN KEY (idiglesia) REFERENCES iglesia(idiglesia),
  FOREIGN KEY (iddistrito) REFERENCES distrito(iddistrito),
  FOREIGN KEY (iddepartamento) REFERENCES departamento(iddepartamento)
);

CREATE TABLE rol (
  idrol INT AUTO_INCREMENT PRIMARY KEY,
  rol VARCHAR(50) NOT NULL
);

CREATE TABLE usuario (
  idusuario INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  PASSWORD VARCHAR(255),
  idrol INT,
  distrito_id INT,
  idiglesia INT,
  persona_id INT,
  estado ENUM('activo', 'inactivo') DEFAULT 'activo',
  FOREIGN KEY (idrol) REFERENCES rol(idrol),
  FOREIGN KEY (distrito_id) REFERENCES distrito(iddistrito),
  FOREIGN KEY (idiglesia) REFERENCES iglesia(idiglesia),
  FOREIGN KEY (persona_id) REFERENCES persona(idpersona)
);



-- =======================
-- EVENTOS
-- =======================

CREATE TABLE evento (
  idevento INT AUTO_INCREMENT PRIMARY KEY,
  tipo VARCHAR(50),
  titulo VARCHAR(150),
  descripcion TEXT,
  foto VARCHAR(255),
  lugar VARCHAR(150),
  fecha DATE,
  hora TIME,	
  iddistrito INT,
  iddepartamento INT,
  creadopor INT,
  FOREIGN KEY (iddistrito) REFERENCES distrito(iddistrito),
  FOREIGN KEY (iddepartamento) REFERENCES departamento(iddepartamento),
  FOREIGN KEY (creadopor) REFERENCES usuario(idusuario)
);

-- =======================
-- DOCUMENTOS
-- =======================

CREATE TABLE documentos (
  iddocumentos INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(255) NOT NULL,
  archivo VARCHAR(255) NOT NULL,
  descripcion TEXT,
  tipo ENUM('pdf','doc','docx','xls','xlsx','ppt','pptx','otro') DEFAULT 'pdf',
  visible_publico BOOLEAN DEFAULT FALSE,
  creadopor INT,
  fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (creadopor) REFERENCES usuario(idusuario)
);

-- =======================
-- INSERTS DE DATOS
-- =======================

-- Departamentos
INSERT INTO departamento (nombre) VALUES
('San Salvador'),
('La Libertad'),
('Santa Ana');

-- Distritos
INSERT INTO distrito (nombre, iddepartamento) VALUES
('Distrito 1', 1),
('Distrito 2', 1),
('Distrito 1', 2),
('Distrito 2', 2),
('Distrito 1', 3);

-- Iglesias
INSERT INTO iglesia (nombre, iddistrito) VALUES
('Iglesia Central', 1),
('Iglesia El Calvario', 2),
('Iglesia La Esperanza', 3),
('Iglesia Buen Pastor', 4),
('Iglesia Cristo Rey', 5);

-- Tallas de camisa
INSERT INTO talla_de_camisa (talla) VALUES
('S'), ('M'), ('L'), ('XL');

-- Roles
INSERT INTO rol (rol) VALUES
('nacional'),
('distrital'),
('miembro'),
('admin')
;

-- Personas
INSERT INTO persona (nombre, genero, fecha_nacimiento, edad, idtalla_de_camisa, idiglesia, iddistrito, iddepartamento) VALUES
('Juan Pérez', 'Masculino', '1990-05-12', 33, 2, 1, 1, 1),
('Ana López', 'Femenino', '1995-08-20', 28, 1, 2, 1, 1),
('Carlos Ramírez', 'Masculino', '1988-12-05', 35, 3, 3, 3, 2),
('Laura Martínez', 'Femenino', '1992-03-18', 31, 2, 4, 4, 2),
('Luis Fernández', 'Masculino', '1985-07-22', 38, 4, 5, 5, 3);

-- Usuarios (con contraseña encriptada de ejemplo: "123456")
INSERT INTO usuario (nombre, email, PASSWORD, idrol, distrito_id, idiglesia, persona_id) VALUES
('Juan Pérez', 'fercho', '123', 4, 1, 1, 1);


-- =======================
-- TABLA: ESCUELA SABÁTICA (por iglesia)
-- =======================
CREATE TABLE escuela_sabatica (
  idescuela_sabatica INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  tipo ENUM('juvenil', 'femenil', 'infantil', 'general') NOT NULL,
  trimestre ENUM('primer', 'segundo', 'tercer', 'cuarto') DEFAULT 'tercer',
  anio YEAR,
  archivo VARCHAR(255),
  creado_por_usuario_id INT,
  fecha_registro DATETIME DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (creado_por_usuario_id) REFERENCES usuario(idusuario)
);

-- Insertar datos de ejemplo
INSERT INTO escuela_sabatica 
(nombre, tipo, trimestre, anio, archivo, creado_por_usuario_id)
VALUES
('Escuela Sabática Juvenil Q3 2025', 'juvenil', 'tercer', 2025, NULL, 1);


-- Tabla para almacenar las localidades/iglesias
CREATE TABLE IF NOT EXISTS localidades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    departamento VARCHAR(100) NOT NULL,
    ciudad VARCHAR(100) NOT NULL,
    direccion TEXT,
    lat DECIMAL(10, 6) NOT NULL,
    lng DECIMAL(10, 6) NOT NULL,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insertar datos de ejemplo
INSERT INTO localidades (nombre, departamento, ciudad, direccion, lat, lng) VALUES
('Iglesia Santa Ana', 'Santa Ana', 'Santa Ana', 'Centro Santa Ana', 13.9942, -89.5597);


CREATE TABLE predicas (
  idpredica INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(255) NOT NULL,
  descripcion TEXT,
  url_youtube TEXT NOT NULL,
  miniatura VARCHAR(255),
  predicador VARCHAR(150),
  creadopor INT,
  fecha_publicacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (creadopor) REFERENCES usuario(idusuario)
);