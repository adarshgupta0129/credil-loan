
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
				<div class="col-sm-10">
					<div class="card-box table-responsive">
						
						<table id="datatable" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Name</th>
									<th>Value</th>
									<th>Description</th>
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
										<td><input type="text" class="form-control" value="<?= $unit->m00_value; ?>" id="<?= $unit->m00_id; ?>" name="<?= $unit->m00_id; ?>" onblur="update_value(this.id, this.value, 'setConfig')" /> </td>
										<td><?php echo $unit->m00_desc; ?></td>
									</tr>
								<?php } ?>            
							</tbody>
						</table>
					</div>
				</div>				
			</div>
