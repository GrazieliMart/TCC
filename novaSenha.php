<?php
include("bd.php"); // Inclua o arquivo de conexão com o banco de dados

if (isset($_POST['atualizarSenha'])) {
    $usuario = $_POST['userId'];
    $novaSenha = $_POST['novaSenha'];

    atualizarSenhaUsuario($usuario, $novaSenha); // Chame a função definida no arquivo bd.php
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Nova Senha | AlmoxariSars</title>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" type="image/png" href="logo/1.png" />

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="stylesheet" href="style/loginStyle.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    .error-messageIncorreto {
  background-color: #ff5b5b6b; /* Cor de fundo vermelha */
  color: white;
  border: 2px solid #ff5b5b; /* Cor do texto branca */
  padding: 10px; /* Espaçamento interno */
  border-radius: 5px; /* Bordas arredondadas */
  margin-top: 10px; /* Espaçamento superior */
}
.error-messageSucesso {
background-color: #7fc1ff6b;
  color: white;
  border: 2px solid #5ca5e6;
  padding: 10px;
  border-radius: 5px;
  margin-top: 10px;
}

body {
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: #03638C;
    background-size: 300% 600%;
   
    font-family: sans-serif;
}
.error-message {
  background-color: #ff5b5b6b; /* Cor de fundo vermelha */
  color: white;
  border: 2px solid #ff5b5b; /* Cor do texto branca */
  padding: 10px; /* Espaçamento interno */
  border-radius: 5px; /* Bordas arredondadas */
  margin-top: 10px; /* Espaçamento superior */
}
.error-messageSenha {
  background-color: #ff5b5b6b; /* Cor de fundo vermelha */
  color: white;
  border: 2px solid #ff5b5b; /* Cor do texto branca */
  padding: 10px; /* Espaçamento interno */
  border-radius: 5px; /* Bordas arredondadas */
  margin-top: 10px; /* Espaçamento superior */
}
.error-messageIncorreto {
  background-color: #ff5b5b6b; /* Cor de fundo vermelha */
  color: white;
  border: 2px solid #ff5b5b; /* Cor do texto branca */
  padding: 10px; /* Espaçamento interno */
  border-radius: 5px; /* Bordas arredondadas */
  margin-top: 10px; /* Espaçamento superior */
}
.error-messageSucesso {
background-color: #7fc1ff6b;
  color: white;
  border: 2px solid #5ca5e6;
  padding: 10px;
  border-radius: 5px;
  margin-top: 10px;
}
.containerLogEsqueciSenha {
  left: 0;
  color: #e4ebf0;
  border-radius: 5px;
  padding: 20px;
  background: rgba(255, 255, 255, 0.5); /* Manter a opacidade */
}

.form-container {
  border-radius: 5px;
  padding: 20px;
  margin-top: 0px;
  max-width: 400px;
  
}
.form-container1 {
  border-radius: 5px;
  padding: 20px;
  margin-top: 0px;
  max-width: 400px;
  background: rgba(255, 255, 255, 0.5); /* Manter a opacidade */
}
h1 {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: Arial, sans-serif;
    font-size: 36px;
    color: white;
}
  


    #container-geral {
      border-radius: 10px;
      border: none;
      background-color: #dbd9de;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);

    }
    #container-geral1 {
      border-radius: 10px;
      border: none;
      

    }

    .form-container {
      border-radius: 5px;
      padding: 20px;
      margin-top: 0px;
      max-width: 400px;
    }

    .form-container label {
      display: flex;
      font-size: 20px;
      font-weight: bold;
      margin-top: 4px;
      color: rgb(255, 255, 255);
    }
    
    .iconLogin{
    width: 45px; 
    height: 45px; 
    right: 30px; 
    top: 0;
    color:white;
      
    }

    .form-container p {
      display: block;
      font-size: 14px;
      font-weight: bold;
      margin-top: 10px;
      color: #fff;
    }

    .form-container input[type="text"],
    .form-container input[type="password"] {
      border-radius: 3px;
      border: none;
      padding: 10px;
      margin-top: 5px;
      margin-bottom: 15px;
      width: 100%;
    }

    .form-container button[type="submit"] {
      background-color: #1D79A1;
      border: none;
      border-radius: 30px;
      color: #fff;
      cursor: pointer;
      font-size: 16px;
      font-weight: bold;
      padding: 10px;
      margin-top: 10px;
      width: 100%;
    }

    .form-container button[type="submit"]:hover {
      background-color:  #03638C;
      box-shadow: 0 0 3px black;
      transition: 0.2s;
    }

    .forgot-password {
      text-align: center;
      margin-top: 15px;
      font-size: 14px;
    }

    .forgot-password a {
      color: black;
      text-decoration: none;
    }

    .forgot-password a:hover {
      text-decoration: underline;
      color: #fff;
      transition: 0.2s;
    }
    
.loginLogo {
  align-items: center; 
  display: flex;
  left:20px;
  justify-content:space-between;
  margin-bottom: 1px; 
  margin-left:10px;
}

