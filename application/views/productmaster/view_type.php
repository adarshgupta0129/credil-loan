
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
							<?= form_open(fetch_class().'/add_type',array("class" => "", "id" => "signupForm")); ?>
							
							<div class="form-group">
								<label class="control-label">Product Type<span class="required">*</span></label>
								
									<input type="text" id="txtpr_type" name="txtpr_type" class="form-control empty" placeholder="Enter Product Type">
									<span id="divtxtpr_type" style="color:red"></span>
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
  									<th>Type </th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$sn=1;
									foreach($type as $unit) {
									if($unit->type_status==1) {
										$status = "success"; $stat = 0;
									} else {
										$status = "danger"; $stat = 1;
									}
								?>												
									<tr class="<?=$status?>">
										<td><?=$sn++; ?></td>
  										<td><input type="text" class="form-control" value="<?= $unit->type_name; ?>" id="<?= $unit->type_id; ?>" name="<?= $unit->type_id; ?>" onblur="update_value(this.id, this.value, '3')" /> </td>
										<td>
											<a href="javascript:void(0);"  class="btn btn-default" onclick="change_status('<?=$unit->type_id?>','<?=$stat?>', '3')"><span class='fa fa-refresh' title="Change Status"></span></a>									
										</td>
									</tr>
								<?php } ?>            
							</tbody>
						</table>
					</div>
				</div>
			</div> 