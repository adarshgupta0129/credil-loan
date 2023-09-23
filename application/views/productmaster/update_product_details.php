<link rel="stylesheet" type="text/css" href="<?=base_url()?>application/libraries/assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" />
<script type="text/javascript" src="<?=base_url()?>application/libraries/assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"  />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" ></script>
 

<div class="row">
	<div class="col-sm-12">
		<h4 id="das"  class="page-title"><?php echo $form; ?></h4>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>master/index">Dashboard</a></li>
			<li class="active"><?php echo $form; ?></li>
		</ol>
	</div>
</div>

<div class="row"><div class="col-sm-12">	
	<?= form_open(fetch_class().'/update_product',array("class" => "", "method"=>"POST", "id" => "signupForm", "enctype"=>"multipart/form-data")); ?>	
	<div class="form">	
	
		<input type="hidden" id="txt_productId" name="txt_productId" value="<?=get('productId')?>" />
		<input type="hidden" id="txt_variantId" name="txt_variantId" value="<?=get('variantId')?>" />
		
		<fieldset><legend><span>Product</span></legend>			
			<!--div class="form-group row">
				<label class="col-md-2 control-label">Main Category<span class="required">*</span></label>
				<div class="col-md-3">
					<select class="form-control opt" name="ddcat1" id="ddcat1" title="Category" onchange="get_cat2(this.value)">
						<option selected="" value="0">Select Category</option>
					</select>
					<span id="divddcat1" style="color:red"></span>
				</div>
				<label class="col-md-3 control-label">Select Product Type</label>
				<div class="col-md-3">
					<select class="form-control" name="ddtype[]" id="ddtype" title="Product Type" multiple>
					</select>
					<span id="divddtype" style="color:red"></span>
				</div> 
			</div>  
			 
			<div class="form-group row">
				<label class="col-md-2 control-label">Main Sub Category<span class="required">*</span></label>
				<div class="col-md-3">
					<select class="form-control opt" name="ddcat2" id="ddcat2" title="Main Sub Category" onchange="get_cat3(this.value)">
						<option selected="" value="0">Main Sub Category</option>
					</select>
					<span id="divddcat2" style="color:red"></span>
				</div>
				<label class="col-md-3 control-label">Sub Category<span class="required">*</span></label>
				<div class="col-md-3">
					<select class="form-control opt" name="ddcat3" id="ddcat3" title="Sub Category" >
						<option selected="" value="0">Sub Category</option>
					</select>
					<span id="divddcat3" style="color:red"></span>
				</div>
			</div-->
			
			<div class="form-group row">
				<label class="col-md-2 control-label">Name <span class="required">*</span></label>
				<div class="col-md-3">
					<input type="text" id="txtname" name="txtname" class="form-control empty" placeholder="Enter Product Name." value="<?=$product->pr_name?>" />
					<span id="divtxtname" style="color:red"></span>
				</div>
				
				<label class="col-md-3 control-label">Select Product Type</label>
				<div class="col-md-3">
					<select class="form-control opt select2" name="ddtype[]" id="ddtype"  title="Product Type" multiple> 
						<?php foreach($type as $st) {
								$sel = '';
								foreach($prodType as $pT) { 
									if($st->type_id == $pT->pr_type_type_id)
										$sel = 'selected';
							}
						?>
						<option value="<?= $st->type_id; ?>" <?=$sel?>><?= $st->type_name; ?></option>
						<?php } ?>
					</select>
					<span id="divddtype" style="color:red"></span>
				</div> 
			</div>
			 
			<div class="form-group row">
				<label class="col-md-2 control-label">Description</label>
				<div class="col-md-9">
					<textarea class="form-control" name="txtdesc" id="txtdesc"> <?=$product->pr_description?></textarea>
					<span id="divtxtdesc" style="color:red"></span>
				</div>
			</div>
		</fieldset>
		<fieldset><legend><span>Media</span></legend>
			<div class="form-group row">
				<label class="col-md-2 control-label">Images <span class="required">(1000x1000)*</span></label>
				<div class="col-md-9">
					<input type="file" class="form-control"  name="userfile[]" id="userfile" accept="image/*" multiple>
					<span id="divuserfile" style="color:red"></span>
					<div id="show_images"></div>
					<div class="show_images">
						<?php foreach($img as $i){ ?>	
						<span class="show_update_images" style="position:relative;" id="img_<?=$i->pr_img_id?>">
							<img src="<?=PROD_PATH.$product->pr_vari_id.'/s/'.$i->pr_img_name?>" />
							<i class="fa fa-times fa-2x" onclick="remove_product_image('<?=$product->pr_vari_id?>', '<?=$i->pr_img_id?>')"></i>
						</span>
						<?php } ?>
					</div>
				</div>
				<div class="col-md-1">
					<div id="remove_images" onclick="remove_images()" title="Remove images"><i class="fa fa-times"></i></div>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-md-2 control-label">Video</label>
				<div class="col-md-9 text">
					<input type="text" id="txtvideo" name="txtvideo" class="form-control " data-role="tagsinput" placeholder="Use comma or enter"/>
					<span id="divtxtvideo" style="color:red"></span>
					<div id="show_images_yt"></div>
					<div class="show_images">
						<?php foreach($video as $v){ ?>	
						<span class="show_update_images" style="position:relative;" id="vid_<?=$v->pr_v_id?>">
							<img src="https://img.youtube.com/vi/<?=$v->pr_v_url?>/mqdefault.jpg">
							<i class="fa fa-times fa-2x" onclick="remove_product_video('<?=$product->pr_vari_id?>', '<?=$v->pr_v_id?>')"></i>
						</span>
						<?php } ?>
				</div>
			</div>
			
		</fieldset>
		
		<fieldset><legend><span>Pricing</span></legend>	
			
			<div class="form-group row">
				<label class="col-md-2 control-label">Amount <span class="required">*</span></label>
				<div class="col-md-3">
					<input type="text" id="txtamt" name="txtamt" class="form-control numeric" placeholder="Product Amount" value="<?=$product->pr_vari_actual_price?>" />
					<span id="divtxtamt" style="color:red"></span>
				</div>
				<label class="col-md-3 control-label">Show Amount <span class="required">*</span></label>
				<div class="col-md-3">
					<input type="text" id="txtshowamt" name="txtshowamt" class="form-control numeric" placeholder="Show Amount" value="<?=$product->pr_vari_show_price?>"/>
					<span id="divtxtshowamt" style="color:red"></span>
				</div>
			</div>
		</fieldset>
		
		<fieldset>
		<legend><span>Others</span></legend>			
			<div class="form-group row">
				<label class="col-md-2 control-label">Unit</label>
				<div class="col-md-3" style="display: inline-flex;">
					<input type="text" id="txtunit" name="txtunit" class="form-control" placeholder="0.0"  value="<?=$product->pr_vari_unit_value?>"/>
					<select class="form-control" name="ddunit" id="ddunit">
						<?php foreach($units as $unit) {
							if($unit->unit_id == $product->pr_vari_unit_id)
								$sel = 'selected';
							else
								$sel = '';
							?>
							<option value="<?= $unit->unit_id;?>" <?=$sel?>><?= $unit->unit_name; ?></option>
						<?php } ?>
					</select>
					<span id="divtxtamt" style="color:red"></span>
				</div>
				
				<label class="col-md-3 control-label">HSN</label>
				<div class="col-md-3">
					<input type="text" id="txthsn" name="txthsn" class="form-control" placeholder="HSN"  value="<?=$product->pr_hsn?>" />
					<span id="divtxthsn" style="color:red"></span>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-md-2 control-label">Badges</label>
				<div class="col-md-3">
					<select class="form-control opt" name="ddbadges" id="ddbadges" >
						<?php foreach($badges as $b) {
							if($b->badges_id == $product->pr_badges)
								$sel = 'selected';
							else
								$sel = '';
							?>
							<option value="<?= $b->badges_id; ?>" <?=$sel?>><?= $b->badges_name; ?></option>
						<?php } ?>
					</select>
					<span id="divddbadges" style="color:red"></span>
				</div>
				
				<label class="col-md-3 control-label">Product Code</label>
				<div class="col-md-3">
					<input type="text" id="txtprcode" name="txtprcode" class="form-control" placeholder="Product Code"  value="<?=$product->pr_code?>" />
					<span id="divtxtprcode" style="color:red"></span>
				</div>
			</div>
		</fieldset>
		
		<fieldset>
			<legend><span>Location</span></legend>
			<div class="form-group row">
				<label class="col-md-2 control-label">Select Location Group<span class="required">*</span></label>
				<div class="col-md-4">
					<select class="form-control select2 opt" name="ddlocgrgoup[]" id="ddlocgrgoup" multiple>
						<option value="-1" disabled>Select Group</option>
						<?php foreach($group as $st) {
							$sel = '';
								foreach($prodGroup as $pG) {
									if($st->loc_gr_id == $pG->pr_loc_gr_id)
										$sel = 'selected';
							}
						?>
						<option value="<?= $st->loc_gr_id; ?>" <?=$sel?>><?= $st->loc_gr_name; ?></option>
						<?php } ?>
					</select>
					<span id="divddlocgrgoup" style="color:red"></span> 
				</div>
				
				<label class="col-md-2 control-label">Min Order Timing (In Hours)<span class="required">*</span></label>
				<div class="col-md-4">
					<input type="text" id="txthour" name="txthour" class="form-control empty" placeholder="Enter Min Order Timing." value="<?=$product->pr_min_order_timing?>"/>
					<span id="divtxthour" style="color:red"></span>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-2 control-label">Delivery Time Slot Group<span class="required">*</span></label>
				<div class="col-md-4">
					<select class="form-control opt select2" name="ddTimeSlotGroup[]" multiple>
						<option value="" disabled>Select</option>
						<?php
							foreach($deli_slot_goup as $k=>$v)
								echo "<option value='".$v->group_id."' ".$v->is_selected.">".$v->group_name."</option>";
						?>
					</select>
					<span id="divddTimeSlotGroup" style="color:red"></span> 
				</div>	

				<label class="col-md-2 control-label">Is Designer Cake<span class="required">*</span></label>
				<div class="col-md-4">
					<input type="checkbox" value="YES" class="" name="is_designer" <?=$product->is_designer == "YES" ? "checked" : ""?>>
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-2 control-label">Product Addons<span class="required">*</span></label>
				<div class="col-md-10">
					<select class="form-control opt select2" name="ddaddons[]" id="ddaddons" multiple>
						<option value="-1" disabled>Select</option>
						<?php
							foreach($addons as $k=>$v){
								echo "<option value='".$v->addon_id."' ".$v->is_selected.">".$v->addon_name."</option>";
							}
						?>
					</select>
					<span id="divddaddons" style="color:red"></span> 
				</div>	
			</div>
		</fieldset>
		
		<fieldset>
			<legend><span>Show Menu</span></legend>	
			
			
			<div class="form-group row">
				<label class="col-md-2 control-label">Level-1</label>
				<div class="col-md-3">
					<select class="form-control" name="ddmenu1" id="ddmenu1" onchange="get_menu2(this.value)">
						<option selected="" value="0"> Select Level-1</option>
					</select>
					<span id="divddmenu1" style="color:red"></span>
				</div>
				<label class="col-md-3 control-label">Level-2</label>
				<div class="col-md-3">
					<select class="form-control" name="ddmenu2" id="ddmenu2" onchange="get_menu3(this.value)">
						<option selected="" value="0"> Select Level-2</option>
					</select>
					<span id="divddmenu2" style="color:red"></span>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-md-2 control-label">Level-3<span class="required">*</span></label>
				<div class="col-md-3">
					<select class="form-control" name="ddmenu3" id="ddmenu3" onchange="get_id_menu_3(this.value)">
						<option selected="" value="0">Select Level-3</option>
					</select>
					<span id="divddcity" style="color:red"></span>
				</div>
				
				<label class="col-md-3 control-label">Menus-3</label>
				<div class="col-md-3 text">
					<input type="text" id="txtmenu3" name="txtmenu3" class="form-control" data-role="tagsinput" placeholder="Selected Menus-3"/>
					<span id="divtxtcat3" style="color:red"></span>
				</div>
			</div>
			
				<div class="form-group row">
					<table id="datatable-buttons" class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>SN</th>
								<th>Level-1 Menu</th>
								<th>Level-2 Menu</th>
								<th>Level-3 Menu</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php 
								$sn=1; foreach($prodMenu as $m) {?>												
								<tr id="menu_<?=$m->pr_sh_m_id?>">
									<td><?=$sn++; ?></td>
									<td><?=$m->L_1_front_menu_name; ?></td>
									<td><?=$m->L_2_front_menu_name; ?></td>
									<td><?=$m->L_3_front_menu_name; ?></td>
									<td>
										<a href="javascript:void(0);" class="btn btn-danger"  onclick="remove_product_menu('<?=$product->pr_vari_id?>', '<?=$m->pr_sh_m_id?>')"><span class='fa fa-times' title="Remove Menu"></span></a>
									</td>
								</tr>
							<?php } ?>            
						</tbody>
					</table>
				</div>
		</fieldset>		 
		
		<div class="form-group row">
			<div class="col-md-offset-4 col-md-4">
				<button class="btn btn-info btn-block" type="button" onclick="check_submit('signupForm')">Update</button>				
			</div>
		</div>		
	</div>	
