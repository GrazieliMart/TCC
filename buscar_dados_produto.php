<?php
if (isset($_GET['code'])) {
    include('bd.php');
    $pdo = conexaoBD();
    $code = $_GET['code'];

    // Consulta SQL para buscar os dados do produto com base no código
    $sql = "SELECT * FROM produtoTCC WHERE code = :code";
    // Prepare a consulta
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':code', $code);
    $stmt->execute();

    // Recupere os dados do produto
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    // Retorna os dados em formato JSON
    header('Content-Type: application/json'); // Define o cabeçalho como JSON
    echo json_encode($produto);
} else {
    echo json_encode(['error' => 'Código do produto não especificado']);
}
