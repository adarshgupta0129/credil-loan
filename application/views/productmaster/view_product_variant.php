
<link rel="stylesheet" type="text/css" href="<?=base_url()?>application/libraries/assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" />

<script type="text/javascript" src="<?=base_url()?>application/libraries/assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>

<script src="<?=base_url()?>application/libraries/assets/plugins/select2/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>application/libraries/assets/plugins/select2/select2.css" />

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
	
	<?= form_open(fetch_class().'/view_add_product_variant',array("class" => "", "id" => "signupForm", "enctype"=>"multipart/form-data", "method"=>"POST")); ?>
	
	
	<div class="form">
		
		
		<fieldset>
			<legend><span>Add Variants</span></legend>	
			<div>
				<div class="form-group row">
					<label class="col-md-2 control-label">Select Product<span class="required">*</span></label>
					<div class="col-md-3">
						<select class="form-control opt" name="ddproduct" id="ddproduct">
							<option value="0">Select Product</option>
							<?php
								foreach($product as $vari)
								{
									if($vari->pr_id == get('productId'))
										$sel = 'selected';
									else
										$sel = '';
								?>
								<option value="<?= $vari->pr_id; ?>"<?=$sel?>><?= $vari->pr_name; ?></option>
								<?php
								}
							?>
						</select>
						<span id="divddproduct" style="color:red"></span>
					</div> 
					<label class="col-md-2 control-label">Select Variant<span class="required">*</span></label>
					<div class="col-md-3">
						<select class="form-control opt" name="ddvariant" id="ddvariant">
							<option value="0">Select Variant</option>
							<?php
								foreach($variants as $vari)
								{
								?>
								<option value="<?= $vari->vari_id; ?>"><?= $vari->vari_name; ?></option>
								<?php
								}
							?>
						</select>
						<span id="divddvariant" style="color:red"></span>
					</div>
				</div>
				<input type="hidden" name="total_item" id="total_item" value="1" />
				<div class="form-group row">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Images<span class="required">*</span></th>
								<th>Unit<span class="required">*</span></th>
								<th>Amount<span class="required">*</span></th>
								<th>Show Amount<span class="required">*</span></th>
								<th></th>
							</tr>
						</thead>
						<tbody id="if_no_row">    
							<tr id="row_id_1">
								<td>1</td>
								<td><input type="file" id="userfile" class="variant_img emptyfile" name="userfile[]" onchange="get_vari_image(this)" /></td>
								<td style="display: inline-flex;">
									<input type="text" id="variant_unit" name="variant_unit[]" class="form-control empty"> &nbsp;
									<select class="form-control opt" name="ddunit[]" id="ddunit">
										<?php foreach($units as $unit) { 
										?>
											<option value="<?= $unit->unit_id; ?>"><?= $unit->unit_name; ?></option>
										<?php } ?>
									</select>
								</td>
								<td><input type="number" value="" id="variant_amt" class="form-control empty" name="variant_amt[]"></td>
								<td><input type="number" value="" id="variant_show_amt" class="form-control empty" name="variant_show_amt[]"></td>
								<td></td>
							</tr>
							<tr>
								<td>2</td>
								<td></td>
								<td></td>
								<td></td>
								<td></td>
								<td>
									<div align="right">
										<button type="button" name="add_row" id="add_row" class="btn btn-success btn-xs" title="Add Row">+</button>
									</div>
								</td>
							</tr>
						</tbody>
					</table>	
				</div>		
			</div>		
		</fieldset>
		<div class="form-group row">
			<div class="col-md-offset-4 col-md-4">
				<button class="btn btn-info btn-block" type="button" onclick="check_submit('signupForm')">Submit</button>
				
			</div>
		</div>
		
	</div>
	
	
</div></div>
<script src="<?=base_url()?>application/libraries/assets/plugins/ckeditor/ckeditor.js"></script>
<script>
	
	var table_data = $("#if_no_row").html();
	
	$('#ddvariant').on('change', function(event) {
		var ddvari = $(this).val();
		var ddpr = $("#ddproduct").val();
		if($(this).val() != '0') {
			$('#signupForm').trigger("reset");
			$("#if_no_row").find('tr').remove();
			$("#if_no_row").append(table_data);
			 
			$('#ddvariant').val(ddvari); 
			$('#ddproduct').val(ddpr);
			$('#total_item').val('1');
			sequence_order();
 	}
});

