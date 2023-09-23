<div class="row">
	<div class="col-sm-12">
		<h4 id="das"  class="page-title"><?php echo $page; ?></h4>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>master/index">Dashboard</a></li>
			<li class="active"><?php echo $form; ?></li>
		</ol>
	</div>
</div>
<!-- Page-Title -->
<div class="row">
	
	<div class="col-lg-12">
		<div class="card-box">
			<h4 class="m-t-0 header-title"><b><?php echo $form; ?></b></h4>
			<p class="text-muted font-13 m-b-30"></p>
			
			<div class="form">
				<?= form_open('userprofile/update_password',array("class" => "cmxform form-horizontal", "id" => "signupForm")); ?>
				
				<div class="form-group">
					<label class="col-md-4 control-label">New Password</label>
					<div class="col-md-6">
						<input type="password" id="txtpassword" name="txtpassword" class="form-control empty" placeholder="Enter New Password.">
						<span id="divtxtpassword" style="color:red"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-4 control-label">Confirm New Password</label>
					<div class="col-md-6">
						<input type="password" id="txtcpassword" name="txtcpassword" class="form-control empty" placeholder="Enter Confirm New Password.">
						<span id="divtxtcpassword" style="color:red"></span>
						<span id="divtxtconfirm" style="color:red"></span>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-offset-4 col-md-8">
						<button class="btn btn-primary" type="button" onclick="check_submit('signupForm')">Submit</button>
						<button type="button" class="btn btn-default">Cancel</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
</div>
</div>

</div>
</div>