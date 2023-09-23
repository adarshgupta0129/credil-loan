
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
<div class="row"><div class="col-sm-12">
	
	<div class="form">
		
		<fieldset>
			<legend><span>Purchase</span></legend>	
			<div>
				<input type="hidden" name="total_item" id="total_item" value="1" />
				<div class="form-group row">
					<table class="table table-striped table-bordered">
						<thead>
							<tr>
								<th>S.No</th>
								<th>Invoice No.</th>
								<th>Product Name</th>
								<th>Unit</th>
								<th>Price</th>
								<th>Qty</th>
								<th>Amount</th>
							</tr>
						</thead>
						<tbody>
							<?php $sn=1; foreach ($rid as $data){ ?>
								<tr>
									<td><?=$sn++;?></td>
									<td><?=$transid;?></td>
									<td><?=$data->pur_all_product_name;?></td>
									<td><?=$data->pur_all_unit_value.' '.$data->unit_name?></td>
									<td><?=$data->pur_all_unit_price?></td>
									<td><?=$data->pur_all_qty?></td>
									<td><?= $data->pur_all_unit_price*$data->pur_all_qty;?></td>
									<td>
									<?php 
									if($data->pur_all_unit_id != '')
									{ 
										
									 $img = get_product_one_image($data->pur_all_variant_id);
									?>
									
										<img src="<?=base_url()?>images/product/<?=$data->pur_all_variant_id?>/s/<?=$img->pr_img_name;?>" width="50" loading="lazy">
										
										<!--img src="<?=base_url()?>images/product/<?=$data->pur_all_variant_id?>/s/<?=$data->pr_img_name;?>"-->
									<?php } else { ?>
										<img src="<?=base_url()?>images/addon/<?=$data->pur_all_variant_id?>/s/<?=$data->addon_image;?>" width="50" loading="lazy">
									<?php } ?>
									</td>
								</tr>
								<tr>
									<td></td>
									<td>Instruction</td>
									<td colspan="4"><?= $data->order_instruction?></td>
									<td>Flavor: <?= $data->order_flavour?></td>
									<td><img src="<?= base_url("images/instruction/".$data->order_design_img)?>" width="50"></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>		
			</div>		
		</fieldset>
		
		
	</div>	
	
</div></div>
<script src="<?=base_url()?>application/libraries/assets/plugins/ckeditor/ckeditor.js"></script>	
<style>	
	
	#show_images img, #show_images_yt img, #show_imagesvari img, .show_imagesvari img, #show_images_ytvari img{
	max-height: 100px;
	min-height: 100px;
	max-width: 350px;
	padding: 2% 1% 0% 1%;
	clear: both;
	}
	#remove_images, #remove_imagesvari{
	border: 1px solid transparent;
	width: fit-content;
	padding: 3px 8px;
	float: right;
	border-radius: 30px;
	background: #ff0000eb;
	color: #fff;
	}
	.variant_count{
	border: 1px solid transparent;
	width: fit-content;
	padding: 3px 9px;
	float: right;
	border-radius: 32px;
	background: #7142b0eb;
	color: #fff;
	}
	.variant_img, .variant_amt, .variant_show_amt{
	max-width: 91px;
	}
	#cke_42, #cke_43{
	display: none;
	}
	.form-group{}
</style>

