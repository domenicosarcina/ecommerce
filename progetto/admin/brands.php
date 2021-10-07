<?php
require_once '../core/init.php';
if(!is_logged_id()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

$sql = "SELECT * FROM brand ORDER BY Nome";
$result = $db->query($sql);
$errors = array();

//modificare brands
if(isset($_GET['edit']) && !empty($_GET['edit'])){
  $edit_id = (int)$_GET['edit'];
  $edit_id = sanitize($edit_id);
  $sql2 = "SELECT * FROM brand WHERE CodiceBrand = '$edit_id'";
  $edit_result = $db->query($sql2);
  $eBrand = mysqli_fetch_assoc($edit_result);

}

//eliminare brands
if(isset($_GET['delete']) && !empty($_GET['delete'])){
  $delete_id = (int)$_GET['delete'];
  $delete_id = sanitize($delete_id);
  $sql = "DELETE FROM brand WHERE CodiceBrand = '$delete_id'";
  $db->query($sql);
  header('Location: brands.php');
}

//condizione del form
if(isset($_POST['add_submit'])){
  $brand = sanitize($_POST['brand']);
  //controlla se il form è vuoto
  if($_POST['brand'] == ''){
    $errors[] .= 'Devi inserire un brand!';
  }
  //controlla se il brand è già esistente nel Database
  $sql = "SELECT * FROM brand WHERE Nome = '$brand'";
  $sql2 = $db->query($sql);
  $count = mysqli_num_rows($sql2);
  if($count > 0){
    $errors[] .= $brand.' è già esistente';
  }

  if(!empty($errors)){
    echo display_errors($errors);
  }else{
    //aggiungi brand al database
    $sql = "INSERT INTO brand (Nome) VALUES ('$brand')";
    if(isset($_GET['edit'])){
      $sql = "UPDATE brand SET Nome = '$brand' WHERE CodiceBrand = '$edit_id'";
    }
    $db->query($sql);
    header('Location : brands.php');
  }
}
 ?>
<h2 class="text-center">Brand</h2><hr>
<!-- Form Brand -->
<div class="text-center">
  <form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:''); ?>" method="post">
    <div class="form-group">
      <label for="brand"><?= ((isset($_GET['edit']))?'Modifica':'Aggiungi'); ?> Brand: </label>
      <input type="text" name="brand" id="brand" class="form-control" value="<?php ((isset($_POST['brand']))?$_POST['brand']:''); ?>">
      <?php if(isset($_GET['edit'])): ?>
        <a href="brands.php" class="btn btn-default">Cancella</a>
        <?php endif; ?>
      <input type="submit" name="add_submit" value="<?=((isset($_GET['edit']))?'Modifica':'Aggiungi'); ?>" class="btn btn-success">
    </div>
  </form>
</div><hr>
<table class="table table-border table-striped table-auto table-condensed">
  <thead>
    <th></th><th>Brand</th><th></th>
  </thead>
  <tbody>
    <?php while($brand = mysqli_fetch_assoc($result)) : ?>
    <tr>
      <td><a href="brands.php?edit=<?php echo $brand['CodiceBrand']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a></td>
      <td><?php echo $brand['Nome']; ?></td>
      <td><a href="brands.php?delete=<?php echo $brand['CodiceBrand']; ?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>
<center><h2> In caso di errore nell'aggiungere o modificare i brand, riaggiornare la pagina di errore. </h2></center>
<?php include 'includes/footer.php'; ?>
