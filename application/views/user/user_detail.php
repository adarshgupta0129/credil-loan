<div class="col-md-4">
	<div class="profile-detail card-box text-center"> 
		<?php
			if($rec1->user_userimage!='')
			{
			?>
			<img src="<?php echo base_url(); ?>application/user_image/<?php echo $rec1->user_userimage; ?>" class="img-circle" alt="profile-image">
			<?php
			}
			else
			{
			?>
			<img src="<?php echo base_url(); ?>favicon/favicon.png" class="img-circle" alt="profile-image">
			<?php
			}
		?> 
		<dl class="dl-horizontal" style="text-align:center">
			<dt>Login As :</dt>
			<dd><?php echo $rec1->user_u_id; ?></dd>
			<dt>Full Name :</dt>
			<dd><?php echo $rec1->user_name; ?></dd>
			<dt>Mobile :</dt>
			<dd><?php echo $rec1->user_mobile_no; ?></dd>
			<dt>Email :</dt>
			<dd><?php echo $rec1->user_email; ?></dd>
 		</dl> 
	</div>
</div>



<div class="col-md-4">
	<div class="profile-detail card-box text-center"> 
		<h1><?=get_bal($this->session->userdata("profile_id"))?></h1>
		<dl class="dl-horizontal" style="text-align:center">
			<h4 align="center">Wallet Balance</h4>
 		</dl> 
	</div>
</div>


<div class="col-md-4">
	<div class="profile-detail card-box text-center"> 
		<h1><?php echo $rec1->user_u_id; ?></h1>
		<dl class="dl-horizontal" style="text-align:center">
			<h4 align="center">My Referral Code <a class="whatshop btn btn-success" target="_blank" href="https://api.whatsapp.com/send?text=https://easycelebrations.org/welcome/register?referral=<?php echo $rec1->user_u_id; ?>">Share</a></h4>
 		</dl> 
	</div>
</div>
