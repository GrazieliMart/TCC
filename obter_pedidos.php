<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Conecte-se ao banco de dados (substitua com suas informações de conexão)
    include('bd.php');

    $pedidoId = $_POST['pedidoId']; // Receba o pedidoId da solicitação POST
    try {
        $pdo = conexaoBd();

        // Consulta para buscar os dados do Pedido com base no pedidoId
        $query = "SELECT * FROM Pedido WHERE codigo = :codigo"; // Usar a mesma coluna 'codigo'
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':codigo', $pedidoId); // Usar o mesmo nome de parâmetro
        $stmt->execute();

        $pedidoData = $stmt->fetch();

        // Retorne os dados do Pedido como JSON
        echo json_encode($pedidoData);
    } catch (PDOException $e) {
        echo json_encode(array('error' => 'Erro na conexão com o banco de dados: ' . $e->getMessage()));
    }
}
