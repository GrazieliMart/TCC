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

?>
<!DOCTYPE html>
<html>

<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Relatório | AlmoxariSars</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style/styleteste7.css">
  
  <link rel="icon" type="image/png" href="logo/1.png">
  
</head>

<body>
  <?php
  include 'menuLateral.php';
  ?> 
  <footer class="footer">
      <p class="footer-text">SARS | UNICAMP | COTIL</p>

    </footer>
 

 
</body>

</html>