<div class="row">
	<div class="col-md-8 col-md-offset-2">
		<div class="card-box">
			<div class=" mb-0">
				<div class="clearfix card-body p-3 border-bottom">
					<div class="pull-left">
						<h4 class="mb-0">Invoice #<?=$purchase->pur_trans_id?></h4>
					</div>
					<div class="pull-right">
						<h4 class=" mb-0 mt-1">Date :
							
							<?php $g=$purchase->pur_date;?>
							
							<?php  $new_date_format = date(' jS F Y g:ia ', strtotime($g));
							echo$new_date_format; ?>
						</h4>
					</div>
				</div>
				<div class=" card-body">
					<div class="row">
						<div class="col-md-6 m-t-5 m-b-5">
							<h4>User Information:</h4>
							<p class="mb-0 text-black">
								<?=$purchase->NAME;?><br>
								<?=$purchase->user_mobile_no?><br>
								<?=$purchase->pur_address?> <?=$purchase->pur_delivery_pincode?><br>
								Desired Delivery : <?=$purchase->pur_delivery_date?> (<?=$purchase->pur_delivery_slot?>)<br>
							</p>
						</div>
						<div class="col-md-6 m-t-5 m-b-5">
							<h4>Payment Details :</h4>
							
							<p class="mb-1 text-black"><strong>Order Date : </strong> <?=date('Y-m-d',strtotime($purchase->pur_date));?></br>
							<strong>Payment Type : </strong> <?=$purchase->pur_pay_mode;?></br>
								<!--<h5 class="mb-0"><span class="text-muted">Name : </span> <?=$purchase->NAME;?></h5>-->
							<?php echo ADDRESS; ?></p>
						</div>
					</div><!-- end col -->
				</div>
				<!-- end row -->
				
				<div class="card-body pt-0">
					<div class="row">
						<div class="col-md-12">
							<div class="table-responsive">
								<table class="table border table-bordered text-nowrap">
									<thead>
										<tr>
											<th align="center" class="border-0  font-weight-bold">S.N.</th>
											<th align="center" class="border-0  font-weight-bold">Item</th>
											<th align="center" class="border-0  font-weight-bold">Quantity</th>
											<th align="center" class="border-0  font-weight-bold">Total</th>
										</tr>
									</thead>
									<tbody>
										<?php $sn=1;$price = $delivery = $discount = $final = "0";
											foreach($product as $data)
											{
												$price = $price + $data->pur_all_unit_price;										
												$final = ($price+$delivery)-$discount;
												
											?>
											<tr>
												
												<td align="center"><?=$sn++;?></td>
												<?php if($data->pur_all_unit_id != ''){ ?>
													<td align="left">
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
												
												<td align="center"><?=$data->pur_all_qty?> </td>
												<td><?=$data->pur_all_unit_price; ?> </td>
											</tr>
										<?php } ?>
										
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
										</tr>
										<tr>
											<th colspan="3" align="right" class="border-0  font-weight-bold">Sub-Total</th>
											<th align="right" class="border-0  font-weight-bold">₹ <?php /*$price = $price + $purchase->pur_tot_amt;*/ echo $price?> </th>
										</tr>
										<tr>
											<th colspan="3" align="right" class="border-0  font-weight-bold">Delivery Charges </th>
											<th align="right" class="border-0  font-weight-bold">+ ₹ <?= round($purchase->pur_delivery_charges,0)?></th>
										</tr>
										
										<tr>
											<th colspan="3" align="right" class="border-0  font-weight-bold">Grand Total</th>
											<th align="right" class="border-0  font-weight-bold"> ₹ <?=($price+$purchase->pur_delivery_charges);?></th>
										</tr>
									</tfoot>
								</table>
							</div>
						</div>
					</div>
					<div class="row "> 
						<div class="col-12">
							<div class="pull-right">
								<a href="#" class="btn btn-primary  m-b-5 m-t-5" onclick="window.print()"><i class="fa fa-print"></i> Print </a>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					
				</div>
			</div>
		</div>
	</div>
</div>