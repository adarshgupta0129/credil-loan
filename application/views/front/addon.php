<section class="dlab-bnr-inr overlay-black-middle bg-pt" style="background-image:url(<?php echo base_url() ?>assets/images/bnr1.jpg);">
   <div class="container">
      <div class="dlab-bnr-inr-entry text-left">
         <h1 class="text-white"> <?php $productDetail = productDetails(get('productId'), get('variantId'))?>
            Add on something to make it extra special for <label class="text-default"> <b><?=$productDetail->pr_name?> (<?=$productDetail->pr_vari_unit_value?> <?=$productDetail->unit_name?>)</b></label>
         </h1>
         <div class="breadcrumb-row">
            <ul class="list-inline">
               <li><a href="<?php echo base_url() ?>">Home</a></li>
               <li>Add on</li>
            </ul>
         </div>
      </div>
   </div>
</section>
<!-- contact area -->
<section class="section-full content-inner">
   <!-- Product -->
   <div class="container">
   <div class="row">
      <div class="col-md-9 add_div" id="addonitems">
         <?php if(count($recommended) > 0): ?>
         <h1>Recommended Addon On Selected Product <hr></h1>
         <div class="row">
            <?php foreach($recommended as $ad){ ?>
            <div class="blog-post col-6 col-md-2 col-sm-3 blog-lg blog-rounded">
               <div class="image_addon">
                  <img src="<?=base_url()?>images/addon/<?=$ad->addon_id?>/x/<?=$ad->addon_image?>" alt="">
               </div>
               <div class="dlab-info">
                  <div class="dlab-post-title">
                     <p class="text-center add-title"><?=$ad->addon_name?></p>
                     <h4 class="price text-center"><i class="fa fa-inr"></i> <?=$ad->addon_amount?></h4>
                     <div class="addon-nav">
                        <div class="add">
                           <input type="checkbox" class="checkboxes" 
                              id="<?php echo $ad->addon_id; ?>" 
                              name="<?php echo $ad->addon_id; ?>" 
                              onClick="str_to_user_check(this.value);" 
                              value="<?php echo $ad->addon_id; ?>"
                              <?= array_search($ad->addon_id, array_column($already_added, 'cart_product_id')) ? "checked" : "" ?>
                              />
                        </div>
                        <div class="count-inlineflex">
                           <select name="ord_qty<?php echo $ad->addon_id; ?>" id="ord_qty<?php echo $ad->addon_id; ?>">
                              <?php
                                 for ($i = 1; $i <= $ad->addon_max_qty; $i++) { 
                                 	$is_selected=""; 
                                 	if(in_array($ad->addon_id, array_column($already_added, 'cart_product_id')))
                                 		if($already_added[array_search($ad->addon_id, array_column($already_added, 'cart_product_id'))]['cart_qty'] == $i)
                                 			$is_selected="Selected";
                                 ?>
                              <option value="<?= $i; ?>" <?=$is_selected ?>><?= $i; ?> Qty</option>
                              <?php } ?>
                           </select>
                           <input type="hidden" id="<?="stock".$ad->addon_id; ?>" value="<?=$ad->addon_max_qty?>" />
                           <input type="hidden" id="<?="amt".$ad->addon_id; ?>" value="<?=$ad->addon_amount?>" />
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php } ?>
            </div>
            <?php endif ?>
         
         <h1>
            Available Addon On Selected Product 
            <hr>
         </h1>
         <div class="row">
            <?php foreach($addon as $ad){ ?>
            <div class="blog-post col-6 col-md-2 col-sm-3 blog-lg blog-rounded">
               <div class="image_addon">
                  <img src="<?=base_url()?>images/addon/<?=$ad->addon_id?>/x/<?=$ad->addon_image?>" alt="">
               </div>
               <div class="dlab-info">
                  <div class="dlab-post-title">
                     <p class="text-center add-title"><?=$ad->addon_name?></p>
                     <h4 class="price text-center"><i class="fa fa-inr"></i> <?=$ad->addon_amount?></h4>
                     <div class="addon-nav">
                        <div class="add">
                           <input type="checkbox" class="checkboxes" 
                              id="<?php echo $ad->addon_id; ?>" 
                              name="<?php echo $ad->addon_id; ?>" 
                              onClick="str_to_user_check(this.value);" 
                              value="<?php echo $ad->addon_id; ?>"
                              <?= in_array($ad->addon_id, array_column($already_added, 'cart_product_id')) ? "checked" : "" ?>
                              />
                        </div>
                        <div class="count-inlineflex">
                           <select name="ord_qty<?php echo $ad->addon_id; ?>" id="ord_qty<?php echo $ad->addon_id; ?>">
                              <?php
                                 for ($i = 1; $i <= $ad->addon_max_qty; $i++) { 
                                 	$is_selected=""; 
                                 	if(in_array($ad->addon_id, array_column($already_added, 'cart_product_id')))
                                 		if($already_added[array_search($ad->addon_id, array_column($already_added, 'cart_product_id'))]['cart_qty'] == $i)
                                 			$is_selected="Selected";
                                 ?>
                              <option value="<?= $i; ?>" <?=$is_selected ?>><?= $i; ?> Qty</option>
                              <?php } ?>
                           </select>
                           <input type="hidden" id="<?="stock".$ad->addon_id; ?>" value="<?=$ad->addon_max_qty?>" />
                           <input type="hidden" id="<?="amt".$ad->addon_id; ?>" value="<?=$ad->addon_amount?>" />
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php } ?>
         </div>
      </div>
    
      <div class="col-md-3">
      <div id="navigation">
	  
	  <h1>
		  Price Details
           
         </h1>
	   <hr>
         <div class="addonfooter">
            <div class="final-price">
           
                  <div class="addonfooter-child">
                     <small>Product Amount</small>
                     <div id="base-price" class="price3">
                        <span class="h-price webprice"><i class="fa fa-inr"></i> <?=cart_amount($session_id, get('cartId'), 1)?></span>
                     </div>
                  </div>
     
                  <div class="addonfooter-child">
                  <span class="sign">+</span>
                     <small >Addons</small>
                     <div class="price3">
                        <span class="h-price webprice" id="addonAmt"><i class="fa fa-inr"></i> 
                        <?php 
                           $addon_total=array_sum(array_map(function($v){return $v['addon_amount']*$v['cart_qty'];},$already_added));
                           echo $addon_total;
                           ?>
                        </span>
                     </div>
                  </div>
              
                  <div class="addonfooter-child">
                  <span class="sign">+</span>
                     <small> Shipping<sup style="color:red">*</sup></small>
                     <div class="price3">
                        <span class="free-shipping">calculate on checkout</span>
                     </div>
                  </div>
              
				  <div class="addonfooter-child total-block">
                  <span class="sign">=</span>
                     <small>Total<sup style="color:red">*</sup></small>
                     <div class="price3">
                        <span class="h-price webprice" id="payTotal"><i class="fa fa-inr"></i> <?=(cart_amount($session_id, get('cartId'), 1)+$addon_total)?></span>
                     </div>
                  </div>
             
                  <form action="<?=base_url()?>welcome/addAddons?cartId=<?=get('cartId')?>" method="post" id="addon_form">						
                     <input type="hidden" id="txtquid" name="txtquid" />
                     <input type="hidden" id="tAmt" name="tAmt" value="0" />
                     <button type="submit" class="btn btn-primary btn-block d-none">Add items</button>
                  </form>
              
               <a href="<?=base_url()?>welcome/checkout" class="btn btn-block btn-danger text-uppercase">Continue Checkout <i class="las la-arrow-right"></i></a>
     
         </div>
      </div>
	  
	  
	  
	  
   </div>
   </div>
   <!-- Product END -->
