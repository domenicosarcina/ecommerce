<?php

require_once 'core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';
include 'includes/headerpartial.php';

//sistema inventario
$itemQ = $db->query("SELECT * FROM carte WHERE CodiceCarta = '{$cart_id}'");
$iresults = mysqli_fetch_assoc($itemQ);
if($iresults['Pagato'] == 0){
$items = json_decode($iresults['Oggetti'],true);
foreach($items as $item){
  $newSizes = array();
  $item_id = $item['id'];
  $productQ = $db->query("SELECT Taglie FROM prodotti WHERE CodiceProdotto = '{$item_id}'");
  $product = mysqli_fetch_assoc($productQ);
  $sizes = sizesToArray($product['Taglie']);
  foreach($sizes as $size){
    if($size['size'] == $item['size']){
      $q = $size['quantity'] - $item['quantity'];
      $newSizes[] = array('size' => $size['size'], 'quantity' => $q);
    }else{
      $newSizes[] = array('size' => $size['size'], 'quantity' => $size['quantity']);
    }
  }
  $sizeString = sizesToString($newSizes);
  $db -> query("UPDATE prodotti SET Taglie = '{$sizeString}' WHERE CodiceProdotto = '{$item_id}'");
}


$db->query("UPDATE carte SET Pagato = 1 WHERE CodiceCarta = '{$cart_id}'");

?>

<h4 class="text-center">Grazie per aver ordinato i nostri prodotti.<br>
  Il tuo ordine e' stato ricevuto e potrai pagare e ritirare in negozio.
  Ricordati il codice del tuo ordine.<br><br></h4>
<h2 class="text-center">  Codice Ordine: <?="#".$cart_id;?> </h2><br><br>
<h4 class="text-center text-danger">  Hai al massimo 30 giorni di tempo, dopodichè il tuo ordine sarà cancellato. </h4>

<?php }else{ ?>
  <h4 class="text-danger text-center"> Il tuo ordine e' stato già ricevuto. Completa l'ordine pagandolo e ritirandolo nel negozio! </h4><br>
  <h2 class="text-center"> Codice Ordine: <?="#".$cart_id;?> </h2><br><br>
  <h4 class="text-danger text-center"> Data Scadenza Ordine: <?=$iresults['Data_Scadenza'];?> <br><br>
  <form method="post" action="delete.php">
    Se desideri disdire l'ordine, clicca qui <button type="submit">Cancella Ordine</button>
  </form></h4>
<?php } include 'includes/footer.php'; ?>
