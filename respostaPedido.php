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
<style>
     .glass-container {
            display:flex;
            flex-direction: column;
            align-items: flex-start; /* Alinhamento à esquerda */
            background-color: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            
            max-width: 800px;
            
        }
        .card {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding:70px;
            margin: 20px;
            width: 50%; /* Largura dos cards ajustada para 100% do contêiner pai */
            box-sizing: border-box; /* Evita problemas de largura total */
        }

        .relatorio {
            display: flex;
            flex-wrap: wrap; /* Permite que os cards quebrem para a próxima linha */
        }

        /* Estilo para a container de ícones horizontal */
        .icon-container {
            display: inline;
            justify-content: space-between; /* Coloca os ícones no espaço disponível horizontalmente */
            margin-top: 10px;
        }

        /* Estilo para os ícones individuais */
       
        .lateral{
            display: flex; /* Torna os elementos flexíveis */
        }

        
        .lateral {
            margin-right: 10px; /* Margem à direita entre os elementos */
        }
        .botao-customizado {
    border-radius: 0.5rem; /* Arredondamento suave */
    background-color: #ffffff; /* Fundo branco */
    color: #000000; /* Texto preto */
    padding: 0.5rem 1rem; /* Espaçamento interno para melhor aparência */
    border: 1px solid #000000; /* Borda preta fina */
    font-weight: bold; /* Texto em negrito */
    transition: background-color 0.3s, color 0.3s; /* Transição suave de cores */
  }

  .botao-customizado:hover {
    background-color: #C0C0C0; /* Fundo preto ao passar o mouse */
    color: #ffffff; /* Texto branco ao passar o mouse */
  }
  </style>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Relatório de Pedidos | AlmoxariSars</title>
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
            <h1>Confira seus pedidos abaixo <?php echo $username ?></h1>
            <br>
        </div>

        
          
        <div class="glass-container">
       
        <div class="card-container" id="cardContainer">
        <div  class="lateral">
            <div class="card" data-nome="obras" data-data="2023-08-09">
                <div class="card-title">Solicitação: Elétrica</div>
                <div class="card-text">Código: 1234</div>
                <div class="card-text">Data: 09/08/2023</div>
                <div class="status-dot andamento"></div>
                <span class="status-text">Em Andamento</span>
                <div class="buttons-container">
                    <button class="botao-customizado" onclick="changeStatus(this, 'concluido')">Concluído</button>
                    <button class="botao-customizado" onclick="changeStatus(this, 'andamento')">Em Andamento</button>
                    <button class="botao-customizado" onclick="changeStatus(this, 'cancelado')">Cancelado</button>
                </div>
            </div>
            <div class="card" data-nome="lazer" data-data="2023-07-05">
                <div class="card-title">Solicitação: Hidraulica</div>
                <div class="card-text">Código: 1234</div>
                <div class="card-text">Data: 05/07/2023</div>
                <div class="status-dot andamento"></div>
                <span class="status-text">Em Andamento</span>
                <div class="buttons-container">
                    <button class="botao-customizado" onclick="changeStatus(this, 'concluido')">Concluído</button>
                    <button class="botao-customizado" onclick="changeStatus(this, 'andamento')">Em Andamento</button>
                    <button class="botao-customizado" onclick="changeStatus(this, 'cancelado')">Cancelado</button>
                 
                </div>
            </div>
        </div>
    </div>
</div>   
    </div>
    <footer class="footer">
  <footer>    
  <p class="footer-text">SARS | UNICAMP | COTIL</p>
    <button class="btnRodape" onclick="abrirFormulario()">Contatar Desenvolvedor</button>

</footer>

<script>
        const inicioCard = document.getElementById('inicioCard');
        const cardContainer = document.getElementById('cardContainer');
        const codigoInput = document.getElementById('codigoInput');
        const buscarCodigoBtn = document.getElementById('buscarCodigoBtn');
        const ordemAlfabetica = document.getElementById('ordem-alfabetica');
        const ordemData = document.getElementById('ordem-data');

        buscarCodigoBtn.addEventListener('click', () => {
            const codigo = codigoInput.value;
            if (codigo === '1234') {
                
                cardContainer.style.display = 'flex';
            } else {
                cardContainer.style.display = 'none';
            }
        });

        ordemAlfabetica.addEventListener('change', () => {
            const cards = Array.from(cardContainer.getElementsByClassName('card'));
            cards.sort((a, b) => a.dataset.nome.localeCompare(b.dataset.nome));
            cardContainer.innerHTML = '';
            cards.forEach(card => cardContainer.appendChild(card));
        });

        ordemData.addEventListener('change', () => {
            const cards = Array.from(cardContainer.getElementsByClassName('card'));
            cards.sort((a, b) => b.dataset.data.localeCompare(a.dataset.data));
            cardContainer.innerHTML = '';
            cards.forEach(card => cardContainer.appendChild(card));
        });

        


    function changeStatus(button, novoStatus) {
        const card = button.closest('.card');
        const statusDot = card.querySelector('.status-dot');
        const statusText = card.querySelector('.status-text');
        const buttons = card.querySelectorAll('.buttons-container button');

        if (novoStatus === 'concluido') {
            statusDot.classList.remove('andamento', 'cancelado');
            statusDot.classList.add('concluido');
            statusDot.style.backgroundColor = 'green';
            statusText.innerHTML = 'Concluído';
            statusText.style.color = 'green';
            buttons.forEach(btn => btn.removeAttribute('disabled'));
            button.setAttribute('disabled', 'true');
        } else if (novoStatus === 'cancelado') {
            statusDot.classList.remove('andamento', 'concluido');
            statusDot.classList.add('cancelado');
            statusDot.style.backgroundColor = 'red';
            statusText.innerHTML = 'Cancelado';
            statusText.style.color = 'red';
            buttons.forEach(btn => btn.removeAttribute('disabled'));
            button.setAttribute('disabled', 'true');
        } else {
            statusDot.classList.remove('concluido', 'cancelado');
            statusDot.classList.add('andamento');
            statusDot.style.backgroundColor = 'yellow';
            statusText.innerHTML = 'Em Andamento';
            statusText.style.color = ' yellow ';
            buttons.forEach(btn => btn.removeAttribute('disabled'));
            button.setAttribute('disabled', 'true');
        }
    }
</script>
        </div>
     
    </form>
        