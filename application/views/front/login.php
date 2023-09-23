<section class="dlab-bnr-inr overlay-black-middle bg-pt" style="background-image:url(<?php echo base_url() ?>assets/images/bnr3.jpg);">
	<div class="container">
		<div class="dlab-bnr-inr-entry">
			<h1 class="text-white">Login</h1>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<ul class="list-inline">
					<li><a href="<?php echo base_url() ?>">Home</a></li>
					<li>Login</li>
				</ul>
			</div>
			<!-- Breadcrumb row END -->
		</div>
	</div>
</section>
<!-- contact area -->
<section class="section-full content-inner shop-account">
	<!-- Product -->
	<div class="container">
		
		<div class="row align-content-stretch">
			<div class="col-lg-6 col-md-12 m-b30">
				<div class="p-a30 border-1 h100 radius-sm">
					<div class="tab-content">
						<h3 class="m-b10">New Customer</h3>
						<p class="m-b15">By creating an account with our store, you will be able to move through the checkout process faster, store multiple shipping addresses, view and track your orders in your account and more.</p>
						<p class="m-b15 text-center">
							Don’t have an account yet? <a class="btn btnhover btn-dark" href="<?php echo base_url() ?>welcome/register"><i class="las la-user-edit"></i> Create An Account</a>
						</p>
						<!--center class="or"><h4><span>or</span></h4></center>
						<div class="row align-content-stretch">
							<div class="col-lg-5 col-md-12 m-b30">
								<a href="#" class="btn btn-info btnhover btn-block"><i class="lab la-facebook-f"></i> Login with Facebook</a>
							</div>
							<div class="col-lg-5 col-md-12 m-b30 offset-md-2">
								<a href="#" class="btn btn-danger btnhover btn-block"><i class="lab la-google-plus-g"></i> Login with Google</a>
							</div>
						</div-->
					</div>
				</div>
			</div>
			<div class="col-lg-6 col-md-12 m-b30">
				<div class="p-a30 border-1 radius-sm">
					<div class="tab-content tab-form nav">
						<form action="<?=base_url()?>Auth/login?login_src=login" method="POST" id="loginForm" class="tab-pane active col-12 p-a0 ">
							<h3 class="m-b5">Login</h3>
							<p>If you have an account with us, please log in.</p>
							<?php if($this->session->flashdata('info')){ ?>
								<div class="alert alert-info alert-dismissible">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong>Info!</strong> <?=$this->session->flashdata('info')?>
								</div>
							<?php } ?>
							
							<div class="form-group">
								<label>Mobile Number <span class="required">*</span></label>
								<input type="text" name="txtlogin" id="txtlogin" class="form-control" placeholder="Your Mobile Number">
							</div>
							
							<div class="form-group">
								<label>Password <span class="required">*</span></label>
								<input type="password" name="txtpwd" id="txtpwd" class="form-control" placeholder="Type Password">
							</div>
							
							<input name="user_type" type="hidden" value="2">
							
							<div class="text-left">
								<button type="submit" class="btn btnhover btn-dark m-r5"><i class="las la-sign-in-alt"></i> Login</button>
								<a data-toggle="tab" href="#forgot-password" class="m-l5"><i class="fa fa-unlock-alt"></i> Forgot Password</a> 
							</div>
						</form>
						<form id="forgot-password" action="<?=base_url("welcome/forgot_password")?>" method="post" class="tab-pane fade col-12 p-a0">
							<h4>Forget Password ?</h4>
							<p>Please Enter your mobile number we will send your password to to registered mobile number. </p>
							<div class="form-group">
								<label>Registered Mobile Number *</label>
								<input name="mobile" required class="form-control" type="number">
							</div>
							<div class="text-left"> 
								<a class="btn btn-light" data-toggle="tab" href="#login"><i class="las la-undo-alt"></i> Back</a>
								<button class="btn btnhover btn-success pull-right"><i class="las la-share"></i> Submit</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Product END -->
</section>

<style>
	.required{
	color:red;
	}
</style>