</div>
</div>

<style>
	.show_update_images {
		position:relative;
	}
	.show_update_images i{
		position: absolute;
		color: #ff00009e;
		right: -1px;
		bottom: 29px;
	}
</style>

<script src="<?=base_url()?>application/libraries/assets/plugins/ckeditor/ckeditor.js"></script>
<script>

function remove_product_image(pr_vari_id, img_id){
	var urlpost = baseUrl+"Get_Details/remove_product_image";
	$.ajax({
		type: "POST",
		url : urlpost,
		data:{"img_id":img_id, "pr_vari_id":pr_vari_id},
		beforeSend : function(){
			$.blockUI({
				message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'
			});
		},
		complete: function () {
			$.unblockUI();
			$("#img_"+img_id).hide();
		}
	});
}

function remove_product_video(pr_vari_id, vid_id){
	var urlpost = baseUrl+"Get_Details/remove_product_video";
	$.ajax({
		type: "POST",
		url : urlpost,
		data:{"vid_id":vid_id, "pr_vari_id":pr_vari_id},
		beforeSend : function(){
			$.blockUI({
				message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'
			});
		},
		complete: function () {
			$.unblockUI();
			$("#vid_"+vid_id).hide();
		}
	});
}

function remove_product_menu(pr_vari_id, menu_id){
	var urlpost = baseUrl+"Get_Details/remove_product_menu";
	$.ajax({
		type: "POST",
		url : urlpost,
		data:{"menu_id":menu_id, "pr_vari_id":pr_vari_id},
		beforeSend : function(){
			$.blockUI({
				message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'
			});
		},
		complete: function () {
			$.unblockUI();
			$("#menu_"+menu_id).hide();
		}
	});
}