#log {
  font-size: 30px;
   font-weight: bold; 
   letter-spacing: 1px; 
   margin-top: 10px; 
   right: 50px; 
  
   color: white;
   text-shadow: -2px 0px 3px rgba(0, 0, 0, 0.2);

 
  margin-bottom: 0; 
}

#logo {
  height: 60px;
  width: 80px;
  
}
.containerLog{
  position: relative;
  align:center;
  
 display: flex;
 left: 35%;

  color: #e4ebf0;
  border-radius:5px;
  padding: 20px;
  background: rgba(255, 255, 255, 0.5); 
 
  
}
.containerLogEsqueciSenha{
  
 left: 0;

  color: #e4ebf0;
  border-radius:5px;
  padding: 20px;
  background: rgba(255, 255, 255, 0.5); 
 
  
}

.group {
 position: relative;
 left: 60px;
 top: 47px;
 font-size: 50px;

 
}
.icone{
  top: 50px;
}
input {
 font-size: 16px;
/* padding: 0px 10px 10px 5px;*/
 display: block;
 width: 20px;
 border: none;
 border-bottom: 1px solid #515151;
 background: transparent;
 left:25px;
 
}
 input:focus {
 outline: none;
 background: transparent;
}
 label {
 color: #b8c7d6;
 
 /*font-weight: normal;*/
 position: absolute;
 pointer-events: none;
 left: 5px;
 top: 3px;
 transition: 0.2s ease all;
 -moz-transition: 0.2s ease all;
 -webkit-transition: 0.2s ease all;
}

#cancelPassword{
  
  left: 25px;
  position: absolute;
}
.input:focus ~ label, .input:valid ~ label {
 top: -25px;

 font-size: 16px;
 color: rgb(255, 255, 255);
}
.bar {
  position: relative;
  display: block;
  width: 250px;
  margin-top: -15px; 
}

.bar:before, .bar:after {
 content: '';
 height: 2px;
 width: 0;
 
 position: absolute;
 background: #1D79A1;
 transition: 0.2s ease all;
 -moz-transition: 0.2s ease all;
 -webkit-transition: 0.2s ease all;
}

.bar:before {
 left: 50%;
}

.bar:after {
 right: 50%;

}

.input:focus ~ .bar:before, .input:focus ~ .bar:after {
 width: 50%;
}

.highlight {
 position: absolute;
 /*height: 60%;*/
 width: 100px;
 /*top: 2%;*/
 left: 0;
 pointer-events: none;
 opacity: 0.5;
}
.formatic{
  top:48px;
  padding:50px;
  text-align: center;
}
.formC{
  align:center;
 color: #fff;
  opacity: none;
  left:50px;
}



.input:focus ~ .highlight {
 animation: inputHighlighter 0.3s ease;
}

@keyframes inputHighlighter {
 from {
  background: #5264AE;
 }

 to {
  width: 0;
  background: transparent;
 }
}
@media (max-width: 600px) {
  .containerLog {
    width: 300px;
    height: auto;
    margin-top: 0;
    left: 65px;}
  .form-container {
    font-size: 14px; 
   
  }
  .iconLogin {
    width: 30px; 
    height: 30px;
  }
 .loginLogo{
  margin-bottom: 1px;
  margin-left: 10px;
  flex-direction: row;
  display: block;
  align-items: center;
 }
 .forgot-password {
  text-align: center;
  margin-top: 15px;
  font-size: 11px;
}
 .bar{
  width: 150px;
 }
 .form-container input[type="text"],
    .form-container input[type="password"] {
     
      width: 150px;
    }
    #logo {
      height: 60px;
      width: 80px;
      margin: 10px; 
    }
}
  </style>
</head>



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
             <input type="text" class="input" id="userId" name="userId" required autocomplete="off">
            
             <span class="highlight"></span>
             <span class="bar"></span>
             <label for="userId">Usuário</label>
             </div>

               <ion-icon name="person-outline" class="iconLogin"></ion-icon>

               <div class="group">
             <input class="input" id="novaSenha" name="novaSenha" type="password" autocomplete="off" required="">
            
             <span class="highlight"></span>
             <span class="bar"></span>
             <label or="novaSenha">Nova Senha</label>
             </div>
               <ion-icon name="lock-open-outline" class="iconLogin"></ion-icon>


             <div class="formatic">
             
             <button type="submit" class="btn btn-primary" name="atualizarSenha">Criar Senha</button>

             <div class="forgot-password">
              <a href="login.php">Login</a>
          </div></div>
          </form>
           
          </div>
         
        </div>
      </div>
    </div>


  </div>


<body>
<!--<form id="formAtualizarSenha" method="post" class="limpar-campos">
    <div class="titleRelatorio">
        <h1>Atualizar Senha do Usuário</h1>
    </div>
    <div class="form-row">
        <div class="divTextForm1">
            <label for="userId">Nome de Usuário</label>
            <input type="text" class="formaticTextRelatorio" id="userId" name="userId" required>

            <label for="novaSenha">Nova Senha</label>
            <input class="formaticTextRelatorio" id="novaSenha" name="novaSenha" type="password">
        </div>

        <div class="button-container1">
            <input type="submit" name="atualizarSenha" value="Atualizar Senha">
        </div>
    </div>
</form>-->
</body>
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

</html>