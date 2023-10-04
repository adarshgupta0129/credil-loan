<div class="row">
	<div class="col-sm-12">
		<ol class="breadcrumb">
			<li>
				<a href="#">Dashboard</a></li>
			<li class="active"><?php echo $form_name; ?></li>
		</ol>
	</div>
</div>
<!-- Page-Title -->
<div class="row">

	<div class="col-lg-12">
		<div class="card-box">
			<h4 class="m-t-0 header-title"><b>View KYC Status</b></h4>
			<p class="text-muted font-13 m-b-30"></p>
			<div class="form">
			<?= form_open(fetch_class().'/'.fetch_method().'/'.uri(3).'/'.uri(4), array("class" => "cmxform horizontal-form", "id" => "signupForm")); ?>
					<div class="row">
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">KYC Status</label>
								<select class="bs-select form-control" name="txtstatus" id="txtstatus">
									<option selected disabled>Select</option>
									<option value="0">Pending</option>
									<option value="1">Approve</option>
								</select>
							</div>
						</div>

						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">User ID <span class="required"> * </span></label>
								<input type="text" id="login_id" name="txtlogin" class="form-control empty" placeholder="Enter Login ID.">
								<span id="divlogin_id" style="color:red;"></span>
							</div>
						</div>
						<div class="col-md-4">
							<div class="form-group">
								<label class="control-label">From Joining Date<span class="required"> * </span></label>
								<div class="input-daterange input-group" id="date-range" data-date-format="yyyy-mm-dd">
									<input type="text" class="form-control" name="start" autocomplete="off" />
									<span class="input-group-addon bg-custom b-0 text-white">to</span>
									<input type="text" class="form-control" name="end" autocomplete="off" />
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="form-group text-center">
							<input type="hidden" id="txtquid" name="txtquid" />
							<button class="btn btn-info btn-sm" type="submit">Submit</button>
							<br><br>
							<!--button type="submit" class="btn btn-success btn-sm" formaction="<?= base_url().fetch_class() ?>/approve_all_kyc">Approve Here</button>
										<button type="submit" class="btn btn-danger btn-sm" formaction="<?= base_url().fetch_class() ?>/reject_all_kyc">Reject Here</button-->
						</div>
					</div>
					<?php echo form_close(); ?>
			</div>
		</div>
	</div>

	<div class="col-lg-12">
		<div class="card-box table-responsive">
			<h4 class="m-t-0 header-title"><b>All KYC</b></h4>
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<!--th><input type="checkbox" id="checkAll" name="checkAll" onclick="chbcheckall()" /></th-->
						<th>S.No.</th>
						<th>User ID</th>
						<th>User Name</th>
						<!--th>Bank</th>
									<th>Date</th>
									<th>Branch</th>
									<th>A/c No.</th>
									<th>IFSC</th>
									<th>Aadhar</th>
									<th>PAN card</th-->
						<th>Pancard</th>
						<th>Aadhar Front Page</th>
						<th>Aadhar Second Page</th>
						<th>Bank/Cheque</th>
						<th>Note</th>
						<th>Status</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody id="userid">
					<?php
					$sn = 1;
					foreach ($rid->result() as $value) {
						/* if(($value->m_bank_name && $value->or_m_b_branch && $value->or_m_b_cbsacno && $value->or_m_b_ifscode && $value->or_m_b_adhar) || $value->admin_status == 1)
										{ */
					?>
						<tr>
							<!--td><input type="checkbox" id="<?php echo $value->user_reg_id; ?>" onClick="chbchecksin()"/></td-->
							<td><?php echo $sn; ?></td>
							<td><?php echo $value->user_u_id; ?></td>
							<td><?php echo  $value->user_name ?></td>
							<!--td><?php echo  date('Y-m-d', strtotime($value->user_joining_date)) ?></td>
										<td><?php echo  $value->m_bank_name ?></td>
										<td><?php echo  $value->or_m_b_branch ?></td>
										<td><?php echo  $value->or_m_b_cbsacno ?></td>
										<td><?php echo  $value->or_m_b_ifscode ?></td>
										<td><?php echo  $value->or_m_b_adhar ?></td>
										<td><?php echo  $value->or_m_b_pancard ?></td-->

							<td>
								<?php if ($value->kyc_pan != '') { ?>
									<a href="<?php echo base_url() ?>application/kyc/<?php echo $value->kyc_pan; ?>" target="_blank">view</a>
								<?php } else {
									echo "n/a";
								} ?>
							</td>

							<td>
								<?php if ($value->kyc_aadhar_f != '') { ?>
									<a href="<?php echo base_url() ?>application/kyc/<?php echo $value->kyc_aadhar_f; ?>" target="_blank">view</a>
								<?php } else {
									echo "n/a";
								} ?>
							</td>
							<td>
								<?php if ($value->kyc_aadhar_b != '') { ?>
									<a href="<?php echo base_url() ?>application/kyc/<?php echo $value->kyc_aadhar_b; ?>" target="_blank">view</a>
								<?php } else {
									echo "n/a";
								} ?>
							</td>
							<td>
								<?php if ($value->kyc_cheque != '') { ?>
									<a href="<?php echo base_url() ?>application/kyc/<?php echo $value->kyc_cheque; ?>" target="_blank">view</a>
								<?php } else {
									echo "n/a";
								} ?>
							</td>
							<td><input type="text" value="<?= $value->kyc_note ?>" onblur="update_value('<?= $value->kyc_id ?>', this.value, 'kycAdminNote')" /></td>
							<td>
								<?php
								if (($value->kyc_admin_status) == 1) {
									echo 'Approved';
								} else {
									echo 'Pending';
								}
								?>
							</td>
							<td>
								<?php
								if (($value->kyc_admin_status) == 0) {
								?>
									<a href="javascript:void(0)" onclick="link_submit('<?= base_url().fetch_class() ?>/approve_kyc/<?php echo $value->user_reg_id; ?>/1')" class="btn-xs btn-success">
										Approved
									</a>
								<?php } ?>
								<a href="<?php echo base_url().fetch_class() ?>/delete_kyc/<?php echo $value->user_reg_id; ?>" class="btn-xs btn-danger">
									Reject
								</a>
							</td>
						</tr>
					<?php
						$sn++;
					}
					/* } */
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
</div>
</div>
</div>
</div>