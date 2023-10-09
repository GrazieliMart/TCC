<!DOCTYPE html>
<html>
<head>
    <title>Registro de Usuário</title>
</head>
<body>
    <h2>Registro de Usuário</h2>
    <form method="post" >
        <label for="username">Usuário:</label>
        <input type="text" name="username" required><br>

        <label for="password">Senha:</label>
        <input type="password" name="password" required><br>

        <label for="level">Nível de Acesso:</label>
        <input type="number" name="level" required><br>

        <input type="submit" value="Registrar">
    </form>
</body>
</html><?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once("bd.php"); // Inclua o arquivo de conexão com o banco de dados
    $pdo = conexaoBd();
    // Coletar dados do formulário
    $username = $_POST["username"];
    $password = $_POST["password"];
    $level = $_POST["level"];

    // Validar campos
    if (empty($username) || empty($password) || empty($level)) {
        die("Por favor, preencha todos os campos.");
    }

    // Verificar se o usuário já existe
    $check_user_query = "SELECT id FROM login WHERE usuario = :username";
    $stmt = $pdo->prepare($check_user_query);
    $stmt->bindParam(":username", $username);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        die("O nome de usuário já está em uso. Escolha outro.");
    }

    // Hash da senha
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Inserir usuário no banco de dados usando uma consulta preparada
    $insert_query = "INSERT INTO login (usuario, level, senha_hash) VALUES (:username, :level, :password_hash)";
    $stmt = $pdo->prepare($insert_query);
    $stmt->bindParam(":username", $username);
    $stmt->bindParam(":password_hash", $hashed_password);
    $stmt->bindParam(":level", $level);

    if ($stmt->execute()) {
        echo "Registro bem-sucedido!";
    } else {
        echo "Erro ao registrar: " . $stmt->errorInfo()[2];
    }
}
?>
