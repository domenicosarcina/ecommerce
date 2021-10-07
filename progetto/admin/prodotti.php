<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/progetto/core/init.php';
  if(!is_logged_id()){
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'includes/navigation.php';
  $dbpath = '';
  if(isset($_GET['add']) || isset($_GET['edit'])){
    $brandQuery = $db->query("SELECT * FROM brand ORDER BY Nome");
    $parentQuery = $db->query("SELECT * FROM categoriepadri ORDER BY Nome");
    $brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):'');
    $title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):'');
    $parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['parent']):'');
    $category = ((isset($_POST['child']) && !empty($_POST['child']))?sanitize($_POST['child']):'');
    $price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):'');
    $list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):'');
    $description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):'');
    $sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):'');
    $sizes = rtrim($sizes,',');
    $saved_image = '';

      if(isset($_GET['edit'])){
        $edit_id = (int)$_GET['edit'];
        $productResults = $db->query("SELECT * FROM prodotti WHERE CodiceProdotto = '$edit_id'");
        $product = mysqli_fetch_assoc($productResults);
        if(isset($_GET['delete_image'])){
          $image_url = $_SERVER['DOCUMENT_ROOT'].$product['Immagine'];echo $image_url;
          unlink($image_url);
          $db->query("UPDATE prodotti SET Immagine = '' WHERE CodiceProdotto = '$edit_id'");
          header('Location: prodotti.php?edit='.$edit_id);
        }
        $category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['Categoria']);
        $title = ((isset($_POST['title']) && !empty($_POST['title']))?sanitize($_POST['title']):$product['Titolo']);
        $brand = ((isset($_POST['brand']) && !empty($_POST['brand']))?sanitize($_POST['brand']):$product['Brand']);
        $parentQ = $db->query("SELECT * FROM categorie WHERE CodiceCategoria = '$category'");
        $parentResult = mysqli_fetch_assoc($parentQ);
        $parent = ((isset($_POST['parent']) && !empty($_POST['parent']))?sanitize($_POST['parent']):$parentResult['Parent']);
        $price = ((isset($_POST['price']) && !empty($_POST['price']))?sanitize($_POST['price']):$product['Prezzo']);
        $list_price = ((isset($_POST['list_price']) && !empty($_POST['list_price']))?sanitize($_POST['list_price']):$product['PrezzoOutlet']);
        $description = ((isset($_POST['description']) && !empty($_POST['description']))?sanitize($_POST['description']):$product['Descrizione']);
        $sizes = ((isset($_POST['sizes']) && !empty($_POST['sizes']))?sanitize($_POST['sizes']):$product['Taglie']);
        $sizes = rtrim($sizes,',');
        $saved_image = (($product['Immagine'] != '')?$product['Immagine']: '');
        $dbpath = $saved_image;
      }
      if(!empty($sizes)){
        $sizeString = sanitize($sizes);
        $sizeString = rtrim($sizeString,',');
        $sizesArray = explode(',',$sizeString);
        $sArray = array();
        $qArray = array();
        foreach($sizesArray as $ss){
          $s = explode(':', $ss);
          $sArray[] = $s[0];
          $qArray[] = $s[1];
        }
        }else{$sizeArray = array();}
    $sizesArray = array();
    if($_POST){

      //echo $title, " ", $brand, " ", $categories, " ", $price, " ", $list_price, " ", $sizes, " ", $description;

      $errors = array();
      $required = array('title', 'brand', 'list_price', 'parent', 'child', 'sizes');
      foreach($required as $field){
        if($_POST[$field] == ''){
          $errors[] = 'Tutti i campi Obbligatori sono richiesti.';
          break;
        }
      }
      if(!empty($_FILES)){
        $photo = $_FILES['photo'];
        $name = $photo['name'];
        $nameArray = explode('.', $name);
        $fileName = $nameArray[0];
        $fileExt = $nameArray[1];
        $mime = explode('/', $photo['type']);
        $mimeType = $mime[0];
        $mimeExt = $mime[1];
        $tmpLoc = $photo['tmp_name'];
        $fileSize = $photo['size'];
        $allowed = array('png', 'jpg', 'jpeg', 'gif');
        $uploadName = md5(microtime()).'.'.$fileExt;
        $uploadPath = BASEURL.'images/prodotti/'.$uploadName;
        $dbpath = '/progetto/images/prodotti/'.$uploadName;
        if($mimeType != 'image'){
          $errors[] = 'Il file deve essere un immagine.';
        }
        if(!in_array($fileExt, $allowed)){
          $errors[] = 'La foto deve essere .png, .jpg, .jpeg, gif.';
        }
        if($fileSize > 25000000){
          $errors[] = 'La grandezza del file deve essere minore di 25mb.';
        }
        if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')){
          $errors[] = 'L estensione del file non corrisponde con quella del file';
        }
      }
      if(!empty($errors)){
        echo display_errors($errors);
      }else{
        //aggiorna database
        if(!empty($_FILES)){
          move_uploaded_file($tmpLoc, $uploadPath);
        }
        $insertSql = "INSERT INTO prodotti (Titolo, Prezzo, PrezzoOutlet, Brand, Categoria, Taglie, Immagine, Descrizione)
                      VALUES ('$title', '$price', '$list_price', '$brand', '$category', '$sizes', '$dbpath', '$description')";
        if(isset($_GET['edit'])){
          $insertSql = "UPDATE prodotti SET Titolo = '$title', Prezzo = '$price', PrezzoOutlet = '$list_price',
                        Brand = '$brand', Categoria = '$category', Taglie = '$sizes', Immagine = '$dbpath', Descrizione = '$description'
                        WHERE CodiceProdotto = '$edit_id'";
        }

        $db->query($insertSql);
        header('Location: prodotti.php');
      }
    }

