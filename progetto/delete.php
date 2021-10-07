<?php

ob_start();

require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';


$domain = ($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false;
//sistema inventario
$itemQ = $db->query("SELECT * FROM carte WHERE CodiceCarta = '{$cart_id}'");
$iresults = mysqli_fetch_assoc($itemQ);
$items = json_decode($iresults['Oggetti'],true);
foreach($items as $item){
  $newSizes = array();
  $item_id = $item['id'];
  $productQ = $db->query("SELECT Taglie FROM prodotti WHERE CodiceProdotto = '{$item_id}'");
  $product = mysqli_fetch_assoc($productQ);
  $sizes = sizesToArray($product['Taglie']);
  foreach($sizes as $size){
    if($size['size'] == $item['size']){
      $q = $size['quantity'] + $item['quantity'];
      $newSizes[] = array('size' => $size['size'], 'quantity' => $q);
    }else{
      $newSizes[] = array('size' => $size['size'], 'quantity' => $size['quantity']);
    }
  }
  $sizeString = sizesToString($newSizes);
  $db -> query("UPDATE prodotti SET Taglie = '{$sizeString}' WHERE CodiceProdotto = '{$item_id}'");
}

  $db -> query("DELETE FROM carte WHERE CodiceCarta = '{$cart_id}'");
  setcookie('SBwi72UCklwiqzz2', FALSE, -1, '/', 'localhost');

?>

<h4 class="text-center"> Il tuo ordine e' stato annullato, ritorna alla homepage del sito </h4>
<form action="index.php"><center><button type="submit" class="btn btn-success">Home</center></button></h4>

<?php include 'includes/footer.php'; ?>
