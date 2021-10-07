<?php
  function display_errors($errors){
    $display = '<ul class="bg-danger">';
    foreach($errors as $error){
      $display .= '<li class="text-danger">'.$error.'</li>';
    }
    $display .= '</ul>';
    return $display;
  }

  function sanitize($dirty){
    return htmlentities($dirty,ENT_QUOTES,"UTF-8");
  }

  function money($number){
    return '€'.number_format($number, 2);

  }

  function login($user_id){
    $_SESSION['SBUser'] = $user_id;
    global $db;
    $date = date("Y-m-d H:i:s");
    $db->query("UPDATE utenti SET Ultimo_Accesso = '$date' WHERE CodiceUtente = '$user_id'");
    $_SESSION['success_flash'] = 'Utente loggato con successo';
    header('Location: index.php');
  }

  function is_logged_id(){
    if(isset($_SESSION['SBUser']) && $_SESSION['SBUser'] > 0){
      return true;
    }
    return false;
  }

  function login_error_redirect($url = 'login.php'){
    $_SESSION['error_flash'] = 'Devi essere loggato per avere accesso a quella pagina';
    header('Location: '.$url);
  }

  function permission_error_redirect($url = 'login.php'){
    $_SESSION['error_flash'] = 'Non hai i permessi per avere accesso a quella pagina';
    header('Location: '.$url);
  }

  function has_permission($permission = 'admin'){
    global $user_data;
    $permissions = explode(',', $user_data['Permessi']);
    if(in_array($permission, $permissions, true)){
      return true;
    }
    return false;
  }

  function pretty_date($date){
    return date("d M, Y H:i",strtotime($date));
  }

  function get_category($child_id){
    global $db;
    $id = sanitize($child_id);
    $sql = "SELECT categoriepadri.CodiceCategoriaPadre, categoriepadri.Nome AS Padre, categorie.CodiceCategoria, categorie.Nome FROM categoriepadri, categorie WHERE categoriepadri.CodiceCategoriaPadre = categorie.Parent AND categorie.CodiceCategoria = '$id'";
    $query = $db->query($sql);
    $category = mysqli_fetch_assoc($query);
    return $category;

  }

  function sizesToArray($string){
    $sizesArray = explode(',',$string);
    $returnArray = array();
    foreach($sizesArray as $size){
      $s = explode(':',$size);
      $returnArray[] = array('size' => $s[0], 'quantity' => $s[1]);
    }
    return $returnArray;
  }

  function sizesToString($sizes){
    $sizeString = '';
    foreach($sizes as $size){
      $sizeString .= $size['size'].':'.$size['quantity'].',';
    }
    $trimmed = rtrim($sizeString,',');
    return $trimmed;
  }
