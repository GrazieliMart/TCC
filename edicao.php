<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar</title>
    <!-- Adicione a biblioteca Font Awesome para ícones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    
    <link rel="stylesheet" href="style.css"><style>
       

        .container {
            width: 300px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 20px auto;
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }

     input[type="submit"]:hover {
            background-color: #0056b3;
        }

        button[type="submit"] {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            width: 100%;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }

        .menu {
            text-align: center;
            margin-top: 20px;
        }

        .menu a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
        }

        .menu a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <header>
        <a href="consulta.php"><i class="fas fa-arrow-left"></i></a> <!-- Ícone de voltar -->
        <h1>Editar 
        </h1>
        <div></div> <!-- Espaço vazio para alinhar o ícone à direita -->
    </header>

    
</body>
</html>

<?php 
include 'bd.php';
edicao1();
?>