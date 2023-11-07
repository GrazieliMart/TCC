<?php
// Verifique se o ID foi fornecido na solicitação
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    try {
        include('bd.php');
        $pdo = conexaoBd();

        // Prepare uma consulta SQL para excluir o registro com base no ID
        $stmt = $pdo->prepare("DELETE FROM login WHERE id = :id");
        $stmt->bindParam(':id', $id);

        // Execute a consulta
        $stmt->execute();

        // Verifique se a exclusão foi bem-sucedida
        if ($stmt->rowCount() > 0) {
            $response = array('success' => true, 'message' => 'Registro excluído com sucesso.');
        } else {
            $response = array('success' => false, 'message' => 'Nenhum registro foi excluído.');
        }
    } catch (PDOException $e) {
        $response = array('success' => false, 'message' => 'Erro ao excluir o registro: ' . $e->getMessage());
    }

    // Encerre a conexão com o banco de dados
    $pdo = null;

    // Responda com uma estrutura JSON indicando o resultado da operação
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    $response = array('success' => false, 'message' => 'ID não fornecido na solicitação.');
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
