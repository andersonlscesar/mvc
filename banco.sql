CREATE DATABASE projeto_mvc;
USE projeto_mvc;

CREATE TABLE depoimentos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL, 
    mensagem TEXT NOT NULL,
    data TIMESTAMP
);


CREATE TABLE usuarios(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

INSERT INTO usuarios(nome, email, senha) VALUES ('Anderson Cesar', 'anderson@gmail.com');