$(document).ready(function() {
	CKEDITOR.replace( 'txtdesc' ); 
	
	// $('#ddtype').select2({
	// 	placeholder: 'Select Types'
	// });
	
	// $('#ddlocgrgoup').select2({
	// 	placeholder: 'Select Groups'
	// });
});

$("#userfile").on('change',function() {
	$("#show_images").children().remove();
	var fileList = this.files;
for(var i = 0; i < fileList.length; i++)
{
	var t = window.URL || window.webkitURL;
	var objectUrl = t.createObjectURL(fileList[i]);
	$('#show_images').append('<img src="' + objectUrl + '" />');
}
});

function remove_images(){
	$("#userfile").val(null);
	$("#show_images").children().remove();
}

$("#userfilevari").on('change',function() {
	$("#show_imagesvari").children().remove();
	var fileList = this.files;
	for(var i = 0; i < fileList.length; i++)
	{
		var t = window.URL || window.webkitURL;
		var objectUrl = t.createObjectURL(fileList[i]);
		$('#show_imagesvari').append('<img src="' + objectUrl + '" />');
	}
});

function remove_images(){
	$("#userfile").val(null);
	$("#show_images").children().remove();
}


$('#txtvideo').on('itemAdded', function(event) {
	var yt_url = "https://img.youtube.com/vi/"+event.item+"/mqdefault.jpg";
	$('#show_images_yt').append('<img id="'+event.item+'" src="' + yt_url + '" />');
});

