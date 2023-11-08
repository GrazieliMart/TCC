<?php
require 'vendor/autoload.php'; // Certifique-se de que a biblioteca PHPMailer está instalada via Composer

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    include("bd.php");

    function enviarEmail($destinatario, $assunto, $mensagem) {
        $mail = new PHPMailer(true);

        try {
                           //Enable verbose debug output
          $mail->isSMTP();                                            //Send using SMTP
          $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
          $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
          $mail->Username   = 'mikayonekawa@gmail.com';     
          $mail->Password   = 'M13m19y42';         
          $mail->Password   = 'vwhv tmxf wlgf viir';                               //SMTP password
          $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
          $mail->Port       = 465;   

            $mail->isHTML(true);
            $mail->Subject = $assunto;
            $mail->Body = $mensagem;

            $mail->setFrom('grazielimartins5@gmail.com', 'Almoxarifado');
            $mail->addAddress($destinatario);

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    // Verifique se o email existe no banco de dados
    $pdo = conexaoBd();
    $stmt = $pdo->prepare("SELECT id, usuario FROM login WHERE email = :email");
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

   if ($stmt->rowCount() > 0) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    // Gere uma nova senha
    $novaSenha = substr(md5(uniqid(mt_rand(), true)), 0, 8);
    $senhaHash = password_hash($novaSenha, PASSWORD_BCRYPT);

    // Atualize a senha do usuário no banco de dados
    $stmt = $pdo->prepare("UPDATE login SET senha_hash = :senhaHash WHERE id = :id");
    $stmt->bindParam(':senhaHash', $senhaHash);
    $stmt->bindParam(':id', $user['id']);
    $stmt->execute();

    $assunto = "Almoxarifado - SAR | COTIL | UNICAMP";
    $paginaNovaSenha = "http://localhost/tcc/novaSenha.php";
    $mensagem = "Clique no link a seguir para cadastrar uma nova senha: <a href='$paginaNovaSenha'>$paginaNovaSenha</a>";

    if (enviarEmail($email, $assunto, $mensagem)) {
      echo ' <div class="error-messageSucesso">';
        echo "<span style='color: white;'>Um link foi enviado a sua caixa de entrada!</span></div>";
    } else {
        // Se houver um erro ao enviar o email
        echo ' <div class="error-messageIncorreto">';
        echo "<span style='color: white;'>Falha de conexão! Entre em contato com o Desenvolvedor!</span></div>";
    }
} else {
    // Se o email não for encontrado
    echo ' <div class="error-messageIncorreto">';
    echo "<span style='color: white;'>E-mail não encontrado! Tente Novamente</span></div>";
}
}


?>
<!DOCTYPE html>
<html>
<head>
</head>
<meta charset="utf-8">
  <title>Recuperação de Senha | AlmoxariSars</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="logo/1.png"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style/loginStyle.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row" id="container-geral">
      <div class="col-6">
       <!--    <div class="logo">
       <img src="logo/unicamp.png" alt="Logo da UNICAMP">-->
        </div>
      </div>
  
        <div class="form-container">

           <div class="containerLogEsqueciSenha">

          <?php if (isset($error)) { ?>
            <p>
              <?php echo $error; ?>
            </p>
          <?php } ?>


           
            <form method="post">
              <div class="loginLogo"> 
                <img src="logo/1.png" alt="Logo da UNICAMP" id="logo">
            <h2 id="log"> AlmoxariSars </h2>
           
          </div>
              <!--E-mail-->
              <div class="formC">
             <div class="group">
             <input type="text" class="input" id="email" name="email" autocomplete="off" required="">
            
             <span class="highlight"></span>
             <span class="bar"></span>
             <label for="username">E-mail</label>
             </div>
               <ion-icon name="person-outline" class="iconLogin"></ion-icon>

             <div class="formatic">
             <button type="submit" class="btn btn-primary">Recuperar Senha</button>
             <div class="forgot-password">
              <a href="login.php">Cancelar</a>
          </div></div>
          </form>
           
          </div>
         
        </div>
      </div>
    </div>


  </div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>


</body>



</html>
   

