<?php
  require_once $_SERVER['DOCUMENT_ROOT'].'/progetto/core/init.php';
  $parentID = (int)$_POST['parentID'];
  $selected = sanitize($_POST['selected']);
  $childQuery = $db->query("SELECT categorie.CodiceCategoria, categorie.Nome, categoriepadri.CodiceCategoriaPadre, categoriepadri.Nome AS CategoriaPadre FROM categorie, categoriepadri WHERE Parent = '$parentID' AND categorie.Parent = categoriepadri.CodiceCategoriaPadre ORDER BY categorie.Nome");
  ob_start();?>
    <option value=""></option>
    <?php while($child = mysqli_fetch_assoc($childQuery)): ?>
      <option value="<?=$child['CodiceCategoria'];?>"<?=(($selected == $child['CodiceCategoria'])?' selected':'');?>><?=$child['Nome'];?></option>
    <?php endwhile; ?>
 <?php echo ob_get_clean();?>
