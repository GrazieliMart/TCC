<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conecte-se ao banco de dados (substitua com suas informações de conexão)
    include('bd.php');

    $pedidoId = $_POST['pedidoId']; // Receba o pedidoId da solicitação POST

    try {
        $pdo = conexaoBd();

        // Consulta para buscar os itens do pedido com base no pedidoId
        $query = "SELECT ItemPedido.quantidade,produtoTCC.nome AS produto FROM ItemPedido INNER JOIN produtoTCC on ItemPedido.codigoItem = produtoTCC.code WHERE codigoPedido = :pedidoId";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':pedidoId', $pedidoId, PDO::PARAM_INT);
        $stmt->execute();

        $itens = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Retorne os dados dos itens do pedido como JSON
        echo json_encode($itens);
    } catch (PDOException $e) {
        echo json_encode(array('error' => 'Erro na conexão com o banco de dados: ' . $e->getMessage()));
    }
}
