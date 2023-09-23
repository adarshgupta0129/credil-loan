
<div class="row">
	<div class="col-sm-12">
		<h4 id="das"  class="page-title"><?php echo $form; ?></h4>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>master/index">Dashboard</a></li>
			<li class="active"><?php echo $form; ?></li>
		</ol>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<div class="card-box">
		<div class=" card-body">
			<div class=" mb-0">
				<div class="clearfix card-body p-3 border-bottom">
					<div class="pull-left">
						<h4 class="mb-0">Invoice #<?=$purchase['purchase'][0]->pur_order_trans_id?></h4>
					</div>
					<div class="pull-right">
						<h4 class=" mb-0 mt-1">Date:
							
							<?php $g=$purchase['purchase'][0]->pur_date;?>
							
							<?php  $new_date_format = date(' jS F Y g:ia ', strtotime($g));
							echo $new_date_format; ?>
						</h4>
					</div>
				</div>
				
					<div class="row">
						<div class="col-md-6 m-t-5 m-b-5">
							<h4>User Information:</h4>
							<p class="mb-0 text-black">
								<br><?=$purchase['purchase'][0]->NAME;?><br>
								<?=$purchase['purchase'][0]->user_mobile_no?><br>
								<?=$purchase['purchase'][0]->pur_address?> <?=$purchase['purchase'][0]->pur_delivery_pincode?><br>
								<!--p>Desired Delivery: <?=$purchase['purchase'][0]->pur_delivery_date?> (<?=$purchase['purchase'][0]->pur_delivery_slot?>)<br></p-->
							</p>
						</div>
						<div class="col-md-6 m-t-5 m-b-5">
							<h4>Payment Details :</h4>
							<p class="mb-1 text-black"><strong>Payment Type: </strong> <?=$purchase['purchase'][0]->pur_pay_mode;?></br>
							<!--<h6 class="mb-0"><span class="text-muted">Name: </span> <?=$purchase['purchase'][0]->NAME;?></h6>-->
							<?php echo ADDRESS; ?></p>
						</div>
					</div><!-- end col -->
					
					
				</div>
				<!-- end row -->
				
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table border table-bordered text-nowrap">
									<thead>
										<tr>
											<th align="center" class="border-0  font-weight-bold">S.N.</th>
											<th class="border-0  font-weight-bold">Item</th>
											<th class="border-0  font-weight-bold">Delivery Charges</th>
											<th class="border-0  font-weight-bold">Date</th>
											<th class="border-0  font-weight-bold">Slot</th>
											<th class="border-0  font-weight-bold">Quantity</th>
											<th class="border-0  font-weight-bold">Total</th>
									  </tr>
									</thead>
									<tbody>
										<?php $price = $delivery = $discount = $pur_type_charge= $final = "0"; $sn=1;echo '<pre>';
											foreach($purchase['purchase'] as $rr22) 
											{
												$delivery += $delivery+$rr22->pur_delivery_charges;
												$discount += $rr22->pur_discount;
												$pur_type_charge += $rr22->pur_type_charge;
												
												$product = get_product_detail($rr22->pur_trans_id);
												
												foreach($product as $data){ 
													$price = $price + $data->pur_all_unit_price;
												?>
												<tr 
												<?php 
													if($data->pur_all_unit_id == '')
													{
														echo "style:margin-left:50px";
													} 
												?>
												>
													
													
													<?php if($data->pur_all_unit_id != ''): ?>
														<td align="center" style="vertical-align: middle;" rowspan="<?=(count($product))?>" class="bg-info text-white"><?=$data->pur_all_unit_id != '' ? $sn++:''?></td>
														<td>
															<table class="table">
																<tr>
																	<td colspan="2" align="right"><b>Invoice</b> : <?=$data->pur_all_trans_id?> | 
																		<a title="invoice" target="_blank" href="<?=base_url()?>Member/view_purchase_details/<?=$data->pur_all_trans_id?>"><i class="fa fa-print"></i></a>
																		<?php if($rr22->pur_current_status == 'Placed') {?>
																			| <a  title="Action" class="btn " onclick="product_status('<?= $data->pur_all_trans_id?>')"><i class="fa fa-tasks"> </i></a>
																		<?php }?>
																	</td>
																</tr>
																<tr>
																	<td width="70"><img src="<?=base_url()?>images/product/<?=$data->pur_all_variant_id?>/s/<?=get_product_one_image($data->pur_all_variant_id)->pr_img_name;?>" width="60"></td>
																	<td>
																		<?=$data->pur_all_product_name?> | <?=$rr22->type_name?>
																		<span class="text-info">(<?php echo $data->pur_all_unit_value.' '.$data->unit_name;?>)</span>
																		<br>
																		<span class="bg-info border p-l-r-10 text-white"><?=$rr22->pur_current_status?></span>
																		<?php if(!empty($data->order_flavour)): ?><span class="bg-warning border p-l-r-10 "><?=  "Flavor: ".$data->order_flavour ?></span><?php endif?>																		
																		
																		<div style="border: 1px solid #e6dede; padding: 10px 0px;">
																			<p class="m-b-0">Order Instructions</p>
																			<span><br><i><?=$data->order_instruction ?></i></span>	
																			<?php if(!empty($data->order_design_img)): ?>
																				<a href="<?= base_url("images/instruction/".$data->order_design_img)?>" target="_blank"><img src="<?= base_url("images/instruction/".$data->order_design_img)?>" width="50"></a>
																			<?php endif ?>
																		</div>																	
																	</td>
																</tr>
															</table>
												  		</td>
													<?php  else: ?>
														<td style="padding-left:50px;">
															<span class="text-info">Addon </span>
															<img src="<?=base_url()?>images/addon/<?=$data->pur_all_variant_id?>/s/<?=$data->addon_image;?>" width="50">
															&nbsp; &nbsp; &nbsp;
															<?=$data->pur_all_product_name?> 
															<span class="text-info"><?php echo $data->pur_all_unit_value.' '.$data->unit_name;?></span>
														</td>
													<?php endif ?>
													
													<td align="center"><?=($data->pur_all_unit_value <> '')?$rr22->pur_delivery_charges:''?> </td>
													<td align="center"><?=($data->pur_all_unit_value <> '')?date('Y-m-d',strtotime($rr22->pur_date)):'' ?> </td>
													<td align="center"><?=($data->pur_all_unit_value <> '')?$rr22->pur_delivery_slot:''?> </td>
													<td align="center"><?=$data->pur_all_qty?> </td>
													<td><?=$data->pur_all_unit_price; ?> </td>
									  </tr>
											<?php } } ?>
											
									</tbody>
									
									<tfoot>
										
										<tr>
											<th colspan="6" align="right" class="border-0  font-weight-bold">Total</th>
											<th align="right" class="border-0  font-weight-bold">₹ <?= $price?> </th>
										</tr>
										
										<?php if(!empty($rr22->pur_type_charge)): ?>
											<tr>
												<th colspan="6" align="right" class="border-0  font-weight-bold">Egg-Less Charge</th>
												<th align="right" class="border-0  font-weight-bold">+ ₹ <?= $rr22->pur_type_charge?></th>
											</tr>
										<?php endif ?>

										
										<tr>
											<th colspan="6" align="right" class="border-0  font-weight-bold">Sub-Total</th>
											<th align="right" class="border-0  font-weight-bold">₹ <?=$price+$rr22->pur_type_charge;//$delivery?></th>
										</tr>

										<tr>
											<th colspan="6" align="right" class="border-0  font-weight-bold">Delivery Charges </th>
											<th align="right" class="border-0  font-weight-bold">+ ₹ <?=$delivery?></th>
										</tr>
										
										<tr>
											<th colspan="6" align="right" class="border-0  font-weight-bold">Offer Discount</th>
											<th align="right" class="border-0  font-weight-bold">- ₹ <?=round($discount,0)?></th>
										</tr>
										<tr>
											<th colspan="6" align="right" class="border-0  font-weight-bold">Wallet Discount</th>
											<th align="right" class="border-0  font-weight-bold">- ₹ <?=round($purchase['purchase'][0]->order_wallet_off,0)?></th>
										</tr>
										<tr>
											<th colspan="6" align="right" class="border-0  font-weight-bold">Grand Total</th>
											<th align="right" class="border-0  font-weight-bold"> ₹ <?=($price+$delivery+$pur_type_charge)-($discount+$purchase['purchase'][0]->order_wallet_off);?></th>
										</tr>
									</tfoot>
									
								</table>
							</div>
						</div>
					</div>
			
			</div>
		</div>
		
	</div>
</div>



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
	
	
	<div id="status_myModal" class="modal fade" role="dialog">
		<div class="modal-dialog">
			
			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Update Product Status</h4>
				</div>
				<div class="custom-modal-text">
					<div class="form">
						<?= form_open('member/view_update_status',array("class" => "form-horizontal", "id" => "signupForm1")); ?>
						
						
						<input type="hidden" id="txt_transid" name="txt_transid" class="form-control">
						<div class="form-group">
							<label class="col-md-3 control-label" id="chg_name">Status</label>
							<div class="col-md-8">
								<select class="form-control opt" name="dd_status" id="dd_status">
									<option value="-1"> Select </option>
									<option value="2"> Deliverd</option>
									<option value="3"> Cancel</option>							
								</select>
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
		</div>
	</div>
	
	<script>
		function product_status(id)
		{
		$('#txt_transid').val(id);
		$('#status_myModal').modal('show');
		}
		
	</script>
		