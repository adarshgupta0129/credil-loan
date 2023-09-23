
	<div class="account-pages"></div>
	<div class="clearfix"></div>
	<div class="wrapper-page">
		<div class="card-box">
            <div class="panel-heading"> 
			<center class="logo2"> <img src="<?php echo base_url()?>logo/logo.png"  class="img-responsive" onclick="window.location.href=''" /> </center>
			</div> 
			
            <div class="panel-body">
				<?php 
					echo form_open('auth/resetpassword', 'class="m-t-20" id="myform"');
					if($this->uri->segment(1) == 'admin_login')
					{
					?>
					<input type="hidden" name="ddtype" value="1">
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
					
						<input class="form-control" type="text" required="" placeholder="UserID" name="txtuserid">
					
				</div>
				
				<?php
					if($this->session->flashdata('info'))
					{
					?>
					<div class="alert alert-danger">
						<button class="close" data-close="alert"></button>
						<span><?php echo $this->session->flashdata('info'); ?> </span>
					</div>
					<?php
					}
				?>
				<div class="form-group text-center m-t-40">
					
						<button class="btn btn-inverse btn-block text-uppercase waves-effect waves-light" type="submit">Redeem Your Password</button>
					
				</div>
				
				<div class="form-group m-t-30 m-b-0">
					
						<a href="<?php echo base_url();?>auth/index" class="text-dark"><i class="fa fa-sign-in m-r-5"></i> Back To Login</a>
					
				</div>
				
				<?php echo form_close(); ?> 
				
			</div>   
		</div>                              
		
	</div>
	
	