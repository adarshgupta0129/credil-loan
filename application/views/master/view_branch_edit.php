
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
													 
							<?= form_open(fetch_class().'/update_branch/'.$this->uri->segment('3'),array("class" => "", "id" => "signupForm")); ?>
                                				 
								<div class="form-group col-lg-4">
									<label class="control-label">Branch Code<span class="required">*</span></label> 
									<input type="number" id="txtbcode" name="txtbcode" class="form-control empty" value="<?= $rec->branch_code; ?>" placeholder="Enter Branch Code" readonly>
									<span id="divtxtbcode" style="color:red"></span>
								</div>
                                				 
								<div class="form-group col-lg-4">
									<label class="control-label">Branch Name *<span class="required">*</span></label> 
									<input type="text" id="txtname" name="txtname" class="form-control empty" value="<?= $rec->branch_name; ?>" placeholder="Enter Branch Name">
									<span id="divtxtname" style="color:red"></span>
								</div>
                                
                                <div class="form-group col-lg-4">
									<label class="control-label">Branch Head<span class="required">*</span></label> 
									<input type="text" id="txtbhead" name="txtbhead" class="form-control empty" value="<?= $rec->branch_conatct_person; ?>" placeholder="Enter Branch Head">
									<span id="divtxtbhead" style="color:red"></span>
								</div>
								<div class="form-group col-lg-4">
									<label class="control-label">Mobile</label> 
									<input type="text" id="txtmobile" name="txtmobile" class="form-control empty" value="<?= $rec->branch_contact_no; ?>" placeholder="Enter Mobile">

									<span id="divtxtmobile" style="color:red"></span>
								</div>
                                <div class="form-group col-lg-4">
									<label class="control-label">Email</label> 
									<input type="text" id="txtemail" name="txtemail" class="form-control empty" value="<?= $rec->branch_email; ?>" placeholder="Enter Email">
									<span id="divtxtemail" style="color:red"></span>
								</div>

                                <div class="form-group col-lg-4">
									<label class="control-label">Password</label> 
									<input type="text" id="txtpassword" name="txtpassword" class="form-control empty" value="<?= $rec->branch_password; ?>" placeholder="Enter Password">
									<span id="divtxtpassword" style="color:red"></span>
								</div>

                                <div class="form-group col-lg-4">
								<label for="state">State</label>
								
								<select onchange="stat()" class="form-control" name="branch_state" id="state" required>
								<option value="">Choose...</option>
								<?php  foreach ($loc as $data ) {?>
								<option value="<?=$data->loc_id?>" <?= ($data->loc_id==$rec->branch_state)?'selected':''?>><?=$data->loc_name?></option>
								<?php } ?>
							</select>
								<span class="errbranch_state"></span>

							</div>
							<div class="form-group col-lg-4">
								<label for="state">City</label>
								<select class="form-control" name="branch_city" id="city" required>
									<option value="">Choose...</option>
									<?php  foreach ($city_list as $city_list ) {?>
								<option value="<?=$city_list->loc_id?>" <?= ($city_list->loc_id==$rec->branch_city)?'selected':''?>><?=$city_list->loc_name?></option>
								<?php } ?>
								</select>
								<span class="errbranch_city"></span>
							</div>

								<div class="form-group col-lg-4">
									<label class="control-label">Address</label> 
									<input type="text" id="txtaddress" name="txtaddress" class="form-control" value="<?= $rec->branch_address; ?>" placeholder="Enter Address">
									<span id="divtxtaddress" style="color:red"></span>
								</div>
                                <!-- <div class="form-group col-lg-4">
									<label class="control-label">Address</label> 
									<input type="text" id="txtaddress" name="txtaddress" class="form-control" placeholder="Enter Address">
									<span id="divtxtaddress" style="color:red"></span>
								</div> -->
							</div>
							
							<div class="form-group">								
								<button class="btn btn-info" type="button" onclick="check_submit('signupForm')">Update</button>								
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
	
				
				
			</div> 