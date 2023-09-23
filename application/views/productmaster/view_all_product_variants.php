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
			<fieldset>
				<legend><span>Update Variants</span></legend>	
				 
				<div>
					<div class="form-group row">
						<label class="col-md-2 control-label">Select Product<span class="required">*</span></label>
						<div class="col-md-3">
							<select class="form-control opt" name="ddproduct" id="ddproduct" onchange="get_product_variants_update(this.value)">
								<option value="0" disabled selected>Select Product</option>
								<?php
									foreach($product as $vari)
									{ 	
										if($vari->pr_id == get('productId'))
											$sel = 'selected';
										else
											$sel = '';
									?>
									<option value="<?= $vari->pr_id; ?>"<?=$sel?>><?= $vari->pr_name; ?></option>
									<?php
									}
								?>
							</select>
							<span id="divddproduct" style="color:red"></span>
						</div>
					</div>
					<?php if(isset($variants)){ ?>
					<h4 class="m-t-0 header-title">
						<b><?php echo $table; ?></b>
						<a class="anchor pull-right" href="<?=base_url()?>Product_Master/view_product_variant?productId=<?=get('productId')?>" target="_blank">add more variants <i class="fa fa-external-link"></i></a>
					</h4>
					<div class="form-group row">
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>S.No</th>
									<th>Category</th>
									<th>Pic</th>
									<th>Unit</th>
									<th>Actual Amount</th>
									<th>Show Amount</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$sn=1;
									foreach($variants as $vari) {
									if($vari->pr_vari_status == 1) {
										$status = "success"; $stat = 0;
									} else {
										$status = "danger"; $stat = 1;
									}
								?>												
									<tr class="<?=$status?>">
										<td><?=$sn++; ?></td>
										<td><?=$vari->vari_name?></td>
										<td>
											<img src="<?=base_url()?>images/product/<?=$vari->pr_vari_id?>/s/<?=$vari->pr_img_name?>" style="width:75px; max-height:75px;" />
											<?= form_open(fetch_class().'/change_variant_image',array("class" => "", "id" => "addOnImage".$vari->pr_vari_id, "enctype"=>"multipart/form-data")); ?>
											<input type="file" name="userfile" accept="image/*" title="Change Pic" style="max-width:90px;padding:4px 0px 0px 0px;" onchange="$('#addOnImage<?=$vari->pr_vari_id?>').submit()" />
											<input type="hidden" name="img_id" value="<?=$vari->pr_img_id?>" />
											<input type="hidden" name="vari_id" value="<?=$vari->pr_vari_id?>" />
											<?php echo form_close(); ?>
										</td>
										<td style="display: inline-flex;width: -webkit-fill-available;">
											<input type="text" id="variant_unit_<?=$vari->pr_vari_id?>" name="variant_unit_<?=$vari->pr_vari_id?>" class="form-control" value="<?=$vari->pr_vari_unit_value?>"  onblur="update_value('<?=$vari->pr_vari_id?>', this.value, '19')" /> &nbsp;
											<select class="form-control" name="ddunit[]" id="ddunit" onchange="update_value('<?=$vari->pr_vari_id?>', this.value, '18')">
												<?php foreach($units as $unit) {
													if($vari->pr_vari_unit_id == $unit->unit_id)
														$sel = 'selected';
													else
														$sel = ''; ?>
													<option value="<?= $unit->unit_id; ?>" <?=$sel?>><?= $unit->unit_name; ?></option>
												<?php } ?>
											</select>
										</td>
										<td><input class="form-control" type="text" value="<?= $vari->pr_vari_actual_price; ?>" onblur="update_value('<?=$vari->pr_vari_id?>', this.value, '20')" /> </td>
										<td><input class="form-control" type="text" value="<?= $vari->pr_vari_show_price; ?>" onblur="update_value('<?=$vari->pr_vari_id?>', this.value, '21')" /> </td>
										<td>
											<a href="javascript:void(0);" class="btn btn-default"  onclick="change_status('<?=$vari->pr_vari_id?>','<?=$stat?>', '10')"><span class='fa fa-refresh' title="Change Status"></span></a>									
										</td>
									</tr>
								<?php } ?>            
							</tbody>
						</table>
					</div>
					<?php } ?>
					</div>
			</fieldset>
		
		<script>
			function get_product_variants_update(productId){	
				full_url.set("productId", productId);
				history.replaceState(null, null, "?"+full_url.toString()); 
				$.blockUI({
					message: '<img src="'+baseUrl+'application/libraries/loading.gif" />'
				});
				$.unblockUI();
				window.location.reload();
			}
		</script>
