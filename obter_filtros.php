<?php
// Inclua o arquivo de conexão com o banco de dados (bd.php ou o arquivo apropriado)
include('bd.php');

// Recupere os critérios de pesquisa enviados via POST
$dataInicial = $_POST['dataInicial'];
$dataFinal = $_POST['dataFinal'];
$cliente = $_POST['cliente'];
$status = $_POST['status'];

try {
    // Conecte-se ao banco de dados
    $pdo = conexaoBd();

    // Construa a consulta SQL com base nos critérios de pesquisa
    $sql = "SELECT * FROM Pedido WHERE 1";

    if (!empty($dataInicial)) {
        $sql .= " AND dataPedido >= :dataInicial";
    }

    if (!empty($dataFinal)) {
        $sql .= " AND dataPedido <= :dataFinal";
    }

    if (!empty($cliente)) {
        $sql .= " AND cliente = :cliente";
    }

    if (!empty($status)) {
        $sql .= " AND status = :status";
    }

    // Prepare a consulta SQL
    $stmt = $pdo->prepare($sql);

    // Associe os parâmetros com os valores dos critérios de pesquisa
    if (!empty($dataInicial)) {
        $stmt->bindParam(':dataInicial', $dataInicial, PDO::PARAM_STR);
    }

    if (!empty($dataFinal)) {
        $stmt->bindParam(':dataFinal', $dataFinal, PDO::PARAM_STR);
    }

    if (!empty($cliente)) {
        $stmt->bindParam(':cliente', $cliente, PDO::PARAM_STR);
    }

    if (!empty($status)) {
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
    }

    // Execute a consulta SQL
    $stmt->execute();

    // Obtém os resultados da consulta como um array associativo
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Retorna os resultados como JSON
    echo json_encode($result);
} catch (Exception $e) {
    echo json_encode(array('error' => 'Erro ao processar a pesquisa: ' . $e->getMessage()));
}
?>