?>
  <h2 class="text-center"><?=((isset($_GET['edit']))?'Modifica':'Aggiungi un');?> prodotto</h2><hr>
  <form action="prodotti.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1');?>" method="post" enctype="multipart/form-data">
    <div class="form-group col-md-3">
      <label for="title">Titolo*:</label>
      <input type="text" name="title" class="form-control "id="title" value="<?=$title;?>">
    </div>
    <div class="form-group col-md-3">
      <label for="brand">Brand*:</label>
      <select class="form-control" id="brand" name="brand">
        <option value="<?=(($brand == '')?' selected':'');?>"></option>
        <?php while($b = mysqli_fetch_assoc($brandQuery)): ?>
          <option value="<?=$b['CodiceBrand'];?>"<?=(($brand == $b['CodiceBrand'])?' selected':'');?>><?=$b['Nome'];?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="parent">Parent*:</label>
      <select class="form-control" id="parent" name="parent">
        <option value=""<?=(($parent == '')?'selected':'');?>></option>
        <?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
          <option value="<?=$p['CodiceCategoriaPadre'];?>"<?=(($parent == $p['CodiceCategoriaPadre'])?' selected':'');?>><?=$p['Nome'];?></option>
        <?php endwhile; ?>
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="child">Categoria*:</label>
      <select id="child" name="child" class="form-control">
      </select>
    </div>
    <div class="form-group col-md-3">
      <label for="price">Prezzo:</label>
      <input type="text" id="price" name="price" class="form-control" value="<?=$price;?>">
    </div>
    <div class="form-group col-md-3">
      <label for="list_price">PrezzoOutlet*:</label>
      <input type="text" id="list_price" name="list_price" class="form-control" value="<?=$list_price;?>">
    </div>
    <div class="form-group col-md-3">
      <label>Quantita' e Taglie*:</label>
      <button class="btn btn-default form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Quantita' e Taglie</button>
    </div>
    <div class="form-group col-md-3">
      <label for="sizes">Taglie e Quantita' Preview</label>
      <input type="text" class="form-control" name="sizes" id="sizes" value="<?=$sizes;?>" readonly>
    </div>
    <div class="form-group col-md-6">
      <?php if($saved_image != ''): ?>
        <div class="saved-image">
          <img src="<?=$saved_image;?>" alt="saved image"/><br>
          <a href="prodotti.php?delete_image=1&edit=<?=$edit_id;?>" class="text-danger">Elimina Foto</a>
        </div>
      <?php else: ?>
      <label for="photo">Immagine Prodotto*:</label>
      <input type="file" name="photo" id="photo" class="form-control">
    <?php endif; ?>
    </div>
    <div class="form-group col-md-6">
      <label for="description">Descrizione:</label>
      <textarea id="description" name="description" class="form-control" rows="6"><?=$description;?></textarea>
    </div>
    <div class="form-group pull-right">
      <a href="prodotti.php" class="btn btn-default">Cancella</a>
      <input type="submit" value="<?=((isset($_GET['edit']))?'Modifica':'Aggiungi');?> Prodotto" class="btn btn-success pull-right">
    </div><div class="clearfix"></div>
  </form>
  <!-- Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="sizesModalLabel">Tagli e Quantita'</h4>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
        <?php for($i = 1; $i <= 12; $i++): ?>
          <div class="forms-group col-md-4">
            <label for="size<?=$i;?>">Taglia: </label>
            <input type="text" size="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
          </div>
          <div class="forms-group col-md-2">
            <label for="quantity<?=$i;?>">Quantita': </label>
            <input type="number" size="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" min="0" class="form-control">
          </div>
      <?php endfor; ?>
    </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Salva Modifiche</button>
      </div>
    </div>
  </div>
