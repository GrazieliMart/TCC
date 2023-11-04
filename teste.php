<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Document</title>
</head>

<body>

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
                echo '</div>';
                echo '<div class="buttonsCadastro">';
                echo "<button class='btn-delete' type='button' onclick='deleteRow()'><i class='w-100 bi bi-trash3-fill'></i></button>";

                echo '</div>';
                echo "</form>";
            } catch (PDOException $e) {
                echo 'Error: ' . $e->getMessage();
            }

            $pdo = null;


                ?>
                <script>
                    function deleteRow(){
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

                  if(selectedTable==0){
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

</body>

</html>