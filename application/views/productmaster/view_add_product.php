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
<!-- Page-Title -->
<div class="row"><div class="col-sm-12">
	
	<?= form_open(fetch_class().'/add_product',array("class" => "", "method"=>"POST", "id" => "signupForm", "enctype"=>"multipart/form-data")); ?>
	
	<div class="form">
	
		<fieldset>
			<legend><span>Show Menu</span></legend>	
			
			
			<div class="form-group row">
				<label class="col-md-2 control-label">Level-1</label>
				<div class="col-md-3">
					<select class="form-control opt" name="ddmenu1" id="ddmenu1" onchange="get_menu2(this.value)">
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
		</fieldset>
		
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
					<input type="text" id="txtname" name="txtname" class="form-control empty" placeholder="Enter Product Name."/>
					<span id="divtxtname" style="color:red"></span>
				</div>
				
				<label class="col-md-3 control-label">Select Product Type</label>
				<div class="col-md-3">
					<select class="form-control opt select2" name="ddtype[]" id="ddtype"  title="Product Type" multiple>
 						<?php
							foreach($type as $st)
							{
							?>
							<option value="<?= $st->type_id; ?>"><?= $st->type_name; ?></option>
							<?php
							}
						?>
					</select>
					<span id="divddtype" style="color:red"></span>
				</div> 
			</div>
			<div class="form-group row">
				<label class="col-md-2 control-label">Description</label>
				<div class="col-md-9">
					<textarea class="form-control" name="txtdesc" id="txtdesc"></textarea>
					<span id="divtxtdesc" style="color:red"></span>
				</div>
			</div>
		</fieldset>
		<fieldset><legend><span>Media</span></legend>
			<div class="form-group row">
				<label class="col-md-2 control-label">Images  <span class="required">(1000x1000)*</span></label>
				<div class="col-md-9">
					<input type="file" class="form-control"  name="userfile[]" id="userfile" accept="image/*" multiple>
					<span id="divuserfile" style="color:red"></span>
					<div id="show_images"></div>
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
				</div>
			</div>
		</fieldset>
		
		<fieldset><legend><span>Pricing</span></legend>	
			
			<div class="form-group row">
				<label class="col-md-2 control-label">Amount <span class="required">*</span></label>
				<div class="col-md-3">
					<input type="text" id="txtamt" name="txtamt" class="form-control numeric" placeholder="Product Amount"/>
					<span id="divtxtamt" style="color:red"></span>
				</div>
				<label class="col-md-3 control-label">Show Amount <span class="required">*</span></label>
				<div class="col-md-3">
					<input type="text" id="txtshowamt" name="txtshowamt" class="form-control numeric" placeholder="Show Amount"/>
					<span id="divtxtshowamt" style="color:red"></span>
				</div>
			</div>
		</fieldset>
		
		<fieldset><legend><span>Others</span></legend>	
			
			<div class="form-group row">
				<label class="col-md-2 control-label">Unit</label>
				<div class="col-md-3" style="display: inline-flex;">
					<input type="text" id="txtunit" name="txtunit" class="form-control" placeholder="0.0" value="0.0"/>
					<select class="form-control" name="ddunit" id="ddunit">
						<?php foreach($units as $unit) { ?>
							<option value="<?= $unit->unit_id; ?>"><?= $unit->unit_name; ?></option>
						<?php } ?>
					</select>
					<span id="divtxtamt" style="color:red"></span>
				</div>
				
				<label class="col-md-3 control-label">HSN</label>
				<div class="col-md-3">
					<input type="text" id="txthsn" name="txthsn" class="form-control" placeholder="HSN" />
					<span id="divtxthsn" style="color:red"></span>
				</div>
			</div>
			
			<div class="form-group row">
				<label class="col-md-2 control-label">Badges</label>
				<div class="col-md-3">
					<select class="form-control opt" name="ddbadges" id="ddbadges" >
						<?php foreach($badges as $b) { ?>
							<option value="<?= $b->badges_id; ?>"><?= $b->badges_name; ?></option>
						<?php } ?>
					</select>
					<span id="divddbadges" style="color:red"></span>
				</div>
				
				<label class="col-md-3 control-label">Product Code</label>
				<div class="col-md-3">
					<input type="text" id="txtprcode" name="txtprcode" class="form-control" placeholder="Product Code" />
					<span id="divtxtprcode" style="color:red"></span>
				</div>
			</div>
		</fieldset>
		
		<fieldset>
			<legend><span>Delivery</span></legend>
			<div class="form-group row">
				<label class="col-md-2 control-label">Select Location Group<span class="required">*</span></label>
				<div class="col-md-3">
					<select class="form-control opt select2" name="ddlocgrgoup[]" id="ddlocgrgoup" title="Select Group" multiple>
 						<?php
							foreach($group as $st)
							{
							?>
							<option value="<?= $st->loc_gr_id; ?>"><?= $st->loc_gr_name; ?></option>
							<?php
							}
						?>
					</select>
					<span id="divddlocgrgoup" style="color:red"></span> 
				</div>
				<label class="col-md-3 control-label">Min Order Timing (In Hours)<span class="required">*</span></label>
				<div class="col-md-3">
					<input type="text" id="txthour" name="txthour" class="form-control empty" placeholder="Enter Min Order Timing."/>
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
								echo "<option value='".$v->group_id."' >".$v->group_name."</option>";
						?>
					</select>
					<span id="divddTimeSlotGroup" style="color:red"></span> 
				</div>	

				<label class="col-md-2 control-label">Is Designer Cake<span class="required">*</span></label>
				<div class="col-md-4">
					<input type="checkbox" value="YES" class="" name="is_designer">
				</div>
			</div>

			<div class="form-group row">
				<label class="col-md-2 control-label">Product Addons<span class="required">*</span></label>
				<div class="col-md-10">
					<select class="form-control opt select2" name="ddaddons[]" id="ddaddons" multiple>
						<option value="-1" disabled>Select</option>
						<?php
							foreach($addons as $k=>$v){
								echo "<option value='".$v->addon_id."'>".$v->addon_name."</option>";
							}
						?>
					</select>
					<span id="divddaddons" style="color:red"></span> 
				</div>	
			</div>

		</fieldset>
		
		<div class="form-group row">
			<div class="col-md-offset-4 col-md-4">
				<button class="btn btn-info btn-block" type="button" onclick="check_submit('signupForm')">Submit</button>
			</div>
		</div>
		
	</div>
	
