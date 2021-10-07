<?php

  ob_start();
  require_once 'core/init.php';
  include 'includes/head.php';
  include 'includes/navigation.php';
  include 'includes/headerpartial.php';

  if($cart_id != ''){
    $cartQ = $db->query("SELECT * FROM carte WHERE CodiceCarta = '{$cart_id}'");
    $result = mysqli_fetch_assoc($cartQ);
    if($result['Pagato'] == 2){
        setcookie('SBwi72UCklwiqzz2', FALSE, -1, '/', 'localhost');
        header('Location: carrello.php');
      }
    $items = json_decode($result['Oggetti'],true);
    $i = 1;
    $sub_total = 0;
    $item_count = 0;
  }
 ?>

<div class="col-md-12">
  <div class="row">
    <h2 class="text-center">Il mio carrello</h2><hr>
    <?php if($cart_id == ''): ?>
      <div class="bg-danger">
        <p class="text-center text-danger">
          Il tuo carrello e' vuoto.
        </p>
      </div>
    <?php else: ?>
      <table class="table table-border table-condensed table-striped">
        <thead><th>#</th><th>Oggetto</th><th>Prezzo</th><th>Quantita'</th><th>Taglia</th><th>Sub Totale</th></thead>
        <tbody>
          <?php
            foreach($items as $item){
              $product_id = $item['id'];
              $productQ = $db->query("SELECT * FROM prodotti WHERE CodiceProdotto = '{$product_id}'");
              $product = mysqli_fetch_assoc($productQ);
              $sArray = explode(',',$product['Taglie']);
              foreach($sArray as $sizeString){
                $s = explode(':',$sizeString);
                if($s[0] == $item['size']){
                  $available = $s[1];
                }
              }
              ?>
              <tr>
                <td><?=$i;?></td>
                <td><?=$product['Titolo'];?></td>
                <td><?=money($product['PrezzoOutlet']);?></td>
                <td>
                  <button class="btn btn-xs btn-default" onclick="update_cart('removeone','<?=$product['CodiceProdotto'];?>','<?=$item['size'];?>');">-</button>
                  <?=$item['quantity'];?>
                  <?php if($item['quantity'] < $available): ?>
                  <button class="btn btn-xs btn-default" onclick="update_cart('addone','<?=$product['CodiceProdotto'];?>','<?=$item['size'];?>');">+</button>
                <?php else: ?>
                  <span class="text-danger">Max</span>
                <?php endif; ?>
                </td>
                <td><?=$item['size'];?></td>
                <td><?=money($item['quantity'] * $product['PrezzoOutlet']);?></td>
              </tr>
              <?php $i++;
              $item_count += $item['quantity'];
              $sub_total += ($product['PrezzoOutlet'] * $item['quantity']);
            }
            $tax = ($sub_total*22)/100;
            $grand_total = $tax + $sub_total;
             ?>
        </tbody>
      </table>
      <table class="table table-border table-condensed text-right totals table-auto pull-left">
        <legend>Totale</legend>
        <thead><th>Prodotti Totali</th><th>Sub Totale</th><th>Tasse</th><th>Totale</th></thead>
        <tbody>
          <tr>
            <td><?=$item_count;?></td>
            <td><?=money($sub_total);?></td>
            <td><?=money($tax);?></td>
            <td class="bg-success"><?=money($grand_total);?></td>
          </tr>
        </tbody>
      </table>
      <!-- Check Out Button -->
      <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#checkoutModal">
        Check Out -->
      </button>
      <?php if($result['Pagato'] == 1){ ?>
        <form action="delete.php" method="post">
        <button type="submit" class="btn btn-primary pull-right" id="delete_button">Cancella Ordine</button>
        </form>
      <?php }?>

      <!-- Modal -->
      <div class="modal fade" id="checkoutModal" tabindex="-1" role="dialog" aria-labelledby="#checkoutModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="checkoutModalLabel">Check Out</h4>
            </div>
            <div class="modal-body">
              Sei sicuro di voler pre-ordinare questi prodotti?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Chiudi</button>
              <form action="thankyou.php" method="post">
              <button type="submit" class="btn btn-primary" id="checkout_button">Ordina</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    <?php endif; ?>
  </div>
</div>

 <?php include 'includes/footer.php'; ?>
