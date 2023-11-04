<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            background-color: #fff;
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
    </style>
    <title>Document</title>
</head>

<body>
    <button id="openModalBtn">Abrir Tabela</button>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Tabela do Banco de Dados</h2>
            <input type="text" class="formaticTextRelatorio" id="search" placeholder="Buscar">
            <button type="button" name="cadCategoria" aria-required="click" class="search-button" onclick="performSearch(0)">
              <i class="fa fa-search"></i>
            </button>
          

                <?php
                include("bd.php");
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

</html>