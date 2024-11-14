CREATE DATABASE if not exists sistema_login;

USE sistema_login;

CREATE TABLE if not exists usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    login VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

TRUNCATE TABLE usuarios;
SELECT * FROM usuarios;