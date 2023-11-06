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
            echo "<tr class='open-modal-on-double-click' data-toggle='modal' data-target='#myModal'>";
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
                    <!-- Conteúdo do modal aqui -->
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Adicione um ouvinte de eventos para o duplo clique nas linhas da tabela
        document.addEventListener('DOMContentLoaded', function () {
            var rows = document.querySelectorAll('.open-modal-on-double-click');
            rows.forEach(function (row) {
                row.addEventListener('dblclick', function () {
                    $('#myModal').modal('show'); // Exibe o modal
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>

</body>

</html>