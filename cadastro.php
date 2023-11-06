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
  <meta name="viewport" content="width=device-width, initial-scale=1">
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
    <?php if ($level == 2) { ?>.divButtonsCadastro {
      justify-content: center;
    }

    <?php } ?>.modal {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: lightblue;
      width: 80%;
      max-width: 600px;
      margin: 100px auto;
      padding: 20px;
      border: 1px solid #000;
      border-radius: 5px;
    }

    .close {
      float: right;
      font-size: 30px;
      cursor: pointer;
    }

    #openModalBtn {
      background-color: #1D79A1;
      font-size: 12px;
      width: 100px px;
      height: 30px;
      cursor: pointer;
      color: #ffffff;
      border: none;
      border-radius: 2px;
      padding: 6px;
      transition: .2s;
      box-shadow: 0px 2px 4px rgba(0, 174, 255, 0.3);
      font-weight: normal;
      text-align: center;
    }
  </style>
</head>

<body>
  <?php
  include 'menuLateral.php';
  include('bd.php');
  ?>
  <?php if ($level == 3) { ?>
    <div class="col-md-10 ml-sm-auto">

      <form id="form1" style="display: none;" method="post" name="formProduto" enctype="multipart/form-data">
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

          <input id="ok-button1" name="cadProduto" aria-required="click" type="submit" value="Cadastrar"></input>
          <br>
          <a href="cadastro.php" class="linkVoltar">Voltar</a>
        </div>

      </form>

    </div>
  <?php } ?>
  <?php
  if ($level == 3) {
  ?>
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



            <button type="button" id="openModalBtn">Abrir Tabela</button>
            <br>
            <div id="myModal" class="modal">
              <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Usuários</h2>
                <input type="text" class="formaticTextRelatorio" id="search" placeholder="Buscar" style='width: 84%;'>
                <button type="button" name="cadCategoria" aria-required="click" class="search-button" onclick="performSearch(0)">
                  <i class="fa fa-search"></i>
                </button>


                <?php

                $pdo = conexaoBD();
                $stmt = $pdo->prepare("select * from login");

                try {
                  //buscando dados
                  $stmt->execute();
                ?>
                  <form method='post'>
                    <div class='table-overflow'>
                      <table class='myTable'>
                        <tr>
                          <th></th>

                          <th>Nome</th>


                        </tr>
                      <?php
                      while ($row = $stmt->fetch()) {

                        echo "<tr>";
                        echo "<td><input type='radio' name='raAluno' 
                            value='" . $row['id'] . "'>";
                        echo "<td>" . $row['usuario'] . "</td>";
                        echo "</tr>";
                      }
                      echo "</table><br>";


                      echo "<button class='btn-delete' type='button' onclick='deleteRow()'><i class='w-100 bi bi-trash3-fill'></i></button>";


                      echo "</form>";
                      echo '</div>';
                    } catch (PDOException $e) {
                      echo 'Error: ' . $e->getMessage();
                    }

                    $pdo = null;


                      ?>

                    </div>
              </div>

              <a href="cadastro.php" class="linkVoltar">Voltar</a>
            </div>

      </form>

    </div>
  <?php } ?>

  <!--UNIDADE DE MEDIDA-->

  <div class="col-md-10 ml-sm-auto">
    <form id="form3" class="limpar-campos" method="post" style="display: none;">
      <div class="titleRelatorio">
        <h1>Unidade de Medida</h1>
      </div>
      <div class="divTextForm2">
        <div class="MedDiv">
          <label for="name">Nova Medida</label>
          <input type="text" class="formaticTextRelatorioUnidade" id="name" name="name" placeholder="Insira a unidade de medida" required>
          <input class="ok-button-medida" id="ok-button1" name="cadUnid" type="submit" aria-required="click" value="CADASTRAR"></input>
        </div>
        <div class="BuscarDiv">
          <div class="search-container">

            <input type="text" class="formaticTextRelatorio" id="search" placeholder="Buscar">
            <button type="button" name="cadCategoria" aria-required="click" class="search-button" onclick="performSearch(1)">
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
                <table class='myTable'>
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
                echo '<div class="buttonsCadastro">';
                echo "<button class='btn-delete' type='button' onclick='deleteRow()'><i class='w-100 bi bi-trash3-fill'></i></button>";
                echo "<button class='edit-button' type='button' onclick='editRow()'><i class='bi bi-pencil-square'></i></button>";
                echo '</div>';
                echo "</form>";
              } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
              }

              $pdo = null;


                ?>
              </div>
              <div class="button-container3">
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
          <input id="ok-button1" name="cadCat" type="submit" aria-required="click" value="CADASTRAR"></input>
        </div>
        <div class="BuscarDiv">
          <div class="search-container">
            <input type="text" class="formaticTextRelatorio" id="search" placeholder="Buscar">
            <button type="button" name="cadCategoria" aria-required="click" class="search-button" onclick="performSearch(2)">
              <i class="fa fa-search"></i>
            </button>
          </div>
          <?php

          $pdo = conexaoBD();
          $stmt = $pdo->prepare("select * from categoria");

          try {
            // Buscando dados
            $stmt->execute();
          ?>
            <form method='post'>
              <div class='table-overflow'>
                <table class='myTable'>
                  <tr>
                    <th></th>
                    <th>Nome</th>
                  </tr>
                <?php
                while ($row = $stmt->fetch()) {
                  echo "<tr>";
                  echo "<td><input type='radio' name='raAluno' value='" . $row['id'] . "'>";
                  echo "<td>" . $row['name'] . "</td>";
                  echo "</tr>";
                }
                echo '</table><br>';
                echo '</div>';
                echo '<div class="buttonsCadastro">';
                echo "<button class='btn-delete' type='button' onclick='deleteRow()'><i class='w-100 bi bi-trash3-fill'></i></button>";

                // Adicionar um botão "Editar" que acionará a edição
                echo "<button class='edit-button' type='button' onclick='editRow()'><i class='bi bi-pencil-square'></i></button>";

                echo '</div>';
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
    <div class="divTitleCadastro">
      <p><?php echo $username ?>, clique no item com o qual deseja trabalhar</p>
    </div>
    <br>
    <div class="divButtonsCadastro">
      <?php
      if ($level == 3) {
      ?>
        <div class="divSeparador">
          <a onclick="trocarFormulario('form1')"><button id="ok-button" aria-required="click"><i class="bi bi-bag-plus"></i><br>Produtos</button></a>
          <a onclick="trocarFormulario('form2')"><button id="ok-button" aria-required="click"><i class="bi bi-person-add"></i><br>Usuários</button></a>
        </div>
      <?php } ?>
      <div class="divSeparador2">
        <a onclick="trocarFormulario('form3')"><button id="ok-button" aria-required="click"><i class="bi bi-rulers"></i><br>Medidas</button></a>
        <a onclick="trocarFormulario('form4')"><button id="ok-button" aria-required="click"><i class="bi bi-grid"></i>Categorias</button></a>
      </div>
    </div>
  </div>

  <footer class="footer">
    <footer>
      <p class="footer-text">SARS | UNICAMP | COTIL</p>

    </footer>



    <script>
      $(document).ready(function() {
        // Abrir a modal quando o botão for clicado
        $("#openModalBtn").click(function() {
          $("#myModal").css("display", "block");


        });

        // Fechar a modal quando o "x" for clicado
        $(".close").click(function() {
          $("#myModal").css("display", "none");
        });

        // Fechar a modal quando clicar fora da modal
        $(window).click(function(e) {
          if (e.target == document.getElementById("myModal")) {
            $("#myModal").css("display", "none");
          }
        });
      });


      function editRow() {
        const tables = document.querySelectorAll('.myTable');
        let selectedRow = null;
        let selectedTable = null;
        tables.forEach((table, index) => {

          const radios = table.querySelectorAll('input[type="radio"]');

          radios.forEach((radio) => {

            if (radio.checked) {
              selectedTable = index;
              selectedRow = radio.parentNode.parentNode;
            }
          });
        });

        if (selectedRow) {
          const cells = selectedRow.querySelectorAll('td');
          cells[1].innerHTML = '<input type="text" value="' + cells[1].innerText + '">';
          const saveCell = document.createElement('td');
          const saveButton = document.createElement('button');
          saveButton.textContent = 'Salvar';
          saveButton.setAttribute('type', 'button');
          saveButton.addEventListener('click', () => saveRow(selectedRow, selectedTable));
          saveCell.appendChild(saveButton);

          // Insira a nova célula na linha
          selectedRow.appendChild(saveCell);
        } else {
          alert('Selecione uma linha para editar.');
        }
      }

      function saveRow(selectedRow, selectedTable) {
        const cells = selectedRow.querySelectorAll('td');
        const id = selectedRow.querySelector('input[type="radio"]').value;
        const newName = cells[1].querySelector('input').value;
        console.log(id, newName);
        if (selectedTable == 2) {
          $.ajax({
            url: 'atualizar_categoria.php', // Substitua pelo URL do seu script PHP de atualização
            type: 'POST',
            dataType: 'json',
            data: {
              id: id,
              newName: newName
            },
            success: function(response) {
              console.log(response);
              if (response.success) {
                cells[1].innerHTML = newName;
                selectedRow.querySelector('input[type="radio"]').checked = false;
                selectedRow.removeChild(cells[2]);
                alert(response.message);
              } else {
                alert(response.message);
              }
            },
            error: function() {
              alert('Erro na solicitação AJAX.');
            }
          });
        } else {
          $.ajax({
            url: 'atualizar_unidade.php', // Substitua pelo URL do seu script PHP de atualização
            type: 'POST',
            dataType: 'json',
            data: {
              id: id,
              newName: newName
            },
            success: function(response) {
              console.log(response);
              if (response.success) {
                cells[1].innerHTML = newName;
                selectedRow.querySelector('input[type="radio"]').checked = false;
                selectedRow.removeChild(cells[2]);
                alert(response.message);
              } else {
                alert(response.message);
              }
            },
            error: function() {
              alert('Erro na solicitação AJAX.');
            }
          });
        }
      }

      function deleteRow() {
        const tables = document.querySelectorAll('.myTable');
        let selectedRow = null;
        let selectedTable = null;
        tables.forEach((table, index) => {

          const radios = table.querySelectorAll('input[type="radio"]');

          radios.forEach((radio) => {

            if (radio.checked) {
              console.log(index)
              selectedTable = index;
              selectedRow = radio.parentNode.parentNode;
            }
          });
        });
        const id = selectedRow.querySelector('input[type="radio"]').value;
        if (selectedTable == 2) {

          $.ajax({
            url: 'excluir_categoria.php', // Substitua pelo URL do seu script de exclusão
            type: 'POST',
            dataType: 'json',
            data: {
              id: id
            },
            success: function(response) {
              if (response.success) {
                // Remova a linha da tabela
                selectedRow.remove();
                alert(response.message);
              } else {
                alert(response.message);
              }
            },
            error: function() {
              alert('Erro na solicitação AJAX.');
            }
          });
        }
        if (selectedTable == 1) {
          $.ajax({
              url: 'excluir_unidade.php', // Substitua pelo URL do seu script de exclusão
              type: 'POST',
              dataType: 'json',
              data: {
                id: id
              },
              success: function(response) {
                if (response.success) {
                  // Remova a linha da tabela
                  selectedRow.remove();
                  alert(response.message);
                } else {
                  alert(response.message);
                }
              },
              error: function() {
                alert('Erro na solicitação AJAX.');
              }
            }

          );

        }
        if (selectedTable == 0) {
          $.ajax({
            url: 'excluir_usuario.php', // Substitua pelo URL do seu script de exclusão
            type: 'POST',
            dataType: 'json',
            data: {
              id: id
            },
            success: function(response) {
              if (response.success) {
                // Remova a linha da tabela
                selectedRow.remove();
                alert(response.message);
              } else {
                alert(response.message);
              }
            },
            error: function() {
              alert('Erro na solicitação AJAX.');
            }
          });
        }
      }
    </script>
    </div>
    </form>


    <script>
      function performSearch(i) {
        const tableRows = document.querySelectorAll(".myTable tr");
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
    </script>




</body>

<script>
  $(".ok-button-medida").click(function() {
    console.log("clicou");
    $("#form3").location.reload();
  });

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
  //echo "fon";

  cadProd($foto);
}
?>