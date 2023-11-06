<?php
// Conecte-se ao banco de dados (substitua com suas informações de conexão)
include('bd.php');

try {
    $pdo = conexaoBd();
} catch (PDOException $e) {
    die("Erro na conexão com o banco de dados: " . $e->getMessage());
}

// Consulta para buscar dados da tabela Pedido
$query = "SELECT * FROM Pedido";

// Executa a consulta
$result = $pdo->query($query);

?>
<!DOCTYPE html>
<html>

<head>
    <title>Tabela de Pedidos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body>
    <h1>Tabela de Pedidos</h1>

    <table class="table table-striped" border="1">
        <tr>
            <th>Codigo</th>
            <th>Data do Pedido</th>
            <th>Cliente</th>
            <th>osgm</th>
            <th>Status</th>
        </tr>

        <?php
        // Loop através dos resultados da consulta e exiba-os na tabela
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr data-pedido-id='" . $row['codigo'] . "' class='open-modal-on-double-click' data-toggle='modal' data-target='#myModal'>";
            echo "<td>" . $row['codigo'] . "</td>";
            echo "<td>" . $row['dataPedido'] . "</td>";
            echo "<td>" . $row['cliente'] . "</td>";
            echo "<td>" . $row['OSGM'] . "</td>";
            echo "<td>" . $row['status'] . "</td>";
            echo "</tr>";
        }
        ?>
    </table>

    <!-- Modal que será exibido -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Detalhes do Pedido</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h2>Dados do Pedido</h2>
                    <form id="pedidoForm">
                        <label for="codigo">Código:</label>
                        <input type="text" id="codigo" name="codigo" readonly>
                        <br>
                        <label for="dataPedido">Data do Pedido:</label>
                        <input type="text" id="dataPedido" name="dataPedido" readonly>
                        <br>
                        <label for="cliente">Cliente:</label>
                        <input type="text" id="cliente" name="cliente" readonly>
                        <br>
                        <label for="osgm">OSGM:</label>
                        <input type="text" id="osgm" name="osgm" readonly>
                        <br>
                        <label for="status">Status:</label>
                        <input type="text" id="status" name="status" readonly>
                    </form>

                    <h2>Itens do Pedido</h2>
                    <div id="itemPedidoList">
                        <!-- Itens do pedido serão preenchidos dinamicamente aqui -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script>
        // Adicione um ouvinte de eventos para o duplo clique nas linhas da tabela
        // ...
        $(document).on('dblclick', '.open-modal-on-double-click', function() {
            var pedidoId = $(this).data('pedido-id');
            console.log(pedidoId);
            // Preencha os dados do Pedido no modal
            $.ajax({
                url: 'obter_pedidos.php', // Substitua pela URL do seu script que retorna os dados do Pedido
                method: 'POST',
                dataType: 'json',
                data: {
                    pedidoId: pedidoId
                },
                success: function(data) {
                    console.log(data);
                    // Preencha os campos do Pedido no modal com os dados obtidos
                    $('#codigo').val(data.codigo);
                    $('#dataPedido').val(data.dataPedido);
                    $('#cliente').val(data.cliente);
                    $('#osgm').val(data.OSGM);
                    $('#status').val(data.status);
                },
                error: function() {
                    alert('Erro na solicitação AJAX para obter os dados do Pedido.');
                }
            });

            // Preencha os Itens do Pedido no modal
            var itemPedidoList = $('#itemPedidoList');
            itemPedidoList.empty(); // Limpe a lista de Itens do Pedido

            // Obtenha os dados dos Itens do Pedido com base no pedidoId usando uma requisição AJAX
            $.ajax({
                url: 'obter_itens.php', // Substitua pela URL do seu script que retorna os Itens do Pedido
                method: 'POST',
                dataType: 'json',
                data: {
                    pedidoId: pedidoId
                },
                success: function(data) {
                    // Preencha os Itens do Pedido no modal
                    data.forEach(function(item) {
                        var itemPedidoForm = `
                    <form>
                        <label for="produto">Produto:</label>
                        <input type="text" id="produto" name="produto" value="${item.produto}" readonly>
                        <br>
                        <label for="quantidade">Quantidade:</label>
                        <input type="text" id="quantidade" name="quantidade" value="${item.quantidade}" readonly>
                    </form>
                `;
                        itemPedidoList.append(itemPedidoForm);
                    });
                },
                error: function() {
                    alert('Erro na solicitação AJAX para obter os Itens do Pedido.');
                }
            });

            $('#myModal').modal('show'); // Exibe o modal
        });
        // ...
    </script>
</body>

</html>