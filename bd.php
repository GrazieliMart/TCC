<?php
function conexaoBd()
{
    try {
        // conexão PDO    // IP, nomeBD, usuario, senha   
        $db = 'mysql:host=143.106.241.3;dbname=cl201272;charset=utf8';
        $user = 'cl201272';
        $passwd = 'cl*26082005';
        $pdo = new PDO($db, $user, $passwd);

        // ativar o depurador de erros para gerar exceptions em caso de erros
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        $output = 'Impossível conectar BD : ' . $e . '<br>';
        echo $output;
    }
    return $pdo;
}
function login()
{
    session_start();
    try {
        $pdo = conexaoBd();

        if (isset($_POST['submit'])) {
            $usuario = $_POST['username'];
            $senha_inserida = $_POST['password'];

            // Consulta para obter o hash da senha e o username armazenados no banco de dados
            $stmt = $pdo->prepare("SELECT usuario, level, senha_hash FROM login WHERE usuario = :usuario");
            $stmt->bindParam(':usuario', $usuario, PDO::PARAM_STR);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // Verificar se a senha inserida corresponde ao hash armazenado
                if (password_verify($senha_inserida, $result['senha_hash'])) {
                    // Credenciais válidas
                    $_SESSION['level'] = $result["level"];
                    $_SESSION['username'] = $result["usuario"];

                    header("Location: index.php");
                    exit();
                } else {
                    // Credenciais inválidas (senha incorreta)
                    echo ' <div id="error-message">';
                    echo "<span style='color: white;'>Senha incorreta!</span>";
                }
            } else {
                // Usuário não encontrado
                echo "<span style='color: white;'>Usuário não encontrado!</span>";
            }
        }
    } catch (PDOException $e) {
        // Tratar qualquer erro de conexão com o banco de dados
        echo "Erro de banco de dados: " . $e->getMessage();
    }

    $pdo = null;
}
function buscarLogin($code, $pdo)
{

    $stmt = $pdo->prepare("select * from login where id = :code");
    $stmt->bindParam(':id', $code);
    $stmt->execute();
    $rows = $stmt->rowCount();
    return $rows;
}
function cadPedido($codigo,$cliente,$observacoes,$dataPedido)
{
    $pdo = conexaoBd();
    try {
        if (isset($_POST['cadPedido'])) {
            $codigo = isset($_POST['codigo']) ? $_POST['codigo'] : "";
            $cliente = isset($_POST['cliente']) ? $_POST['cliente'] : "";
            $observacoes = isset($_POST['observacoes']) ? $_POST['observacoes'] : "";
            $dataPedido = isset($_POST['dataPedido']) ? $_POST['dataPedido'] : "";

            $stmt = $pdo->prepare("INSERT INTO testePedidos (codigo, cliente, observacoes, dataPedido)
                                   VALUES (:codigo, :cliente, :observacoes, :dataPedido)");

            $stmt->bindParam(':codigo', $codigo);
            $stmt->bindParam(':cliente', $cliente);
            $stmt->bindParam(':observacoes', $observacoes);
            $stmt->bindParam(':dataPedido', $dataPedido);

            if ($stmt->execute()) {
                echo '<script>Swal.fire("Sucesso", "Pedido Efetuado!", "success");</script>';
            } else {
                echo '<script>Swal.fire("Erro", "Tente Novamente!", "error");</script>';
            }
        }
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        echo '<script>Swal.fire("Erro", "Erro: ' . $ex->getMessage() . '", "error");</script>';
    }
}

function cadProd($foto)
{
    $pdo = conexaoBd();
    try {

        $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
        $code = isset($_POST['code']) ? (int) $_POST['code'] : 0;
        $category = isset($_POST['category']) ? $_POST['category'] : 0;
        $unidadeMedida = isset($_POST['unidadeMedida']) ? $_POST['unidadeMedida'] : 0;
        $quantidade = isset($_POST['quantidade']) ? (int) $_POST['quantidade'] : 0;

        $uploadDir = 'upload/produtos/';
        $uploadfile = "";




        if ($foto === null || $foto['error'] !== UPLOAD_ERR_OK) {
            echo '<script>Swal.fire("Erro", "Erro no upload da imagem.", "error");</script>';
        } else if (!preg_match('/^image\/(jpeg|png|gif)$/', $foto['type'])) {
            echo '<script>Swal.fire("Erro", "Isso não é uma imagem válida.", "error");</script>';
        } else {
            $stmt = $pdo->prepare("SELECT * FROM produtoTCC WHERE nome = :nome");
            $stmt->bindParam(':nome', $nome);
            $stmt->execute();

            $rows = $stmt->rowCount();

            if ($rows <= 0) {
                $novoNomeFoto = substr($foto['name'], 0, 4) . "." . pathinfo($foto['name'], PATHINFO_EXTENSION);

                if (move_uploaded_file($foto['tmp_name'], $uploadDir . $novoNomeFoto)) {
                    $uploadfile = $uploadDir . $novoNomeFoto;
                } else {
                    $uploadfile = "";
                }

                $stmt = $pdo->prepare("INSERT INTO produtoTCC (nome, code, category, unidadeMedida, arquivoFoto, quantidade) VALUES (:nome, :code, :category, :unidadeMedida, :arquivoFoto, :quantidade)");

                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':code', $code);
                $stmt->bindParam(':category', $category);
                $stmt->bindParam(':unidadeMedida', $unidadeMedida);

                $stmt->bindParam(':arquivoFoto', $uploadfile);


                $stmt->bindParam(':quantidade', $quantidade);

                $stmt->execute();

                echo '<script>Swal.fire("Sucesso", "Produto cadastrado!", "success");</script>';
            } else if ($rows > 0) {
                echo '<script>Swal.fire("Erro", "Produto já existe.", "error");</script>';
            }
        }
    } catch (PDOException $ex) {
        echo $ex->getMessage();
        echo '<script>Swal.fire("Erro", "Erro: ' . $ex->getMessage() . '", "error");</script>';
    }
}
function cadUsuario($name, $code, $level, $senha,$email)
{
    $pdo = conexaoBd();

    if (empty($name) || empty($code) || empty($level) || empty($senha)) {
        die("Por favor, preencha todos os campos.");
    }

    // Verificar se o usuário já existe
    $check_user_query = "SELECT id FROM login WHERE usuario = :username";
    $stmt = $pdo->prepare($check_user_query);
    $stmt->bindParam(":username", $name);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        die("O nome de usuário já está em uso. Escolha outro.");
    }

    // Hash da senha
    $hashed_password = password_hash($senha, PASSWORD_BCRYPT);

    // Inserir usuário no banco de dados usando uma consulta preparada
    $insert_query = "INSERT INTO login (usuario, level, senha_hash, email) VALUES (:username, :level, :password_hash, :email)";
    $stmt = $pdo->prepare($insert_query);
    $stmt->bindParam(":username", $name);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password_hash", $hashed_password);
    $stmt->bindParam(":level", $level);

    if ($stmt->execute()) {
        echo '<script>Swal.fire("Sucesso", "Usuário cadastrado!", "success");</script>';
    } else {
        echo '<script>Swal.fire("Erro", "Usuário já existe.", "error");</script>';
    }
}

