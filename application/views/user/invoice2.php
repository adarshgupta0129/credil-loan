
<?php foreach($purchase as $rr) {}?>
<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="card-box">
		<div class=" card-body">
			<div class=" mb-0">
				<div class="clearfix card-body p-3 border-bottom">
					<div class="pull-left">
						<h4 class="mb-0">Invoice #<?=$rr->pur_order_trans_id?></h4>
					</div>
					<div class="pull-right">
						<h4 class=" mb-0 mt-1">Date:
							
							<?php $g=$rr->pur_date;?>
							
							<?php  $new_date_format = date(' jS F Y g:ia ', strtotime($g));
							echo $new_date_format; ?>
						</h4>
					</div>
				</div>
				
					<div class="row">
						<div class="col-md-6 m-t-5 m-b-5">
							<h4>User Information:</h4>
							<p class="mb-0 text-black">
								<br><?=$rr->NAME;?><br>
								<?=$rr->user_mobile_no?><br>
								<?=$rr->pur_address?> <?=$rr->pur_delivery_pincode?><br>
								<!--p>Desired Delivery: <?=$rr->pur_delivery_date?> (<?=$rr->pur_delivery_slot?>)<br></p-->
							</p>
						</div>
						<div class="col-md-6 m-t-5 m-b-5">
							<h4>Payment Details :</h4>
							
							<p class="mb-1 text-black"><strong>Payment Type: </strong> <?=$rr->pur_pay_mode;?></br>
							<!--<h6 class="mb-0"><span class="text-muted">Name: </span> <?=$rr->NAME;?></h6>-->
							<?php echo ADDRESS; ?></p>
						</div>
					</div><!-- end col -->
					
					
				</div>
				<!-- end row -->
				
	
					<div class="row">
						<div class="col-md-12">
							<div class="">
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
										<?php $price = $delivery = $discount = $final = "0"; $sn=1;
											foreach($purchase as $rr22) 
											{
												// $price = $price + $rr22->pur_tot_amt;
												$delivery = $delivery+$rr22->pur_delivery_charges;
												$discount = $rr22->pur_discount;
												$final = ($price+$delivery)-$discount;
												
												$product = get_product_detail($rr22->pur_trans_id);
												/* echo "<pre>";
												print_r($product);die; */
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
													<td align="center"><?=($data->pur_all_unit_id != ''?$sn++:'')?></td>
													<?php if($data->pur_all_unit_id != ''){ ?>
														<td>
													<?php $img = get_product_one_image($data->pur_all_variant_id); ?>
														<img src="<?=base_url()?>images/product/<?=$data->pur_all_variant_id?>/s/<?=$img->pr_img_name;?>">
 															&nbsp; &nbsp; &nbsp;
															<?=$data->pur_all_product_name?> 
															<span class="text-info">(<?php echo $data->pur_all_unit_value.' '.$data->unit_name;?>)</span>
												  </td>
														<?php } else { ?>
														<td align="center">
															<img src="<?=base_url()?>images/addon/<?=$data->pur_all_variant_id?>/s/<?=$data->addon_image;?>">
															&nbsp; &nbsp; &nbsp;
															<?=$data->pur_all_product_name?> 
															<span class="text-info"><?php echo $data->pur_all_unit_value.' '.$data->unit_name;?></span>
														</td>
													<?php } ?>
													
													
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
											<th class="border-0  font-weight-bold">&nbsp;</th>
											<th class="border-0  font-weight-bold"><br>
												<br>
												<br>
												<br>
											<br></th>
											<th class="border-0  font-weight-bold">&nbsp;</th>
											<th class="border-0  font-weight-bold">&nbsp;</th>
											<th class="border-0  font-weight-bold">&nbsp;</th>
											<th class="border-0  font-weight-bold">&nbsp;</th>
											<th class="border-0  font-weight-bold">&nbsp;</th>
										</tr>
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
											<th align="right" class="border-0  font-weight-bold">₹ <?=$price+$delivery?></th>
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
											<th align="right" class="border-0  font-weight-bold">- ₹ <?=round($purchase[0]->order_wallet_off,0)?></th>
										</tr>
										<tr>
											<th colspan="6" align="right" class="border-0  font-weight-bold">Grand Total</th>
											<th align="right" class="border-0  font-weight-bold"> ₹ <?=($price+$delivery)-($discount+$purchase[0]->order_wallet_off);?></th>
										</tr>
									</tfoot>
									
								</table>
							</div>
						</div>
					</div>

					<div class=" mb-0">
						<div class="pull-right">
							<a href="#" class="btn btn-primary  m-b-5 m-t-5" onclick="window.print()"><i class="fa fa-print"></i> Print </a>
						</div>
						<div class="clearfix"></div>
					</div>
			
			</div>
		</div>
		
	</div>
</div>