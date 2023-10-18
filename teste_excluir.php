<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>

</body>

</html>

<?php

session_start(); // Inicie a sessão se ainda não estiver iniciada

try {
    include('bd.php');
    $pdo = conexaoBD();
    $stmt = $pdo->prepare('DELETE FROM produtoTCC WHERE code = :id');
    $stmt->bindParam(':id', $_POST["id"]);
    $stmt->execute();
    
    // Armazene a mensagem em uma variável de sessão
    $_SESSION['mensagem'] = 'Os dados do produto ' . $id . ' foram excluídos com sucesso.';
    
    header('Location: estoque.php');
} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}