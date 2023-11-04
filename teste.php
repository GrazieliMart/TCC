<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>teste</title>
</head>

<body>
    <div class="col-md-10 ml-sm-auto">
        <form id="form4" class="limpar-campos" method="post">
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
                        <button type="submit" name="cadCategoria" aria-required="click" class="search-button" onclick="performSearch(1)">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>

                    <?php
                    include("bd.php");
                    $pdo = conexaoBD();
                    $stmt = $pdo->prepare("select * from categoria");

                    try {
                        // Buscando dados
                        $stmt->execute();
                    ?>
                        <form method='post'>
                            <div class='table-overflow'>
                                <table id='myTable'>
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

                                <!-- JavaScript para edição de linha -->
                                <script>
                                    function editRow() {
                                        const table = document.getElementById('myTable');
                                        const radios = table.querySelectorAll('input[type="radio"]');
                                        let selectedRow = null;
                                        console.log(radios);

                                        radios.forEach((radio) => {
                                            if (radio.checked) {
                                                selectedRow = radio.parentNode.parentNode;
                                            }
                                        });

                                        if (selectedRow) {
                                            const cells = selectedRow.querySelectorAll('td');
                                            cells[1].innerHTML = '<input type="text" value="' + cells[1].innerText + '">';
                                            const saveCell = document.createElement('td');
                                            const saveButton = document.createElement('button');
                                            saveButton.textContent = 'Salvar';
                                            saveButton.setAttribute('type', 'button');
                                            saveButton.addEventListener('click', () => saveRow(selectedRow));
                                            saveCell.appendChild(saveButton);

                                            // Insira a nova célula na linha
                                            selectedRow.appendChild(saveCell);
                                        } else {
                                            alert('Selecione uma linha para editar.');
                                        }
                                    }

                                    function saveRow(selectedRow) {
                                        const cells = selectedRow.querySelectorAll('td');
                                        const id = selectedRow.querySelector('input[type="radio"]').value;
                                        const newName = cells[1].querySelector('input').value;
                                    
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
                                                    selectedRow.removeChild(cells[2]);
                                                    alert(response.message);
                                                    location.reload();
                                                } else {
                                                    alert(response.message);
                                                }
                                            },
                                            error: function() {
                                                alert('Erro na solicitação AJAX.');
                                            }
                                        });
                                    }

                                    function deleteRow() {
                                        const table = document.getElementById('myTable');
                                        const radios = table.querySelectorAll('input[type="radio"]');
                                        let selectedRow = null;
                                        console.log(radios);

                                        radios.forEach((radio) => {
                                            if (radio.checked) {
                                                selectedRow = radio.parentNode.parentNode;
                                            }
                                        });
                                        const id = selectedRow.querySelector('input[type="radio"]').value; // Obtenha o ID da linha
                                        
                                        console.log(id);
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
                                </script>
                            </div>
                        </form>


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

</html>