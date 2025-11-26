-- Agregar campo doctor_id a la tabla pacientes para rastrear qué doctor registró al paciente
USE EPS;

ALTER TABLE pacientes 
ADD COLUMN doctor_id INT DEFAULT NULL AFTER id,
ADD FOREIGN KEY (doctor_id) REFERENCES doctores(id) ON DELETE SET NULL;

-- Agregar índice para mejorar el rendimiento de las consultas
CREATE INDEX idx_doctor_id ON pacientes(doctor_id);
