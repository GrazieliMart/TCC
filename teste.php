<!DOCTYPE html>
<html>
<head>
    <title>Editar Dados</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <table id="data-table">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
        </tr>
        <!-- Dados serão preenchidos dinamicamente aqui -->
    </table>

    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <span class="close" id="close-modal">&times;</span>
            <h2>Editar Dados</h2>
            <input type="text" id="new-name" placeholder="Novo Nome">
            <button id="save-changes">Salvar Alterações</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Editar Dados</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
<?php
          $pdo = conexaoBD();
          $stmt = $pdo->prepare("select * from unidadeMedida");

          try {
            //buscando dados
            $stmt->execute();
          ?>
    <table id="data-table">
        <tr>
            <th>ID</th>
            <th>Nome</th>
            <th>Ações</th>
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
        <!-- Dados serão preenchidos dinamicamente aqui -->
    </table>

    <div id="edit-modal" class="modal">
        <div class="modal-content">
            <span class="close" id="close-modal">&times;</span>
            <h2>Editar Dados</h2>
            <input type="text" id="new-name" placeholder="Novo Nome">
            <button id="save-changes">Salvar Alterações</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>
