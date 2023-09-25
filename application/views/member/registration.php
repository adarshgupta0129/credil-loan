
	<!-- Start content -->
	
		

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 id="das"  class="page-title">
						<?php echo $page; ?>
					</h4>
					<ol class="breadcrumb">
						<li>
							<a href="<?php echo base_url(); ?>master/index">Dashboard</a>
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

						<div class="form">
							<?= form_open(fetch_class().'/register_candidate',array("class" => "cmxform form-horizontal", "id" => "signupForm")); ?>

							<div class="row">

								<!--/span-->
								<div class="form-group">
									<label class="col-md-4 control-label">Sponsor Id <span class="required"> * </span>
									</label>
									<div class="col-md-5">
										<input type="text" class="form-control empty" name="txtintroducer_id" id="txtintroducer_id" onblur="get_intro_detail()" />
										<span id="divtxtintroducer_id" style="color:red"/>
									</div>
								</div>

								<input type="hidden" name="dddesignation" id="dddesignation" value="1"/>

								<div class="form-group">
									<label class="col-md-4 control-label">Sponsor Name <span class="required"> * </span>
									</label>
									<div class="col-md-5">
										<input type="text" class="form-control empty" name="txtintroducer_name" id="txtintroducer_name"  readonly />
										<span id="divtxtintroducer_name" style="color:red"/>
									</div>
								</div>

								<?php if(JOINING==1){ ?>
								<div class="form-group">
									<label class="col-md-4 control-label">Join As <span class="required"> * </span>
									</label>
									<div class="col-md-5">
										<div class="radio-list" id="leg">
											<label class="radio-inline">
												<input type="radio" name="rbjoin_leg" id="rbjoin_leg1" value="L"  onClick="$('#txtjoin_leg').val('L')"/>Left</label>
											<label class="radio-inline">
												<input type="radio" name="rbjoin_leg" id="rbjoin_leg2" value="R"  onClick="$('#txtjoin_leg').val('R')" />Right</label>
											<input type="hidden" class="form-control empty" id="txtjoin_leg" name="txtjoin_leg" />
											<span id="divtxtjoin_leg" style="color:red"/>
										</div>
									</div>
								</div>

								<input type="hidden" class="form-control" name="txtparent_id" id="txtparent_id"  readonly onblur="get_parent_detail()"/>
								<input type="hidden" class="form-control" name="txtparent_name" id="txtparent_name" readonly />
								<?php } ?>

								<?php if(PIN_SYSTEM==1 && IS_FREE == 0){ ?>
								<h3 class="form-section">Pin Details</h3>

								<div class="form-group">
									<label class="col-md-4 control-label">Package <span class="required"> * </span>
									</label>
									<div class="col-md-5">
										<select id="ddpackid" name="ddpackid" class="form-control opt" onchange="fill_pin()">
											<option selected="selected" value="-1">Select Package</option>
											<?php 
													foreach($pack->result() as $p)
													{
													?>
											<option value="<?php echo $p->m_pack_id; ?>">
												<?php echo $p->m_pack_name; ?></option>
											<?php
													}
												?>
										</select>
										<span id="divddpackid" style="color:red"/>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Pin <span class="required"> * </span>
									</label>
									<div class="col-md-5">
										<select id="ddpin" name="ddpin" class="form-control opt">
											<option selected="selected" value="-1">Select Pin</option>
										</select>
										<span id="divddpin" style="color:red"/>
									</div>
								</div>

								<?php } ?>

								<div class="form-group">
									<label class="col-md-4 control-label">Applicant Name <span class="required"> * </span>
									</label>
									<div class="col-md-5">
										<input type="text" class="form-control empty"  name="txtassociate_name" id="txtassociate_name"/>
										<span id="divtxtassociate_name" style="color:red"/>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Gender<span class="required"> * </span></label>
									<div class="col-md-5">
										<div class="radio-list">
											<label class="radio-inline">
												<input type="radio" name="rbgender1" id="rbgender1" value="M" onClick="$('#rbgender').val('M')"/>Male</label>
											<label class="radio-inline">
												<input type="radio" name="rbgender1" id="rbgender2" value="F" onClick="$('#rbgender').val('F')"/>Female</label>
											<input type="hidden" class="form-control empty" id="rbgender" name="rbgender" />
											<span id="divrbgender" style="color:red"/>
 										</div>
									</div>
								</div>

								<!--div class="form-group">
									<label class="col-md-4 control-label">Father/Husband's Name</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="txtparent" id="txtparent"/>
										<span id="divtxtparent" style="color:red"/>
									</div>
								</div>

		

								<div class="form-group">
									<label class="col-md-4 control-label">Date of Birth <span class="required"> * </span>
									</label>
									<div class="col-md-5">
										<div class="input-daterange" id="date-range" data-date-format="yyyy-mm-dd">
											<input type="text" class="form-control empty" name="txtdob" id="datepicker" data-date-format="yyyy-mm-dd" autocomplete="off" value="">
											<span id="divdatepicker" style="color:red"/>
										</div>
									</div>
								</div-->
								<h3 class="form-section">Contact Details</h3>
	
								<div class="form-group">
									<label class="col-md-4 control-label">Mobile<span class="required"> * </span></label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="txtmobile" id="txtmobile" <?php /*onkeyup="verify_mobile()"*/ ?> max="9999999999" />
											<i class="fa fa-times" onclick="$('#txtmobile').val('');$('#txtmobile').attr('readonly', false);$('#divtxtmobile').html('');" style="position: absolute;top: 9px;right: 23px;" title="change number"></i>
										<span id="divtxtmobile" style="color:red"/>
									</div>
								</div>
			
								<div class="form-group">
									<label class="col-md-4 control-label">Email Address</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="txtemail" id="txtemail"/>
										<span id="divtxtemail" style="color:red"/>
									</div>
								</div>

								<?php if( STATE_CITY == 1 ){ ?>
								<div class="form-group">
									<label class="col-md-4 control-label">State <span class="required"> * </span>
									</label>
									<div class="col-md-5">
										<select id="ddstate" name="ddstate" class="form-control opt" onChange="get_city()">
											<option selected="selected" value="-1">Select State</option>
											<?php foreach($state->result() as $row)
												{
												?>
											<option value="<?php echo $row->loc_id;?>">
												<?php echo $row->loc_name;?></option>
											<?php
												}
											?>
										</select>
										<span id="divddstate" style="color:red"/>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">City <span class="required"> * </span>
									</label>
									<div class="col-md-5">
										<select id="ddcity" name="ddcity" class="form-control opt">
											<option selected="selected" value="">Select City</option>
										</select>
										<span id="divddcity" style="color:red"/>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Pincode<span class="required"> * </span></label>
									<div class="col-md-5">
										<input type="text" class="form-control numeric" min="100000" max="999999" name="txtpincode" id="txtpincode" maxlength="6"/>
										<span id="divtxtpincode" style="color:red"/>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Address<span class="required"> * </span></label>
									<div class="col-md-5">
										<textarea class="form-control alpha_numeric" name="txtaddress" id="txtaddress"></textarea>
										<span id="divtxtaddress" style="color:red"/>
									</div>
								</div>
								<?php } ?>
							<?php if( NOMINEE == 1 ){ ?>
								<div class="form-group">
									<label class="col-md-4 control-label">Nominee's Name</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="txtnoname" id="txtnoname"/>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Nominee's Age</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="txtage" id="txtage"/>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Nominee's Relation</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="txtrelation" id="txtrelation"/>
									</div>
								</div>

							<?php } ?>
							<?php if( REG_BANK == 1 ){ ?>
								<h3 class="form-section">Bank Details</h3>

								<div class="form-group">
									<label class="col-md-4 control-label">Bank Name</label>
									<div class="col-md-5">
										<select class="form-control" name="ddbank_name" id="ddbank_name">
											<option value="">Select Bank</option>
											<?php
														foreach($bank->result() as $bank_row)
														{
														?>
											<option value="<?php echo $bank_row->m_bank_id;?>">
												<?php echo $bank_row->m_bank_name;?></option>
											<?php 
															}
															?>
										</select>
										<span id="divddbank_name" style="color:red"/>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Branch Name</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="txtbranch_name" id="txtbranch_name"/>	
										<span id="divtxtbranch_name" style="color:red"/>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Account Number</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="txtaccount" id="txtaccount"/>
										<span id="divtxtaccount" style="color:red"/>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">IFSCode</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="txtifscode" id="txtifscode"  maxlength="11"/>	
										<span id="divtxtifscode" style="color:red"/>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Pancard Number</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="txtpancard" id="txtpancard"  maxlength="10"/>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Adhar</label>
									<div class="col-md-5">
										<input type="text" class="form-control" name="txtadhar" id="txtadhar"/>
										<span id="divtxtadhar" style="color:red"/>
									</div>
								</div>
							<?php } ?>
								<!--h3 class="form-section">Password</h3>

								<div class="form-group">
									<label class="col-md-4 control-label">Password</label>
									<div class="col-md-5">
										<input type="password" class="form-control" name="txtpassword" id="txtpassword"  maxlength="10"/>
										<span id="divtxtpassword" style="color:red"/>
									</div>
								</div>

								<div class="form-group">
									<label class="col-md-4 control-label">Confirm Password</label>
									<div class="col-md-5">
										<input type="password" class="form-control" name="txtcpassword" id="txtcpassword"/>
										<span id="divtxtcpassword" style="color:red"/>
										<span id="divtxtconfirm" style="color:red"/>
									</div>
								</div-->


								<div class="col-md-offset-3 col-md-9" >
									<div class="col-md-1 control-label">
										<div class="form-group">
											<input type="checkbox" name="txtterm" id="txtterm" />
										</div>
									</div>
									<div class="col-md-11">
										<div class="form-group">
											<label class="control-label" style="float:left">By clicking the button you have confirmed accept the <?php echo SITE_NAME ?> Terms & Conditions and <a href="<?=base_url().fetch_class()?>/view_term_condition" target="_blank">Privacy Policy </a>.</label>
										</div>
									</div>
								</div>
 
							</div>

							<input type="hidden" name="txtproc" id="txtproc" value="1" />
							<input type="hidden" name="txtreg_from" id="txtreg_from" value="1" />

							<div class="row">
								<div class="form-group">
									<div class="col-md-offset-4 col-md-8" id="function">
										<button class="btn btn-info" type="button" onclick="registration('signupForm')">Submit</button>
										<button type="button" class="btn btn-danger">Cancel</button>
									</div>
								</div>
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
			</div>
	