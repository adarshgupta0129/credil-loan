<script type="text/javascript" src="<?php echo base_url() ?>assets/zoom/xzoom.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/zoom/xzoom.css" media="all" />
<?php $available = check_product_on_pincode($product->pr_id, get('pincode'));?>
<div class="col-lg-4">
   <div class="xzoom-container">
      <?php $image = get_product_image(get('productId'), get('variantId'));
         $main_img = get_product_one_image(get('variantId'));
         ?>
      <img class="xzoom5 img-fluid" id="xzoom-magnific" src="<?=PROD_PATH.$main_img->pr_img_pr_vari_id.'/m/'.$main_img->pr_img_name?>" xoriginal="<?=PROD_PATH.$main_img->pr_img_pr_vari_id.'/x/'.$main_img->pr_img_name?>" />
      <div class="xzoom-thumbs">
         <?php foreach($image as $img){ ?>
         <a href="<?=PROD_PATH.$img->pr_img_pr_vari_id.'/x/'.$img->pr_img_name?>">
         <img class="xzoom-gallery5" class="img-fluid" src="<?=PROD_PATH.$img->pr_img_pr_vari_id.'/m/'.$img->pr_img_name?>" >
         </a>
         <?php } ?>
      </div>
   </div>
</div>
<script src="<?php echo base_url() ?>assets/zoom/setup.js"></script>
<div class="col-lg-8">
   <h1><?=$product->pr_name?>
      <span class="text-info" id="product_unit">(<?=$product->pr_vari_unit_value?> <?=$product->unit_name?>)</span>
   </h1>
   <div class="rating">
      <p class="rating1">4.6<i class="las la-star-half-alt"></i></p>
      <p class="Reviews">1549 Reviews</p>
   </div>
   <div class="price">
      <span><i class="fa fa-inr"></i><span id="money" data-money="<?=$product->pr_vari_actual_price?>"><?=$product->pr_vari_actual_price?></span></span>
      <del><i class="fa fa-inr"></i><?=$product->pr_vari_show_price?></del>
      <span class="badge bg-success"><i class="las la-tag"></i> <?=discount($product->pr_vari_actual_price, $product->pr_vari_show_price)?></span>
   </div>
   <p class="text-secondary">Inclusive of all taxes</p>
   <div class="text-secondary cake_type cake-type__wrap">
      <?php $p_type = egg_less_charge($product->pr_id);
         foreach($p_type["type"] as $k=>$v): ?>
            <span>
               <input type="radio" name="cake_type"  value="<?=$v->pr_type_type_id?>" id="egg<?=$k+1?>" data-price="<?=$product->pr_vari_actual_price?>" data-charge="<?=count($p_type["type"]) == "2" ? $p_type["fee"] : "0" ?>" <?=$k == 0 ? "checked" : ""?> > 
               <label for="egg<?=$k+1?>" class="<?=$v->type_name?>"><?=$v->type_name?> <span class="variants-icon"></span></label> 
            </span>
      <?php endforeach ?> 
   </div>

   <div class="row">
      <?php if(!empty($product_variant)){
         foreach($product_variant as $vari) {
         	if($vari->pr_vari_id <> get('variantId')) {
         	?>
      <div class="col-lg-2 text-center">
         <a href="javascript:void(0);" onclick="select_variant('<?=$vari->pr_vari_id?>')">
            <img class="img-fluid" src="<?=PROD_PATH.$vari->pr_vari_id.'/s/'.$vari->pr_img_name?>" />
            <p class="text-center"><?=$vari->pr_vari_unit_value?> <?=$vari->unit_name?><br>
               <i class="fa fa-inr"></i>
               <span class="text-danger"><?=$vari->pr_vari_actual_price?></span>
            </p>
         </a>
      </div>
      <?php } } } ?>
   </div>
   <div class="row">
      <div class="col-lg-5 text-center">
         <div class="input-group Pincode">
            <span class="input-group-text" id="basic-addon1"><i class="las la-map-marker"></i></span>
            <input type="text" id="pincode2" name="pincode2" class="form-control" placeholder="Enter Pincode" value="<?=get('pincode')?>" maxlength="6"  onkeyup="set_pincode(this.value)" />
         </div>
         <?php if($available == -1){ ?>
         <div class="text-danger"><i class="las la-map-marker"></i> <b>Enter correct Pincode for free timely delivery.</b></div>
         <?php } else if($available == 0){ ?>
         <div class="text-danger"><i class="las la-map-marker"></i> <b>Delivery not available for this pincode.</b></div>
         <?php } else if($available == 1){ ?>
         <div class="text-success"><i class="las la-map-marker"></i> <b>Pincode available for delivery.</b></div>
         <?php } ?>
      </div>

      <?php if($available == 1){ ?>
      <div class="col-lg-7 text-center">
         <div class="input-group date">
            <input type = "date" id='deliveryDate' name="deliveryDate" class="form-control" data-date="" data-date-format="MMMM DD, YYYY" min="<?=date('Y-m-d')?>" value="<?=date('Y-m-d')?>" />  
            <select class="form-control opt" name="dddeliverySlot" id="dddeliverySlot">
               <option value="0">Select Delivery Slot (Charges)</option>
            </select>
         </div>
         <div class="text-danger" id="deliveryDIV"><i class="las la-map-marker"></i> <b>Please select delivery details.</b></div>
      </div>
      <?php } ?>
      <div class="col-lg-12 text-center">
         <div class="mt-5 mb-3">
            <div class="row">
               <?php if($available == 1){ ?>
               <?php $cartId = ifProductInCart(get('variantId'), session('tmp_profile_id')); if($cartId == 0){ ?>
               <a href="javascript:void(0);" onclick="add_to_cart()" class="btn btn-info btn-block btnhover"><i class="ti-shopping-cart"></i> Add To Cart</a>
               <?php } else { ?> 
               <div class="col-lg-3 text-center">
                  <a href="<?=base_url()?>welcome/addon?cartId=<?=$cartId?>&productId=<?=get('productId')?>&variantId=<?=get('variantId')?>" class="btn btn-danger btn-block btnhover"><i class="ti-shopping-cart"></i> Add some Addons</a>
               </div>
               <div class="col-lg-5 text-center">
                  <button value="<?=$cartId?>" class="btn btn-danger btn-block btnhover" data-bs-toggle="modal" data-bs-target="#instructionModal"><i class="ti-info"></i> Add Message or Instruction For Store</button>
               </div>

				<?php if($product->is_designer == "YES"): ?>
					<div class="col-md-4">
						<select class="form-control opt select_flavour" name="ddFlavours" id="ddFlavour">
							<option value="">Choose Flavours</option>
							<?php foreach($flavours as $k=>$v): ?>
							<option value="<?=$v->m13_id ?>"><?=$v->m13_flavor ?> <?//=$v->m13_price ?></option>
							<?php endforeach ?>
						</select>
					</div>
				<?php endif ?>

               <?php } } else { ?>
               <a href="javascript:void(0);" onclick="select_variant('<?=get("variantId")?>')" class="btn btn-info btn-block btnhover"><i class="ti-reload"></i> &nbsp;&nbsp;Check Availability</a>
               <?php } ?>
            </div>
         </div>
      </div>
   </div>
   <h5>Description</h5>
   <div class="card p-2 mb-3 ">
      <?=$product->pr_description?>
   </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.3/moment.min.js"></script>
