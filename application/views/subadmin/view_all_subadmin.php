
    <!-- Start content -->
    
		
			
			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 id="das"  class="page-title"><?php echo $page; ?></h4>
					<ol class="breadcrumb">
						<li><a href="#">Dashboard</a></li>
						<li class="active"><?php echo $form_name; ?></li>
					</ol>
				</div>
			</div>
			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box table-responsive">
						<h4 class="m-t-0 header-title"><b><?php echo $table_name; ?></b></h4>
						<table id="datatable" class="table table-striped table-bordered">
							<thead>
												<tr>
													<th>SNo.</th>
													<th>Action</th>
													<th>Login Id</th>
													<th>Name</th> 
													<th class="ignore">Password</th> 
													<th>Date</th>
													<th>State</th>
													<th>City</th>
													<th>Pincode</th>
													<th>Address</th>
													<th>DOB</th>
													<th>Mobile No</th>
													<th>Email</th>
												</tr>
											</thead>
											<tbody>
												<?php
													$sn = 1;
													if(!empty($info))
													{
														foreach($info as $rows)
														{
														?>
														<tr>
															<td><?= $sn;?></td>
															<td><a href="<?=base_url()?>subadmin/view_subadmin_edit/<?= $rows->sub_admin_id; ?>" title="Edit Profile"><i class="fa fa-pencil text-primary"></i></a> </td>
															<td><?= $rows->sub_admin_login_id;?></td>
															<td><?= $rows->sub_admin_name;;?></td>
															<td><?= $rows->sub_admin_password;?></td> 
															<td><?= $rows->sub_admin_entry_date;;?></td>
															<td><?= $rows->State; ?></td>
															<td><?= $rows->City; ?></td>
															<td><?= $rows->sub_admin_pin_code;?></td>
															<td><?= $rows->sub_admin_address;?></td>
															<td><?= $rows->sub_admin_dob;?></td>
															<td><?= $rows->sub_admin_contact_no;?></td>
															<td><?= $rows->sub_admin_email;?></td>
														</tr>   
														<?php $sn++;
														}
													}
												?>
											</tbody>
						</table>
					</div>
				</div>	
			</div>
	