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
  $logado = true;
}
// Verifica o nível de acesso do usuário e exibe os cards correspondente
include("bd.php");
?>
<!DOCTYPE html>
<html>

<head>
  <title>Estoque | AlmoxariSars</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style/styleteste7.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <link rel="icon" type="image/png" href="logo/1.png">
  <style>
    #ok-button {

      background-color: #fff;
      font-size: 13px;
      width: 100px;
      /* Reduzi a largura para ajustar melhor */
      cursor: pointer;
      color: #000000;
      border: none;
      margin-left: 5px;
      border-radius: 20px;
      padding: 6px;

      transition: .2s;
      box-shadow: 0px 2px 4px rgba(0, 174, 255, 0.3);

      font-weight: normal;
      text-align: center;

    }

    /* Estilos para a janela modal */
    .modal {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-content {
      background-color: lightsteelblue;
      width: 50%;
      max-width: 600px;
      margin: 100px auto;
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .table {
      width: 100%;
    }


    .close {
      float: right;
      cursor: pointer;
    }
  </style>
</head>

<body>
  <?php
  include 'menuLateral.php';
  ?>
  <div class="divRelatorio1">
    <div class="titleRelatorio">
      <h1>Estoque</h1>
    </div>
    <br>

    <div class="divTextRelatorio2">

      <form method="post">
        <input type="text" id="search" class="formaticTextRelatorio" placeholder="Pesquisar produto..." name="name">
        <input id="ok-button" type="submit" value="Consultar">
      </form>

      <?php

      buscarTeste(); ?>

      <div class="modal" id="edit-modal">
        <div class="modal-content">
          <h2>Editar Produto</h2>
          <form method="post" enctype="multipart/form-data">
            <input type="hidden" name="code" id="edit-code">
            <label for="edit-nome">Nome:</label>
            <input type="text" name="edit-nome" id="edit-nome"> <br>
            <label for="edit-category">Categoria:</label>
            <input type="text" name="edit-category" id="edit-category"> <br>
            <label for="edit-unidadeMedida">Unidade de Medida:</label>
            <input type="text" name="edit-unidadeMedida" id="edit-unidadeMedida"> <br>
            <label for="edit-quantidade">Quantidade:</label>
            <input type="text" name="edit-quantidade" id="edit-quantidade"> <br>
            <label for="editfoto">Foto</label>
            <img id="edit-foto" name="edit-foto" style="width: 50px; height:auto;" src=""><br>

            <input type="file" name="foto" id="foto">
            <br>
            <input type="submit" name="editar_produto" value="Salvar">
          </form>

        </div>
      </div>
      <?php
      if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $pdo = conexaoBD();

        $code = $_POST['code'];
        $nome = $_POST['edit-nome'];
        $category = $_POST['edit-category'];
        $unidadeMedida = $_POST['edit-unidadeMedida'];
        $quantidade = $_POST['edit-quantidade'];

        $uploaddir = 'upload/produtos/'; //diretorio ondde será gravado a foto

        //foto

        $foto = $_FILES['foto'];
        $nomeFoto = $foto['name'];
        $tipoFoto = $foto['type'];
        $tamanhoFoto = $foto['size'];

        //gerando novo nome para a foto
        $info = new SplFileInfo($nomeFoto);
        $extensaoArq = $info->getExtension();
        $novoNomeFoto = $nome . "." . $extensaoArq;

        if (($nomeFoto != "") && (move_uploaded_file($_FILES['foto']['tmp_name'], $uploaddir . $novoNomeFoto))) {
          $uploadfile = $uploaddir . $novoNomeFoto;


          $sql = "UPDATE produtoTCC SET nome = '$nome', category = '$category', unidadeMedida = '$unidadeMedida', quantidade = '$quantidade' , arquivoFoto = '$uploadfile' WHERE code = '$code'";
          $result = $pdo->query($sql);
        } else {

          $sql = "UPDATE produtoTCC SET nome = '$nome', category = '$category', unidadeMedida = '$unidadeMedida', quantidade = '$quantidade'  WHERE code = '$code'";
          $result = $pdo->query($sql);
        }
        if ($result) {
          echo "<script>alert('Produto editado com sucesso!');</script>";
        } else {
          echo "<script>alert('Erro ao editar produto!');</script>";
        }
      }
      ?>


    </div>


  </div>



  <footer class="footer">
    <footer>
      <p class="footer-text">SARS | UNICAMP | COTIL</p>
    </footer>
  </footer>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    const editButtons = document.querySelectorAll('.edit-button');
    const editModal = document.getElementById('edit-modal');
    const editCode = document.getElementById('edit-code');
    const editNome = document.getElementById('edit-nome');
    const editCategory = document.getElementById('edit-category');
    const editUnidadeMedida = document.getElementById('edit-unidadeMedida');
    const editQuantidade = document.getElementById('edit-quantidade');
    const editFoto = document.getElementById('edit-foto');

    editButtons.forEach(button => {
      button.addEventListener('click', () => {
        const productCode = button.getAttribute('data-product-code');

        // Realiza a solicitação AJAX para buscar os dados do produto
        $.ajax({
          url: 'buscar_dados_produto.php',
          type: 'GET',
          data: {
            code: productCode
          },
          dataType: 'json',
          success: function(data) {
            // Preenche os campos do modal com os dados do produto
            editCode.value = productCode;
            editNome.value = data.nome;
            editCategory.value = data.category;
            editUnidadeMedida.value = data.unidadeMedida;
            editQuantidade.value = data.quantidade;
            if (data.arquivoFoto !== null) {
              const fotoUrl = data.arquivoFoto;
              $('#edit-foto').attr('src', fotoUrl);
            } else {
              // Se não houver foto, exiba uma imagem padrão ou oculte a tag <img>
              $('#edit-foto').attr('src', 'upload/produtos/mela.jpeg ');
            }

            // Abre o modal
            editModal.style.display = 'block';
          },
          error: function() {
            alert('Erro ao buscar os dados do produto');
          }
        });
      });
    });

    // Fecha o modal ao clicar fora dele
    editModal.addEventListener('click', (event) => {
      if (event.target === editModal) {
        editModal.style.display = 'none';
      }
    });
  </script>
</body>

</html>