$('#txtvideo').on('itemRemoved', function(event) {
	$("#"+event.item).remove();
});


localStorage.setItem('LS_menu',JSON.stringify(<?=json_encode($menu)?>));
localStorage.setItem('LS_category',JSON.stringify(<?=json_encode($category)?>));
localStorage.setItem('LS_type',JSON.stringify(<?=json_encode($type)?>));

var menu = localStorage.getItem('LS_menu');
var category = localStorage.getItem('LS_category');
var type = localStorage.getItem('LS_type');

/* CATEGORY START */

function update_get_cat1(cat1)
{
	$.each(JSON.parse(category), function (i, item) { 
		if(item.pr_cat_id == cat1)
			var sel = 'selected';
		else
			var sel = '';			
		if(item.pr_cat_parent_id == 0)
		{
			$('#ddcat1').append("<option value="+item.pr_cat_id+" "+sel+">"+item.pr_cat_name+"</option>");
		}
		
	});
}



function update_get_cat2(parent_id, cat2)
{
	$("#ddcat2").children().remove();
	$('#ddcat2').append("<option value='0'>Select Main Sub Category</option>");
	$.each(JSON.parse(category), function (i, item) {
		if(item.pr_cat_id == cat2)	
			var sel = 'selected';
		else
			var sel = '';	
		if(item.pr_cat_parent_id != 0 && item.pr_cat_parent_id == parent_id)
		{
			$('#ddcat2').append("<option value="+item.pr_cat_id+" "+sel+">"+item.pr_cat_name+"</option>");
		}		
	});
	
/* 	$("#ddtype").children().remove();
	$.each(JSON.parse(type), function (i, item) {
		if(item.type_id == <?=($product->pr_type_type_id <> '')?$product->pr_type_type_id:'0'?>)	
			var sel = 'selected';
		else
			var sel = '';
		if(item.type_cat_id == parent_id)
		{
			$('#ddtype').append("<option value='"+item.type_id+"'"+sel+">"+item.type_name+"</option>");
		}
		
	}); */
}

