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

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cadPedido'])) {
  // Obtenha os valores do formulário
  $cliente = isset($_POST['cliente']) ? $_POST['cliente'] : "";
  $dataPedido = isset($_POST['dataPedido']) ? $_POST['dataPedido'] : "";
  $observacoes = isset($_POST['observacoes']) ? $_POST['observacoes'] : "";
  $produtos = $_POST['produtos']; // Produtos selecionados

  $pdo = conexaoBd();

  try {
    $codigo = 3; // Vazio
    $status = "Pedido Efetuado";
    $OSGM = 0; 
    $stmt = $pdo->prepare("INSERT INTO Pedido (codigo, cliente, dataPedido, status, OSGM, observacoes, produtos) VALUES (:codigo, :cliente, :dataPedido, :status, :OSGM, :observacoes, :produtos)");

      // Associe os parâmetros com os valores do formulário
      $stmt->bindParam(':codigo', $codigo, PDO::PARAM_STR);
      $stmt->bindParam(':cliente', $cliente, PDO::PARAM_STR);
      $stmt->bindParam(':dataPedido', $dataPedido, PDO::PARAM_STR);
      $stmt->bindParam(':status', $status, PDO::PARAM_STR);
      $stmt->bindParam(':OSGM', $OSGM, PDO::PARAM_STR);
      $stmt->bindParam(':observacoes', $observacoes, PDO::PARAM_STR);

      // Converta o array de produtos em uma string
      $produtosStr = implode(', ', $produtos);
      $stmt->bindParam(':produtos', $produtosStr, PDO::PARAM_STR);

      // Execute a consulta
      if ($stmt->execute()) {
          echo '<script>alert("Pedido Efetuado!");</script>';
      } else {
          echo '<script>alert("Erro ao efetuar o pedido.");</script>';
      }
  } catch (PDOException $ex) {
      echo $ex->getMessage();
      echo '<script>alert("Erro: ' . $ex->getMessage() . '");</script>';
  }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Novo Pedido | AlmoxariSars</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style/styleteste7.css">
    <link rel="icon" type="image/png" href="logo/1.png">

</head>

		
</head>
<body>	
<?php
  include 'menuLateral.php';

?>



<div class="col-md-10 ml-sm-auto">


<form class="divPedidoNovo2" method="post" name="formPedidos">
    <div class="titleRelatorio">
        <h1>Pedido</h1>
    </div>
    <div class="divTextForm">
       
        <label for="produto">Selecione um Produto</label>
        <select class="formaticRelatorio" id="produto" required name="produto">
            <option selected disabled>Selecione um produto</option>
            <?php
            consultaProdutoTCC();
            ?>
        </select>
        <label for="cliente">Cliente</label>
        <input type="text" id="cliente" name="cliente" placeholder="Digite o nome do cliente" required class="formaticTextRelatorio">

        <label for="observacoes">Observações</label>
        <input type="text" id="observacoes" name="observacoes" placeholder="Atribua observações e especificações sobre o seu pedido" required class="formaticTextRelatorio">

        <div class="delivery-date">
            <label for="dataPedido">Data do Pedido</label><br>
            <input type="date" id="dataPedido" name="dataPedido" placeholder="" required class="formaticTextRelatorio">
        </div>
    </div>
   
        <input class="btnRelatorio1" name="cadPedido" aria-required="click" type="submit" value="Solicitar"></input>
        
   
</form>


</div>
        <footer class="footer">
       <p class="footer-text">SARS | UNICAMP | COTIL</p>
       </footer>
</body>
</html>