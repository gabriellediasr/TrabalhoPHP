CREATE DATABASE gabiphpdb;
USE gabiphpdb;

CREATE TABLE Cadastro (
    idCad INT AUTO_INCREMENT PRIMARY KEY,
    Nome VARCHAR(100) NOT NULL,
    Email VARCHAR(100) NOT NULL,
    DataNasc DATE NOT NULL,
    Genero ENUM('masculino', 'feminino', 'outros') NOT NULL,
    Biografia TEXT NOT NULL
);