<div class="row">
	<div class="col-sm-12">
		<h4 id="das"  class="page-title"><?php echo $page; ?></h4>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>master/index">Dashboard</a></li>
			<li class="active"><?php echo $form; ?></li>
		</ol>
	</div>
</div>
<div class="row">
	<div class="col-lg-12">
		<div class="card-box">
			<h4 class="m-t-0 header-title"><b><?php echo $form; ?></b></h4>
			<p class="text-muted font-13 m-b-30"></p>
			
			<div class="form">
				<?= form_open('userprofile/insert_ticket',array("class" => "cmxform form-horizontal", "id" => "signupForm")); ?>
				
				<div class="form-group">
					<label class="col-md-3 control-label">Title </label>
					<div class="col-md-9">
						<input type="text" id="txttitle" name="txttitle" class="form-control empty" placeholder="Enter Title." >
						<input type="hidden" id="txtuserid" name="txtuserid" value="<?=session('profile_id'); ?>" >
						<span id="divtxttitle" style="color:red"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">Text Message</label>
					<div class="col-md-9">
						<textarea id="txtmsg" name="txtmsg" class="form-control empty" rows="3" style="resize:none;" placeholder="Enter Text Message."></textarea>
						<span id="divtxtmsg" style="color:red"></span>
					</div>
				</div>
				
				<div class="form-group">
					<div class="col-md-offset-4 col-md-8">
						<button class="btn btn-primary" type="button" onclick="check_submit('signupForm')">Submit</button>
						<button type="button" class="btn btn-default">Cancel</button>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	
	
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<h4 class="m-t-0 header-title"><b><?php echo $table; ?></b></h4>
			
			<table id="datatable" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>S No.</th>
						<th>Action</th>
						<th>Created Date</th>
						<th>Full Name</th>
						<th>Associate Code</th>
						<th>Title</th>
						<th>Description</th>
						<th>Status</th>
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
								<a onclick="get_ticket_details('<?php echo $row->TICKET_ID; ?>')" href="#custom-modal" class="waves-effect waves-light" data-animation="sign" data-plugin="custommodal"  data-overlaySpeed="100" data-overlayColor="#36404a">Reply</a>
							</td>
							<td><?php echo $row->TICKET_DATE; ?></td>
							<td><?php echo $row->TICKET_USERNAME; ?></td>
							<td><?php echo $row->TICKET_USERID; ?></td>
							<td><?php echo $row->TICKET_TITLE; ?></td>
							<td><?php echo substr($row->TICKET_DESC,0,50); ?></td>
							<td><?php echo $row->TICKET_STATUS; ?></td>
						</tr>
						<?php
						}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>

<div id="custom-modal" class="modal-demo">
	<button type="button" class="close" onclick="Custombox.close();">
		<span>&times;</span><span class="sr-only">Close</span>
	</button>
	<h4 class="custom-modal-title" id="headtxt"><?=$table?></h4>
	<div class="custom-modal-text">
		<div class="form">
			<?= form_open('member/update_reply',array("class" => "form-horizontal", "id" => "signupForm1")); ?>
			
			<div class="form-group">
				<label class="col-md-3 control-label" id="chg_name">Title</label>
				<div class="col-md-8">
					<span id="divtitle"></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-3 control-label" id="chg_name">Description</label>
				<div class="col-md-8">
					<span id="divdesc"></span>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-3 control-label" id="chg_name">Reply</label>
				<div class="col-md-8">
					<span id="divreply"></span>
				</div>
			</div>
			
			<?php echo form_close(); ?>
		</div>
	</div>
	</div>	