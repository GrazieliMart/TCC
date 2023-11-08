<?php
//tratar o warnning de erro https://www.totvs.com/  https://admsistemas.com.br/almoxarifado/  https://solucao.digital/?gclid=EAIaIQobChMImafKqsKf_wIVtkZIAB30Tw1pEAAYAiAAEgJLWfD_BwE

// prova cadastro de php em banco de dados https://nicepage.com/pt/modelos-html
ini_set('display_errors', 0);
set_error_handler('tratarAviso');
function tratarAviso($errno, $errstr, $errfile, $errline)
{
    //badge notificação para o adm de novo pedido

    include 'login.php';
    exit();
}

session_start();

$username = $_SESSION['username'];

if (isset($_SESSION['username']) && null !== $_SESSION['level']) {

    $username = $_SESSION['username'];

    $level = $_SESSION['level'];
    $logado = true;
}
// Verifica o nível de acesso do usuário e exibe os cards correspondente
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style/styleteste7.css">
    <link rel="stylesheet" href="style/stylePedido.css">
    <link rel="icon" type="image/png" href="logo/1.png">
    <style>
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            width: calc(50% - 20px);
        }

        .card.hidden {
            display: none;
        }

        /* Estilo base */
.pedido {
    max-height: 450px;
    overflow-y: auto;
}

/* Media query para dispositivos com largura menor que 768px (dispositivos móveis) */
@media (max-width: 768px) {
    .pedido {
        max-height: 400px; /* Remove a altura máxima */
         /* Remove a barra de rolagem vertical */
    }
}


    </style>
</head>

<body>
    <?php
    include 'menuLateral.php';
    ?>

    <div class="divRelatorio1">
        <div class="titleRelatorio">
            <h1>Confira seus pedidos abaixo <?php echo $username ?></h1>
                
        </div>
        
        <div class="divTextRelatorio3">
            <div>
                <input type="date" id="dataInicial" placeholder="Data inicial">
                <input type="date" id="dataFinal" placeholder="Data final">

                <select name="cliente1" id="cliente1">
                    <option value=""></option>
                    <?php consultaUsuario(); ?>
                </select>
                <select name="status" id="status">
                    <option value=""></option>
                    <option value="Recebido">Recebido</option>
                    <option value="Liberado">Liberado</option>
                    <option value="Atendido">Atendido</option>
                    <option value="Cancelado">Cancelado</option>
                </select>
                <button id="btnSearch">Pesquisar</button>
            </div>

            <div class="pedido">
                <table class="table table-striped table-hover" border="1">
                    <tr>
                        <th>Código</th>
                        <th>Data</th>
                        <th>Solicitante</th>
                        <th>OSGM</th>
                        <th>Status</th>
                    </tr>

                    <tbody id='tbody'>
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
                    </tbody>
                </table>
            </div>
        </div>
        <button id="ok-button3"><a href="novoPedido.php">Novo Pedido</a> </button>
    </div>
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
                    <form id="pedidoForm" method='POST'>
                        <label for="codigo">Código:</label>
                        <input type="number" id="codigo" name="codigo" readonly>
                        <br>
                        <label for="dataPedido">Data</label>
                        <input type="text" id="dataPedido" name="dataPedido" readonly>
                        <br>
                        <label for="cliente">Solicitante:</label>
                        <input type="text" id="cliente" name="cliente" readonly>
                        <br>
                        <label for="osgm">OSGM:</label>
                        <input type="text" id="osgm" name="osgm" readonly>
                        <br>
                        <label for="status">Status:</label>
                        <?php if ($level == 3) { ?>
                            <select name="status1" id="status1">
                                <option value="Recebido">Recebido</option>
                                <option value="Liberado">Liberado</option>
                                <option value="Atendido">Atendido</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>

                            <button type="button" id='editar'>Salvar</button>
                        <?php } ?>
                        <?php if ($level < 3) { ?>
                            <input type="text" id="status1" readonly>
                        <?php } ?>
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
        var screen = 'dblclick';
        $(document).on(screen, '.open-modal-on-double-click', function() {
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
                    $('#status1').val(data.status);
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
                        <input type="text" class="produto" name="produto" value="${item.produto}" readonly>
                        <br>
                        <label for="quantidade">Quantidade:</label>
                        <input type="text" class="quantidade" name="quantidade" value="${item.quantidade}" readonly>
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
    </script>
    <script>
        $(document).ready(function() {
            $(".close").click(function() {
                $("#myModal").modal('hide');
            });
        });
    </script>
    <script>
        $(document).on('click', '#editar', function() {
            var itemCodigo = $('#codigo').val();
            var itemStatus = $('#status1').val();

            var produtos = $('.produto').map(function() {
                return $(this).val();
            }).get();

            var quantidades = $('.quantidade').map(function() {
                return $(this).val();
            }).get();

            console.log(itemCodigo, itemStatus, produtos, quantidades);

            $.ajax({
                url: 'atualizar_pedido.php',
                method: 'POST',
                dataType: 'json',
                data: {
                    codigo: itemCodigo,
                    status: itemStatus,
                    produtos: produtos,
                    quantidades: quantidades
                },
                success: function(response) {
                    alert(response.message);
                    location.reload();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    alert(errorThrown);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#btnSearch').click(function() {
                var dataInicial = $('#dataInicial').val();
                var dataFinal = $('#dataFinal').val();
                var cliente = $('#cliente1').val();
                var status = $('#status').val();
                console.log()
                // Faça uma solicitação AJAX para obter os dados filtrados com base nos critérios de pesquisa
                $.ajax({
                    url: 'obter_filtros.php',
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        dataInicial: dataInicial,
                        dataFinal: dataFinal,
                        cliente: cliente,
                        status: status
                    },
                    success: function(data) {
                        // Limpe a tabela
                        $('#tbody').empty();

                        // Preencha a tabela com os novos dados
                        data.forEach(function(row) {
                            var newRow = "<tr data-pedido-id='" + row.codigo + "' class='open-modal-on-double-click' data-toggle='modal' data-target='#myModal'>";
                            newRow += '<td>' + row.codigo + '</td>';
                            newRow += '<td>' + row.dataPedido + '</td>';
                            newRow += '<td>' + row.cliente + '</td>';
                            newRow += '<td>' + row.OSGM + '</td>';
                            newRow += '<td>' + row.status + '</td>';
                            newRow += '</tr>';
                            $('#tbody').append(newRow);
                        });
                    },
                    error: function() {
                        alert('Erro na solicitação AJAX para obter os dados filtrados.');
                    }
                });
            });
        });
    </script>

    <footer class="footer">

        <p class="footer-text">
            <a href="https://www.sar.unicamp.br/" style="color: white; text-decoration: none;">SARS</a> |
            <a href="https://www.unicamp.br/unicamp/" style="color: white; text-decoration: none;">UNICAMP</a> |
            <a href="https://www.cotil.unicamp.br/" style="color: white; text-decoration: none;">COTIL</a>
        </p>

        <p class="footer-text"> Copyright © 2023 Almoxarisars</p>


    </footer>


</body>

</html>