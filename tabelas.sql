CREATE TABLE produtoTCC (
    code INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    category INT NOT NULL,
    unidadeMedida INT NOT NULL,
    arquivoFoto VARCHAR(255),
    quantidade INT NOT NULL
);
CREATE TABLE categoria (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);
CREATE TABLE unidadeMedida (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL
);

CREATE TABLE ItemPedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigoPedido INT NOT NULL,
    codigoItem INT NOT NULL,
    quantidade INT NOT NULL
);

CREATE TABLE Pedido (
    codigo INT PRIMARY KEY NOT NULL,
    cliente VARCHAR(255) NOT NULL,
    dataPedido DATE,
    dataEntrega DATE,
    status VARCHAR(50) DEFAULT 'Recebido',
    OSMG INT,
    observacoes TEXT
);
CREATE TABLE login (
    id INT PRIMARY KEY NOT NULL,
    usuario VARCHAR(255) NOT NULL,
    level INT NOT NULL,
    senha_hash VARCHAR(255),
    email VARCHAR(255)
);

