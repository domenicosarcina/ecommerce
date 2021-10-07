<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/progetto/core/init.php';
if(!is_logged_id()){
  login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';

$sql = "SELECT * FROM categoriepadri";
$result = $db->query($sql);
$errors = array();
$category = '';
$post_parent = '';

//modifica Categoria
if(isset($_GET['edit']) && !empty($_GET['edit'])){
  $edit_id = (int)$_GET['edit'];
  $edit_id = sanitize($edit_id);
  if($edit_id >= 5){
    $edit_sql = "SELECT * FROM categorie WHERE CodiceCategoria = '$edit_id'";
    $edit_result = $db->query($edit_sql);
    $edit_category = mysqli_fetch_assoc($edit_result);
  }
  else{
    $edit_sql = "SELECT * FROM categoriepadri WHERE CodiceCategoriaPadre = '$edit_id'";
    $edit_result = $db->query($edit_sql);
    $edit_category = mysqli_fetch_assoc($edit_result);
  }

}

//elimina categoria
if(isset($_GET['delete']) && !empty($_GET['delete'])){
  $delete_id = (int)$_GET['delete'];
  $delet_id = sanitize($delete_id);
  $sql = "SELECT * FROM categorie WHERE CodiceCategoria = '$delet_id'";
  $result = $db->query($sql);
  $category = mysqli_fetch_assoc($result);
  if($category['parent'] == 0){
    $sql = "DELETE FROM categorie WHERE Parent = '$delete_id'";
    $db->query($sql);
  }
  $dsql = "DELETE FROM categorie WHERE CodiceCategoria = '$delete_id'";
  $db->query($dsql);
  header('Location: categorie.php');
}

//form categoria
if(isset($_POST) && !empty($_POST)){
  $post_parent = sanitize($_POST['parent']);
  $category = sanitize($_POST['categoria']);
  $sqlform = "SELECT * FROM categorie WHERE Nome = '$category' AND Parent = '$post_parent'";
  if(isset($_GET['edit'])){
    $id = $edit_category['CodiceCategoria'];
    $sqlform = "SELECT * FROM categorie WHERE Nome = '$category' AND Parent = '$post_parent' AND CodiceCategoria != '$id'";
  }
  $fresult = $db->query($sqlform);
  $count = mysqli_num_rows($fresult);
  //categoria vuota
  if($category == ''){
    $errors[] .= 'La categoria non può essere vuota';
  }

  //se la categira è già esistente
  if($count > 0){
    $errors[] .= $category. ' è già esistente';
  }

  //Mostra Errori o Aggiungi al Database
  if(!empty($errors)){
    //mostra Errori
    $display = display_errors($errors); ?>
    <script>
      jQuery('document').ready(function(){
        jQuery('#errors').html('<?=$display; ?>');
      });
    </script>
  <?php }else{
    //aggiungi al database
    $updatesql = "INSERT INTO categorie (Nome,Parent) VALUES ('$category','$post_parent')";
    if(isset($_GET['edit'])){
      $updatesql = "UPDATE categorie SET Nome = '$category', Parent = '$post_parent' WHERE CodiceCategoria = '$edit_id'";
    }
    $db->query($updatesql);
    header('Location: categorie.php');
  }
}

$category_value = '';
$parent_value = 0;
if(isset($_GET['edit'])){
  $category_value = $edit_category['Nome'];
  $parent_value = $edit_category['Parent'];
}else{
  if(isset($_POST)){
    $category_value = $category;
    $parent_value = $post_parent;
  }
}
?>
<h2 class="text-center">Categorie</h2><hr>
<div class="row">

  <!-- Form -->
  <div class="col-md-6">
    <form class="form" action="categorie.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:'');?>" method="post">
      <legend><?=((isset($_GET['edit']))?'Modifica':'Aggiungi');?> Categoria</legend>
      <div id="errors"></div>
      <div class="form-group">
        <label for="parent">Parent</label>
        <select class="form-control" name="parent" id="parent">
          <option value="0"<?=(($parent_value == 0)?' selected="selected"':'');?>>Parent</option>
          <?php while($parent = mysqli_fetch_assoc($result)) : ?>
            <option value="<?=$parent['CodiceCategoriaPadre'];?>"<?=(($parent_value == $parent['CodiceCategoriaPadre'])?' selected="selected"':'');?>><?=$parent['Nome'];?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div class="form-group">
        <label for="categoria">Categoria</label>
        <input type="text" class="form-control" id="categoria" name="categoria" value="<?=$category_value;?>">
      </div>
      <div class="form-group">
        <input type="submit" value="<?=((isset($_GET['edit']))?'Modifica':'Aggiungi');?> Categoria" class="btn btn-success">
        <?php if(isset($_GET['edit'])): ?>
          <a href="categorie.php" class="btn btn-default">Cancella</a>
          <?php endif; ?>
      </div>
    </form>
  </div>
  <!-- Tabella Categorie -->
  <div class="col-md-6">
    <table class="table table-bordered">
      <thead>
        <th>Categorie</th><th>Parent</th><th></th>
      </thead>
      <tbody>
        <?php
        $sql = "SELECT * FROM categoriepadri";
        $result = $db->query($sql);
        while($parent = mysqli_fetch_assoc($result)) :
            $parent_id = (int)$parent['CodiceCategoriaPadre'];
            $sql2 = "SELECT categorie.CodiceCategoria, categorie.Nome FROM categorie, categoriepadri WHERE categorie.Parent = categoriepadri.CodiceCategoriaPadre AND Parent = '$parent_id'";
            $cresult = $db->query($sql2);
        ?>
        <tr class="bg-primary">
          <td><?=$parent['Nome'];?></td>
          <td>Parent</td>
          <td>
            <!--<a href="categorie.php?edit=<?=$parent['CodiceCategoriaPadre'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
            <a href="categorie.php?delete=<?=$parent['CodiceCategoriaPadre'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>-->
          </td>
        </tr>
        <?php while($child = mysqli_fetch_assoc($cresult)): ?>
          <tr class="bg-info">
            <td><?=$child['Nome'];?></td>
            <td><?=$parent['Nome'];?></td>
            <td>
              <a href="categorie.php?edit=<?=$child['CodiceCategoria'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
              <a href="categorie.php?delete=<?=$child['CodiceCategoria'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove-sign"></span></a>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php
include 'includes/footer.php';
 ?>
