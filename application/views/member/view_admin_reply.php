
    <!-- Start content -->
    
		
			
			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 id="das"  class="page-title"><?php echo $page; ?></h4>
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>master/index">Dashboard</a></li>
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
									<th>Action</th>
									<th>Created Date</th>
									<th>Full Name</th>
									<th>Member Code</th>
									<th>Title</th>
									<th>Description</th>
									<th>Reply</th>
									<th>Status</th>
									<th>Date</th>
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
										<td>
											<?php
												if($row->TICKET_REPLY=='')
												{
													if($row->TICKET_STATUS_ID==1)
													{
													?>
													<a href="<?php echo base_url(); ?>member/deactive_ticket/<?php echo $row->TICKET_ID; ?>/0">Deactive</a>
													<?php
													}
												?>
												/
												<a onclick="get_ticket_details('<?php echo $row->TICKET_ID; ?>')" href="#custom-modal" class="waves-effect waves-light" data-animation="sign" data-plugin="custommodal"  data-overlaySpeed="100" data-overlayColor="#36404a">Reply</a>
												<?php 
												}
											?>
										</td>
										<td><?php echo date('d-m-Y h:i:s', strtotime($row->TICKET_DATE)); ?></td>
										<td><?php echo $row->TICKET_USERNAME; ?></td>
										<td><?php echo $row->TICKET_USERID; ?></td>
										<td><?php echo $row->TICKET_TITLE; ?></td>
										<td><?php echo substr($row->TICKET_DESC,0,50); ?>...</td>
										<td><?php echo wordwrap($row->TICKET_REPLY,70,"<br>\n"); ?></td>
										<td><?php echo $row->TICKET_STATUS; ?></td>
										<td><?php echo $row->TICKET_DATE; ?></td>
									</tr>
									<?php
									}
								?>
							</table>
						</div>
					</div>
				</div>
			</div>
			
			<div id="custom-modal" class="modal-demo">
				<button type="button" class="close" onclick="Custombox.close();">
					<span>&times;</span><span class="sr-only">Close</span>
				</button>
				<h4 class="custom-modal-title" id="headtxt">Admin Reply</h4>
				<div class="custom-modal-text">
					<div class="form">
						<?= form_open('member/update_reply',array("class" => "form-horizontal", "id" => "signupForm1")); ?>
						
						<div class="form-group">
							<label class="col-md-3 control-label" id="chg_name">Title</label>
							<div class="col-md-8">
								<span id="divtitle"></label>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label" id="chg_name">Description</label>
							<div class="col-md-8">
								<span id="divdesc"></label>
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-md-3 control-label" id="chg_name">Reply</label>
							<div class="col-md-8">
								<textarea name="txtreply" id="txtreply" placeholder="Enter Description" style="resize:none;" rows="5" class="form-control empty"></textarea>
								<input type="hidden" id="txtid" name="txtid" class="form-control">
							</div>
						</div>
						
						<div class="form-group">
							<div class="col-md-offset-4 col-md-8">
								<button class="btn btn-info" type="submit">Submit</button>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>			