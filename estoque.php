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
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Estoque | AlmoxariSars</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <link rel="stylesheet" href="style/styleteste7.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <link rel="icon" type="image/png" href="logo/1.png">
  <style>
    #ok-button {


      font-size: 13px;

      background: transparent;
      cursor: pointer;
      color: #fff;
      border: none;
      margin-left: 5px;
      border-radius: 20px;
      padding: 6px;
      color: #fff;
      transition: .2s;
      font-weight: normal;
      text-align: center;

    }

    #ok-button:hover {
      transition: 0.2s;
      color: rgb(0, 112, 216);
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
      margin: 5px auto;
     
      padding: 20px;
      border-radius: 5px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }
    .modal-content input {
  width: 100%;
  
 
  border: none;
  background: #fff; 
  border-radius: 5px; 
}
.modal-content label {
  display: block;
  margin-left: 0;
}
.modal-content input[type="submit"] {
    background-color: #03638C;
    border: none;
    border-radius: 20px;
    margin-top:10px;
    padding: 6px 12px;
    color: #fff;
    font-size: 13px;
    font-weight: normal;
    cursor: pointer;
}

.modal-content input[type="submit"]:hover {
    background-color: #1D79A1;
    transition: 0.2s;
}
.tituloClose{
  flex-direction: row;
  display: flex;
}
    .table {
      width: 100%;
    }

    .edit-button {
      background-color: transparent;
      border: none;

    }

    .btn-delete {
      background-color: transparent;
      border: none;
    }


    .close {
      float: right;
      cursor: pointer;
    }

    .table-responsive {
    overflow-x: auto;
}

/* Opcional: Para melhorar a aparência, você pode ocultar a barra de rolagem horizontal até que haja rolagem */
.table-responsive::-webkit-scrollbar {
    width: 0.25rem;
    height: 0.25rem;
    visibility: hidden;
}.close {
    background-color: #03638C;
    border: none;
    border-radius: 20px;
    margin-top: 10px;
    padding: 6px 12px;
    color: #fff;
    font-size: 13px;
    margin-left: 130px;
    width: 50px;
    font-weight: normal;
    cursor: pointer;
}
.table-responsive::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0);
}

.table-responsive:hover::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.2);
}

.table-responsive::-webkit-scrollbar-thumb:hover {
    background: rgba(0, 0, 0, 0.3);
}

@media (max-width: 600px) {
.modal-content {
   
    width: 100%; 
   
}
}
  </style>
</head>

<body>
  <?php
  include 'menuLateral1.php';
  ?>

<footer class="footer">
   
   <p class="footer-text">
   <a href="https://www.sar.unicamp.br/" style="color: white; text-decoration: none;">SARS</a> | 
   <a href="https://www.unicamp.br/unicamp/" style="color: white; text-decoration: none;">UNICAMP</a> | 
   <a href="https://www.cotil.unicamp.br/" style="color: white; text-decoration: none;">COTIL</a>
   
 </p>
 <p>Copyright © 2023 AlmoxariSars</p>

      
 
     </footer>
 
 
  <div class="divRelatorio1">
    <div class="titleRelatorio">
      <h1>Estoque</h1>
    </div>
    <br>

    <div class="divTextRelatorio3">

      <form method="post">
        <div class="BuscarDiv">
          <div class="search-container">


            <input type="text" id="search" class="formaticTextRelatorioEstoque" placeholder="Pesquisar produto..." name="name" required>
            <button id="ok-button" type="submit" name="cadCategoria" aria-required="click" class="search-button">
              <i class="fa fa-search"></i>
            </button>

          </div>
        </div>

        <!-- <input id="ok-button" type="submit" value="Consultar">-->


      </form>

      <?php

      buscarTeste(); ?>

      <div class="modal" id="edit-modal">
        <div class="modal-content">
       <div class="tituloClose">
          <h2>Editar Produto</h2> 
          <button type="button" class="close" id data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button></div>
          <form id="edit" method="post" enctype="multipart/form-data">
            <input type="hidden" name="code" id="edit-code">
            <label for="edit-nome">Nome:</label>
            <input type="text" name="edit-nome" id="edit-nome"> <br>
            <label for="edit-category">Categoria:</label>
            <select name="edit-category" id="edit-category">
              <?php
              consultaCat();
              ?>
            </select>
            <label for="edit-unidadeMedida">Unidade de Medida:</label>
            <select name="edit-unidadeMedida" id="edit-unidadeMedida">
              <?php
              consultaUnid();
              ?>
            </select>
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


    </div>


  </div>



  

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
            console.log(data);
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

    $('#edit').submit(function(e) {
      e.preventDefault(); // Evita o envio tradicional do formulário

      const formData = new FormData(this);

      // Realiza a solicitação AJAX para atualizar os dados do produto
      $.ajax({
        url: 'atualizar_produto.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        dataType: 'json',
        success: function(data) {
          if (data.success) {
            // Atualize a tabela com os dados atualizados
            const productCode = editCode.value;
            const updatedNome = editNome.value;
            const updatedCategory = editCategory.value;
            const updatedUnidadeMedida = editUnidadeMedida.value;
            const updatedQuantidade = editQuantidade.value;

            // Atualize a linha da tabela com os novos dados
            const $table = $('#tabela');
            const $row = $table.find(`tr[data-product-code="${productCode}"]`);

            if ($row.length > 0) {
              $row.find('td:eq(0)').text(updatedNome);
              $row.find('td:eq(1)').text(updatedCategory);
              $row.find('td:eq(2)').text(updatedUnidadeMedida);
              $row.find('td:eq(3)').text(updatedQuantidade);
            }

            alert('Produto editado com sucesso!');
            editModal.style.display = 'none';
            location.reload(); // Recarregue a página ou atualize a tabela de forma mais eficiente
          } else {

            alert('Erro ao editar produto!');
          }
        },
        error: function() {
          alert('Erro ao editar produto!');
        }
      });
    });
  </script>
  <script>
        $(document).ready(function() {
            $(".close").click(function() {
                $("#myModal").modal('hide');
            });
        });
    </script>
</body>

</html>