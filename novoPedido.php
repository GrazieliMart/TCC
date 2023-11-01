<?php
//tratar o warnning de erro https://www.totvs.com/  https://admsistemas.com.br/almoxarifado/  https://solucao.digital/?gclid=EAIaIQobChMImafKqsKf_wIVtkZIAB30Tw1pEAAYAiAAEgJLWfD_BwE


  // prova cadastro de php em banco de dados https://nicepage.com/pt/modelos-html
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
  $logado = true;}
  // Verifica o nível de acesso do usuário e exibe os cards correspondente

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
	<form class="divPedidoNovo2">
		<div class="titleRelatorio">
		<h1 >Novo Pedido</h1>
        </div>

        <div class="divTextRelatorio1">
		<label for="nome">Código de Usuário</label>
		<input type="text" id="nome" name="nome" placeholder="Digite seu nome" required  class="formaticTextRelatorio">
    <label for="nome">Ordem de Serviço</label>
		<input type="text" id="nome" name="nome" placeholder="Digite o Código de Serviço" required  class="formaticTextRelatorio">
        <label for="produto">Produto</label>
		<select id="produto" name="produto" class="formaticRelatorio">
      <option value="">Selecione um filtro</option>
	  <option value="mensal">Hidraulica</option>
	  <option value="semestral">Elétrica</option>
      <option value="semestral">Cabeamento</option>
      <option value="semestral">Estrutura (Aço,concreto,alvenaria...)</option>
      <option value="semestral">Cobertura</option>
      <option value="semestral">Impermeabilidade</option>
      <option value="semestral">SPDA</option>
      <option value="semestral">Pintura</option>
      <option value="semestral">Climatização</option>
      <option value="semestral">Pavimentação</option>
	  </select>
		
		<label for="quantidade">Observações</label>
        <input type="text" id="observacao" name="observacao" required class="formaticTextRelatorio">

        <label for="quantidade">Quantidade</label>
			<input type="number" id="quantidade" name="quantidade" required class="formaticTextRelatorio">
				<div class="delivery-date">
				  <label for="delivery">Data de entrega</label><br>
				  <input type="date" id="delivery" placeholder="" required class="formaticTextRelatorio">
                  <br>
</div>
  </div>	
  <input type="submit" value="Solicitar" class="btnRelatorio1">
</form>

</div>
        <footer class="footer">
       <p class="footer-text">SARS | UNICAMP | COTIL</p>
       </footer>
</body>
</html>