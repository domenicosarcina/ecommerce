<?php
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerfull.php';
  include 'includes/leftbar.php';

  $sql = "SELECT * FROM prodotti WHERE Featured = 1";
  $featured = $db->query($sql);
?>

<!-- Main content -->
<div class="col-md-8">
  <div class="row">
    <h2 class="text-center">Featured Products</h2>
    <?php while($product = mysqli_fetch_assoc($featured)) : ?>
      <div class="col-md-3">
        <h4><center><?php echo $product['Titolo']; ?></center></h4>
        <img src="<?php echo $product['Immagine']; ?>" alt="Felpa Gucci" class="img-size" />
        <p class="list-price text-danger">List Price: <s>€<?php echo $product['Prezzo']; ?></s></p>
        <p class="price">Prezzo Store: €<?php echo $product['PrezzoOutlet']; ?></p>
        <button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?php echo $product['CodiceProdotto']; ?>)">Dettagli</button>
      </div>
  <?php endwhile; ?>
  </div>
</div>

<?php
  include 'includes/rightbar.php';
  include 'includes/footer.php';
?>
