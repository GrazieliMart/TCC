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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


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
        <br>
        <a href="cadastro.php" class="linkVoltar">Voltar</a>
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
        <div class="divTextForm1">
          <label for="name">Nome</label>
          <input type="text" class="formaticTextRelatorio" id="name" name="name" placeholder="Insira o nome" required>


          <label for="code">Código de funcionário</label>
          <input type="text" class="formaticTextRelatorio" id="code" name="code" placeholder="Insira o código" required>

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
        <div class="button-container1">
          <input id="ok-button1" name="cadUsuario" type="submit" aria-required="click" value="CADASTRAR"></input>
          <br>
          <a href="cadastro.php" class="linkVoltar">Voltar</a>
        </div>
    </form>

  </div>
  <!--UNIDADE DE MEDIDA-->

  <div class="col-md-10 ml-sm-auto">
    <form id="form3" class="limpar-campos" method="post" style="display: none;">
      <div class="titleRelatorio">
        <h1>Unidade de Medida</h1>
      </div>
      <div class="divTextForm2">
        <div class="MedDiv">
          <label for="name">Nova Medida</label>
          <input type="text" class="formaticTextRelatorio" id="name" name="name" placeholder="Insira a unidade de medida" required>
          <input id="ok-button" name="cadUnid" type="submit" aria-required="click" value="CADASTRAR"></input>
        </div>
        <div class="BuscarDiv">
          <div class="search-container">
            <input type="text" class="formaticTextRelatorio" id="search" placeholder="Buscar">
            <button type="button" name="cadCategoria" aria-required="click" class="search-button" onclick="performSearch(0)">
              <i class="fa fa-search"></i>
            </button>

          </div>
          <?php
          $pdo = conexaoBD();
          $stmt = $pdo->prepare("select * from unidadeMedida");

          try {
            //buscando dados
            $stmt->execute();
          ?>
            <form method='post'>
              <div class='table-overflow'>
                <table id='myTable' border='1px'>
                  <tr>
                    <th></th>

                    <th>Nome</th>

                  </tr>
                <?php
                while ($row = $stmt->fetch()) {

                  echo "<tr>";
                  echo "<td><input type='radio' name='raAluno' 
                            value='" . $row['id'] . "'>";
                  echo "<td>" . $row['name'] . "</td>";
                  echo "</tr>";
                }
                echo "</table><br>";
                echo '</div>';

                echo "<button type='submit' formaction='remove.php'>Excluir</button>";
                echo "<button type='submit' formaction='edicao.php'>Editar</button>";
                echo "</form>";
              } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
              }

              $pdo = null;


                ?>
              </div>
              <div class="button-container2">
                <a href="cadastro.php" class="linkVoltar">Voltar</a>
              </div>
        </div>
    </form>
  </div>

  <!--CATEGORIA-->
  <div class="col-md-10 ml-sm-auto">
    <form id="form4" class="limpar-campos" method="post" style="display: none;">
      <div class="titleRelatorio">
        <h1>Categoria</h1>
      </div>
      <div class="divTextForm">
        <div class="MedDiv">
          <label for="name">Nova Categoria</label>
          <input type="text" class="formaticTextRelatorio" id="name" name="name" placeholder="Insira a categoria" required>
          <input id="ok-button2" name="cadCatehoria" type="submit" aria-required="click" value="CADASTRAR"></input>
        </div>
        <div class="BuscarDiv">
          <div class="search-container">
            <input type="text" class="formaticTextRelatorio" id="search" placeholder="Buscar">
            <button type="submit" name="cadCategoria" aria-required="click" class="search-button" onclick="performSearch(1)">
              <i class="fa fa-search"></i>
            </button>
          </div>
          <?php
          $pdo = conexaoBD();
          $stmt = $pdo->prepare("select * from categoria");
  
          try {
            //buscando dados
            $stmt->execute();
          ?>
            <form method='post'>
              <div class='table-overflow'>
                <table id='myTable' border='1px'>
                  <tr>
                    <th></th>
  
                    <th>Nome</th>
  
                  </tr>
                <?php
                while ($row = $stmt->fetch()) {
  
                  echo "<tr>";
                  echo "<td><input type='radio' name='raAluno' 
                              value='" . $row['id'] . "'>";
  
                  echo "<td>" . $row['name'] . "</td>";
                  echo "</tr>";
                }
  
                echo "</table><br>";
                echo '</div>';
  
                echo "<button type='submit' formaction='remove.php'>Excluir</button>";
                echo "<button type='submit' formaction='edicao.php'>Editar</button>";
                echo "</form>";
              } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
              }
  
              $pdo = null;
  
  
                ?>
  
          
  
              </div>
              <div class="button-container2">
                <a href="cadastro.php" class="linkVoltar">Voltar</a>
              </div>
      </div>
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




    <script>
      function performSearch(i) {
        const tableRows = document.querySelectorAll("#myTable tr");
        console.log(tableRows);

        const search = document.querySelectorAll("#search");
        const query = search[i].value.toLowerCase();

        tableRows.forEach(row => {
          const name = row.textContent.toLowerCase();

          if (name.includes(query)) {
            row.style.display = "table-row";
          } else {
            row.style.display = "none";
          }
        });
      }

      function removeItem() {
        // Adicione sua lógica para remover o aluno aqui
      }

      function editItem() {
        // Adicione sua lógica para editar o aluno aqui
      }
    </script>


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

  cadUnid($name);
} else if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['cadProduto'])) {
  $foto = isset($_FILES['arquivoFoto']) ? $_FILES['arquivoFoto'] : null;
  cadProd($foto);
}
?>