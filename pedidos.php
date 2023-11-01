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


?>
<!DOCTYPE html>
<html>
<style>
 
     /*.divRelatorio {
        display: inline;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 80vh;
        background-color: #f0f0f0;
    }

    .btnBuscar {
        background-color: white;
        color: black;
        border: 1px solid black;
        border-radius: 50px;
        padding: 10px 20px;
        cursor: pointer;
        transition: background-color 0.3s, color 0.3s;
    }

    .btnBuscar:hover {
        backgroud-color: white;
        color: black;
    }

    .glass-container {
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        /* Alinhamento à esquerda */
      
    

    /* Estilo dos cards */
    .card {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        margin: 10px;
        width: calc(50% - 20px);
        /* Largura dos cards (50% do container) com margens */
    }

 
    .card.hidden {
        display: none;
    }
</style>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pedidos | AlmoxariSars</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style/styleteste7.css">
    <link rel="stylesheet" href="style/stylePedido.css">
    <link rel="icon" type="image/png" href="logo/1.png">

</head>

<body>
    <?php
    include 'menuLateral.php';
    ?>

    <div class="divRelatorio">
        <form>
            <div class="titleRelatorio">
                <h1>Confira seus pedidos abaixo
                    <?php echo $username ?>
                </h1>
                <br>
              </div>

              <div class="DivPedido">
           <button id="ok-button3"><a href="novoPedido.php">Novo Pedido</a> </button>
            </div>

         
    </div>


    <footer class="footer">
        <footer>
            <p class="footer-text">SARS | UNICAMP | COTIL</p>


        </footer>

</body>

</html>