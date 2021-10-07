<?php
require_once '../core/init.php';
if(!is_logged_id()){
  login_error_redirect();
}
if(!has_permission('admin')){
  permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';
if(isset($_GET['delete'])){
  $delete_id = sanitize($_GET['delete']);
  $db->query("DELETE FROM utenti WHERE CodiceUtente = '$delete_id'");
  $_SESSION['success_falsh'] = 'L\' utente è stato eliminato';
  header('Location: utenti.php');
}
if(isset($_GET['add'])){
  $name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
  $email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
  $password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
  $confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
  $permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
  $errors = array();

  if($_POST){
    $emailQuery = $db->query("SELECT * FROM utenti WHERE Email = '$email'");
    $emailCount = mysqli_num_rows($emailQuery);
    if($emailCount != 0){
      $errors[] = 'L\' email inserita è già esitente nel database';
    }

    $required = array('name', 'email', 'password', 'confirm', 'permissions');
    foreach($required as $f){
      if(empty($_POST[$f])){
        $errors[] = 'Devi completare tutti i campi';
        break;
      }
    }
    if(strlen($password) < 6){
      $errors[] = 'La tua password deve essere di almeno 6 caratteri';
    }

    if($password != $confirm){
      $errors[] = 'Le 2 password non corrispondono';
    }

    if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
      $errors[] = 'Devi inserire un\' email valida';
    }

    if(!empty($errors)){
      echo display_errors($errors);
    }else{
      //aggiungi utente
      $hashed = password_hash($password,PASSWORD_DEFAULT);
      $db->query("INSERT INTO utenti (Nome_Cognome, Email, Password, Permessi) VALUES ('$name', '$email', '$hashed', '$permissions')");
      $_SESSION['success_flash'] = 'L\' utente è stato aggiunto';
      header('Location: utenti.php');
    }
  }
  ?>
  <h2 class="text-center">Aggiungi un nuovo Utente</h2><hr>
  <form action="utenti.php?add=1" method="post">
    <div class="form-group col-md-6">
      <label for="name">Nome e Cognome: </label>
      <input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="email">Email: </label>
      <input type="text" name="email" id="email" class="form-control" value="<?=$email;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="password">Password: </label>
      <input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="confirm">Conferma Password: </label>
      <input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
    </div>
    <div class="form-group col-md-6">
      <label for="name">Permessi: </label>
      <select class="form-control" name="permissions">
        <option value=""<?=(($permissions == '')?' selected':'');?>></option>
        <option value="editor"<?=(($permissions == 'editor')?' selected':'');?>>Editor</option>
        <option value="admin,editor"<?=(($permissions == 'admin,editor')?' selected':'');?>>Admin</option>
      </select>
    </div>
    <div class="form-group col-md-6 text-right" style="margin-top: 25px;">
      <a href="utenti.php" class="btn btn-default">Cancella</a>
      <input type="submit" value="Aggiungi Utente" class="btn btn-primary">
    </div>
  </form>
  <?php
}else{
$userQuery = $db->query("SELECT * FROM utenti ORDER BY Nome_Cognome");

 ?>

<h2>Utenti</h2>
<a href="utenti.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Aggiungi un nuovo utente</a>
<hr>
<table class="table table-border table-striped table-condensed">
  <thead><th></th><th>Nome</th><th>Email</th><th>Data Iscrizione</th><th>Ultimo Login</th><th>Permessi</th></thead>
  <tbody>
    <?php while($user = mysqli_fetch_assoc($userQuery)): ?>
      <tr>
        <td>
          <?php if($user['CodiceUtente'] != $user_data['CodiceUtente']): ?>
            <a href="utenti.php?delete=<?=$user['CodiceUtente'];?>" class="btn btn-default btn-xs"><span class="glyphicon glyphicon-remove-sign"></span></a>
          <?php endif; ?>
        </td>
        <td><?=$user['Nome_Cognome'];?></td>
        <td><?=$user['Email'];?></td>
        <td><?=pretty_date($user['Data_Iscrizione']);?></td>
        <td><?=(($user['Ultimo_Accesso'] == '0000-00-00 00:00:00')?'Never':pretty_date($user['Ultimo_Accesso']));?></td>
        <td><?=$user['Permessi'];?></td>
      </tr>
  <?php endwhile; ?>
  </tbody>
</table>
 <?php } include 'includes/footer.php'; ?>
