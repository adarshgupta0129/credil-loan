
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
				<div class="col-lg-5">
					<div class="card-box"> 	
							<div class="form">
								<?= form_open(fetch_class().'/add_payment_mode',array("class" => "", "id" => "signupForm")); ?>
													 
								<div class="form-group">
									<label class="control-label">Payment Mode<span class="required">*</span></label> 
									<input type="text" id="txtpaymentmode" name="txtpaymentmode" class="form-control empty" placeholder="Enter Payment Mode">
									<span id="divtxtgroup" style="color:red"></span>
								</div>
							</div>
							
							<div class="form-group">								
								<button class="btn btn-info" type="button" onclick="check_submit('signupForm')">Submit</button>								
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
	
				
				<div class="col-sm-7">
					<div class="card-box table-responsive">
						<h4 class="m-t-0 header-title"><b><?php echo $table; ?></b></h4>
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>S.No</th>
 									<th>Pay Mode</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$sn=1;
									foreach($payment as $unit) {
									if($unit->pay_mode_status==1) {
										$status = "success"; $stat = 0;
									} else {
										$status = "danger"; $stat = 1;
									}
								?>												
									<tr class="<?=$status?>">
										<td><?=$sn++; ?></td>
  										<td><?= $unit->pay_mode_name; ?> </td>
										<td>
											<a href="javascript:void(0);"  class="btn btn-default" onclick="change_status('<?=$unit->pay_mode_id?>','<?=$stat?>', 'payment')"><span class='fa fa-refresh' title="Change Status"></span></a>									
										</td>
									</tr>
								<?php } ?>            
							</tbody>
						</table>
					</div>
				</div>
			</div> 