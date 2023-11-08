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


  
  <style>
        body {
            margin: 0;
            overflow: hidden;

        }

        .iframe-container {


          
            overflow: hidden;
            margin-top: 30px;
            zoom: 130%;
            margin-right: 90px;


            /* 16:9 aspect ratio */
         
            position: relative;

            width: 138%;
            height: 125%;
           
           
          


          
          
        }


        
    </style>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style/styleteste7.css">
  
  <link rel="icon" type="image/png" href="logo/1.png">
  
</head>

<body>
  <?php
  include 'menuLateral.php';


  ?>
<br>
<br>
<br>
<br>

<div class="divRelatorio12">
  
    <div class="titleRelatorio1">
      <h1>Relatório</h1>
    </div>
    <br>
    <br>
    <br>



  

<div class="iframe-container">
    <iframe title="relatorio" src="https://app.powerbi.com/reportEmbed?reportId=6662da05-e53d-4b46-9e69-1f693bb3d0f1&autoAuth=true&ctid=d3acd233-2d54-401d-8cc3-d86d8614b7c5" frameborder="0" allowFullScreen="true"
      
      style="width: 1000px; height: 700px;"></iframe>
      <!-- ele "tem" que ficar desse jeito p manter filtro e página escondido.  esse aqui muda diretamente no tamanho de exibição, os outros sao tentativas-->
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
 
 

 
</body>

</html>
