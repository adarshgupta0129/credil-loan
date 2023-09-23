<?php if($product->pr_name == get_product() && get('productId') <> "" && get('variantId') <> ""){ ?>
	
	<link href="<?= base_url(); ?>application/third_party/js/front/css/auto-complete.css" rel="stylesheet" type="text/css">
	
	<section class="dlab-bnr-inr overlay-black-middle bg-pt" style="background-image:url(<?php echo base_url() ?>assets/images/bnr1.jpg);">
		<div class="container">
			<div class="dlab-bnr-inr-entry text-left">
				<h1 class="text-white">
					<?=get_product()?>
				</h1>
				<!-- Breadcrumb row -->
				<div class="breadcrumb-row">
					<ul class="list-inline">
						<li><a href="<?php echo base_url() ?>">Home</a></li>
						<li><?=get_product()?></li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	<!-- contact area -->
	<section class="content-inner productdetails">
		<div class="container">
			<div class="row" id="main_product">
				<?php $this->load->view('front/product/product_single'); ?>
			</div> 
		</div>
	</div>
</section>
<?php } ?>

<section class="section-full related-products content-inner bg-gray-light">
	<div class="container">
		<h2 class="title">You May Also Like</h2>	
		<? $this->load->view('front/product/product_grid') ?>
	</div>
</section>	

<section class="section-full related-products content-inner bg-gray-light">
	<div class="container">
		<h2 class="title">What Others Are Viewing</h2>	
		<? $this->load->view('front/product/product_grid') ?>
	</div>
</section>	


<script src="<?= base_url(); ?>application/third_party/js/front/js/auto-complete.min.js"></script>
<script> 
	localStorage.setItem('LS_location',JSON.stringify(<?=json_encode($location)?>));
	var loc = localStorage.getItem('LS_location');
  	var obj = JSON.parse(loc);
	var data = [];
	for(var i = 0; i < obj.length; i++) {
		var localvalue = obj[i].loc_name;
		data.push(localvalue);
	}
	
	var demo1 = new autoComplete({
		selector: '#pincode2',
		minChars: 2,
		source: function(term, suggest){
			term = term.toLowerCase();
			var choices = data;
			var suggestions = [];
			for (i=0;i<choices.length;i++)
			if (~choices[i].toLowerCase().indexOf(term)) suggestions.push(choices[i]);
			suggest(suggestions);
		}
	});
	
	function add_to_cart(){
	var date = $("#deliveryDate").val();
	var slotId = $("#dddeliverySlot").val();
	var ptype = $("input[name=cake_type]:checked").val();
	if(slotId != '0' && date != ''){
		window.location.href = baseUrl+"welcome/add_to_cart/"+window.location.search+"&deliveryDate="+date+"&slotId="+slotId+"&ptype="+ptype;
	} else { 
		$("#deliveryDIV").css('transform', 'scale(1.5)').css('transition','transform .5s');
	}
}
	
	function load_single_product(){
		$("#main_product").fadeOut('fast').load("<?=base_url()?>welcome/product_single/"+window.location.search).fadeIn('fast');
	}
	
	function select_variant(variantId){
		full_url.set("variantId", variantId);
		history.replaceState(null, null, "?"+full_url.toString()); 
		$.blockUI({
			message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'
		});
		load_single_product();
		$.unblockUI();
	}
</script>
