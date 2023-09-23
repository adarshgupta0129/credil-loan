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
				<div class="col-lg-4">
					<div class="card-box">
								
						<div class="form">
							<?= form_open(fetch_class().'/add_product_addons',array("class" => "", "id" => "signupForm", "enctype"=>"multipart/form-data")); ?>
							
							<div class="form-group">
								<label class="control-label">Addon Name<span class="required">*</span></label>
								<input type="text" id="txtaddonname" name="txtaddonname" class="form-control empty" placeholder="Enter Addon Name" />
								<span id="divtxtaddonname" style="color:red"></span>
							</div>
							
							<div class="form-group">
								<label class="control-label">Addon Image <span class="required">*</span></label>
								<input type="file" class="form-control" name="userfile" id="userfile" accept="image/*" />
								<span id="divuserfile" style="color:red"></span>
								<div id="show_images"></div>
 							</div>
							
							<div class="form-group">
								<label class="control-label">Addon Price<span class="required">*</span></label>
								<input type="text" id="txtamt" name="txtamt" class="form-control numeric" placeholder="Enter Addon Amount" />
								<span id="divtxtamt" style="color:red"></span>
							</div>
							
							<div class="form-group">
								<label class="control-label">Addon Max Quantity Sell<span class="required">*</span></label>
								<input type="text" id="txtmaxqty" name="txtmaxqty" class="form-control numeric" placeholder="Enter Max Quantity" value="1" />
								<span id="divtxtmaxqty" style="color:red"></span>
							</div>
							
							<div class="form-group">
								<button class="btn btn-info" type="button" onclick="check_submit('signupForm')">Submit</button>
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
				</div>
				
				<div class="col-sm-8">
					<div class="card-box table-responsive">
						<h4 class="m-t-0 header-title"><b><?php echo $table; ?></b></h4>
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>S.No</th>
 									<th>Addon Name</th>
 									<th>Addon Pic</th>
 									<th>Addon Price</th>
 									<th nowrap>Addon Max Quantity</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$sn=1;
									foreach($addons as $unit) {
									if($unit->addon_status == 1) {
										$status = "success"; $stat = 0;
									} else {
										$status = "danger"; $stat = 1;
									}
								?>												
									<tr class="<?=$status?>">
										<td><?=$sn++; ?></td>
 										<td><input class="form-control" type="text" value="<?= $unit->addon_name; ?>" onblur="update_value('<?=$unit->addon_id?>', this.value, '6')" /> </td>
 										<td>
											<img src="<?=base_url()?>images/addon/<?=$unit->addon_id?>/s/<?=$unit->addon_image?>" style="width:75px; max-height:75px;" />
											<?= form_open(fetch_class().'/change_addon_image',array("class" => "", "id" => "addOnImage".$unit->addon_id, "enctype"=>"multipart/form-data")); ?>
											<input type="file" name="userfile" accept="image/*" title="Change Pic" style="max-width:90px;padding:4px 0px 0px 0px;" onchange="$('#addOnImage<?=$unit->addon_id?>').submit()" />
											<input type="hidden" name="addon_id" value="<?=$unit->addon_id?>" />
											<?php echo form_close(); ?>
										</td>
 										<td><input class="form-control" type="text" value="<?= $unit->addon_amount; ?>" onblur="update_value('<?=$unit->addon_id?>', this.value, '7')" /> </td>
 										<td><input class="form-control" type="text" value="<?= $unit->addon_max_qty; ?>" onblur="update_value('<?=$unit->addon_id?>', this.value, '8')" /> </td>
										<td>
											<a href="javascript:void(0);" class="btn btn-default"  onclick="change_status('<?=$unit->addon_id?>','<?=$stat?>', '6')"><span class='fa fa-refresh' title="Change Status"></span></a>									
										</td>
									</tr>
								<?php } ?>            
							</tbody>
						</table>
					</div>
				</div>
			</div>