function cadCat($name)
{
    try {
        $pdo = conexaoBd();
        $stmt = $pdo->prepare("select * from categoria where name = :name ");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $rows = $stmt->rowCount();

        if ($rows <= 0) {
            $stmt = $pdo->prepare("insert into categoria (name) values (:name)");

            $stmt->bindParam(':name', $name);

            $stmt->execute();
            echo '<script>Swal.fire("Sucesso", "Categoria cadastrada!", "success");</script>';
        } else {
            echo '<script>Swal.fire("Erro", "Categoria já existe.", "error");</script>';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
function cadUnid($name)
{
    try {
        $pdo = conexaoBd();
        $stmt = $pdo->prepare("select * from unidadeMedida where name = :name ");
        $stmt->bindParam(':name', $name);
        $stmt->execute();

        $rows = $stmt->rowCount();

        if ($rows <= 0) {
            $stmt = $pdo->prepare("insert into unidadeMedida (name) values (:name)");

            $stmt->bindParam(':name', $name);

            $stmt->execute();
            echo '<script>Swal.fire("Sucesso", "Unidade cadastrada!", "success");</script>';
        } else {
            echo '<script>Swal.fire("Erro", "Unidade já existe.", "error");</script>';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

function consultar($offset, $itensPorPagina)
{
    $pdo = conexaoBD();
    if (isset($_POST["name"]) && ($_POST["name"] != "")) {
        $nome = $_POST["name"];
        $nome = '%' . $nome . '%'; // Adicione % antes e depois do valor de pesquisa

        $stmt = $pdo->prepare("SELECT produtoTCC.code AS code, produtoTCC.nome AS nome,
        produtoTCC.arquivoFoto AS arquivoFoto,
        produtoTCC.quantidade AS quantidade,
        categoria.name AS category,
        unidadeMedida.name AS unidadeMedida
    FROM produtoTCC
    INNER JOIN categoria ON produtoTCC.category = categoria.id
    INNER JOIN unidadeMedida ON produtoTCC.unidadeMedida = unidadeMedida.id
            WHERE produtoTCC.nome LIKE :nome LIMIT $itensPorPagina OFFSET $offset");

        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    } else {
        $stmt = $pdo->prepare("SELECT produtoTCC.code AS code, produtoTCC.nome AS nome,
        produtoTCC.arquivoFoto AS arquivoFoto,
        produtoTCC.quantidade AS quantidade,
        categoria.name AS category,
        unidadeMedida.name AS unidadeMedida
    FROM produtoTCC
    INNER JOIN categoria ON produtoTCC.category = categoria.id
    INNER JOIN unidadeMedida ON produtoTCC.unidadeMedida = unidadeMedida.id
            LIMIT $itensPorPagina OFFSET $offset");
    }

    $stmt->execute();
    return $stmt;
}

function consultarNormal($id)
{
    $pdo = conexaoBD();
    $stmt = $pdo->prepare("SELECT * FROM produtoTCC WHERE code = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    return $stmt;
}
function obterTotalRegistros()
{
    $pdo = conexaoBd(); // Certifique-se de que a conexão com o banco de dados esteja disponível

    $sql = "SELECT COUNT(*) as total FROM produtoTCC";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}
function excluir($id)
{
    try {
        $pdo = conexaoBD();
        $stmt = $pdo->prepare('DELETE FROM produtoTCC WHERE code = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();



        echo '<script>Swal.fire("Sucesso", "Os dados do produto' . $id . '", "success");</script>';
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}

function buscarTeste()
{

    try {
        // Defina o número de itens por página
        $itensPorPagina = 5;



        // Consulta SQL para obter o número total de registros
        $totalRegistros = obterTotalRegistros(); // Implemente a função obterTotalRegistros()

        if (!isset($_POST['op'])) {

            // Receba o número da página atual
            $paginaAtual = isset($_GET['pagina']) ? $_GET['pagina'] : 1;


            // Calcule o número de páginas
            $totalPaginas = ceil($totalRegistros / $itensPorPagina);

            // Calcule o offset
            $offset = ($paginaAtual - 1) * $itensPorPagina;

            // Consulta SQL para obter os registros da página atual
            $stmt = consultar($offset, $itensPorPagina); // Implemente a função consultarComPaginacao()

            // Inicie a tabela fora do loop

            echo "<table id='tabela' class=' table table-secondary table-striped' >";
            echo "<thead>
                            <tr data-product-code='1'>
                        <th  class='table-secondary'>Código</th>
                         <th>Nome</th>
                         <th>Categoria</th>
                         <th>Unidade Medida</th>
                         <th>Quantidade</th>
                         <th>Foto</th>
                         <th>Ações</th>
                     </tr>
                 </thead>";

            while ($row = $stmt->fetch()) {
                echo "<tr>";

                echo "<td>" . $row['code'] . "</td>";
                echo "<td>" . $row['nome'] . "</td>";
                echo "<td>" . $row['category'] . "</td>";
                echo "<td>" . $row['unidadeMedida'] . "</td>";
                echo "<td>" . $row['quantidade'] . "</td>";

                if ($row["arquivoFoto"] == null) {
                    echo "<td align='center'><img src='upload/patinha.png' width='50px' height='50px'></td>";
                } else {
                    echo "<td align='center'><img src=" . $row['arquivoFoto'] . " width='50px' height='50px'></td>";
                }

                echo '
                <td>
                <button  class="edit-button" data-product-code="' . $row["code"] . '" ><i class="bi bi-pencil-square"></i></button>
                <form method="POST">
                
                <input type="hidden" name="id" value="' . $row["code"] . '">
                <button class="btn-delete" type="submit" formaction="excluir.php" name="op"><i class="w-100 bi bi-trash3-fill"></i></button>
                
            </form>

                </td>
            </tr>
            ';
            }

            // <input type="submit"  formaction="excluir.php" name="op">    Encerre a tabela
            echo "</table>";

            // Crie links de paginação
            echo '<nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item">
                        <a class="page-link" href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                        </li>';
            for ($i = 1; $i <= $totalPaginas; $i++) {

                echo " <li class='page-item'><a class='page-link' href='estoque.php?pagina=$i'>$i</a> </li>";
            }
            echo '
                    <li class="page-item">
                    <a class="page-link" href="#" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                    </li>
                </ul>
                </nav>';
        }
    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
function atualizarSenhaUsuario($username, $novaSenha)
{
    $pdo = conexaoBd();

    if (empty($username) || empty($novaSenha)) {
        die("Por favor, forneça um nome de usuário e a nova senha.");
    }

  
    // Hash da nova senha
    $hashed_password = password_hash($novaSenha, PASSWORD_BCRYPT);

    // Atualizar a senha do usuário no banco de dados
    $update_query = "UPDATE login SET senha_hash = :password_hash WHERE usuario = :user_username";
    $stmt = $pdo->prepare($update_query);
    $stmt->bindParam(":password_hash", $hashed_password);
    $stmt->bindParam(":user_username", $username);

    if ($stmt->execute()) {
       
        echo ' <div class="error-messageSucesso">';
        echo "<span style='color: white;'>Senha atualizada com sucesso!</span></div>";
    } else {
       
        echo ' <div class="error-messageIncorreto">';
        echo "<span style='color: black;'>Erro! Tente Novamente</span></div>";
    }
}

function editarTeste($id)
{
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
}



function consultaUnid()
{
    try {
        $pdo = conexaoBD();
        $stmt = $pdo->prepare('SELECT * FROM unidadeMedida');
        $stmt->execute();
        while ($row = $stmt->fetch()) {

            echo " <option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $pdo = null;
}

function consultaCat()
{
    try {
        $pdo = conexaoBD();

        $stmt = $pdo->prepare('SELECT * FROM categoria');
        $stmt->execute();
        while ($row = $stmt->fetch()) {
            echo " <option value='" . $row["id"] . "'>" . $row['name'] . "</option>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $pdo = null;
}

function consultaProdutoTCC()
{
    try {
        $pdo = conexaoBD();

        $stmt = $pdo->prepare('SELECT nome,code FROM produtoTCC');
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            echo '<option value="' . $row["code"] . '">' . $row['nome'] . '</option>';
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $pdo = null;
}

function consultaUsuario(){
    try {
        $pdo = conexaoBD();
        $stmt = $pdo->prepare('SELECT usuario FROM login');
        $stmt->execute();
        while ($row = $stmt->fetch()) {

            echo " <option value='" . $row["usuario"] . "'>" . $row['usuario'] . "</option>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
    $pdo = null;

}


