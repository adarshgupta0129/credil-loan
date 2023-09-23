
<!-- Start content -->



<!-- Page-Title -->
<div class="row">
	<div class="col-sm-12">
		<h4 id="das"  class="page-title"><?php echo $form; ?></h4>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>master/index">Dashboard</a></li>
			<li class="active"><?php echo $form; ?></li>
		</ol>
	</div>
</div>

<?php
	foreach($config->result() as $row)
	{
		break;
	}
?>
<!-- Page-Title -->
<div class="row">
	
	<div class="col-lg-6">
		<?php if($this->session->flashdata('info')) { ?>
			<div class="alert alert-danger alert-dismissible">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<?= $this->session->flashdata('info'); ?>
			</div>
		<?php } ?>
		
		<div class="card-box">
			
			
			<div class="form">
				<?= form_open('master/update_mainconfig/'.$row->m00_login_id,array("class" => "", "id" => "signupForm")); ?>
				
				<div class="form-group">
					
					<label for="username" class="control-label col-lg-4">Login Id<span class="required">*</span></label>
					
					<input type="text" id="txtusername" name="txtusername" class="form-control empty" placeholder="Enter User Name." value="<?php echo $row->m00_username;?>">
				<span id="divtxtusername" style="color:red"></span></div>
				<div class="form-group ">
					<label for="password" class="control-label col-lg-4">Password<span class="required">*</span></label>
					
					<input type="password" id="txtuserpass" name="txtuserpass" class="form-control" placeholder="Enter User Password." value="<?php echo $row->m00_password;?>">
					<span id="divtxtuserpass" style="color:red"></span>
				</div>
				<div class="form-group ">
					<label for="confirm_password" class="control-label col-lg-4">Confirm Password<span class="required">*</span></label>
					
					<input type="password" id="txtuserpinpass" name="txtuserpinpass" class="form-control" placeholder="Enter User Pin Password." value="<?php echo $row->m00_password;?>">
					<span id="divtxtuserpinpass" style="color:red"></span>
				</div>
				<input type="hidden" id="txtusertype" name="txtusertype" value="1">
				<input type="hidden" id="txtuserstatus" name="txtuserstatus" value="1">
				
				
				
				
				<div class="form-group">
					<button class="btn btn-info" type="button" onclick="check_submit('signupForm')">Update</button>
					
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
</div>
