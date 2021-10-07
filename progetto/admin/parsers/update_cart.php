<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/progetto/core/init.php';
  $mode = sanitize($_POST['mode']);
  $edit_size = sanitize($_POST['edit_size']);
  $edit_id = sanitize($_POST['edit_id']);
  $cartQ = $db->query("SELECT * FROM carte WHERE CodiceCarta = '{$cart_id}'");
  $result = mysqli_fetch_assoc($cartQ);
  $items = json_decode($result['Oggetti'],true);
  $updated_items = array();
  $domain = (($_SERVER['HTTP_HOST'] != 'localhost')?'.'.$_SERVER['HTTP_HOST']:false);

  if($mode == 'removeone'){
    foreach($items as $item){
      if($item['id'] == $edit_id && $item['size'] == $edit_size){
        $item['quantity'] = $item['quantity'] - 1;
      }
      if($item['quantity'] > 0){
        $updated_items[] = $item;
      }
    }
  }
  if($mode == 'addone'){
    foreach($items as $item){
      if($item['id'] == $edit_id && $item['size'] == $edit_size){
        $item['quantity'] = $item['quantity'] + 1;
      }
      $updated_items[] = $item;
    }
  }

  if(!empty($updated_items)){
    $json_updated = json_encode($updated_items);
    $db->query("UPDATE carte SET Oggetti = '{$json_updated}' WHERE CodiceCarta = '{$cart_id}'");
    $_SESSION['success_flash'] = 'Il tuo carrello e\' stato aggoirnato';
  }

  if(empty($updated_items)){
    $db->query("DELETE FROM carte WHERE CodiceCarta = '{$cart_id}'");
    setcookie(CART_COOKIE,'',1,"/",$domain,false);
  }

?>
