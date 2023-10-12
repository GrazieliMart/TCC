<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['level'])) {
  // Se o usuário não estiver logado ou não tiver um nível definido, redirecione para a página de login
  header("Location: login.php");
  exit();
}

$username = $_SESSION['username'];
$level = $_SESSION['level'];

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Home | AlmoxariSars</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="styleteste7.css">
  <link rel="icon" type="image/png" href="logo/1.png">
</head>

<body>
  <?php
  include 'menuLateral.php';
  ?>


  <div class="divRelatorio3">
    <form>
      <div class="divWelcome">
        <img src="logo/1.png" alt="Logo da UNICAMP" id="logo">
        <h1 class="textWelcome">Bem-vindo,
          <?php echo $username ?>!
        </h1>
      </div>
      <div class="divTextRelatorio">

        <div class="divWelcome2">
          <h2 class="textWelcome2">Realize cadastro de produtos, funcionários e confira pedidos
          </h2>
        </div>
      </div>
    </form>
  </div>

  <footer class="footer">
    <footer>
      <p class="footer-text">SARS | UNICAMP | COTIL</p>
      <button class="btnRodape" onclick="abrirFormulario()">Contatar Desenvolvedor</button>

    </footer>



</body>

</html>