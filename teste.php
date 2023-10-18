<!DOCTYPE html>
<html>

<head>
    <title>Lista de Produtos</title>
    <style>
        /* Estilos CSS para a janela modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            padding: 20px;
        }

        .modal-content {
            background-color: #fff;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <h1>Lista de Produtos</h1>
    <!-- Tabela de produtos -->
    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Nome</th>
                <th>Categoria</th>
                <th>Unidade de Medida</th>
                <th>Quantidade</th>
                <th>Foto</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Estabeleça uma conexão com o banco de dados
            include('bd.php');

            $pdo = conexaoBD();

            // Consulta SQL para selecionar todos os produtos da tabela
            $sql = "SELECT * FROM produtoTCC";
            $result = $pdo->query($sql);

            if ($row = $result->fetch()) {
                while ($row = $result->fetch()) {

                    echo "<tr>";
                    echo "<td>" . $row["code"] . "</td>";
                    echo "<td>" . $row["nome"] . "</td>";
                    echo "<td>" . $row["category"] . "</td>";
                    echo "<td>" . $row["unidadeMedida"] . "</td>";
                    echo "<td>" . $row["quantidade"] . "</td>";
                    if ($row["arquivoFoto"] == null) {
                        echo "<td align='center'>--</td>";
                    } else {
                        echo "<td align='center'><img src=" . $row['arquivoFoto'] . " width='50px' height='50px'></td>";
                    }

                    echo '<td>
                    <button class="edit-button" data-product-code="' . $row["code"] . '">Editar</button>
                  </td>';
                  
                    echo "</tr>";
                }
            } else {
                echo "Nenhum produto encontrado no banco de dados.";
            }
            $pdo = null;
            ?>
        </tbody>
    </table>

    <!-- Janela modal para edição -->
    <div class="modal" id="edit-modal">
        <div class="modal-content">
            <h2>Editar Produto</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="code" id="edit-code">
                <label for="edit-nome">Nome:</label>
                <input type="text" name="edit-nome" id="edit-nome"> <br>
                <label for="edit-category">Categoria:</label>
                <input type="text" name="edit-category" id="edit-category"> <br>
                <label for="edit-unidadeMedida">Unidade de Medida:</label>
                <input type="text" name="edit-unidadeMedida" id="edit-unidadeMedida"> <br>
                <label for="edit-quantidade">Quantidade:</label>
                <input type="text" name="edit-quantidade" id="edit-quantidade"> <br>
                <label for="editfoto">Foto</label>
                <img id="edit-foto" name="edit-foto" style="width: 50px; height:auto;" src=""><br>

                <input type="file" name="foto" id="foto">
                <br>
                <input type="submit" name="editar_produto" value="Salvar">
            </form>
        </div>
    </div>
    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $pdo = conexaoBD();

        $code = $_POST['code'];
        $nome = $_POST['edit-nome'];
        $category = $_POST['edit-category'];
        $unidadeMedida = $_POST['edit-unidadeMedida'];
        $quantidade = $_POST['edit-quantidade'];

        $uploaddir = 'upload/produtos/'; //diretorio ondde será gravado a foto

        //foto

        $foto = $_FILES['foto'];
        $nomeFoto = $foto['name'];
        $tipoFoto = $foto['type'];
        $tamanhoFoto = $foto['size'];

        //gerando novo nome para a foto
        $info = new SplFileInfo($nomeFoto);
        $extensaoArq = $info->getExtension();
        $novoNomeFoto = $nome . "." . $extensaoArq;

        if (($nomeFoto != "") && (move_uploaded_file($_FILES['foto']['tmp_name'], $uploaddir . $novoNomeFoto))) {
            $uploadfile = $uploaddir . $novoNomeFoto;


            $sql = "UPDATE produtoTCC SET nome = '$nome', category = '$category', unidadeMedida = '$unidadeMedida', quantidade = '$quantidade' , arquivoFoto = '$uploadfile' WHERE code = '$code'";
            $result = $pdo->query($sql);
        } else {

            $sql = "UPDATE produtoTCC SET nome = '$nome', category = '$category', unidadeMedida = '$unidadeMedida', quantidade = '$quantidade'  WHERE code = '$code'";
            $result = $pdo->query($sql);
        }
        if ($result) {
            echo "<script>alert('Produto editado com sucesso!');</script>";
        } else {
            echo "<script>alert('Erro ao editar produto!');</script>";
        }
    }
    ?>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const editButtons = document.querySelectorAll('.edit-button');
        const editModal = document.getElementById('edit-modal');
        const editCode = document.getElementById('edit-code');
        const editNome = document.getElementById('edit-nome');
        const editCategory = document.getElementById('edit-category');
        const editUnidadeMedida = document.getElementById('edit-unidadeMedida');
        const editQuantidade = document.getElementById('edit-quantidade');
        const editFoto = document.getElementById('edit-foto');

        editButtons.forEach(button => {
            button.addEventListener('click', () => {
                const productCode = button.getAttribute('data-product-code');

                // Realiza a solicitação AJAX para buscar os dados do produto
                $.ajax({
                    url: 'buscar_dados_produto.php',
                    type: 'GET',
                    data: {
                        code: productCode
                    },
                    dataType: 'json',
                    success: function(data) {
                        // Preenche os campos do modal com os dados do produto
                        editCode.value = productCode;
                        editNome.value = data.nome;
                        editCategory.value = data.category;
                        editUnidadeMedida.value = data.unidadeMedida;
                        editQuantidade.value = data.quantidade;
                        if (data.arquivoFoto !== null) {
                            const fotoUrl = data.arquivoFoto;
                            $('#edit-foto').attr('src', fotoUrl);
                        } else {
                            // Se não houver foto, exiba uma imagem padrão ou oculte a tag <img>
                            $('#edit-foto').attr('src', 'upload/produtos/mela.jpeg ');
                        }

                        // Abre o modal
                        editModal.style.display = 'block';
                    },
                    error: function() {
                        alert('Erro ao buscar os dados do produto');
                    }
                });
            });
        });

        // Fecha o modal ao clicar fora dele
        editModal.addEventListener('click', (event) => {
            if (event.target === editModal) {
                editModal.style.display = 'none';
            }
        });
    </script>
</body>

</html>