CREATE DATABASE projeto_mvc;
USE projeto_mvc;

CREATE TABLE depoimentos (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(200) NOT NULL, 
    mensagem TEXT NOT NULL,
    data TIMESTAMP
);