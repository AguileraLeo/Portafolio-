DROP DATABASE IF EXISTS portfolio_estudiante;
CREATE DATABASE portfolio_estudiante CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE portfolio_estudiante;

CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE biografia (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(150) NOT NULL,
  titulo VARCHAR(180) NOT NULL,
  descripcion TEXT NOT NULL,
  avatar VARCHAR(255) DEFAULT 'assets/img/avatar.svg'
);

CREATE TABLE habilidades (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  icono VARCHAR(80) NOT NULL DEFAULT 'bi bi-code-slash',
  color VARCHAR(30) DEFAULT '#3B82F6'
);

CREATE TABLE tecnologias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(100) NOT NULL,
  nivel INT NOT NULL DEFAULT 50,
  etiqueta VARCHAR(50) DEFAULT 'Intermedio'
);

CREATE TABLE proyectos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  titulo VARCHAR(150) NOT NULL,
  descripcion TEXT NOT NULL,
  imagen VARCHAR(255) DEFAULT 'assets/img/project.svg',
  demo_url VARCHAR(255) DEFAULT '#',
  github_url VARCHAR(255) DEFAULT '#'
);

CREATE TABLE mensajes (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nombre VARCHAR(120) NOT NULL,
  correo VARCHAR(160) NOT NULL,
  asunto VARCHAR(180) NOT NULL,
  mensaje TEXT NOT NULL,
  creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admins (nombre, email, password) VALUES
('Administrador', 'admin@demo.cl', '$2y$12$SO0newqhIbO/Od2uau7JQ.UMVI1eS3Dbiy2V/YWpN.oTgZMQqv9OW');

INSERT INTO biografia (nombre, titulo, descripcion, avatar) VALUES
('Leonardo Aguilera', 'Estudiante de Informática y Desarrollo Web', 'Soy estudiante del área informática con interés en desarrollo web, bases de datos, inteligencia artificial aplicada y creación de soluciones digitales modernas. Este portafolio presenta mis habilidades, tecnologías y proyectos realizados.', 'assets/img/avatar.svg');

INSERT INTO habilidades (nombre, icono, color) VALUES
('HTML', 'bi bi-filetype-html', '#F97316'),
('CSS', 'bi bi-filetype-css', '#3B82F6'),
('JavaScript', 'bi bi-filetype-js', '#EAB308'),
('PHP', 'bi bi-filetype-php', '#6366F1'),
('MySQL', 'bi bi-database', '#0EA5E9'),
('Bootstrap', 'bi bi-bootstrap', '#7C3AED'),
('GitHub', 'bi bi-github', '#111827'),
('IA Web', 'bi bi-cpu', '#10B981');

INSERT INTO tecnologias (nombre, nivel, etiqueta) VALUES
('HTML', 95, 'Avanzado'),
('CSS', 88, 'Avanzado'),
('JavaScript', 75, 'Intermedio'),
('PHP', 72, 'Intermedio'),
('MySQL', 78, 'Intermedio'),
('Bootstrap', 85, 'Avanzado');

INSERT INTO proyectos (titulo, descripcion, imagen, demo_url, github_url) VALUES
('Gestor de Tareas', 'Aplicación web para registrar, listar y administrar tareas usando PHP y MySQL.', 'assets/img/project.svg', 'demos/gestor-tareas.php', '#'),
('Registro de Estudiantes', 'Sistema simple para registrar estudiantes y visualizar datos en tabla.', 'assets/img/project.svg', 'demos/registro-estudiantes.php', '#'),
('App de Hash Seguro', 'Aplicación educativa para generar hashes SHA-256 y SHA-512.', 'assets/img/project.svg', 'demos/hash-seguro.php', '#');
