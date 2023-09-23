<link rel="stylesheet" type="text/css" href="<?=base_url()?>application/libraries/assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" />
<script type="text/javascript" src="<?=base_url()?>application/libraries/assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>

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
	
	<?= form_open(fetch_class().'/add_coupon',array("class" => "", "method"=>"POST", "id" => "signupForm", "enctype"=>"multipart/form-data")); ?>
	
	<div class="form">			
		<fieldset>
		<legend><span>Coupon</span></legend>
		
			<div class="form-group row">
				<label class="col-md-2 control-label">Code <span class="required">*</span></label>
				<div class="col-md-4">
					<input type="text" id="txtcode" name="txtcode" class="form-control empty" placeholder="Enter Coupon Code"/>
					<span id="divtxtcode" style="color:red"></span>
				</div>
				
				<label class="col-md-2 control-label">Title <span class="required">*</span></label>
				<div class="col-md-4">
					<input type="text" id="txttitle" name="txttitle" class="form-control empty" placeholder="Enter Coupon Title"/>
					<span id="divtxttitle" style="color:red"></span>
				</div>
				
			</div>
			
			<div class="form-group row">
				<label class="col-md-2 control-label">Description</label>
				<div class="col-md-10">
					<textarea class="form-control" name="txtdesc" id="txtdesc"></textarea>
				</div>
			</div>
		</fieldset>
		
		<fieldset><legend><span>Amount</span></legend>
			
			<div class="form-group row">
				<label class="col-md-3 control-label">Minimum Apply Amount <span class="required">*</span></label>
				<div class="col-md-3">
					<input type="number" id="txtminamount" name="txtminamount" class="form-control empty" placeholder="Enter Minimum Apply Amount"/>
					<span id="divtxtminamount" style="color:red"></span>
				</div>
				<label class="col-md-3 control-label">Discount Amount <span class="required">*</span></label>
				<div class="col-md-3">
					<input type="number" id="txtamount" name="txtamount" class="form-control empty" placeholder="Enter Discount Amount"/>
					<span id="divtxtamount" style="color:red"></span>
				</div>				
			</div>			
		</fieldset>
		
		<fieldset>
		<legend><span>Timing</span></legend>	
			
			<div class="form-group row">

				<label class="col-md-3 control-label">Valid Date <span class="required">*</span></label>
				<div class="col-md-3">
					<input type = "date" id="txtdate" name="txtdate" class="form-control" data-date="" data-date-format="MMMM DD, YYYY" min="<?=date('Y-m-d')?>" value="<?=date('Y-m-d')?>" />  
					<span id="divtxtdate" style="color:red"></span>
				</div>
				
				<label class="col-md-3 control-label">Apply Frequency <span class="required">*</span></label>
				<div class="col-md-3">
					<select class="form-control" name="ddapplytime" id="ddapplytime">
						<option selected="" value="0"> Select Apply Time</option>
						<?php foreach ( $applyTime as $key => $value ) { ?>
								<option value="<?=$key+1?>"><?=$value?></option>
						<?php }	?>
					</select>
					<span id="divddapplytime" style="color:red"></span>
				</div>
			</div>
		</fieldset>
		
		<fieldset>
			<legend><span>Specific</span></legend>
			<div class="form-group row">
			<p class="text-danger">Leave this field blank for all users.</p>
				<label class="col-md-2 control-label">User</label>
				<div class="col-md-3">
					<select class="form-control" name="dduser" id="dduser" onchange="getUsers(this.value)">
						<option value="0" selected disabled>Select User</option>
						<?php foreach($userId as $user) { ?>
							<option value="<?= $user->user_reg_id; ?>"><?= $user->user_u_id; ?> | <?= $user->user_name; ?></option>
						<?php } ?>
					</select>
					<span id="divdduser" style="color:red"></span>
				</div>
				
				<label class="col-md-3 control-label">Users</label>
				<div class="col-md-3 text">
					<input type="text" id="txtusers" name="txtusers" class="form-control" data-role="tagsinput" placeholder="Selected Users" readonly />
					<span id="divtxtuser" style="color:red"></span>
				</div>
			</div>
			<div class="form-group row">
			<p class="text-danger">Leave this field blank for all products.</p>
				<label class="col-md-2 control-label">Product</label>
				<div class="col-md-3">
					<select class="form-control" name="ddproduct" id="ddproduct" onchange="getProducts(this.value)">
						<option value="0" selected disabled>Select Product</option>
						<?php foreach($product as $prod) { ?>
							<option value="<?= $prod->pr_id; ?>"><?= $prod->pr_name; ?> | <?= $prod->pr_code; ?></option>
						<?php } ?>
					</select>
				</div>
				
				<label class="col-md-3 control-label">Products</label>
				<div class="col-md-3 text">
					<input type="text" id="txtproducts" name="txtproducts" class="form-control" data-role="tagsinput" placeholder="Selected Products" readonly />
					<span id="divtxtproducts" style="color:red"></span>
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
	CKEDITOR.replace('txtdesc');
});	

function getUsers(id){
	if(id != '0')
	$("#txtusers").tagsinput('add', id);
}

function getProducts(id){
	if(id != '0')
	$("#txtproducts").tagsinput('add', id);
}

</script>