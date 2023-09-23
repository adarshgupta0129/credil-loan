<section class="dlab-bnr-inr overlay-black-middle bg-pt" style="background-image:url(<?php echo base_url() ?>assets/images/bnr3.jpg);">
	<div class="container">
		<div class="dlab-bnr-inr-entry">
			<h1 class="text-white">Customized Cake</h1>
			<!-- Breadcrumb row -->
			<div class="breadcrumb-row">
				<ul class="list-inline">
					<li><a href="<?php echo base_url() ?>">Home</a></li>
					<li>Customized Cake</li>
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
			
			<div class="offset-3 col-md-6 m-b30">
				<div class="p-a30 border-1 radius-sm">
					<div class="tab-content tab-form nav">
						<form action="<?=base_url()?>welcome/enquire_now?login_src=login" method="POST" enctype="multipart/form-data" id="CustomizeForm" class="tab-pane active col-12 p-a0 ">
							
							
							<?php if($this->session->flashdata('info')){ ?>
								<div class="alert alert-info alert-dismissible">
									<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
									<strong>Info!</strong> <?=$this->session->flashdata('info')?>
								</div>
							<?php } ?>
							
							<div class="form-group">
								<label>Name <span class="required">*</span></label>
								<input type="text" name="txtname" id="txtname" class="form-control empty" placeholder="Your Name" value="<?= $this->session->userdata('name')?>">
							</div>
							
							<div class="form-group">
								<label>Mobile Number <span class="required">*</span></label>
								<input type="text" name="txtmobile" id="txtmobile" class="form-control empty" placeholder="Your Mobile Number" value="<?= $this->session->userdata('mobile_no')?>">
							</div>
							<div class="form-group">
								<label>Upload Photo <span class="required">*</span></label>
								<input type="hidden" name="txtpic" id="txtpic" value="" >
								<input type="file"   name="userfile" id="userfile" accept="image/*" class="form-control " style="position: relative;opacity:1">
							</div>
							
							<div class="form-group">
								<label>Reference Link </label>
								<input type="text" name="txtrefer_link" id="txtrefer_link" class="form-control" placeholder="Your Reference Link" value="">
							</div>
						
							<div class="text-left">
								<button type="submit" class="btn btnhover btn-dark m-r5"><i class="las la-sign-in-alt"></i> Enquire Now </button>
							
								<a class="whatshop btn btn-success" target="_blank" href="https://api.whatsapp.com/send?phone=<?= WHATSAPP_NO?>&amp;text=Hello..."><i class="fa fa-whatsapp"></i></a>
							</div>
						</form>
						<form id="forgot-password" class="tab-pane fade col-12 p-a0">
							<h4>Forget Password ?</h4>
							<p>We will send you an email to reset your password. </p>
							<div class="form-group">
								<label>E-Mail *</label>
								<input name="dzName" required="" class="form-control" placeholder="Your Email Id" type="email">
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