function get_vari_image(elem){
	
 	$(elem).next().children().remove();
	var fileList = elem.files;
	for(var i = 0; i < fileList.length; i++)
	{
		var t = window.URL || window.webkitURL;
		var objectUrl = t.createObjectURL(fileList[i]);
 		$(elem).parent().append('<div class="show_imagesvari"><img src="' + objectUrl + '" /></div>');
	}
}

$(document).ready(function()
{
	var count = 1; 
	$(document).on('click', '#add_row', function()
	{
		var ddvariant = $("#ddvariant").val();
		if(ddvariant > 0){
		var amt = $("#txtamt").val();
		var show_amt = $("#txtshowamt").val();
		count++;
		
		var last = $(".table-bordered > tbody").find('tr:nth-last-child(2)').attr('id');
		var total = $('#total_item').val();
		$('#total_item').val(parseInt(total)+1);
		
		var total_rows = parseInt($(".table-bordered > tbody").find('tr').length);
		
		var html_code = '';
		
		html_code += '<tr id="row_id_'+count+'">';
		html_code += '<td id="'+count+'">'+count+'</td>';
		html_code += '<td><input type="file" id="userfile'+count+'" class="variant_img" name="userfile[]" onchange="get_vari_image(this)" />';
		html_code += '</td>';
		html_code += '<td style="display: inline-flex;"><input type="text" id="variant_unit" name="variant_unit[]" class="form-control" /> &nbsp;';
		html_code += '<select class="form-control" name="ddunit[]" id="ddunit'+count+'" class="prod_add_select_weight"><?php foreach($units as $unit) { ?><option value="<?= $unit->unit_id; ?>"><?= $unit->unit_name; ?></option><?php } ?></select></td>';
		html_code += '<td><input type="number" value="'+amt+'" id="variant_amt'+count+'" class="form-control" name="variant_amt[]" /></td>';
		html_code += '<td><input type="number" value="'+show_amt+'" id="variant_show_amt'+count+'" class="form-control" name="variant_show_amt[]" /></td>';
		html_code += '<td><button type="button" name="remove_row" id="'+count+'" onclick="remove_tr(this,'+count+')" class="btn btn-danger btn-xs remove_row">X</button></td>';
		html_code += '</tr>';
		$('#'+last).after(html_code);
		sequence_order();
		} else {
		bootbox.alert('Please select variant type!');
		}
	});	
});

function sequence_order(){
	var k = 1
	$('#if_no_row').find('tr').find('td:first').each(function(){
		$(this).html(k);
		k = k+1;
	});
}


function remove_tr(element, count)
{ 
	var row_id = $(element).attr("id");
	$('#row_id_'+row_id).remove();
	var one_delete = $('#total_item').val();
	one_delete = one_delete-1;
	var one_delete = $('#total_item').val(one_delete);
	sequence_order();
}


</script>
<style>
	#show_images img, #show_images_yt img, #show_imagesvari img, .show_imagesvari img, #show_images_ytvari img{
	max-height: 100px;
	min-height: 100px;
	max-width: 350px;
	padding: 2% 1% 0% 1%;
	clear: both;
	}
	#remove_images, #remove_imagesvari{
	border: 1px solid transparent;
	width: fit-content;
	padding: 3px 8px;
	float: right;
	border-radius: 30px;
	background: #ff0000eb;
	color: #fff;
	}
	.variant_count{
	border: 1px solid transparent;
	width: fit-content;
	padding: 3px 9px;
	float: right;
	border-radius: 32px;
	background: #7142b0eb;
	color: #fff;
	}
	.variant_img, .variant_amt, .variant_show_amt{
	max-width: 91px;
	}
	#cke_42, #cke_43{
	display: none;
	}
	.form-group{}
	</style>						