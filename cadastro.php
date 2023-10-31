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

  $level = $_SESSION['level'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Cadastro | AlmoxariSars</title>
  <link rel="icon" type="image/png" href="logo/1.png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style/styleteste7.css">
  <link rel="stylesheet" href="style/formsCadastro.css">

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
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
    <form id="form1" class="limpar-campos" style="display: none;" method="post" name="formProduto" enctype="multipart/form-data">
      <div class="titleRelatorio">
        <h1>Produto</h1>
      </div>
      <div class="divTextForm">
        <label for="nome">Nome</label>
        <input type="text" id="name" name="nome" placeholder="Digite seu nome" required class="formaticTextRelatorio">

        <label for="code">Código</label>
        <input type="code" id="code" name="code" placeholder="Digite seu código" required class="formaticTextRelatorio">
        <label for="category">Categoria</label>
        <select class="formaticRelatorio" id="category" required name="category">
          <option selected disabled>Selecione uma categoria</option>
          <?php
          include('bd.php');
          consultaCat();
          ?>
        </select>
        <label for="qnt">Quantidade</label>
        <input type="code" id="code" name="quantidade" placeholder="Digite a quantidade" required class="formaticTextRelatorio">

        <label for="unidadeMedida">Unidade de Medida</label>
        <select class="formaticRelatorio" id="unit" required name="unidadeMedida">
          <option selected disabled>Selecione uma unidade de medida</option>

          <?php

          consultaUnid();
          ?>
        </select>
        <label for="formFile">Insira a imagem referente</label>
        <input type="file" name="arquivoFoto" id="arquivoFoto" accept="image/*" required>
      </div>
      <div class="button-container">
      
        <input id="ok-button" name="cadProduto" aria-required="click" type="submit" value="Cadastrar"></input>
        
      </div>
    </form>
  </div>
  <!--USUÁRIO -->
  <div class="col-md-10 ml-sm-auto">

    <form id="form2" method="post" class="limpar-campos" style="display: none;">
      <div class="titleRelatorio">
        <h1>Usuário</h1>
      </div>
      <div class="form-row">
        <div class="divTextForm">
          <label for="name">Nome</label>
          <input type="text" class="formaticTextRelatorio" id="name" name="name" placeholder="Insira o nome" required>


          <label for="code">Código de funcionário</label>
          <input type="text"  class="formaticTextRelatorio" id="code" name="code" placeholder="Insira o código" required>

          <label for="unit">Tipo de usuário</label>
          <select class="formaticRelatorio" id="level" name="level" required>
            <option selected disabled>Selecione o tipo de usuário</option>
            <option value="3">Adm</option>
            <option value="2">nível 2</option>
            <option value="1">nível 1</option>

          </select>

          <label for="senha">Senha</label>
          <input class="formaticTextRelatorio" id="senha" name="senha" placeholder="Insira a senha" type="password">

        </div>
        <div class="button-container">
          <input id="ok-button" name="cadUsuario" type="submit" aria-required="click" value="CADASTRAR"></input>

        </div>
    </form>

  </div>
  <!--UNIDADE DE MEDIDA-->
  <form id="form3" class="limpar-campos" method="post" style="display: none;">
    <div class="titleRelatorio">
      <h1>Unidade de Medida</h1>
    </div>

    <div class="divTextForm">
      <label for="name">Nova Medida</label>

      <input type="text" class="formaticTextRelatorio" id="name" name="name" placeholder="Insira a unidade de medida" required>
      <input id="ok-button" name="cadUnid" type="submit" aria-required="click" value="CADASTRAR"></input>

        <span class="icon"><i class="bi bi-search"></i></span>
          <input type="text" class="formaticTextRelatorio" id="search" placeholder="Buscar">
      
      <input id="ok-button" name="cadUnid" type="submit" aria-required="click" value="CADASTRAR"></input>
    </div>


  

   
  </form>
  <!--CATEGORIA-->
  <div class="col-md-10 ml-sm-auto">
    <form id="form4" class="limpar-campos" method="post" style="display: none;">
      <div class="titleRelatorio">
        <h1>Categoria</h1>
      </div>

      <div class="divTextForm">
        <label for="name">Nova categoria</label>
        <input type="text" class="formaticTextRelatorio" id="name" name="name" placeholder="Insira a categoria" required>


        <div class="iconeBuscar">
          <span class="icon"><i class="bi bi-search"></i>
            <input type="text" class="formaticTextRelatorio" id="search" placeholder="Buscar"></span>
        </div>

      </div>
      <div class="button-container">
        <input id="ok-button" name="cadCat" type="submit" aria-required="click" value="CADASTRAR"></input>

      </div>
    </form>

  </div>

  <div id="custom-alert">
    <p><?php echo $username ?>, clique no item com o qual deseja trabalhar</p>
    <br>
    <a onclick="trocarFormulario('form1')"><button id="ok-button" aria-required="click">Produtos</button></a>
    <a onclick="trocarFormulario('form2')"><button id="ok-button" aria-required="click">Usuários</button></a>
    <a onclick="trocarFormulario('form3')"><button id="ok-button" aria-required="click">Medidas</button></a>
    <a onclick="trocarFormulario('form4')"><button id="ok-button" aria-required="click">Categorias</button></a>
  </div>

  <footer class="footer">
    <footer>
      <p class="footer-text">SARS | UNICAMP | COTIL</p>

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

  $(document).ready(function() {
    var elementos = document.querySelectorAll('#ok-button');
    elementos.forEach(
      function(e) {
        // Adiciona o evento de clique ao botão "OK"
        $(e).click(function() {
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



<?php

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cadUsuario'])) {

  $name = $_POST['name'];
  $code = $_POST["code"];
  $level = $_POST['level'];
  $senha = $_POST['senha'];
  cadUsuario($name, $code, $level, $senha);
} else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cadCat'])) {
  $name = $_POST['name'];
  cadCat($name);
} else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cadUnid'])) {
  $name = $_POST['name'];
  echo $name;
  cadUnid($name);
} else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cadProduto'])) {
  $foto = isset($_FILES['arquivoFoto']) ? $_FILES['arquivoFoto'] : null;
  cadProd($foto);
}
?>