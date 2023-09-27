<?php
ini_set('display_errors', 0);
set_error_handler('tratarAviso');
function tratarAviso($errno, $errstr, $errfile, $errline)
{
  // Exibir a tela bonita ao invés do aviso padrão
  include 'login.php';
  exit(); // Encerra a execução do script após exibir a tela bonita
}

session_start();

$username = $_SESSION['username'];

if (isset($_SESSION['username']) && null !== $_SESSION['level']) {

  $username = $_SESSION['username'];

  $level = $_SESSION['level'];}
  ?>

  <!DOCTYPE html>
  <html lang="en">

  <head>
    <meta charset="UTF-8">
    <title>Cadastro | AlmoxariSars</title>
    <link rel="icon" type="image/png" href="logo/1.png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="styleteste7.css">
    <link rel="stylesheet" href="formsCadastro.css">
   

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>

    <style>
    
    </style>
  </head>

  <body>
  <?php
  include 'menuLateral.php';
?>

    <!--PRODUTO -->
    <div class="col-md-10 ml-sm-auto">
      <form id="form1" class="limpar-campos" style="display: none;" method="post" name="formProduto" action="teste.php
      ">
      <div class="titleRelatorio">
		  <h1>Produto</h1>
      </div>
      <div class="divTextForm">
      <label for="nome">Nome</label>
      <input type="text" id="nome" name="nome" placeholder="Digite seu nome" required  class="formaticTextRelatorio">
  
      <label for="code">Código</label>
      <input type="code" id="code" name="code" placeholder="Digite seu código" required  class="formaticTextRelatorio">
      <label for="category">Categoria</label>
		  <select class="formaticRelatorio" id="category" required name="category">
              <option selected disabled>Selecione uma categoria</option>
              <option value="categoria1">Hidráulica</option>
              <option value="categoria2">Finalização</option>
              <option value="categoria3">Tintas</option>
      </select>
      <label for="unidadeMedida">Unidade de Medida</label>
      <select class="formaticRelatorio" id="unit" required name="unidadeMedida">
              <option selected disabled>Selecione uma unidade de medida</option>
              <option value="média">Bobina</option>
              <option value="alta">Caixa com 10 sachês com 1 grama</option>
              <option value="alta">Cartela com 1 cartela</option>
              <option value="alta">Caixa 50 pares</option>
              <option value="alta">Centena</option>
              <option value="alta">Dezena</option>
              <option value="alta">Fardo</option>
              <option value="alta">Frasco</option>
              <option value="alta">Galão</option>
              <option value="alta">Quilograma</option>
              <option value="alta">Litro</option>
              <option value="alta">Milheiro</option>
              <option value="alta">Peça</option>
              <option value="alta">Pacote (500 folhas)</option>
              <option value="alta">Pacote com 4 blocos com 50 folhas</option>
            </select>
           <label for="formFile">Insira a imagem referente</label>
              <input type="file" id="formFile" class="formaticTextRelatorio"  accept="image/*" name="foto"  accept="image/gif, image/png, image/jpg, image/jpeg">
          </div> 
                <div class="button-container">
                 <input id="ok-button" name="cadProduto" aria-required="click" type="submit" value="Cadastrar"></input>
                 <button id="ok-button" aria-required="click">ATUALIZAR</button>
                 <button id="ok-button" aria-required="click">EXCLUIR</button>
                </div>   
      </form>
    </div>

    <!--USUÁRIO -->
    <div class="col-md-10 ml-sm-auto">
    <form id="form2" class="limpar-campos" style="display: none;">
    <div class="titleRelatorio">
		  <h1>Usuário</h1>
      </div>
    <div class="form-row">
    <div class="divTextForm2">
      <label for="name">Nome</label>
      <input type="text" class="formaticTextRelatorio" id="name" name="name" placeholder="Insira o nome" required>
    
      <div class="iconeBuscar">
            <span class="icon"><i class="bi bi-search"></i>
            <input type="text" class="formaticTextRelatorio" id="search" placeholder="Buscar"></span>
          </div>

      <label for="code">Código de funcionário</label>
      <input type="text" class="formaticTextRelatorio" id="code" name="code" placeholder="Insira o código" required>
  
      <label for="unit">Tipo de usuário</label>
      <select class="formaticRelatorio" id="unit" name="unit" required>
        <option selected disabled>Selecione o tipo de usuário</option>
        <option value="média">Adm</option>
        <option value="alta">nível 1</option>
        <option value="alta">nível 2</option>
      </select>

    <?php
    /*
    include('bd.php');



          if($_SERVER["REQUEST_METHOD"]==='POST'){
            $name = $_POST['name'];
            $code = $_POST['code'];
            $unit = $_POST['unit'];

            if((trim($name)=="")||(trim($code)=="")||trim($unit)==""){
              echo "<div class='container' style='background-color: red; color: white; text-align: center; padding: 10px; border-radius: 5px;'>
              Todos os campos são obrigatórios!";
              echo "</div>";
            }
            else{
              $pdo = conexaoBd();
              $rows = buscarLogin($code, $pdo); 

                    $stmt = $pdo->prepare("insert into login (id, usuario, level, senha, senha_hash) values(:id, :nomePet, :nomeDono, :raca, :idade, :foto)");
                    $stmt->bindParam(':id', $id);
                    $stmt->bindParam(':nomePet', $nomePet);
                    $stmt->bindParam(':nomeDono', $nomeDono);
                    $stmt->bindParam(':raca', $raca);
                    $stmt->bindParam(':idade', $idade);
                    $stmt->bindParam(':foto', $uploadfile);
                    $stmt->execute();
            }
          }
   */
   ?>
  </div>
  <div class="button-container">
                 <button id="ok-button" aria-required="click">CADASTRAR</button>
                 <button id="ok-button" aria-required="click">ATUALIZAR</button>
                 <button id="ok-button" aria-required="click">EXCLUIR</button>
                </div>   
