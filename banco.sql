CREATE DATABASE IF NOT EXISTS comentarios_db
    CHARACTER SET utf8
    COLLATE utf8_general_ci;
USE comentarios_db;
CREATE TABLE IF NOT EXISTS comentarios (
    id          INT AUTO_INCREMENT PRIMARY KEY,
    nome        VARCHAR(100)  NOT NULL,
    email       VARCHAR(150)  NOT NULL,
    comentario  TEXT          NOT NULL,
    data_envio  TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);