</div>

  <?php }else{
  $sql = "SELECT prodotti.CodiceProdotto, prodotti.Titolo, prodotti.Prezzo, prodotti.PrezzoOutlet, prodotti.Brand, prodotti.Categoria, prodotti.Immagine, prodotti.Descrizione, prodotti.Featured, prodotti.Taglie, prodotti.Deleted, categorie.CodiceCategoria, categorie.Nome, categorie.Parent, categoriepadri.CodiceCategoriaPadre, categoriepadri.Nome AS NomePadre FROM prodotti, categorie, categoriepadri WHERE (prodotti.Categoria = categorie.CodiceCategoria) AND (categorie.Parent = categoriepadri.CodiceCategoriaPadre) AND (deleted = 0)";
  $presult = $db->query($sql);

  if(isset($_GET['featured'])){
    $id = (int)$_GET['id'];
    $featured = (int)$_GET['featured'];
    $featuredSql = "UPDATE prodotti SET Featured = '$featured' WHERE CodiceProdotto = '$id'";
    $db->query($featuredSql);
    header('Location: prodotti.php');
    }

    //eliminare Prodotto
    if(isset($_GET['delete']) && !empty($_GET['delete'])){
      $delete_id = (int)$_GET['delete'];
      $delete_id = sanitize($delete_id);
      $sql_delete = "DELETE FROM prodotti WHERE CodiceProdotto = '$delete_id'";
      $db->query($sql_delete);
      header('Location: prodotti.php');
    }
?>
<h2 class="text-center">Prodotti</h2>
<a href="prodotti.php?add=1" class="btn btn-success pull-right" id="add-product-btn">Aggiungi Prodotto</a><div class="clearfix"></div>
<hr>
<table class="table table-border table-condensed table-striped">
  <thead><th></th><th>Prodotti</th><th>Prezzo</th><th>Categoria</th><th>Featured</th><th>Venduti</th></thead>
  <tbody>
    <?php while($product = mysqli_fetch_assoc($presult)):

      ?>
      <tr>
        <td>
          <a href="prodotti.php?edit=<?=$product['CodiceProdotto'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-pencil"></span></a>
          <a href="prodotti.php?delete=<?=$product['CodiceProdotto'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
        </td>
        <td><?=$product['Titolo'];?></td>
        <td><?=money($product['PrezzoOutlet']);?></td>
        <td><?=$product['Nome'], " - ", $product['NomePadre'];?></td>
        <td><a href="prodotti.php?featured=<?=(($product['Featured'] == 0)?'1':'0');?>&id=<?=$product['CodiceProdotto'];?>" class="btn btn-xs btn-default">
          <span class="glyphicon glyphicon-<?=(($product['Featured'] == 1)?'minus':'plus');?>"></span>
          </a>&nbsp <?=(($product['Featured'] == 1)?'Prodotto Featured':'');?></td>
        <td>0</td>
      </tr>
    <?php endwhile; ?>
  </tbody>
</table>
<?php } include 'includes/footer.php'?>
<script>
  jQuery('document').ready(function(){
    get_child_options('<?=$category;?>');
  });
</script>