</form>

</div>
      <!--UNIDADE DE MEDIDA-->
      <form id="form3" class="limpar-campos" style="display: none;">
      <div class="titleRelatorio">
      <h1>Unidade de Medida</h1>
       </div>
        
          <div class="divTextForm1">
            <label for="name">Nova Medida</label>
            <input type="text" class="formaticTextRelatorio" id="name" placeholder="Insira a unidade de medida" required>
            <div class="iconeBuscar">
            <span class="icon"><i class="bi bi-search"></i>
            <input type="text" class="formaticTextRelatorio" id="search" placeholder="Buscar"></span>
          </div>
        </div>
          
        
          <div class="button-container">
                 <button id="ok-button" aria-required="click">CADASTRAR</button>
                 <button id="ok-button" aria-required="click">ATUALIZAR</button>
                 <button id="ok-button" aria-required="click">EXCLUIR</button>
                </div> 
      </form>
    <!--CATEGORIA-->
    <div class="col-md-10 ml-sm-auto">
      <form id="form4" class="limpar-campos" style="display: none;">
      <div class="titleRelatorio">
      <h1>Categoria</h1>
       </div>
        
          <div class="divTextForm1">
            <label for="name">Nova categoria</label>
            <input type="text" class="formaticTextRelatorio" id="name" placeholder="Insira a categoria" required>
         

            <div class="iconeBuscar">
            <span class="icon"><i class="bi bi-search"></i>
            <input type="text" class="formaticTextRelatorio" id="search" placeholder="Buscar"></span>
          </div>

        </div>
        <div class="button-container">
                 <button id="ok-button" aria-required="click">CADASTRAR</button>
                 <button id="ok-button" aria-required="click">ATUALIZAR</button>
                 <button id="ok-button" aria-required="click">EXCLUIR</button>
                </div> 
      </form>
    </div>

    <div id="custom-alert">
      <p><?php echo $username ?>, clique no item com o qual deseja trabalhar</p>
      <br>
      <a onclick="trocarFormulario('form1')"><button id="ok-button" aria-required="click">Produto</button></a>
      <a href="#" onclick="trocarFormulario('form2')"><button id="ok-button" aria-required="click">Pessoas</button></a>
      <a href="#" onclick="trocarFormulario('form3')"><button id="ok-button" aria-required="click">Medidas</button></a>
      <a href="#" onclick="trocarFormulario('form4')"><button id="ok-button" aria-required="click">Categorias</button></a>
    </div>

  <footer class="footer">
  <footer>    
  <p class="footer-text">SARS | UNICAMP | COTIL</p>
    <button class="btnRodape" onclick="abrirFormulario()">Contatar Desenvolvedor</button>

</footer>

  


</body>


<script>


  function trocarFormulario(id) {
    // ocultar todos os formulários
    var forms = document.getElementsByTagName("form");
    for (var i = 0; i < forms.length; i++) {
      forms[i].style.display = "none";
    }

    // exibir o formulário correto
    document.getElementById(id).style.display = "block";
  }

  $(document).ready(function () {
    var elementos = document.querySelectorAll('#ok-button');
    elementos.forEach(
      function(e){
        // Adiciona o evento de clique ao botão "OK"
    $(e).click(function () {
      // Exibe o conteúdo do site
      $('#site-content').css('display', 'block');
      // Oculta o alert personalizado
      $('#custom-alert').css('display', 'none');
    });

      }
    )
    
  });

    function limparCampos() {
        var forms = document.getElementsByClassName("limpar-campos");
        for (var i = 0; i < forms.length; i++) {
            forms[i].reset();
        }
    }
</script>

</html>




