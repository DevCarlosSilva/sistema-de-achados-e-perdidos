<?php
require '../template/header.php';
?>

<body class="d-flex align-items-center flex-column p-5 form-page-bg">
  <?php
  if (isset($_GET['signUpErrorInvalidCredentials'])) {
    if ($_GET['signUpErrorInvalidCredentials'] === 'y') {
      echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
              <ion-icon name="alert-circle-outline" class="me-1"></ion-icon>
              <div>Por favor, insira um nome de usuário, e-mail e senha válidos <a href="formSignUp.php" class="text-danger">[X]</a></div>
            </div>';
    }
  }
  if (isset($_GET['emailAlreadyInUse'])) {
    if ($_GET['emailAlreadyInUse'] === 'y') {
      echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
              <ion-icon name="alert-circle-outline" class="me-1"></ion-icon>
              <div>E-mail já está sendo usado por outra conta <a href="formSignUp.php" class="text-danger">[X]</a></div>
            </div>';
    }
  }
  ?>
  <div class="w-100 m-auto form-container">
    <form action="signUpValidation.php" method="post" class="needs-validation" novalidate>
      <img src="../assets/trimmedLogo.png" alt="logo" class="w-100 m-auto form-logo d-block mb-2">
      <span class="h3 fw-semi-bold">Registre-se,</span>
      <span class="h5 fw-semi-bold text-warning"> bem-vindo(a)!</span>
      <div class="form-floating mt-2">
        <input name="username" id="username" class="form-control mb-1" placeholder="Insira seu nome de usuário" required>
        <label for="username">Insira um nome de usuário</label>
      </div>
      <div class="form-floating">
        <input type="email" name="email" id="email" class="form-control mb-1" placeholder="Insira seu e-mail" required>
        <label for="email">Insira seu e-mail</label>
      </div>
      <div class="form-floating">
        <input type="password" name="password" id="password" class="form-control" placeholder="Insira sua senha" required>
        <label for="password">Insira uma senha</label>
      </div>
      <input type="submit" value="Registre-se" class="my-3 btn btn-warning w-100">
      <div class="text-center">
        <span>Já tem uma conta? • </span><a href="formSignIn.php" class="text-warning">Entre</a>
      </div>
      <hr>
      <p class="text-secondary copyright text-center">Direitos Autorais © 2024 Carlos Silva. Todos os Direitos Reservados</p>
    </form>
  </div>
  <script defer>
    // Capturar todos os form com class need-validaion e pra cada form ele adiciona um controlador de evento ao botão de submit checando os inputs e deixando ou não o form ser enviado
    (() => {
      'use strict'
      const forms = document.querySelectorAll('.needs-validation')
      Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
          if (!form.checkValidity()) {
            event.preventDefault()
            event.stopPropagation()
          }
          form.classList.add('was-validated')
        }, false)
      })
    })()
  </script>
  <link rel="stylesheet" href="../css/style.css">
  <?php
  require '../template/footer.php';
  ?>