<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/progetto/core/init.php';
  if(!is_logged_id()){
    login_error_redirect();
  }
  include 'includes/head.php';
  include 'includes/navigation.php';

  $ordini = $db->query("SELECT * FROM carte WHERE Pagato = 1 OR Pagato = 2");

if(isset($_GET['confirm'])){
  $id_ordine = (int)$_GET['confirm'];
  $id_ordine = sanitize($id_ordine);
  $db->query("UPDATE carte SET Pagato = 2 WHERE CodiceCarta = '{$id_ordine}'");
  header('Location: ordini.php');
}

if(isset($_GET['delete'])){
  $id_ordine = (int)$_GET['delete'];
  $id_ordine = sanitize($id_ordine);
  $db->query("UPDATE carte SET Pagato = 0 WHERE CodiceCarta = '$id_ordine'");
  $itemQ = $db->query("SELECT * FROM carte WHERE CodiceCarta = '{$id_ordine}'");
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
  setcookie('SBwi72UCklwiqzz2', FALSE, -1, '/', 'localhost');
  header('Location: ordini.php');
}

  ?>

<h2 class="text-center">Ordini in Sospeso</h2><hr>
<table class="table table-border table-striped table-condensed">
  <thed><th>Elimina/Conferma</th><th>Data Scadenza</th><th>Codice Ordine</th><th>Scaduto</th><th>Stato</th></thead>
  <tbody>
    <?php while($ordine = mysqli_fetch_assoc($ordini)) :
      $today = date("Y-m-d");
      $scadenza = $ordine['Data_Scadenza'];
      $today_time = strtotime($today);
      $scadenza_time = strtotime($scadenza);
       ?>
    <tr>
      <td>
        <?php if($ordine['Pagato'] == 1){ ?>
        <a href="ordini.php?delete=<?=$ordine['CodiceCarta'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-remove"></span></a>
        <?php } ?>
        <a href="ordini.php?confirm=<?=$ordine['CodiceCarta'];?>" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-ok"></span></a>
      </td>
      <td><?=$ordine['Data_Scadenza'];?></td>
      <td><?="#".$ordine['CodiceCarta'];?></td>
      <td><?=(($today_time > $scadenza_time)?'<div class="text-danger">Scaduto! Devi eliminarlo</div>':'Non Scaduto');?></td>
      <td><?=(($ordine['Pagato'] == 1)?'Ordinato':'Pagato e ritirato');?></td>
    </tr>
  <?php endwhile; ?>
  </tbody>
</table>



<?php include 'includes/footer.php'; ?>