<style>
   #deliveryDate:before {
   position: absolute;
   top: 10px; left: 12px;
   content: attr(data-date);
   display: inline-block;
   color: black;
   }
   #deliveryDate::-webkit-datetime-edit, #deliveryDate::-webkit-inner-spin-button, #deliveryDate::-webkit-clear-button {
   display: none;
   }
   #deliveryDate::-webkit-calendar-picker-indicator {
   position: absolute;
   top: 10px;
   right: 5px;
   color: black;
   opacity: 1;
   }
</style>
<script>
   $("#deliveryDate").on("change", function() {
   this.setAttribute(
   "data-date",
   moment(this.value, "YYYY-MM-DD")
   .format( this.getAttribute("data-date-format") )
   ),
   getSlot(this.value, <?=get('productId')?>);
   }).trigger("change");
   
   function getSlot(deliveryDate, productId){
   $.ajax({
   url: "<?=base_url()?>welcome/getSlots",
   type: "post",
   dataType: "json",
   data: {
   deliveryDate: deliveryDate,productId: productId,
   },
   success: function(data) {
  	$("#dddeliverySlot").empty();
  	$("#dddeliverySlot").append("<option value=0>Select Delivery Slot (Charges)</option>");
   	$.each(data,function(i,item){				
   		$('#dddeliverySlot').append("<option value="+item.deli_slot_id+">"+item.deli_slot_start_time+" to "+item.deli_slot_end_time+" ( <?=CURRENCY?> "+item.deli_slot_charges+" )</option>");
   	});
   }		
   });
   } 	
   
   $("#ddFlavour").on("change", function() {
	   var f=$(this).val();
		if(f != ""){
			$.ajax({
				url: "<?=base_url()?>welcome/update_flavour",
  				type: "post",
				data: {product: get("productId"),flavour:f},
   				success: function(data) {
					bootbox.alert("Flavour Added Successfully");
			   }		
   			});
		}
   });
