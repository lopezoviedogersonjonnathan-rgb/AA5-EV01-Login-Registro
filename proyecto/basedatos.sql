-- ===========================================================
-- ARCHIVO: basedatos.sql
-- QUÉ HACER CON ESTO: abre phpMyAdmin (http://localhost/phpmyadmin),
-- ve a la pestaña "SQL" (sin seleccionar ninguna base de datos antes)
-- y pega todo este contenido, luego dale clic en "Continuar / Go".
-- También puedes usar la pestaña "Importar" y subir este archivo tal cual.
-- ===========================================================

-- Creamos la base de datos solo si todavía no existe.
CREATE DATABASE IF NOT EXISTS login_db;

-- Le decimos a MySQL: "a partir de aquí, trabaja dentro de login_db".
USE login_db;

-- Creamos la tabla "usuarios": aquí se guarda cada persona registrada.
CREATE TABLE IF NOT EXISTS usuarios (

    -- id: número único que identifica a cada usuario.
    -- AUTO_INCREMENT: MySQL lo numera solo (1, 2, 3, 4...).
    -- PRIMARY KEY: convierte esta columna en la "llave principal" de la tabla.
    id INT AUTO_INCREMENT PRIMARY KEY,

    -- nombre: nombre completo de la persona.
    -- VARCHAR(100): texto de máximo 100 caracteres.
    -- NOT NULL: este campo es obligatorio, no puede quedar vacío.
    nombre VARCHAR(100) NOT NULL,

    -- email: el correo, que vamos a usar como "usuario" para iniciar sesión.
    -- UNIQUE: no pueden existir dos filas con el mismo correo repetido.
    email VARCHAR(100) NOT NULL UNIQUE,

    -- password: AQUÍ NUNCA SE GUARDA LA CONTRASEÑA REAL.
    -- Se guarda su versión "encriptada" (técnicamente se llama HASH),
    -- generada por la función password_hash() de PHP. Por eso el
    -- campo es largo (255 caracteres), el hash ocupa bastante espacio.
    password VARCHAR(255) NOT NULL,

    -- fecha_registro: guarda automáticamente la fecha/hora del registro.
    -- DEFAULT CURRENT_TIMESTAMP = "pon la fecha y hora de ahora mismo".
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
