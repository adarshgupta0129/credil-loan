
    <!-- Start content -->
    
		
			
			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 id="das" class="page-title"><?php echo $table; ?></h4>
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>master/index">Dashboard</a></li>
						<li class="active"><?php echo $form; ?></li>
					</ol>
				</div>
			</div>
			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<div class="card-box table-responsive">
						
						<table id="datatable" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Constant</th>
									<th>Value</th>
									<th>Description</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$sn=0;
									foreach($config->result() as $unit)
									{
										$sn++;
									?>												
									<tr>
										<td><?php echo $sn; ?></td>
										<td><?php echo $unit->m00_name; ?></td>
										<td><?php echo $unit->m00_value; ?></td>
										<td><?php echo $unit->m00_desc; ?></td>
										<td><a href="#custom-modal" onclick="setting_value(<?php echo $unit->m00_id; ?>)" class="waves-effect waves-light" data-animation="sign" data-plugin="custommodal"  data-overlaySpeed="100" data-overlayColor="#36404a"> <span class="glyphicon glyphicon-pencil"></span> </a></td>
									</tr>
								<?php } ?>            
							</tbody>
						</table>
					</div>
				</div>
				
			</div>
		
		<div id="custom-modal" class="modal-demo">
			<button type="button" class="close" onclick="Custombox.close();">
				<span>&times;</span><span class="sr-only">Close</span>
			</button>
			<h4 class="custom-modal-title" id="headtxt">Change Password</h4>
			<div class="custom-modal-text">
				<div class="form">
					<?= form_open('',array("class" => "form-horizontal", "id" => "signupForm")); ?>
					
					<div class="form-group">
						<label class="col-md-4 control-label" id="chg_name">Name</label>
						<div class="col-md-6">
							<input type="text" id="txtname" name="txtname" class="form-control empty">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label" id="chg_name">Value</label>
						<div class="col-md-6">
							<input type="text" id="txtval" name="txtval" class="form-control empty">
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-md-4 control-label" id="chg_name">Description</label>
						<div class="col-md-6">
							<input type="text" id="txtdesc" name="txtdesc" class="form-control empty">
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-md-offset-4 col-md-6">
							<button class="btn btn-info" type="submit" onclick="return check('signupForm')">Submit</button>
						</div>
					</div>
					<?php echo form_close(); ?>
				</div>
			</div>
		</div>			