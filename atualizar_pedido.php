<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include('bd.php'); // Verifique se esse arquivo está correto e sem erros.

    $codigo = filter_var($_POST['codigo'], FILTER_SANITIZE_STRING);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);
    $produto = filter_var($_POST['produtos'], FILTER_SANITIZE_STRING);
    $quantidade = filter_var($_POST['quantidades'], FILTER_SANITIZE_STRING);

    if ($status == 'Liberado') {
        try {
            $pdo = conexaoBd();
            $produtos = $_POST['produtos'];
            $quantidades = $_POST['quantidades'];

            for ($i = 0; $i < count($produtos); $i++) {
                $produto = $produtos[$i];
                $quantidade = $quantidades[$i];

                $sql = "SELECT quantidade FROM produtoTCC WHERE nome = :codigo";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':codigo', $produto);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $quantidadeDisponivel = $result['quantidade'];

                if ($quantidadeDisponivel >= $quantidade) {
                    $quantidadeAtualizada = $quantidadeDisponivel - $quantidade;

                    $updateSql = "UPDATE produtoTCC SET quantidade = :quantidadeAtualizada WHERE nome = :codigo";
                    $updateStmt = $pdo->prepare($updateSql);
                    $updateStmt->bindParam(':quantidadeAtualizada', $quantidadeAtualizada);
                    $updateStmt->bindParam(':codigo', $produto);
                    $updateStmt->execute();
                } else {
                    $response = array('success' => false, 'message' => 'Quantidade insuficiente do produto ' . $produto);
                    echo json_encode($response);
                    exit();
                }
            }
        } catch (PDOException $e) {
            $response = array('success' => false, 'message' => 'Erro no servidor ao atualizar a quantidade do produto');
            echo json_encode($response);
            exit();
        }
    }
    try {
        $pdo = conexaoBd();

        $sql = "UPDATE Pedido SET status = :status WHERE codigo = :codigo";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':codigo', $codigo);
        if ($stmt->execute()) {
            $response = array('success' => true, 'message' => 'Edição feita com sucesso!');
        } else {
            $response = array('success' => false, 'message' => 'Erro na edição!');
        }

        echo json_encode($response);
    } catch (PDOException $e) {
        $response = array('success' => false, 'message' => 'Erro no servidor ao atualizar o pedido ');
        echo json_encode($response);
    }
}
