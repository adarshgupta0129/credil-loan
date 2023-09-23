
<link rel="stylesheet" type="text/css" href="<?=base_url()?>application/libraries/assets/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css" />

<script type="text/javascript" src="<?=base_url()?>application/libraries/assets/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js"></script>

<script src="<?=base_url()?>application/libraries/assets/plugins/select2/select2.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>application/libraries/assets/plugins/select2/select2.css" />

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
			<h4 class="m-t-0 header-title">
				<b>
					<?php echo $form; ?>
				</b>
			</h4>
			<p class="text-muted font-13 m-b-30"/>
			
			<div class="form">
				<?= form_open('member/viewOrders',array("class" => "cmxform horizontal-form", "id" => "signupForm")); ?>
				
				<div class="row">					
					<div class="col-md-4">
						<div class="form-group">
							<label class="control-label">Invoice No.<span class="required"> * </span>
							</label>
							<input type="text" id="txt_invoice" name="txt_invoice"  class="form-control input-inline input-medium" placeholder="Enter Invoice No.">
						</div>
					</div>					
				</div>				
				<div class="row">
					<div class="form-group">
						<div class="col-md-offset-1 col-md-8">
							<button class="btn btn-info" type="submit">Submit</button>
							<button type="button" class="btn btn-danger">Cancel</button>
						</div>
					</div>
				</div>
				<?php echo form_close(); ?>
			</div>
		</div>
	</div>
	
	<div class="col-lg-12">
		<div class="card-box table-responsive">
			<h4 class="m-t-0 header-title">
				<b>
					<?php echo $table; ?>
				</b>
			</h4>
			<div class="form">				
				<fieldset>					
					<div>						
						<input type="hidden" name="total_item" id="total_item" value="1" />
						<div class="form-group row">
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th>S.No</th>
										<th>Order Time</th>
										<th>Invoice No.</th>
										<th>Status</th>
										<th>User Name</th>
										<th>Amount</th>
										<th>Deli. Chrg.</th>
										<th>Dis.</th>
										<th>Payable Amt</th>
										<th>Order Mode</th>										
										<th>View</th>
										<th>Invoice</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									<?php $sn=1; foreach ($purchase as $data){ ?>
										<tr>
											<td><?=$sn++;?></td>
											<td><?=date("d/m/Y H:i",strtotime($data->order_date));?></td>
											<td><?=$data->order_trans_id;?></td>
											<td><span class="<?php if($data->order_status == "Pending") echo "bg-warning"; else if($data->order_status == "Cancel") echo "bg-danger"; else echo  "bg-success"; ?> border p-l-r-10 "><?=$data->order_status;?></span></td>
											<td><?=$data->NAME;?></td>
											<td><?=$data->order_amt?></td>
											<td><?=$data->order_delivery_charges?></td>
											<td><?=$data->order_discount_amt?></td>
											<td><?=$data->order_payble_amt?></td>
											<td><?=$data->order_pay_mode;?></td>
											
											<td><a target="_blank" href="<?=base_url()?>Member/prodcut_summery/<?=$data->order_trans_id?>"><i class="fa fa-info-circle"></i></a></td>
											<td><a target="_blank" href="<?=base_url()?>Member/view_order_details/<?=$data->order_trans_id?>"><i class="fa fa-file"></i></a></td>
											<td>
												<?php if($data->order_status == "Pending"): ?>
													<select class="main_order_status" data-invoice="<?=$data->order_trans_id;?>">
														<option value="Delivered">-- Choose Action -- </option>
														<option value="Delivered">Mark Delivered</option>
														<option value="AllDelivered">All Product Delivered</option>
														<option value="AllCancel">All Cancel</option>
													</select>
												<?php endif ?>
												
											</td>
										</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>		
					</div>		
				</fieldset>				
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

<script>
	$(document).ready(function(){
		$(".main_order_status").change(function(){
			var select=$(this);
			bootbox.confirm("Are you sure?", function(result){
				if(result){
					$.ajax({
						type:"POST",
						url:"<?=base_url("Member/update_main_order_status")?>",
						data:{invoice:select.data("invoice"),status:select.val()},
						success:function(res){
							location.reload();
						}
					})
				}
			});
		});
	});
</script>

