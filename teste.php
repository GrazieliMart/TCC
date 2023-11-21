<!DOCTYPE html>
<html>

<head>
    <title>Formulário de Cadastro de Pedido</title>
   
</head>

<body>
   <div class='pedido'>
   <h2>Cadastro de Pedido</h2>
    <form method="POST">
        <label for="codigo">Código:</label>
        <input type="number" name="codigo" required><br><br>

        <label for="solicitante">Solicitante:</label>
        <input type="text" name="solicitante" required><br><br>

        <label for="osgm">OSGM:</label>
        <input type="number" name="osgm" required><br><br>

        <label for="obs">Observações:</label>
        <input type="text" name="obs" required><br><br>

        <label for="data">Data:</label>
        <input type="date" name="data" required><br><br>

        <h3>Produtos</h3>
        <div id="produtos">
            <div class="produto">
                <label for="produto">Produto:</label>
                <input type="text" name="produto[]">
                <label for="quantidade">Quantidade:</label>
                <input type="number" name="quantidade[]">
            </div>
        </div>
        <button type="button" onclick="adicionarProduto()">Adicionar Produto</button><br><br>

        <input type="submit" value="Salvar Pedido">
    </form>
   </div>

    <script>
        function adicionarProduto() {
            const produtosDiv = document.getElementById("produtos");
            const novoProdutoDiv = document.querySelector(".produto").cloneNode(true);
            produtosDiv.appendChild(novoProdutoDiv);
        }
    </script>
</body>

</html>

<?php
try {
    // Conectar-se ao banco de dados (substitua as informações do banco de dados)
    include('bd.php'); // Supondo que bd.php tenha a função de conexão

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = conexaoBd(); // Certifique-se de que a função de conexão está retornando uma instância PDO.
        // Recuperar dados do formulário
        $codigo = $_POST['codigo'];
        $solicitante = $_POST['solicitante'];
        $osgm = $_POST['osgm'];
        $obs = $_POST['obs'];
        $data = $_POST['data'];
        $produtos = $_POST['produto'];
        $quantidades = $_POST['quantidade'];

        // Inserir o pedido na tabela "Pedidos"
        $sql_pedido = "INSERT INTO Pedido (codigo, cliente, dataPedido, OSGM, observacoes) VALUES (?, ?, ?, ?, ?)";
        $stmt_pedido = $pdo->prepare($sql_pedido);
        $stmt_pedido->execute([$codigo, $solicitante, $data, $osgm, $obs]);
        // Inserir os produtos na tabela "ItemPedido" com o pedido_id correspondente
        $sql_produto = "INSERT INTO ItemPedido (codigoPedido, codigoItem, quantidade) VALUES (?, ?, ?)";
        $stmt_produto = $pdo->prepare($sql_produto);

        for ($i = 0; $i < count($produtos); $i++) {
            echo $produto = $produtos[$i];
            echo $quantidade = $quantidades[$i];
            $stmt_produto->execute([$codigo, $produto, $quantidade]);
        }

        echo "Pedido cadastrado com sucesso!";
    } else {
        echo 'erro';
    }
} catch (Exception $e) {
    echo "Ocorreu um erro: " . $e->getMessage();
}
?>