</div>
</div>
<script src="<?=base_url()?>application/libraries/assets/plugins/ckeditor/ckeditor.js"></script>
<script>

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


/*	localStorage.setItem('LS_location',JSON.stringify(<?=json_encode($location)?>));*/
localStorage.setItem('LS_menu',JSON.stringify(<?=json_encode($menu)?>));
localStorage.setItem('LS_category',JSON.stringify(<?=json_encode($category)?>));
localStorage.setItem('LS_type',JSON.stringify(<?=json_encode($type)?>));
//	var loc = localStorage.getItem('LS_location');
var menu = localStorage.getItem('LS_menu');
var category = localStorage.getItem('LS_category');
var type = localStorage.getItem('LS_type');

/* CATEGORY START */

function get_cat1()
{
	$.each(JSON.parse(category), function (i, item) {
		if(item.pr_cat_parent_id == 0)
		{
			$('#ddcat1').append("<option value="+item.pr_cat_id+">"+item.pr_cat_name+"</option>");
		}
		
	});
}

function get_cat2(parent_id)
{
	$("#ddcat2").children().remove();
	$('#ddcat2').append("<option value='0'>Select Main Sub Category</option>");
	$.each(JSON.parse(category), function (i, item) {
		if(item.pr_cat_parent_id != 0 && item.pr_cat_parent_id == parent_id)
		{
			$('#ddcat2').append("<option value="+item.pr_cat_id+">"+item.pr_cat_name+"</option>");
		}		
	});
	
	$("#ddtype").children().remove();
	$.each(JSON.parse(type), function (i, item) {
		if(item.type_cat_id == parent_id)
		{
			$('#ddtype').append("<option value="+item.type_id+">"+item.type_name+"</option>");
		}
		
	});
}

function get_cat3(parent_id)
{
	$("#ddcat3").children().remove();
	$('#ddcat3').append("<option value='0'>Select Sub Category</option>");
	$.each(JSON.parse(category), function (i, item) {
		if( item.pr_cat_parent_id != 0 && item.pr_cat_parent_id == parent_id)
		{
			$('#ddcat3').append("<option value="+item.pr_cat_id+">"+item.pr_cat_name+"</option>");
		}
		
	});
}

function get_id_cat_3(parent_id)
{
	if(parent_id != '0')
	$("#txtcat3").tagsinput('add', parent_id);
}

get_cat1();

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
	$('#ddmenu2').append("<option value='0'>Select</option>");
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
	$('#ddmenu3').append("<option value='0'>Select</option>");
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