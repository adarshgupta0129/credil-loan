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
				<?= form_open(fetch_class().'/view_all_products',array("class" => "", "id" => "signupForm", "enctype"=>"multipart/form-data")); ?>							
				<div class="form-group">
					<label class="control-label">Product Name<span class="required">*</span></label>
					<input type="text" id="txtprodname" name="txtprodname" class="form-control empty" placeholder="Enter Product Name" />
					<span id="divtxtprodname" style="color:red"></span>
				</div>
				
				<div class="form-group">
					<button class="btn btn-info" type="button" onclick="check_submit('signupForm')">Submit</button>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<h4 class="m-t-0 header-title"><b><?php echo $table; ?></b></h4>
			<table id="datatable-buttons" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>S.No</th>
						<th>Pic</th>
						<th>Name</th>
						<th>Variant</th>
						<th>Show Price</th>
						<th>Actual Price</th>
						<th>Code</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$sn=1;
						foreach($products as $unit) {
							if($unit->pr_status == 1) {
								$status = "success"; $stat = 0;
								} else {
								$status = "danger"; $stat = 1;
							}
						?>												
						<tr class="<?=$status?>">
							<td><?=$sn++; ?></td>
							<td class="product_img_change">
								<a href="<?=base_url()?>images/product/<?=$unit->pr_vari_id?>/x/<?=$unit->pr_img_name?>" target="_blank">
									<img src="<?=base_url()?>images/product/<?=$unit->pr_vari_id?>/s/<?=$unit->pr_img_name?>" style="width:25px; max-height:25px;" />
								</a>									
								<?php /* echo  form_open(fetch_class().'/change_product_image',array("class" => "", "id" => "addOnImage".$unit->pr_id, "enctype"=>"multipart/form-data")); ?>
									<input type="file" name="userfile" accept="image/*" title="Change Pic" style="max-width:90px;padding:4px 0px 0px 0px;" onchange="$('#addOnImage<?=$unit->pr_id?>').submit()" />
									<input type="hidden" name="pr_id" value="<?=$unit->pr_id?>" />
								<?php echo form_close(); */ ?>
							</td>
							<td><input class="form-control" type="text" value="<?= $unit->pr_name; ?>" onblur="update_value('<?=$unit->pr_id?>', this.value, '14')" /> </td>
							<td><?=$unit->pr_vari_unit_value?> <?=$unit->unit_name?> &nbsp;&nbsp;&nbsp;
								<a class="anchor pull-right" href="<?=base_url()?>Product_Master/view_all_product_variants?productId=<?=$unit->pr_id?>" target="_blank">Others</a>
							</td>
							<td><input class="form-control" type="text" value="<?= $unit->pr_vari_show_price; ?>" onblur="update_value('<?=$unit->pr_vari_id?>', this.value, '15')" /> </td>
							<td><input class="form-control" type="text" value="<?= $unit->pr_vari_actual_price; ?>" onblur="update_value('<?=$unit->pr_vari_id?>', this.value, '16')" /> </td>
							<td><input class="form-control" type="text" value="<?= $unit->pr_code; ?>" onblur="update_value('<?=$unit->pr_id?>', this.value, '17')" /> </td>
							<td>
								<a href="javascript:void(0);" class="btn btn-default"  onclick="change_status('<?=$unit->pr_id?>','<?=$stat?>', '9')"><span class='fa fa-refresh' title="Change Status"></span></a>									
								<a href="<?=base_url()?>Product_Master/update_product_details?productId=<?=$unit->pr_id?>&variantId=<?=$unit->pr_vari_id?>" class="btn btn-info" title="Update more details" target="_blank">more</a>									
							</td>
						</tr>
					<?php } ?>            
				</tbody>
			</table>
		</div>
	</div>
</div>