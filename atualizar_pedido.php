<?php 
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include('bd.php');

    $codigo = filter_var($_POST['codigo'], FILTER_SANITIZE_STRING);
    $status = filter_var($_POST['status'], FILTER_SANITIZE_STRING);

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
        // Trate a exceção de forma apropriada, por exemplo, registrando em um arquivo de log.
        $response = array('success' => false, 'message' => 'Erro no servidor. Por favor, tente novamente mais tarde.');
        echo json_encode($response);
    }
}
?>