</section>
<script>
         var quid = "";
         var cartAmt = <?=cart_amount($session_id, get('cartId'), 1)?>;
         function str_to_user_check(ord_id)
         {
         	var resu = $('#ord_qty' + ord_id).val();
         	var stock = $('#stock' + ord_id).val();
         	let amt = 0, dp = 0, bv = 0, pv = 0, gst = 0, payamt = 0;
         	let checkbox_=false;
         	if (resu == 0 && resu == '')
         	{
         		alert('Please fill order quantity then checked');
         		$('#ord_qty' + ord_id).css('color', 'red');
         		document.getElementById(ord_id).checked = false;
         	} 
         	else
         	{
         		if(parseInt(resu) > parseInt(stock) || parseInt(resu) <= parseInt(0))
         		{
         			alert('Please fillorder quantity  less than or equal ' + stock);
         			$('#ord_qty' + ord_id).css('color', 'red');
         			$('#' + ord_id).prop('checked', false)
         		}
         		$('#ord_qty' + ord_id).css('color', 'black');
         		quid = "";
         		var collection = $("#addonitems");
         		var inputs = collection.find("input[type=checkbox]");
         		for (var x = 0; x < inputs.length; x++)
         		{
         			var id = inputs[x].id;
         			if (document.getElementById(id).checked)
         			{
         				quid= id + "-" + document.getElementById("ord_qty" + id).value + "," + quid;
         				amt = ((parseFloat(document.getElementById("amt" + id).value) * parseFloat(document.getElementById("ord_qty" + id).value)) + parseFloat(amt)).toFixed(2);
         				$("#ord_qty"+id).attr("disabled",true);
         			}
         			else
         			{
         				$("#ord_qty"+id).attr("disabled",false);
         			}
         		}
         			$("#txtquid").val(quid);
         		$("#tAmt").val(amt);
         		$("#addonAmt").html(amt);
         		$("#payTotal").html((parseFloat(cartAmt)+parseFloat(amt)).toFixed(2));
         		console.log('click');
         	}
         }
         
         $(".checkboxes").click(function(){
         	
         	if($(this).prop("checked") == true){
         		//console.log("Checkbox is checked.");
         		$.ajax({
         			type:$("#addon_form").attr('method'),
         			url:$("#addon_form").attr('action'),
         			data:$("#addon_form").serialize(),
         			success:function(res){
         				bootbox.alert("Addon Added Successfully.");
         			}
         		})
         	}
         	else if($(this).prop("checked") == false){
         		//console.log("Checkbox is unchecked.");
         		var p=$(this).val();
         		$.ajax({
         			url: "<?=base_url()?>/welcome/remove_addon",
         			type: "post",data: {product:p,parent:"<?=get('cartId')?>"},
         			success: function(data) { 
         				bootbox.alert(data);
         			},
         			
         		});
         	}
         })
         var elementPosition = $('#navigation').offset();

      $(window).scroll(function(){
        if($(window).scrollTop() > elementPosition.top){
		      $('#navigation').css('position','sticky').css({'top':'105px','width':'100%','margin-left':'2%'});
        } else {
		      $('#navigation').css('position','initial').css({'top':'90px','width':'100%','margin-left':'2%'});
        }    
      });
      </script>
	  
	  
	  
	  
	  
<style>
   .blog-post.blog-rounded {
   padding-top: 10px;
   }
   .blog-post {
   margin-bottom: 25px;
   }
   input[type=number]::-webkit-inner-spin-button, 
   input[type=number]::-webkit-outer-spin-button { 
   -webkit-appearance: none;
   -moz-appearance: none;
   appearance: none;
   margin: 0; 
   }
   .image_addon{
   max-height: 140px;
   min-height: 140px;	
   }
</style>