</script>
<div class="modal fade" id="instructionModal" tabindex="-1" aria-labelledby="instructionModalLabel" aria-hidden="true">
   <div class="modal-dialog">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title" id="instructionModalLabel">Add Instruction In Product</h5>
            <button type="button" class="btn btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="ti-close"></i></button>
         </div>
         <div class="modal-body">
            <form action="<?=base_url("welcome/save_instructions")?>" method="Post" encrypt="multipart/form-data" id="order_instruction_form">
               <input type="hidden" value="<?=get("productId")?>" name="product">
               <div class="form-group">
                  <label for="" class="control-label">Message</label>
                  <textarea name="order_message" id="instruction_message" class="form-control" cols="30" rows="3" require></textarea>
               </div>
               <?php if($product->is_designer == "YES"): ?>
               <div class="row">
                  <div class="form-group col-md-6">
                     <label for="" class="control-label">Upload Image For Your Designer Cake</label>
                     <input type="file" name="image" class="form-control" required id="ins_img_upload">
                  </div>
                  <div class="form-group col-md-6">
                     <a href="" target="_blank" id="instruction_img"><img src="" alt="" height="100" width="100" id="ins_img"></a>
                  </div>
               </div>
               <?php endif ?>
               <div class="form-group">
                  <input type="submit" value="Save My Instruction" class="btn btn-info">
               </div>
            </form>
            <div class="form-group" id="232"></div>
         </div>
      </div>
   </div>
</div>
<script>
   $(document).ready(function(){
      
      $("#ins_img_upload").change(function(){
         const [file] = ins_img_upload.files
         if (file) {
            ins_img.src = URL.createObjectURL(file)
         }
         });

   	$("#order_instruction_form").submit(function(e){
   		e.preventDefault();
   		var f=$(this);
   		var form = f[0];
   		var data = new FormData(form);
   		$.ajax({
   			type: "POST",
   			url:f.attr("action"),
   			enctype: 'multipart/form-data',
   			processData: false, 
   			contentType: false,
   			cache: false,
   			data:data,
   			success:function(res){
   				$("#232").fadeIn();
   				$("#232").html("<span class='alert alert-success'>"+res.trim()+"</span>").delay(1500).fadeOut();
               $("#instructionModal").delay(1500).modal('toggle');
   			}
   
   		});
   	});
   
   	get_saved_instruction();
   	
   	function get_saved_instruction(){
   		$.ajax({
   			type: "POST",
   			url:"<?=base_url("welcome/get_saved_instruction")?>",
   			data:{product:"<?=get("productId")?>"},
   			success:function(res){console.log(res);
   				$("#instruction_message").val(res.cart_message);
   				if(res.cart_custom_img == "" || res.cart_custom_img == undefined){
   					$("#instruction_img img").attr('src',"<?=base_url('images/No-Image.png')?>");
   				}else{
   					$("#instruction_img").attr('href',"<?=base_url('images/instruction/')?>/"+res.cart_custom_img);
   					$("#instruction_img img").attr('src',"<?=base_url('images/instruction/')?>/"+res.cart_custom_img);
   				}
				   $("#ddFlavour").val(res.cart_flavour);
   			}
   
   		});
   	}

      $("input[name=cake_type]:radio").click(function(){
         if($(this).val() == "2"){
            $("#money").html((parseInt($(this).data("price"))+parseInt($(this).data("charge"))));
         }else{
            $("#money").html($("#money").data("money"));
         }
      });
   });
   
</script>