function update_get_cat3(parent_id, cat3)
{
	$("#ddcat3").children().remove();
	$('#ddcat3').append("<option value='0'>Select Sub Category</option>");
	$.each(JSON.parse(category), function (i, item) {
		if(item.pr_cat_id == cat3)	
			var sel = 'selected';
		else
			var sel = '';
		if( item.pr_cat_parent_id != 0 && item.pr_cat_parent_id == parent_id)
		{
			$('#ddcat3').append("<option value="+item.pr_cat_id+" "+sel+">"+item.pr_cat_name+"</option>");
		}
		
	});
}
/* update_get_cat1(<?=$product->pr_cat1?>);
update_get_cat2(<?=$product->pr_cat1?>, <?=$product->pr_cat2?>);
update_get_cat3(<?=$product->pr_cat2?>, <?=$product->pr_cat3?>); */

function get_id_cat_3(parent_id)
{
	if(parent_id != '0')
	$("#txtcat3").tagsinput('add', parent_id);
}


/* CATEGORY END */


/* MENU START */
function get_menu1()
{
	$.each(JSON.parse(menu), function (i, item) {
		if(item.front_menu_parent_id == 0)
		{
			$('#ddmenu1').append("<option value="+item.front_menu_id+">"+item.front_menu_name+"</option>");
		}
		
	});
}
function get_menu2(parent_id)
{
	$("#ddmenu2").children().remove();
	$.each(JSON.parse(menu), function (i, item) {
		if(item.front_menu_parent_id != 0 && item.front_menu_parent_id == parent_id)
		{
			$('#ddmenu2').append("<option value="+item.front_menu_id+">"+item.front_menu_name+"</option>");
		}
		
	});
}

function get_menu3(parent_id)
{
	$("#ddmenu3").children().remove();
	$.each(JSON.parse(menu), function (i, item) {
		if( item.front_menu_parent_id != 0 && item.front_menu_parent_id == parent_id)
		{
			$('#ddmenu3').append("<option value="+item.front_menu_id+">"+item.front_menu_name+"</option>");
		}
		
	});
}

function get_id_menu_3(parent_id)
{
	if(parent_id != '0')
	$("#txtmenu3").tagsinput('add', parent_id);
}

get_menu1();

/* MENU END */


</script>					