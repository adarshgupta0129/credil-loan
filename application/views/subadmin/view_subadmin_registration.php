
	<!-- Start content -->
	
		

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 id="das"  class="page-title">
						<?php echo $page; ?>
					</h4>
					<ol class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li class="active">
							<?php echo $form_name; ?>
						</li>
					</ol>
				</div>
			</div>
			<!-- Page-Title -->
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<h3 class="form-section"><?php echo $form_name; ?></h3>
						<p class="text-muted font-13 m-b-30"/>
						<form class="form form-horizontal" action="<?=base_url()?>subadmin/insert_subadmin" method="post" id="signupform">
							<div class="form-body">
								
								<h4 class="form-section"><i class="ft-user"></i> Personal Info</h4>
								
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">Name <span class="required"> * </span></label>
											<div class="col-md-8">
												<input type="text" class="form-control empty"  name="txtassociate_name" id="txtassociate_name" placeholder="Enter Member Name">	
												<span id="divtxtassociate_name" style="color:red"></span>
											</div>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">DOB <span class="required"> * </span></label>
											<div class="col-md-8">
												<div class="input-daterange" id="date-range" data-date-format="yyyy-mm-dd">
													<input type="text" class="form-control empty" name="txtdob" id="datepicker" data-date-format="yyyy-mm-dd" autocomplete="off">
													<span id="divdatepicker" style="color:red"/>
												</div>
											</div>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">Gender</label>
											<div class="col-md-8">
												<div class="radio-list">
													<label class="radio-inline">
													<input type="radio" name="rbgender" id="rbgender1" value="1" onClick="$('#txtgender').val('1')">Male</label>
													<label class="radio-inline">
													<input type="radio" name="rbgender" id="rbgender2" value="0" onClick="$('#txtgender').val('0')">Female</label>
													<input type="hidden" id="txtgender" name="txtgender" class="form-control" />
												</div>
												<span id="divtxtgender" style="color:red"></span>
											</div>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">State</label>
											<div class="col-md-8">
												<select id="ddstate" name="ddstate" class="form-control" onChange="get_city()">
													<option selected="selected" value="-1">Select State</option>
													<?php
														foreach ($state->result() as $row) {
														?>
														<option value="<?php echo $row->m_loc_id; ?>"><?php echo $row->m_loc_name; ?></option>
														<?php
														}
													?>
												</select>
												<span id="divddstate" style="color:red"></span>
											</div>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">City</label>
											<div class="col-md-8">
												<select id="ddcity" name="ddcity" class="form-control">
													<option selected="selected" value="">Select City</option>
												</select>
											</div>
										</div>
									</div>
									
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">Pincode</label>
											<div class="col-md-8">
												<input type="text" class="form-control" name="txtpincode" id="txtpincode" maxlength="6" placeholder="Enter Pincode">										
												<span id="divtxtpincode" style="color:red"></span>
											</div>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">Mobile <span class="required"> * </span></label>
											<div class="col-md-8">
												<input type="text" class="form-control" name="txtmobile" id="txtmobile" maxlength="10" placeholder="Enter Mobile">	
												<span id="divtxtmobile" style="color:red"></span>															
											</div>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">Email <span class="required"> * </span></label>
											<div class="col-md-8">
												<input type="text" class="form-control" name="txtemail" id="txtemail" placeholder="Enter Email">
												<span id="divtxtemail" style="color:red"></span>															
											</div>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">Address</label>
											<div class="col-md-8">
												<textarea class="form-control" name="txtaddress" id="txtaddress" placeholder="Enter Address"></textarea>
												<span id="divtxtaddress" style="color:red"></span>
											</div>
										</div>
									</div>
								</div>
								
								<h4 class="form-section"><i class="la la-unlock"></i> Credential Info</h4>
								
								<div class="row">
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">Password <span class="required"> * </span></label>
											<div class="col-md-8">
												<input type="password" class="form-control empty" name="txtpassword" id="txtpassword" placeholder="Enter Password">
												<span id="divtxtpassword" style="color:red"></span>
											</div>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="form-group row">
											<label class="col-md-4 control-label">Confirm Password <span class="required"> * </span> </label>
											<div class="col-md-8">
												<input type="password" class="form-control empty" name="txtcpassword" id="txtcpassword" placeholder="Enter Confirm Password">
												<span id="divtxtcpassword" style="color:red"></span>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="form-actions text-right">
								<button type="button" id="btnsubmit" onclick="conwv('signupform')" class="btn btn-success btn-sm mr-1"><i class="la la-check-square-o"></i> Save</button>
								<button type="button" class="btn btn-danger btn-sm"><i class="ft-x"></i> Cancel</button>
							</div>
						</form>
					</div>
				</div>
			</div>
