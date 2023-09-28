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
			<dt>User Id :</dt>
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
<?php
$bal =	get_bal(session("profile_id"));
if($bal > 0){ ?>
<div class="col-md-4">
	<div class="profile-detail card-box text-center"> 
		<h1><?=$bal?></h1>
		<dl class="dl-horizontal" style="text-align:center">
			<h4 align="center">Wallet Balance</h4>
 		</dl> 
	</div>
</div>
<?php } ?>