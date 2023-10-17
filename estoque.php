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
  $logado = true;
}
// Verifica o nível de acesso do usuário e exibe os cards correspondente

?>
<!DOCTYPE html>
<html>

<head>
  <title>Estoque | AlmoxariSars</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style/styleteste7.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <link rel="icon" type="image/png" href="logo/1.png">
  <style>
#ok-button {

background-color: #fff;
font-size: 13px;
width: 100px; /* Reduzi a largura para ajustar melhor */
cursor: pointer;
color: #000000;
border: none;
margin-left: 5px;
border-radius: 20px;
padding: 6px;

transition: .2s;
box-shadow: 0px 2px 4px rgba(0, 174, 255, 0.3);

font-weight: normal;
text-align: center;

}
/* Estilos para a janela modal */
.modal {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
}

.modal-content {
  background-color: lightsteelblue;
  width: 50%;
  max-width: 600px;
  margin: 100px auto;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.table {
  width: 100%;
}

.close {
  float: right;
  cursor: pointer;
}


  </style>
</head>

<body>
  <?php
  include 'menuLateral.php';
  ?>
  <div class="divRelatorio1">
    <div class="titleRelatorio">
      <h1>Estoque</h1>
    </div>
    <br>

    <div class="divTextRelatorio2">

      <form method="post">
        <input type="text" id="search" class="formaticTextRelatorio" placeholder="Pesquisar produto..." name="name">
        <input id="ok-button" type="submit" value="Consultar">
      </form>

      <?php
      include("bd.php");
      buscarTeste();?>
    </div>
    
    
  </div>

  <footer class="footer">
    <footer>
      <p class="footer-text">SARS | UNICAMP | COTIL</p>
      <button class="btnRodape" onclick="abrirFormulario()">Contatar Desenvolvedor</button>

    </footer>
</body>

</html>
