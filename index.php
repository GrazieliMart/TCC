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
  <link rel="stylesheet" href="style/styleteste7.css">
  <link rel="icon" type="image/png" href="logo/1.png">
</head>

<body>


  <?php
  include('menuLateral.php');
  ?>


<div class="center-content">
  <div class="divRelatorio3">

    <form>
      
      <div class="divWelcome">

        <img src="logo/1.png" alt="Logo da UNICAMP" id="logo">

        <h1 class="textWelcome">Bem-vindo,

          <?php echo $username ?>!

        </h1>
      </div>
     

        <div class="divWelcome2">
          <h2 class="textWelcome2">Realize cadastro de produtos, funcionários e confira pedidos
          </h2>
        </div>
     
    </form>
  </div>
  </div>

  <footer class="footer">
   
  <p class="footer-text">
  <a href="https://www.sar.unicamp.br/" style="color: white; text-decoration: none;">SARS</a> | 
  <a href="https://www.unicamp.br/unicamp/" style="color: white; text-decoration: none;">UNICAMP</a> | 
  <a href="https://www.cotil.unicamp.br/" style="color: white; text-decoration: none;">COTIL</a>
</p>

  
<p>Copyright © 2023 AlmoxariSars</p>

    </footer>



</body>

</html>