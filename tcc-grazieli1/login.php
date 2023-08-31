<?php
session_start();
$users = array(
  array("username" => "admin", "password" => "1234", "level" => 3),
  array("username" => "user2", "password" => "user123", "level" => 2),
  array("username" => "user1", "password" => "user456", "level" => 1)
);
// Verifica se o formulário foi enviado
if (isset($_POST['submit'])) {
  $username = $_POST['username'];
  $password = $_POST['password'];
  // Verifica se o usuário existe no array de usuários
  foreach ($users as $user) {
    if ($user['username'] == $username && $user['password'] == $password) {
      // Cria uma sessão para o usuário
      $_SESSION['username'] = $user["username"];
      $_SESSION['level'] = $user["level"];
      header('Location: index.php');
      exit;

      

    }
  }
  // Se chegou aqui, é porque o usuário não existe ou a senha está incorreta
  $error = "<span style='color: white;'>Usuário ou senha incorretos!</span>";
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Login | AlmoxariSars</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="logo/unicampCor.png"/>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="loginStyle.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
  <div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row" id="container-geral">
      <div class="col-6">
       <!--    <div class="logo">
       <img src="logo/unicamp.png" alt="Logo da UNICAMP">-->
        </div>
      </div>
      <div class="col-6">
        <div class="form-container">

           <div class="containerLog">

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
             <input required="" type="text" class="input" id="username" name="username" autocomplete="off">
             <span class="highlight"></span>
             <span class="bar"></span>
             <label for="username">E-mail</label>
             </div>
               <ion-icon name="person-outline" class="iconLogin"></ion-icon>

              <!--Senha-->
             <div class="group">
             <input required="" type="password" class="input" id="password" name="password" autocomplete="off">
             <span class="highlight"></span>
             <span class="bar"></span>
            
             <label for="password" >Senha</label>
             
             </div>

             <ion-icon name="lock-closed-outline" class="iconLogin" ></ion-icon>
          
             <div class="formatic">
             <button type="submit" id="submit" name="submit">Entrar</button>
             <div class="forgot-password">
              <a href="esqueciSenha.php">Esqueci minha senha</a>
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

</html>