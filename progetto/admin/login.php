<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/progetto/core/init.php';
  include 'includes/head.php';
  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $email = trim($email);
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $password = trim($password);
  $errors = array();

  ?>

  <style>
    body{
      background-image: url("/progetto/images/home/back.jpg");
      background-repeat: no-repeat;
      background-size: 100vw 100vh;
      background-attachment: fixed;
    }
  </style>
  <center><img src="/progetto/images/home/logo.jpg" style="width:400px; height:100px;"></img></center>
  <div id="login-form">
    <div>

      <?php
        if($_POST){
          //validità del form
          if(empty($_POST['email']) || empty($_POST['password'])){
            $errors[] = 'Devi compilare tutto!';
          }

          //email convalidata
          if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $errors[] = 'Devi inserire un\'email valida';
          }

          //la password è più lunga di 6 caratteri
          if(strlen($password) < 6){
            $errors[] = 'La password deve essere di almeno 6 caratteri';
          }

          //controlla se l'email esiste nel database
          $query = $db->query("SELECT * FROM utenti WHERE Email = '$email'");
          $user = mysqli_fetch_assoc($query);
          $userCount = mysqli_num_rows($query);
          if($userCount < 1){
            $errors[] = 'L\'email inserita non esiste';
          }

          if(!password_verify($password, $user['Password'])){
            $errors[] = 'La password non e\' corretta';
          }

          //controlla errori
          if(!empty($errors)){
            echo display_errors($errors);
          }else{
            //login $user
            $user_id = $user['CodiceUtente'];
            login($user_id);
          }

          //controlla se e' un utente
          if($user['Permessi'] == 'user'){
            header('Location: /progetto/index.php');
          }
        }
       ?>

    </div>
    <h2 class="text-center">Login</h2><hr>
    <form action="login.php" method="post">
      <div class="form-group">
        <label for="email">Email: </label>
        <input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
      </div>
      <div class="form-group">
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
      </div>
      <div class="form-group">
        <input type="submit" value="Login" class="btn btn-primary">
      </div>
    </form>
    <p class="text-right"><a href="/progetto/index.php" alt="home">Visita il Sito</a></p>
  </div>

  <?php include 'includes/footer.php'; ?>
