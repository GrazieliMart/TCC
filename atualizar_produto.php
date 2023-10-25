<?php
// Inclua o código para estabelecer uma conexão com o banco de dados aqui
include 'bd.php';

// Verifique se o método da requisição é POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtenha os dados do formulário
        $code = $_POST['code'];
        $nome = $_POST['edit-nome'];
        $category = $_POST['edit-category'];
        $unidadeMedida = $_POST['edit-unidadeMedida'];
        $quantidade = $_POST['edit-quantidade'];

        $uploaddir = 'upload/produtos/'; // Diretório onde as imagens são armazenadas

        // Verifique se uma nova imagem foi enviada
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $foto = $_FILES['foto'];
            $nomeFoto = $foto['name'];
            $extensaoArq = pathinfo($nomeFoto, PATHINFO_EXTENSION);
            $novoNomeFoto = $nome . '.' . $extensaoArq;
            $uploadfile = $uploaddir . $novoNomeFoto;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $uploadfile)) {
                // Atualize o produto com a nova imagem
                $sql = "UPDATE produtoTCC SET nome = '$nome', category = '$category', unidadeMedida = '$unidadeMedida', quantidade = '$quantidade', arquivoFoto = '$uploadfile' WHERE code = '$code'";
            } else {
                // Erro ao mover a imagem
                $response = array('success' => false, 'message' => 'Erro ao fazer o upload da imagem');
                echo json_encode($response);
                exit();
            }
        } else {
            // Atualize o produto sem a imagem
            $sql = "UPDATE produtoTCC SET nome = '$nome', category = '$category', unidadeMedida = '$unidadeMedida', quantidade = '$quantidade' WHERE code = '$code'";
        }

        // Execute a consulta SQL para atualizar o produto
        $pdo = conexaoBD();
        $result = $pdo->query($sql);

        if ($result) {
            $response = array('success' => true, 'message' => 'Produto editado com sucesso');
            echo json_encode($response);
        } else {
            $response = array('success' => false, 'message' => 'Erro ao editar o produto');
            echo json_encode($response);
        }
    } catch (Exception $e) {
        $response = array('success' => false, 'message' => 'Erro: ' . $e->getMessage());
        echo json_encode($response);
    }
}
