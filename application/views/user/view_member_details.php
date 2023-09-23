
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
	<div class="col-sm-6">
		<div class="card-box table-responsive">
			<h4 class="m-t-0 header-title"><b>Personal Details</b></h4>
			<table id="datatable-buttons" class="table table-striped table-bordered">
				<tbody>								
					<tr>
						<td>DOB</td>
						<td><input type="text" onblur="update_user_value('<?=$$rec->user_reg_id?>', this.value, '1')" value="<?= $rec->user_dob;?>" /></td>
					</tr>
					<tr>
						<td>Mobile</td>
						<td><input type="text" onblur="update_user_value('<?=$$rec->user_reg_id?>', this.value, '2')" value="<?php echo $rec->user_mobile_no;?>" /></td>
					</tr>
					<tr>
						<td>Email</td>
						<td><input type="text" onblur="update_user_value('<?=$$rec->user_reg_id?>', this.value, '3')" value="<?php echo $rec->user_email;?>" /></td>
					</tr>
					<tr>
						<td>Password</td>
						<td class="password">
							<span class="pass_show"><?php echo $rec->login_pwd;?></span>
						</td> 
					</tr>					
				</tbody>
			</table>
		</div>
	</div>
	
	<div class="col-sm-6">
		<div class="card-box table-responsive">
			<h4 class="m-t-0 header-title"><b>Address</b></h4>
			<table id="datatable-buttons" class="table table-striped table-bordered">
				<tbody>								
					<tr>
						<td>State</td>
						<td><?php echo $rec->State;?></td>
					</tr>
					<tr>
						<td>City</td>
						<td><?php echo $rec->City;?></td>
					</tr>
					<tr>
						<td>Pincode</td>
						<td><input type="text" onblur="update_user_value('<?=$$rec->user_reg_id?>', this.value, '6')" value="<?php echo $rec->user_pincode;?>" /></td>
					</tr>
					<tr>
						<td>Address</td>
						<td><input type="text" onblur="update_user_value('<?=$$rec->user_reg_id?>', this.value, '7')" value="<?php echo $rec->user_address;?>" /></td>
					</tr>					
				</tbody>
			</table>
		</div>
	</div>
</div>
