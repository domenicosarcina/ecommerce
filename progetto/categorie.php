<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';
  include 'includes/leftbar.php';

  if(isset($_GET['cat'])){
    $cat_id = sanitize($_GET['cat']);
  }
  else{
    $cat_id = '';
  }

  $sql = "SELECT * FROM prodotti WHERE Categoria = '$cat_id'";
  $productQ = $db->query($sql);

  $category = get_category($cat_id);
?>

<!-- Main content -->
<div class="col-md-8">
  <div class="row">
    <h2 class="text-center"><?=$category['Nome']. ' ' . $category['Padre'];?></h2>
    <?php while($product = mysqli_fetch_assoc($productQ)) : ?>
      <div class="col-md-3">
        <h4><center><?php echo $product['Titolo']; ?></center></h4>
        <center><img src="<?php echo $product['Immagine']; ?>" alt="Felpa Gucci" class="img-size" />
        <p class="list-price text-danger">List Price: <s>€<?php echo $product['Prezzo']; ?></s></p>
        <p class="price">Prezzo Store: €<?php echo $product['PrezzoOutlet']; ?></p>
        <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?php echo $product['CodiceProdotto']; ?>)">Dettagli</button></center>
      </div>
  <?php endwhile; ?>
  </div>
</div>

<?php
  include 'includes/rightbar.php';
  include 'includes/footer.php';
?>
