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
                    echo '<td>';
                 
                  echo "
                  <td>
                      <form method='POST'>
                          <input type='hidden' name='code' value='" . $row['code'] . "'>
                          <button type='submit' class='btn btn-edit' formaction='edicao.php'>Editar</button>
                          <input type='submit' class='btn btn-delete' value='Excluir' name='op'>
                      </form>
                  </td>
              </tr>
              ";
                    echo "</tr>";
                }
            } else {
                echo "Nenhum produto encontrado no banco de dados.";
            }
            $pdo = null;
            buscarTeste();
            ?>
        </tbody>
    </table>

    <!-- Janela modal para edição -->
    <div class="modal" id="edit-modal">
        <div class="modal-content">
            <h2>Editar Produto</h2>
            <form method="post" action="editar_produto.php">
                <input type="hidden" name="code" id="edit-code">
                <label for="edit-nome">Nome:</label>
                <input type="text" name="edit-nome" id="edit-nome">
                <label for="edit-category">Categoria:</label>
                <input type="text" name="edit-category" id="edit-category">
                <label for="edit-unidadeMedida">Unidade de Medida:</label>
                <input type="text" name="edit-unidadeMedida" id="edit-unidadeMedida">
                <label for="edit-quantidade">Quantidade:</label>
                <input type="text" name="edit-quantidade" id="edit-quantidade">
                <input type="submit" name="editar_produto" value="Salvar">
            </form>
        </div>
    </div>

</body>
</html>
