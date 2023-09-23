
<!-- Start content -->



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
				<?= form_open('master/add_city',array("class" => "", "id" => "signupForm")); ?>
				
				<div class="form-group">
					<label class="col-md-2 control-label">State</label>
					<div class="col-md-3">
						<select class="bs-select form-control input-large" name="ddstate" id="ddstate">
							<option value="-1">Select</option>
							<?php
								foreach($state->result() as $st)
								{
								?>
								<option value="<?= $st->m_loc_id; ?>"><?= $st->m_loc_name; ?></option>
								<?php
								}
							?>
						</select>
					</div>
				
					<label class="col-md-2 control-label">City Name<span class="required">*</span></label>
					<div class="col-md-3">
						<input type="text" id="txtcity" name="txtcity" class="form-control empty" placeholder="Enter City Name.">
					</div>
			
					<div class="col-md-2">
						<button class="btn btn-info" type="button" onclick="conwv('signupForm')">Submit</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
			<hr>
			<div class="table-responsive">
				
				<table id="datatable-buttons" class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>S.No</th>
							<th>State</th>
							<th>City</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<?php 
							$sn=0;
							foreach($allcity->result() as $unit)
							{
								$sn++;
							?>												
							<tr>
								<td><?php echo $sn; ?></td>
								<td><?php echo $unit->state; ?></td>
								<td><?php echo $unit->city; ?></td>
								<td>
									<?php 
										if($unit->status_id==1)
										{
										?>
										<a class="btn btn-info btn-sm" href="<?php echo base_url(); ?>master/city_status/<?php echo $unit->city_id; ?>"><span class='glyphicon glyphicon-trash'></span></a>
										<?php
										}
									?>
							</td>
						</tr>
					<?php } ?>            
				</tbody>
			</table>
		</div>
	</div>
</div>
