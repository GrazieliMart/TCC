<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try{
    $id = $_POST['id'];
    $newName = $_POST['newName'];
    // Substitua estas configurações de conexão com seu próprio banco de dados
    include('bd.php');
    $pdo = conexaoBd();

    $sql = "UPDATE unidadeMedida SET name = :newName WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':newName', $newName);
    $stmt->bindParam(':id', $id);

    if ($stmt->execute()) {
        $response = array('success'=> true,'message'=> 'Edição feita com sucesso!');
    } else {
        $response = array('success'=> false,'message'=> 'Erro na edição!');
    }

    echo json_encode($response);
    } catch(PDOException $e) {
        $response = ['success'=> false,'message'=> $e->getMessage()];
    }
}
