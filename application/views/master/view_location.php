<link href="<?= base_url(); ?>application/third_party/js/menu_tree/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>application/third_party/js/menu_tree/css/jquery-explr-1.4.css" rel="stylesheet" type="text/css">
<style>
	.create_new{
	color: #000000!important;
	}
</style>



<div class="row">
	<div class="col-sm-12">
		<h4 id="das"  class="page-title"><?php echo $table; ?></h4>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>master/index">Dashboard</a></li>
			<li class="active"><?php echo $table; ?></li>
		</ol>
	</div>
</div> 
<div class="row">
	
	<div class="col-sm-4">
		<div class="card-box table-responsive">
			<ul id="tree">
				<?php foreach($menu as $first){ ?>
					<li class="icon-chain"> 
						<a href="javascript:void(0);" onclick="edit_location_details('<?= $first->loc_id ?>','0','<?= $first->loc_name ?>','<?= $first->loc_status ?>','Main')"><?=$first->loc_name?> </a>
						<ul>
							<?php
								$submenu = location_child_admin($first->loc_id);
								if(!empty($submenu))
								{
									foreach($submenu as $second)
									{
									?>
									<li class="icon-chain">
										<a id="second<?= $second->loc_id ?>" href="javascript:void(0);" onclick="edit_location_details('<?= $second->loc_id ?>','0','<?= $second->loc_name ?>','<?= $second->loc_status ?>','<?=$first->loc_name?>')"><?=$second->loc_name?> </a>
										<ul>
											<?php
												$subsubmenu = location_child_admin($second->loc_id);
												if(!empty($subsubmenu))
												{
													foreach($subsubmenu as $third)
													{
													?>
													<li class="icon-chain">
														<a id="third<?= $third->loc_id ?>" class="<?=($third->loc_status==0)?'inactive_menu':'active_menu' ?>" href="javascript:void(0);" onclick="edit_location_details('<?= $third->loc_id ?>','0','<?= $third->loc_name ?>','<?= $third->loc_status ?>','<?=$second->loc_name?>')" ><?=$third->loc_name?></a>
													</li>
													<?php 
													}
												}
											?>
											<li class="icon-bookmark">
												<a href="javascript:void(0);" class="create_new" onclick="edit_location_details('0','<?= $second->loc_id ?>','','1','<?=$second->loc_name?>')">Add new in <span class="adding_new_menu"><?=$first->loc_name?>/<?=$second->loc_name?></span></a>
											</li>
										</ul>
										<?php 
										}
									}
								?>
							</li>
							<li class="icon-bookmark">
								<a href="javascript:void(0);" class="create_new" onclick="edit_location_details('0','<?= $first->loc_id ?>','','1','<?=$first->loc_name?>')">Add new in <span class="adding_new_menu"><?=$first->loc_name?></span></a>
							</li>
						</ul>
					</li>
				<?php } ?> 
				<li class="icon-bookmark"> 
					<a href="javascript:void(0);" class="create_new" onclick="edit_location_details('0','0','','1','Main')">Add new in <span class="adding_new_menu">India</span></a>
				</li>
			</ul> 
		</ul>
		
	</div>
</div>
<div class="col-lg-8">
	<div class="card-box">
		<h4 class="header-title"><b><?php echo $form; ?></b></h4>
		
		
		<div class="form">
			<?= form_open('#',array("class" => "", "id" => "signupForm")); ?>
			
			<div class="form-group">
				<label class="col-md-3 control-label">Upper Level</label>
				<div class="col-md-9">
					<input type="text" id="loc_level" name="loc_level" class="form-control input-inline input-medium" placeholder="Location Level" readonly />
				</div>
			</div>
			<div class="form-group">
				<label class="col-md-3 control-label">Status<span class="required">*</span></label>
				<div class="col-md-9">
					<select class="bs-select form-control input-large" name="ddstatus" id="ddstatus">
						<option value="1" selected>Active</option>
						<option value="0">DeActive</option>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-md-3 control-label">Location Name<span class="required">*</span></label>
				<div class="col-md-9">
					<input type="text" id="loc_name" name="loc_name" class="form-control empty" placeholder="Location Name" />
				</div>
			</div>
			<input type="hidden" id="loc_id" name="loc_id" />
			<input type="hidden" id="loc_parent_id" name="loc_parent_id" />
			
			<div class="form-group">
				<label class="col-md-3 control-label">&nbsp;</label> 
				<div class="col-md-9">
					<button class="btn btn-info" type="button" name="submit" id="submit" onclick="set_location('signupForm')">Submit</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>

</div>

<script src="<?= base_url(); ?>application/third_party/js/menu_tree/js/jquery-explr-1.4.js"></script> 
<script>
	$(document).ready(function() {	
	$("#tree").explr();		
	}); 		
	</script> 								