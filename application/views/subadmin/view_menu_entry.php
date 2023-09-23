
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
						<form class="form form-horizontal" action="<?=base_url()?>subadmin/insert_menu_entry" method="post" id="signupform">
							<div class="form-body">
								
								<h4 class="form-section"><i class="ft-user"></i> Personal Info</h4>
								
								<div class="row">
								
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">Menu Name <span class="required"> * </span></label>
											<div class="col-md-8">
												<input type="text" class="form-control empty"  name="menu_name" id="menu_name" placeholder="Enter Menu Name">	
												<span id="divtxtassociate_name" style="color:red"></span>
											</div>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">Menu Order By <span class="required"> * </span></label>
											<div class="col-md-8">
												<input type="text" class="form-control empty"  name="menu_orderby" id="menu_orderby" placeholder="Enter Menu Order By">	
												<span id="divtxtassociate_name" style="color:red"></span>
											</div>
										</div>
									</div>
									
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">Main Menu</label>
											<div class="col-md-8">
												<select id="menu_parent_id" name="menu_parent_id" class="form-control" >
													<option value="0">Select Main Menu</option>
													<?php
														foreach ($menu_parent->result() as $row) {
														?>
														<option value="<?php echo $row->menu_id; ?>"><?php echo $row->menu_name; ?></option>
														<?php
														}
													?>
												</select>
												<span id="divmenu_parent_id" style="color:red"></span>
											</div>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">Menu URL <span class="required"> * </span></label>
											<div class="col-md-8">
												<input type="text" class="form-control empty"  name="menu_url" id="menu_url" placeholder="Enter Menu URL">	
												<span id="divtxtassociate_name" style="color:red"></span>
											</div>
										</div>
									</div>
									
									<div class="col-md-4">
										<div class="form-group">
											<label class="col-md-4 control-label">Menu Icon <span class="required"> * </span></label>
											<div class="col-md-8">
												<input type="text" class="form-control empty"  name="menu_fa_icon" id="menu_fa_icon" placeholder="Enter Menu Icon">	
												<span id="divtxtassociate_name" style="color:red"></span>
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
		</div>		