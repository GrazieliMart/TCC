<?php
function conexaoBd(){
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
function login(){
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
                    // Credenciais inválidas
                    $error = "<span style='color: black;'>Usuário ou senha incorretos!</span>";
                }
            } else {
                echo "<span style='color: black;'>Usuário não encontrado!</span>";
            }
        }
    } catch (PDOException $e) {
        // Tratar qualquer erro de conexão com o banco de dados
        echo "Erro de banco de dados: " . $e->getMessage();
    }
    
    $pdo = null;
    }
     function buscarLogin($code, $pdo){
        
        $stmt = $pdo->prepare("select * from login where id = :code");
        $stmt->bindParam(':id', $code);
        $stmt->execute();
        $rows = $stmt->rowCount();
        return $rows;
    
     }


function cadProd($foto){
    $pdo = conexaoBd();
    try {

        $nome = isset($_POST['nome']) ? $_POST['nome'] : "";
        $code = isset($_POST['code']) ? (int) $_POST['code'] : 0;
        $category = isset($_POST['category']) ? $_POST['category'] : "";
        $unidadeMedida = isset($_POST['unidadeMedida']) ? $_POST['unidadeMedida'] : "";
        $quantidade = isset($_POST['quantidade']) ? (int) $_POST['quantidade'] : 0;

        $uploadDir = 'upload/produtos/';
        $uploadfile = "";

       
    

        if ($foto === null || $foto['error'] !== UPLOAD_ERR_OK) {
            echo '<script>Swal.fire("Erro", "Erro no upload da imagem.", "error");</script>';
        } else if (!preg_match('/^image\/(jpeg|png|gif)$/', $foto['type'])) {
            echo '<script>Swal.fire("Erro", "Isso não é uma imagem válida.", "error");</script>';
        }  else {
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
        echo '<script>Swal.fire("Erro", "Erro: ' . $ex->getMessage() . '", "error");</script>';
    }

}
function cadUsuario($name,$code,$level,$senha){
    $pdo = conexaoBd();
    
    if (empty($name) || empty($code) || empty($level)||empty($senha)) {
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
    $insert_query = "INSERT INTO login (usuario, level, senha_hash) VALUES (:username, :level, :password_hash)";
    $stmt = $pdo->prepare($insert_query);
    $stmt->bindParam(":username", $name);
    $stmt->bindParam(":password_hash", $hashed_password);
    $stmt->bindParam(":level", $level);

    if ($stmt->execute()) {
        echo '<script>Swal.fire("Sucesso", "Usuário cadastrado!", "success");</script>';
    } else {
        echo '<script>Swal.fire("Erro", "Usuário já existe.", "error");</script>';
    }

}

function cadCat($name){
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
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

}
function cadUnid($name){
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
    } catch(PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }

}

?>