
			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 id="das"  class="page-title"><?php echo $form; ?></h4>
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>master/index">Dashboard</a></li>
						<li class="active"><?php echo $form; ?></li>
					</ol>
				</div>
			</div>
			<!-- Page-Title -->
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box"> 	
							<div class="form">
								<?= form_open(fetch_class().'/add_branch',array("class" => "", "id" => "signupForm")); ?>
													 
								
                                				 
								<div class="form-group col-lg-4">
									<label class="control-label">Branch Code<span class="required">*</span></label> 
									<input type="number" id="txtbcode" name="txtbcode" class="form-control empty" placeholder="Enter Branch Code">
									<span id="divtxtbcode" style="color:red"></span>
								</div>
                                				 
								<div class="form-group col-lg-4">
									<label class="control-label">Branch Name *<span class="required">*</span></label> 
									<input type="text" id="txtname" name="txtname" class="form-control empty" placeholder="Enter Branch Name">
									<span id="divtxtname" style="color:red"></span>
								</div>
                                
                                <div class="form-group col-lg-4">
									<label class="control-label">Branch Head<span class="required">*</span></label> 
									<input type="text" id="txtbhead" name="txtbhead" class="form-control empty" placeholder="Enter Branch Head">
									<span id="divtxtbhead" style="color:red"></span>
								</div>
								<div class="form-group col-lg-4">
									<label class="control-label">Mobile</label> 
									<input type="text" id="txtmobile" name="txtmobile" class="form-control" placeholder="Enter Mobile">

									<span id="divtxtmobile" style="color:red"></span>
								</div>
                                <div class="form-group col-lg-4">
									<label class="control-label">Email</label> 
									<input type="text" id="txtemail" name="txtemail" class="form-control" placeholder="Enter Email">
									<span id="divtxtemail" style="color:red"></span>
								</div>

                                <div class="form-group col-lg-4">
									<label class="control-label">Password</label> 
									<input type="text" id="txtpassword" name="txtpassword" class="form-control" placeholder="Enter Password">
									<span id="divtxtpassword" style="color:red"></span>
								</div>
                                				 
								<div class="form-group col-lg-4">
									<label class="control-label">Address</label> 
									<input type="text" id="txtaddress" name="txtaddress" class="form-control" placeholder="Enter Address">
									<span id="divtxtaddress" style="color:red"></span>
								</div>
                                <!-- <div class="form-group col-lg-4">
									<label class="control-label">Address</label> 
									<input type="text" id="txtaddress" name="txtaddress" class="form-control" placeholder="Enter Address">
									<span id="divtxtaddress" style="color:red"></span>
								</div> -->
							</div>
							
							<div class="form-group">								
								<button class="btn btn-info" type="button" onclick="check_submit('signupForm')">Submit</button>								
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
	
				
				<div class="col-sm-12">
					<div class="card-box table-responsive">
						<h4 class="m-t-0 header-title"><b><?php echo $table; ?></b></h4>
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>S.No</th>
 									<th>Branch Code</th>
 									<th>Branch Name</th>
 									<th>Branch Head</th>
 									<th>Mobile</th>
 									<th>Email</th>                                   
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$sn=1;
									foreach($branchList as $unit) {
									if($unit->branch_status==1) {
										$status = "success"; $stat = 0;
									} else {
										$status = "danger"; $stat = 1;
									}
								?>												
									<tr class="<?=$status?>">
										<td><?=$sn++; ?></td>
                                       
  										<td><input type="text" class="form-control" value="<?= $unit->branch_code; ?>" onblur="update_value('<?= $unit->branch_id; ?>', this.value, 'adminBankAc')" /> </td>
  										<td><input type="text" class="form-control" value="<?= $unit->branch_name; ?>" onblur="update_value('<?= $unit->branch_id; ?>', this.value, 'adminBankIfsc')" /> </td>
  										<td><input type="text" class="form-control" value="<?= $unit->branch_conatct_person; ?>" onblur="update_value('<?= $unit->branch_id; ?>', this.value, 'adminBankBranch')" /> </td>
  										<td><input type="text" class="form-control" value="<?= $unit->branch_contact_no; ?>" onblur="update_value('<?= $unit->branch_id; ?>', this.value, 'adminBankAddress')" /> </td>
  										<td><input type="text" class="form-control" value="<?= $unit->branch_email; ?>" onblur="update_value('<?= $unit->branch_id; ?>', this.value, 'adminBankAddress')" /> </td>
										<td>
											<a href="javascript:void(0);"  class="btn btn-default" onclick="change_status('<?=$unit->branch_id?>','<?=$stat?>', 'adminBank')"><span class='fa fa-refresh' title="Change Status"></span></a>									
										</td>
									</tr>
								<?php } ?>            
							</tbody>
						</table>
					</div>
				</div>
			</div> 