	<?php
		$menuName = $menuName1 = $menuName2 = $menuName3 = $menuNameHead = '';
		$menuId = get('menuId');
		if($menuId == 0)
		{
			$menuName = "<li>We provide best offers</li>";
		}
		else 
		{
			$menu1 = getMenuName($menuId);
			$menuName1 = "<li>".$menu1->front_menu_name."</li>";
			if($menu1->front_menu_parent_id == 0)
			{
				$menuNameHead = $menu1->front_menu_name;
			}
			else 
			{
				$menu2 = getMenuName($menu1->front_menu_parent_id);
				$menuName2 = "<li>".$menu2->front_menu_name."</li>";
				if($menu2->front_menu_parent_id == 0)
				{
					$menuNameHead = $menu2->front_menu_name;
				}
				else 
				{
					$menu3 = getMenuName($menu2->front_menu_parent_id);
					$menuName3 = "<li>".$menu3->front_menu_name."</li>";
					$menuNameHead = $menu3->front_menu_name;
				}
			}
			
			$menuName = $menuName3.$menuName2.$menuName1;
		}
		
		?>
<section class="dlab-bnr-inr overlay-black-middle bg-pt" style="background-image:url(<?php echo base_url() ?>assets/images/bnr1.jpg);">
	<div class="container">
		<div class="dlab-bnr-inr-entry text-left">
			<h1 class="text-white" id="menuname"><?=$menuNameHead?> <small><span id="offset"><?=PAGE_LIMIT?></span> of <span id="totalFilterProd"><?=totalFilterProd()?></span> Product</small></h1>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<ul class="list-inline">
					<li><a href="<?php echo base_url() ?>">Home</a></li>
					<?php echo $menuName; ?>
				</ul>
			</div>
			<!-- Breadcrumb row END -->
			<div class="post-tags">
				Sort by : 
				<a href="javascript:void(0);" class="active" onclick="load_data('&filter=recomm')">Recommended</a>
				<a href="javascript:void(0);" onclick="load_data('&filter=new')">New</a>
				<a href="javascript:void(0);" onclick="load_data('&filter=plow')">Price : Low to High</a>
				<a href="javascript:void(0);" onclick="load_data('&filter=phigh')">Price : High to Low</a>
			</div>
		</div>
	</div>
</section>
<!-- contact area -->
<section class="section-full content-inner">
	<div class="container">
	<div class="row" id="all_products"></div>
		<div class="row">  
			<div class="col-lg-12">
				<div class="pagination-bx clearfix primary rounded-sm text-center">
					<ul class="pagination justify-content-center">
						<li class="previous"><a href="javascript:void(0);" onclick="load_query_data(parseInt(get('page'))-1)"><i class="ti-arrow-left"></i> Prev</a></li>
						
						<li class="next"><a href="javascript:void(0);" onclick="load_query_data(parseInt(get('page'))+1)">Next <i class="ti-arrow-right"></i></a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
/*
	var menu = get('menuName');
	var m1 = get('menuName1');
	var m2 = get('menuName2');
	var m3 = get('menuName3');
	
  	$("#menuname1").html(m1);
	$("#menuname2").html(m2);
	$("#menuname3").html(m3);
	
	$("#menuname").html(menu);
	*/
	  $(document).ready(function(){
	  if(get('page')==1){
		  $(".previous").css("pointer-events","none");
		  }
			load_data('');
 		});
		
	function load_data(filter){
		 $("#all_products").load("<?=base_url()?>welcome/all_products_query/"+window.location.search+filter).fadeIn('fast');
 	}
	
	function load_query_data(new_page)
	{
		full_url.set("page", new_page);
 		history.replaceState(null, null, "?"+full_url.toString()); 
		$.blockUI(
		{
			message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'
		});
		load_data('');
		$.unblockUI(); 
		
	  if(get('page')==1){
		  $(".previous").css("pointer-events","none");
	  } else {
		  $(".previous").css("pointer-events","auto");
	  }
	}
	 
</script>