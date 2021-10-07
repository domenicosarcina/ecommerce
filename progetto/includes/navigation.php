<?php
  $sql = "SELECT * FROM categoriepadri";
  $pquery = $db->query($sql);
?>

<nav class="navbar navbar-default navbar-fixed-top" style="background-color:#DB2222;">
  <div class="container">
    <a href="/progetto/index.php" class="navbar-brand"><img style="padding:-5;width:200px; height:25px;" src="/progetto/images/home/logo.jpg"></a>
    <ul class="nav navbar-nav">
      <?php while($parent = mysqli_fetch_assoc($pquery)) : ?>
      <?php
        $parent_id = $parent['CodiceCategoriaPadre'];
        $sql2 = "SELECT categorie.Nome, categorie.CodiceCategoria FROM categorie, categoriepadri WHERE categorie.Parent = categoriepadri.CodiceCategoriaPadre AND categoriepadri.CodiceCategoriaPadre = '$parent_id'";
        $cquery = $db->query($sql2);
      ?>
      <!-- Prodotti Menu -->
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #fff;   background: #DB2222;  margin : auto; font-family: Helvetica, Arial, sans-serif;   font-weight: bold;   font-style : italic; font-size:20px;"><?php echo $parent['Nome']; ?><span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <?php while($child = mysqli_fetch_assoc($cquery)) : ?>
          <li><a href="categorie.php?cat=<?=$child['CodiceCategoria'];?>" style="color: #fff;   background: #DB2222;  margin : auto; font-family: Helvetica, Arial, sans-serif;   font-weight: bold;   font-style : italic; font-size:20px;"><?php echo $child['Nome']; ?></a></li>
        <?php endwhile; ?>
        </ul>
      </li>
    <?php endwhile; ?>
    <li><a href="carrello.php" style="color: #fff;   background: #DB2222;  margin : auto; font-family: Helvetica, Arial, sans-serif;   font-weight: bold;   font-style : italic; font-size:20px;"><span class="glyphicon glyphicon-shopping-cart" style="color: #fff; font-size:20px;"></span>Carrello</a></li>
  </ul>
  </div>
</nav>
