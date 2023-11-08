<?php
ini_set('display_errors', 0);
set_error_handler('tratarAviso');

function tratarAviso($errno, $errstr, $errfile, $errline)
{
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

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Novo Pedido | AlmoxariSars</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style/styleteste7.css">
    <link rel="icon" type="image/png" href="logo/1.png">
    <style>
        .divPedidoNovo2 {
            
    max-height: 500px; /* Defina a altura máxima desejada */
    overflow-y: auto; /* Adiciona a barra de rolagem vertical quando o conteúdo excede a altura máxima */
     /* Opcional: Adicione preenchimento para melhor aparência e espaço ao redor do formulário */

        }
    </style>

</head>


</head>

<body>
    <?php
    include 'menuLateral.php';

    ?>

    <div class="col-md-10 ml-sm-auto">


        <div class='pedido'>
            <form class="divPedidoNovo2" method="post" name="formPedidos">
                <div class="titleRelatorio">
                    <h1>Pedido</h1>
                </div>
                <div class="divTextForm">
                    <div class="delivery-date">
                        <label for="dataPedido">Data do Pedido</label><br>
                        <input type="date" id="dataPedido" name="dataPedido" placeholder="" required class="formaticTextRelatorio">
                    </div>
                    <label for="cliente">Código</label>
                    <input type="number" name="codigo" id="codigo" class="formaticTextRelatorio" required>

                    <label for="cliente">Solicitante</label>
                    <input type="text" class="formaticTextRelatorio" readonly value="<?php echo $username ?>" name="solicitante">


                    <label for="cliente">OS-GM</label>
                    <input type="number" name="osgm" id="osgm" class="formaticTextRelatorio" required>

                    <label for="observacoes">Observações</label>
                    <input type="text" id="observacoes" name="observacoes" placeholder="Atribua observações e especificações sobre o seu pedido" required class="formaticTextRelatorio">

                    <div id="produtos">
                        <div class="produto">
                            <label for="produto">Produto:</label><br>
                            <select name="produto[]" id="produto" class="formaticTextRelatorio">
                                <?php

                                consultaProdutoTCC();

                                ?>
                            </select>
                            <!--<input type="text" name="produto[]" class="formaticTextRelatorio">-->
                            <label for="quantidade">Quantidade:</label>
                            <input type="number" name="quantidade[]" class="formaticTextRelatorio">
                            <button type="button" onclick="adicionarProduto()" class="btnRelatorioPlus">+</button><br><br>
                        </div>
                    </div>
                    



                </div>

              
  <input class="btnRelatorioSolicitar" name="cadPedido" aria-required="click" type="submit" value="Solicitar"></input>

            </form>
        </div>


    </div>

   
  <footer class="footer">
   
   <p class="footer-text">
   <a href="https://www.sar.unicamp.br/" style="color: white; text-decoration: none;">SARS</a> | 
   <a href="https://www.unicamp.br/unicamp/" style="color: white; text-decoration: none;">UNICAMP</a> | 
   <a href="https://www.cotil.unicamp.br/" style="color: white; text-decoration: none;">COTIL</a>
 </p>
 
       <p class="footer-text"> Copyright © 2023 Almoxarisars</p>
      
 
     </footer>
 
 
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
    // Supondo que bd.php tenha a função de conexão

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $pdo = conexaoBd(); // Certifique-se de que a função de conexão está retornando uma instância PDO.
        // Recuperar dados do formulário
        $codigo = $_POST['codigo'];
        $solicitante = $_POST['solicitante'];
        $osgm = $_POST['osgm'];
        $obs = $_POST['observacoes'];
        $data = $_POST['dataPedido'];
        $produtos = $_POST['produto'];
        $quantidades = $_POST['quantidade'];

        $stmt_validate = $pdo->prepare('SELECT * FROM Pedido WHERE codigo = :codigo');
        $stmt_validate->bindParam(':codigo', $codigo);
        $stmt_validate->execute();

        if ($stmt_validate->rowCount() > 0) {
            echo '<script>Swal.fire("Erro", "Pedido já existe.", "error");</script>';
        } else {
            $sql_pedido = "INSERT INTO Pedido (codigo, cliente, dataPedido, OSGM, observacoes) VALUES (?, ?, ?, ?, ?)";
            $stmt_pedido = $pdo->prepare($sql_pedido);

            if ($stmt_pedido->execute([$codigo, $solicitante, $data, $osgm, $obs])) {
                echo '<script>Swal.fire("Sucesso", "Pedido efetuado!", "success");</script>';

                $sql_produto = "INSERT INTO ItemPedido (codigoPedido, codigoItem, quantidade) VALUES (?, ?, ?)";
                $stmt_produto = $pdo->prepare($sql_produto);

                for ($i = 0; $i < count($produtos); $i++) {
                    $produto = $produtos[$i];
                    $quantidade = $quantidades[$i];
                    $stmt_produto->execute([$codigo, $produto, $quantidade]);
                }
            } else {
                echo '<script>Swal.fire("Erro", "Erro ao efetuar o pedido.", "error");</script>';
            }
        }
    }
} catch (Exception $e) {
    echo 'Ocorreu o erro: ' . $e->getMessage();
}
?>