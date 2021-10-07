<nav class="navbar navbar-default navbar-fixed-top" style="background-color:#DB2222;">
  <div class="container">
    <a href="/progetto/admin/index.php" class="navbar-brand"><img style="padding:-5;width:200px; height:25px;" src="/progetto/images/home/logo.jpg"></a>
    <ul class="nav navbar-nav">
      <!-- Prodotti Menu -->
      <li><a href="brands.php" style="color: #fff;   background: #DB2222;  margin : auto; font-family: Helvetica, Arial, sans-serif;   font-weight: bold;   font-style : italic; font-size:20px;">Brand</a></li>
      <li><a href="categorie.php" style="color: #fff;   background: #DB2222;  margin : auto; font-family: Helvetica, Arial, sans-serif;   font-weight: bold;   font-style : italic; font-size:20px;">Categorie</a></li>
      <li><a href="prodotti.php" style="color: #fff;   background: #DB2222;  margin : auto; font-family: Helvetica, Arial, sans-serif;   font-weight: bold;   font-style : italic; font-size:20px;">Prodotti</a></li>
      <li><a href="ordini.php" style="color: #fff;   background: #DB2222;  margin : auto; font-family: Helvetica, Arial, sans-serif;   font-weight: bold;   font-style : italic; font-size:20px;">Ordini</a></li>
      <?php if(has_permission('admin')): ?>
        <li><a href="utenti.php" style="color: #fff;   background: #DB2222;  margin : auto; font-family: Helvetica, Arial, sans-serif;   font-weight: bold;   font-style : italic; font-size:20px;">Utenti</a></li>
      <?php endif; ?>
      <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #fff;   background: #DB2222;  margin : auto; font-family: Helvetica, Arial, sans-serif;   font-weight: bold;   font-style : italic; font-size:20px;">Ciao <?=$user_data['first'];?>!
          <span class="caret"></span>
        </a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="cambia_password.php" style="color: #fff;   background: #DB2222;  margin : auto; font-family: Helvetica, Arial, sans-serif;   font-weight: bold;   font-style : italic; font-size:20px;">Cambia Passoword</a></li>
          <li><a href="logout.php" style="color: #fff;   background: #DB2222;  margin : auto; font-family: Helvetica, Arial, sans-serif;   font-weight: bold;   font-style : italic; font-size:20px;">Log Out</a></li>
        </ul>
      </li>
      <!-- <li class="dropdown">
        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $parent['Nome']; ?><span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu">
          <li><a href="#"></a></li>
        </ul>
      </li> -->
  </div>
</nav>
