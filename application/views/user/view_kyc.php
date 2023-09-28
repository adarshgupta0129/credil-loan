
        <div class="row">
            <div class="col-sm-12">
                <h4 id="das"  class="page-title"><?php echo $page; ?>&nbsp;&nbsp;|</h4>
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?><?=fetch_class()?>/index">&nbsp; Dashboard</a></li>
                    <li class="active"><?php echo $form_name; ?></li>
				</ol>
			</div>
		</div>
        <!-- Page-Title -->
        <div class="row">
            <div class="col-lg-12">
                <div class="card-box">
                    <div class="card">
						<div class="card-content">
						<?php if(isset($info->kyc_note)) {
							if($info->kyc_note <> ''){ ?>
							<h2 style="color:red"><?=$info->kyc_note?></h2>
						<?php } } ?>
							<h4>Pan Card</h4>
							<br>
							<?php
								if($get_count==0 || $info->kyc_pan=='')
								{
								?>
								<form action="<?php echo base_url()?>Userprofile/upload_kyc/1" method="post" enctype="multipart/form-data">
									<input type="file" name="userfile" accept="image/*"><br>
									<input type="submit" name="Submit" value="Upload" class="btn btn-sm btn-fill btn-success">
									<button type="reset" class="btn btn-sm btn-fill btn-danger">Cancel</button>
								</form>
								<?php
								}
								else
								{
								?>
								<img src="<?php echo base_url(); ?>application/kyc/<?php echo $info->kyc_pan; ?>" style="width:300px;" class="img-responsive"/>
								<?php 
									if($info->kyc_admin_status == '0')
									{
									?>
									<a href="<?php echo base_url(); ?>Userprofile/remove_kyc/1" class="btn btn-sm btn-fill btn-danger">Remove</a> 
									<?php
									}
								}
							?>
						</div>
						<!-- end content-->
					</div>
				</div>
                <!-----Adhar Front Update------->
                <div class="card-box">
					<div class="card">
						<div class="card-content">
							<h4>Aadhar Front Update</h4>
							<br>
							<?php
								if($get_count==0 || $info->kyc_aadhar_f=='')
								{
								?>
								<form action="<?php echo base_url()?>Userprofile/upload_kyc/2" method="post" enctype="multipart/form-data">
									<input type="file" name="userfile" accept="image/*"><br>
									<input type="submit" name="Submit" value="Upload" class="btn btn-sm btn-fill btn-success">
									<button type="reset" class="btn btn-sm btn-fill btn-danger">Cancel</button>
								</form>
								<?php
								}
								else
								{
								?>
								<img src="<?php echo base_url(); ?>application/kyc/<?php echo $info->kyc_aadhar_f; ?>" style="width:300px;" class="img-responsive"/>
								<?php 
									if($info->kyc_admin_status == '0')
									{
									?>
									<a href="<?php echo base_url(); ?>Userprofile/remove_kyc/2" class="btn btn-sm btn-fill btn-danger">Remove</a> 
									<?php
									}
								}
							?>
						</div>
						<!-- end content-->
					</div>
				</div>
                <!-----Adhar Back Update------->
                <div class="card-box">
					<div class="card">
						<div class="card-content">
							<h4>Aadhar Back Update</h4>
							<br>
							<?php
								if($get_count==0 || $info->kyc_aadhar_b=='')
								{
								?>
								<form action="<?php echo base_url()?>Userprofile/upload_kyc/3" method="post" enctype="multipart/form-data">
									<input type="file" name="userfile" accept="image/*"><br>
									<input type="submit" name="Submit" value="Upload" class="btn btn-sm btn-fill btn-success">
									<button type="reset" class="btn btn-sm btn-fill btn-danger">Cancel</button>
								</form>
								<?php
								}
								else
								{
								?>
								<img src="<?php echo base_url(); ?>application/kyc/<?php echo $info->kyc_aadhar_b; ?>" style="width:300px;" class="img-responsive" />
								<?php 
									if($info->kyc_admin_status == '0')
									{ 
									?>
									<a href="<?php echo base_url(); ?>Userprofile/remove_kyc/3" class="btn btn-sm btn-fill btn-danger">Remove</a> 
									<?php
									}
								}
							?>
						</div>
						<!-- end content-->
					</div>
				</div>
				
                <!-----ACancel Cheque/Passbook Update------->
                <div class="card-box">
					<div class="card">
						<div class="card-content">
							<h4>Cancel Cheque/Bank Passbook Update</h4>
							<br>
							<?php
								if($get_count==0 || $info->kyc_cheque=='')
								{
								?>
								<form action="<?php echo base_url()?>Userprofile/upload_kyc/4" method="post" enctype="multipart/form-data">
									<input type="file" name="userfile" accept="image/*"><br>
									<input type="submit" name="Submit" value="Upload" class="btn btn-sm btn-fill btn-success">
									<button type="reset" class="btn btn-sm btn-fill btn-danger">Cancel</button>
								</form>
								<?php
								}
								else
								{
								?>
								<img src="<?php echo base_url(); ?>application/kyc/<?php echo $info->kyc_cheque; ?>" style="width:300px;" class="img-responsive" />
								<?php 
									if($info->kyc_admin_status == '0')
									{
									?>
									<a href="<?php echo base_url(); ?>Userprofile/remove_kyc/4" class="btn btn-sm btn-fill btn-danger">Remove</a> 
									<?php
									}
								}
							?> 
						</div>
						<!-- end content-->
					</div>
				</div>
			</div>
		</div>
	</div>	

</div>
</div>