<link href="<?= base_url(); ?>application/third_party/js/menu_tree/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>application/third_party/js/menu_tree/css/jquery-explr-1.4.css" rel="stylesheet" type="text/css">
<style>
	.create_new{
	color: #000000!important;
	}
</style>
<div class="row">
	<div class="col-sm-12">
		<h4 id="das"  class="page-title"><?php echo $form; ?></h4>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>master/index">Dashboard</a></li>
			<li class="active"><?php echo $table; ?></li>
		</ol>
	</div>
</div> 
<div class="row">
	
	<div class="col-sm-6">
		<div class="card-box table-responsive">
			<h4 class="m-t-0 header-title"><b><?php echo $table; ?></b></h4>
			<ul id="tree">
				<?php foreach($cat as $first){ ?>
					<li class="icon-chain"> 
						<a href="javascript:void(0);" onclick="edit_category_details('<?= $first->pr_cat_id ?>','0','<?= $first->pr_cat_name ?>','<?= $first->pr_cat_status ?>','Main Menu','<?= $first->pr_cat_img ?>')"><?=$first->pr_cat_name?> </a>
						<ul>
							<?php
								$submenu = category_child_admin($first->pr_cat_id);
								if(!empty($submenu))
								{
									foreach($submenu as $second)
									{
									?>
									<li class="icon-chain">
										<a id="second<?= $second->pr_cat_id ?>" href="javascript:void(0);" onclick="edit_category_details('<?= $second->pr_cat_id ?>','0','<?= $second->pr_cat_name ?>','<?= $first->pr_cat_status ?>','<?= $first->pr_cat_name ?>','<?= $second->pr_cat_img ?>')"><?=$second->pr_cat_name?> </a>
										<ul>
											<?php
												$subsubmenu = category_child_admin($second->pr_cat_id);
												if(!empty($subsubmenu))
												{
													foreach($subsubmenu as $third)
													{
													?>
													<li class="icon-chain">
														<a id="third<?= $third->pr_cat_id ?>" href="javascript:void(0);" onclick="edit_category_details('<?= $third->pr_cat_id ?>','0','<?= $third->pr_cat_name ?>','<?= $third->pr_cat_status ?>','<?= $second->pr_cat_name ?>','<?= $third->pr_cat_img ?>')"><?=$third->pr_cat_name?> </a>
													</li>
													<?php 
													}
												}
											?>
											<li class="icon-bookmark">
												<a href="javascript:void(0);" class="create_new" onclick="edit_category_details('0','<?= $second->pr_cat_id ?>','','1','<?= $second->pr_cat_name ?>','')">Add new in <span class="adding_new_menu"><?=$first->pr_cat_name?>/<?=$second->pr_cat_name?></a>
											</li>
										</ul>
										<?php 
										}
									}
								?>
							</li>
							<li class="icon-bookmark">
								<a href="javascript:void(0);" class="create_new" onclick="edit_category_details('0','<?= $first->pr_cat_id ?>','','1','Main Sub Menu','')">Add new in <span class="adding_new_menu"><?=$first->pr_cat_name?></span></a>
							</li>
						</ul>
					</li>
				<?php } ?> 
				<li class="icon-bookmark"> 
					<a href="javascript:void(0);" class="create_new" onclick="edit_category_details('0','0','','1','Main Menu','')">Add new in <span class="adding_new_menu">Main</span></a>
				</li>
			</ul>
		</div>
	</div>
	<div class="col-lg-6">
		<div class="card-box">
			
			<div class="form">
				<?= form_open(base_url().fetch_class().'/set_category', array( "id" => "signupForm", "method" => "post", "enctype"=>"multipart/form-data")); ?>
				
				<div class="form-group">
					<label class="col-md-3 control-label">Category Level</label>
					<div class="col-md-9">
						<input type="text" id="cat_level" name="cat_level" class="form-control" placeholder="Category Level" readonly />
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Status<span class="required">*</span></label>
					<div class="col-md-9">
						<select class="form-control opt" name="ddstatus" id="ddstatus">
							<option value="1" selected>Active</option>
							<option value="0">DeActive</option>
						</select>
						<span id="divddstatus" style="color:red"></span>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-md-3 control-label">Category Name<span class="required">*</span></label>
					<div class="col-md-9">
						<input type="text" id="cat_name" name="cat_name" class="form-control empty" placeholder="Category Name" />
						<span id="divcat_name" style="color:red"></span>
					</div>
				</div>

				<div class="form-group">
					<label class="col-md-3 control-label">Category Pic</label>
					<div class="col-md-9">
						<input type="file" id="userfile" name="userfile" class="form-control" placeholder="Category Picture" />
						<span id="divuserfile" style="color:red"></span>
					</div>
				</div>
				
				<span style="width:50px"> <img id="cat_img" /> </span>
				
				<input type="hidden" id="cat_id" name="cat_id" />
				<input type="hidden" id="cat_parent_id" name="cat_parent_id" />
				
				<div class="form-group">
					<div class="col-md-offset-4 col-md-8">
						<button class="btn btn-info" type="submit" name="submit" id="submit" <?php /*onclick="check_submit('signupForm')"*/ ?> >Submit</button>
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