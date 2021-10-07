<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/progetto/core/init.php';
  if(!is_logged_id()){
    login_error_redirect();
  }

  include 'includes/head.php';

  $hashed = $user_data['Password'];
  $old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
  $old_password = trim($old_password);
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $password = trim($password);
  $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $confirm = trim($confirm);
  $new_hashed = password_hash($password, PASSWORD_DEFAULT);
  $user_id = $user_data['CodiceUtente'];
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
          if(empty($_POST['old_password']) || empty($_POST['password']) || empty($_POST['confirm'])){
            $errors[] = 'Devi compilare tutto!';
          }

          //la password è più lunga di 6 caratteri
          if(strlen($password) < 6){
            $errors[] = 'La password deve essere di almeno 6 caratteri';
          }

          //se la nuova password e' dicersa aa quella confermata
          if($password != $confirm){
            $errors[] = 'La nuova password e la password confermata non corrispondono';
          }

          if(!password_verify($old_password, $hashed)){
            $errors[] = 'La vecchia password non e\' corretta';
          }

          //controlla errori
          if(!empty($errors)){
            echo display_errors($errors);
          }else{
            //cambia password
            $db->query("UPDATE utenti SET Password = '$new_hashed' WHERE CodiceUtente = '$user_id'");
            $_SESSION['success_flash'] = 'La password e\' stata aggiornata';
            header('Location: index.php');
          }
        }
       ?>

    </div>
    <h2 class="text-center">Cambia Password</h2><hr>
    <form action="cambia_password.php" method="post">
      <div class="form-group">
        <label for="old_password">Vecchia Password: </label>
        <input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>">
      </div>
      <div class="form-group">
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
      </div>
      <div class="form-group">
        <label for="confirm">Conferma la nuova password: </label>
        <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
      </div>
      <div class="form-group">
        <a href="index.php" class="btn btn-default">Cancella</a>
        <input type="submit" value="Login" class="btn btn-primary">
      </div>
    </form>
    <p class="text-right"><a href="/progetto/index.php" alt="home">Visita il Sito</a></p>
  </div>

  <?php include 'includes/footer.php'; ?>
