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
	
	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<h4 class="m-t-0 header-title"><b><?php echo $table; ?></b></h4>
			<table id="datatable" class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>S.No</th>
						<th>Code</th>
						<th>Min Amount</th>
						<th>Discount Amount</th>
						<th>Frequency</th>
						<th>Valid Date</th>
						<th>Users</th>
						<th>Products</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
						$sn=1;
						foreach($coupons as $coup) {
							if($coup->coupon_status == 'Active') {
								$status = "success"; $stat = 2;
								} else {
								$status = "danger"; $stat = 1;
							}
						?>												
						<tr class="<?=$status?>">
							<td><?=$sn++; ?></td>
							<td><?=$coup->coupon_code?></td>
							<td><?=$coup->coupon_min_amount?></td>
							<td><?=$coup->coupon_amount?></td>
							<td><?=$coup->coupon_apply_time?></td>
							<td><?=$coup->coupon_valid_date?></td>
							<td><?=$coup->USERS?></td>
							<td><?=$coup->PRODUCTS?></td>
							<td>
								<a href="javascript:void(0);" class="btn btn-default"  onclick="change_status('<?=$coup->coupon_id?>','<?=$stat?>', '11')"><span class='fa fa-refresh' title="Change Status"></span></a>									
								<a href="javascript:void(0);" class="btn btn-danger"  onclick="change_status('<?=$coup->coupon_id?>','3', '12')" title="Delete coupon permanently">delete</a>									
 							</td>
						</tr>
					<?php } ?>            
				</tbody>
			</table>
		</div>
	</div>
</div>