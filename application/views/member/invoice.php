<div class="card-box">
	<div class=" mb-0">
		<div class="clearfix card-body p-3 border-bottom">
			<div class="pull-left">
				<h5 class="mb-0">Invoice #<?=$purchase->pur_trans_id?></h5>
			</div>
			<div class="pull-right">
				<p class="text-muted mb-0 mt-1">Date:
					
					<?php $g=$purchase->pur_date;?>
					
					<?php  $new_date_format = date(' jS F Y g:ia ', strtotime($g));
						echo$new_date_format; ?>
					</p>
			</div>
		</div>
		<div class="row card-body">
			<div class="col-md-12">
				<div class="pull-left m-t-5 m-b-5">
					<h6>User Information:</h6>
					<h6 class="mb-0 ">
						 <br><?=$purchase->NAME;?><br>
						<?=$purchase->user_mobile_no?><br>
						<?=$purchase->pur_address?> <?=$purchase->pur_delivery_pincode?><br>
					</h6>
				</div>
				<div class="pull-right m-t-5 m-b-5">
					<h6>Payment Details :</h6>
					
					<h6 class="mb-1 "><span class="">Payment Type: </span> <?=$purchase->pur_pay_mode;?></h6>
					<!--<h6 class="mb-0"><span class="text-muted">Name: </span> <?=$purchase->NAME;?></h6>-->
					<h6 class="mb-0">1/102, Vishesh Khand 2, Gomti Nagar, </br>Lucknow, Uttar Pradesh 226010</h6>
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
									<th class="border-0 text-uppercase font-weight-bold">S.N.</th>
									<th class="border-0 text-uppercase font-weight-bold">Item</th>
									<th class="border-0 text-uppercase font-weight-bold">Name</th>
									<th class="border-0 text-uppercase font-weight-bold">Quantity</th>
									<th class="border-0 text-uppercase font-weight-bold">Weight / Size</th>
									<th class="border-0 text-uppercase font-weight-bold">Total</th>
								</tr>
							</thead>
							<tbody><?php $price="0"?>
							<?php $sn=1; foreach  ($product as $data){?>
								<tr>
								
									<td><?=$sn++;?></td>
									<?php if($data->pur_all_type=='Product'){?>
										<td><img src=<?=PROD_PATH.$data->pur_all_product_id.'/s/'.$data->pr_img_name?> width="50"><?=$data->pur_all_product_name?></td><?php  } ?>
										
										
										
										<?php if($data->pur_all_type=='Addon'){?>
										<td><img src="<?=base_url()?>images/addon/<?php echo$data->pur_all_product_id;?>/x/<?=$data->addon_image?> " width="50"><?=$data->pur_all_product_name?></td><?php  } ?>
									<td> <?=$data->pur_all_product_name?></td>
									<td><?=$data->pur_all_qty?></td>
									<td><?php if($data->pur_all_unit_value==''){}else{echo$data->pur_all_unit_value.'kg';}?> </td>
									<td><?=$data->pur_all_unit_price; ?></td>
								</tr>
								<?php $price=$price+$data->pur_all_unit_price;?>
							<?php } ?>
								
							</tbody>
						</table>
					</div>
				</div>
			</div>
			<div class="row "> 
				<div class="col-xl-3 col-12 offset-xl-9">
					<h6 class="text-right"><strong>Sub-total: ₹ <?=$price;?></strong> </h6>
					<h6 class="text-right">Delivery Charges: + ₹ 00.00</h6>
					
					<h6 class="text-right">Offer Discount: - ₹ 0.00 </h6>
					<hr>										<h4 class="text-right">Grand Total: <strong> ₹<?=$price;?></strong></h4>
				</div>
			</div>
			<div class=" mb-0">
				<div class="pull-right">
					<a href="#" class="btn btn-primary  m-b-5 m-t-5" onclick="window.print()"><i class="fa fa-print"></i> Print </a>
					<!--a href="#" class="btn btn-success  m-b-5 m-t-5"><i class="fa fa-paper-plane"></i> Send </a>
					<a href="#" class="btn btn-danger m-t-5 m-b-5"><i class="fa fa-credit-card"></i>  Pay</a-->
				</div>
				<div class="clearfix"></div>
			</div>
		</div>
	</div>
</div>