</div><br><br>

<div class="col-md-12 text-center">
<hr>
<img src="/progetto/images/home/logo.jpg" style="width:300px; height:100px;"></img><br><br><br><h2>Contatti</h2><br><br>
<a href="http://www.facebook.it"><img src="/progetto/images/home/facebook.png" style="width:140px; height:90px;"></img></a> <a href="http://www.instagram.it"><img src="/progetto/images/home/instagram.png" style="width:100px; height:100px;"><br><br><br></a>

<h3>Tel: +39 1234567890<br><br>
Indirizzo: Bari, Via delle vie, 99</h3><br><br><hr>
  &copy; Copyright 2012-2019 StreetWear Italia<br><br>
</div>

<script>
  jQuery(window).scroll(function(){
    var vscroll = jQuery(this).scrollTop();
    console.log(vscroll);
    jQuery('#logotext').css({
      "transform" : "translate(0px, "+vscroll/2+"px)"
    });
  });

  function detailsmodal(CodiceProdotto){
    var data = {"CodiceProdotto" : CodiceProdotto};
    jQuery.ajax({
      url: '/progetto/includes/detailsmodulo.php',
      method: "post",
      data: data,
      success: function(data){
        jQuery('body').append(data);
        jQuery('#details-modal').modal('toggle');
      },
      error: function(){
        alert("Qualcosa e' andato storto");
      }
    });
  }

  function update_cart(mode,edit_id,edit_size){
    var data = {"mode" : mode, "edit_id" : edit_id, "edit_size" : edit_size};
    jQuery.ajax({
      url : '/progetto/admin/parsers/update_cart.php',
      method : "post",
      data: data,
      success : function(){location.reload();},
      error : function(){alert("Qualcosa e' andato storto");},
    });
  }

 function add_to_cart(){
    jQuery('#modal_errors').html("");
    var size = jQuery('#size').val();
    var quantity = jQuery('#quantity').val();
    var available = jQuery('#available').val();
    var error = '';
    var data = jQuery('#add_product_form').serialize();
    if(size == '' || quantity == '' || quantity == 0){
      error += '<p class="text-danger text-center">Devi inserire una taglia ed una quantità</p>';
      jQuery('#modal_errors').html(error);
      return;
    }else if(quantity > available){
      error += '<p class="text-danger text-center">Scegli una quantità minore o uguale a quella disponibile per la taglia</p>';
      jQuery('#modal_errors').html(error);
      return;
    }
    else{
      jQuery.ajax({
        url: '/progetto/admin/parsers/add_cart.php',
        method: 'post',
        data: data,
        success : function(){
          location.reload();
        },
        error : function(){alert("Qualcosa e' andato storto");}
      });
    }
  }
</script>
</body>
</html>
