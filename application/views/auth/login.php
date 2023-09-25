<link rel="stylesheet" href="<?php echo base_url()?>assets/css/app.css" type="text/css">
<div class="account-pages"></div>
<div class="clearfix"></div>
<div class="wrapper-page">
	<center class="logo2"> <img src="<?php echo base_url()?>logo/logo.png"  class="img-responsive" onclick="window.location.href=''" style="width:30%" /> </center>
	<div class="card-box">
		
		
		<h1 class="text-center">Sign In</h1>
		
		
		<?php 
			echo form_open('auth/login', 'class="m-t-20" id="myform"');
			if(uri(1) == 'admin')
			{
			?>
            <input type="hidden" name="ddtype" value="1">
            <?php
			}
			else if($this->uri->segment(1) == 'store')
			{
			?>
            <input type="hidden" name="ddtype" value="3">
            <?php
			}else if($this->uri->segment(1) == 'subadmin')
			{
			?>
            <input type="hidden" name="ddtype" value="4">
            <?php
			}
			else
			{
			?>
            <input type="hidden" name="ddtype" value="2">
            <?php
			}
		?>
		<div class="form-group ">
			<input class="form-control" type="text" required="" placeholder="Username" name="txtlogin">
		</div>
		<div class="form-group">
			<input class="form-control" type="password" required="" placeholder="Password" name="txtpwd">
		</div>
		<!--div class="form-group ">
			<div class="checkbox checkbox-primary">
				<input id="checkbox-signup" type="checkbox">
				<label for="checkbox-signup" class="text-dark">
					Remember me
				</label>
			</div>
		</div-->
		<?php
			if($this->session->flashdata('error'))
			{
			?>
            <div class="alert alert-danger">
				<button class="close" data-close="alert"></button>
				<span><?php echo $this->session->flashdata('error'); ?> </span>
			</div>
            <?php
			}
		?>
		<div class="form-group text-center m-t-20">
			<button class="btn btn-inverse btn-block text-uppercase waves-effect waves-light" type="submit">Log In</button>
		</div>
		<?php 
			if(uri(1) != 'admin')
			{
			?>
		<div class="form-group text-right">
			<a href="<?php echo base_url();?>auth/registration" class="text-dark"><i class="fa fa-user"></i> New Customer?</a>
		</div>
			<?php } ?>
		<!--div class="form-group m-t-20 m-b-0">
			<a href="<?php echo base_url();?>auth/forgot_password" class="text-dark"><i class="fa fa-lock m-r-5"></i> Forgot your password?</a>
		</div-->
		<?php echo form_close(); ?> 
		
	</div>
</div>
<script>
	var resizefunc = [];
</script>