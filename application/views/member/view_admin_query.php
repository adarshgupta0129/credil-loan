
    <!-- Start content -->
    
		
			
			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 id="das"  class="page-title"><?php echo $page; ?></h4>
					<ol class="breadcrumb">
						<li><a href="">Dashboard</a></li>
						<li class="active"><?php echo $form_name; ?></li>
					</ol>
				</div>
			</div>
			<!-- Page-Title -->
			<div class="row">
				
				<div class="col-sm-12">
					<div class="card-box table-responsive">
						<h4 class="m-t-0 header-title"><b><?php echo $table_name; ?></b></h4>
						<table id="datatable" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>S No.</th>
									<th>Name</th>
									<th>Email</th>
									<th>Description</th>
									<th>Date</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									$SN=0;
									foreach($rec->result() as $row)
									{
										$SN++;
									?>
									<tr>
										<td><?php echo $SN; ?></td>
										<td><?php echo $row->tr_form_name; ?></td>
										<td><?php echo $row->tr_form_email; ?></td>
										<td><?php echo $row->tr_form_msg; ?></td>
										<td><?php echo date('d-m-Y h:i:s', strtotime($row->tr_form_date));?></td>
										<td><a href="<?php echo base_url(); ?>member/delete_query/<?= $row->tr_form_id; ?>">Delete</a></td>
									</tr>
									<?php
									}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>			