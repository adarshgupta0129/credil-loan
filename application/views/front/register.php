<section class="dlab-bnr-inr overlay-black-middle bg-pt" style="background-image:url(<?php echo base_url() ?>assets/images/bnr1.jpg);">
	<div class="container">
		<div class="dlab-bnr-inr-entry">
			<h1 class="text-white">Register</h1>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<ul class="list-inline">
					<li><a href="<?php echo base_url() ?>">Home</a></li>
					<li>Register</li>
				</ul>
			</div>
			<!-- Breadcrumb row END -->
		</div>
	</div>
</section>
<!-- contact area -->

<section class="section-full content-inner-2 shop-account">
	<!-- Product -->
	<div class="container">
		
		<div class="row">
			<div class="col-lg-12">
				<div class="p-a30 border-1 max-w700 m-auto radius-sm">				
					<form action="javascript:void(0)" id="registrationForm" autocomplete="off" >
						<div class="form-row">

							<div class="form-group col-md-6">
								<label>Referral Code<span class="required">*</span></label>
								<input type="text" class="form-control " id="txtreferral" name="txtreferral" value="<?=$this->input->get("referral")?>" <?=!empty($this->input->get("referral")) ? "disabled" : ""?> placeholder="Enter Referral Code If Have" />
								<span id="txtreferral" class="required"></span>
							</div>

							<div class="form-group col-md-6">
								<label>Full Name<span class="required">*</span></label>
								<input type="text" class="form-control empty" id="txtname" name="txtname" placeholder="Enter Name" />
								<span id="divtxtname" class="required"></span>
							</div>
							
							<div class="form-group col-md-12">
								<label>Email</label>
								<input type="text" class="form-control" id="txtemail" name="txtemail" placeholder="Enter Email" />
								<span id="divtxtemail" class="required"></span>
							</div>
							
							<div class="form-group col-md-6">
								<label>Mobile No.<span class="required">*</span></label>
								<input type="text" class="form-control" id="txtmobile" name="txtmobile" maxlength="10" placeholder="Enter Mobile No" onChange="login_mobile_change(this)" />
								<span id="divtxtmobile" class="required"></span>
							</div>
							
							<div class="form-group col-md-6">
								<label>Enter OTP</label>
								<div class="form-inline">
									<div class="form-group mb-2" style="width: 60%;">									
										<input type="text" class="form-control empty" id="txtotp" name="txtotp" placeholder="Enter OTP">
									</div>								
									<button type="submit" class="btn btnhover btn-info mb-2"><i class="las la-check-circle"></i></button>
								</div>
								<span id="divtxtotp" class="required"></span>
							</div>
							
							<div class="form-group col-md-6">
								<label>Password<span class="required">*</span></label>
								<input type="password" class="form-control empty" name="txtpassword" id="txtpassword" placeholder="Enter Password" >
								<span id="divtxtpassword" class="required"></span>
							</div>
							
							<div class="form-group col-md-6">
								<label>DOB</label>
								<input type="date" class="form-control" id="txtdob" name="txtdob">
								<span id="divtxtdob" class="required"></span>
							</div>
							
							<input type="hidden" id="txtreg_from" name="txtreg_from" value="1">
							<input type="hidden" id="txtproc" name="txtproc" value="1">
							
							<div class="form-group col-md-4 offset-4 text-center">
								<button class="btn btnhover btn-dark btn-block" onclick="registration('registrationForm')"><i class="las la-user-edit"></i> Create An Account</button>
							</div>
							
							<div class="form-group col-md-12 text-center">
								<p class="text-center large">You might have already account  <strong><a href="<?php echo base_url() ?>welcome/login" class="text-primary">Login</a></strong></p>
							</div>
							<!--div class="form-group col-md-12 text-center">
								<center class="or"><h4><span>or</span></h4></center>
								<div class="row align-content-stretch">
									<div class="col-lg-5 col-md-12 m-b30">
										<a href="#" class="btn btn-info btnhover btn-block"><i class="lab la-facebook-f"></i> Login with Facebook</a>
									</div>
									<div class="col-lg-5 col-md-12 m-b30 offset-md-2">
										<a href="#" class="btn btn-danger btnhover btn-block"><i class="lab la-google-plus-g"></i> Login with Google</a>
									</div>
								</div>
							</div-->
						</div>
					</form>
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
