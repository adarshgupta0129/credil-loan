
	<!-- Start content -->
	
		

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 id="das"  class="page-title">
						<?php echo $page; ?>
					</h4>
					<ol class="breadcrumb">
						<li>
							<a href="<?php echo base_url(); ?>master/index">Dashboard</a>
						</li>
						<li class="active">
							<?php echo $form_name; ?>
						</li>
					</ol>
				</div>
			</div>
			<!-- Page-Title -->
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<h4 class="m-t-0 header-title">
							<b>
								<?php echo $form_name; ?>
							</b>
						</h4>
						<p class="text-muted font-13 m-b-30"/>

						<div class="form">
							<?= form_open('member/view_all_member',array("class" => "cmxform horizontal-form", "id" => "signupForm")); ?>

							<div class="row">

								<div class="col-md-4">
									<div class="form-group">
										<label class="control-label">Login Id<span class="required"> * </span>
										</label>
										<input type="text" id="txtlogin" name="txtlogin"  class="form-control input-inline input-medium" placeholder="Enter login id.">
										</div>
									</div>

									<div class="col-md-4">
										<div class="form-group">
											<label class="control-label">Mobile No</label>
											<input type="text" id="txtmob" name="txtmob"  class="form-control input-inline input-medium" placeholder="Enter Mobile No.">
											</div>
										</div>

										<div class="col-md-4">
											<div class="form-group">
												<label class="control-label">Name</label>
												<input type="text" id="txtname" name="txtname" class="form-control input-inline input-medium" placeholder="Enter Name."> 
												</div>
											</div>

										</div>

										<div class="row">

											<div class="col-md-4">
												<div class="form-group">
													<label class="control-label">From Joining Date<span class="required"> * </span>
													</label>
													<div class="input-daterange input-group" id="date-range" data-date-format="yyyy-mm-dd">
														<input type="text" class="form-control" name="start" autocomplete="off" />
														<span class="input-group-addon bg-custom b-0 text-white">to</span>
														<input type="text" class="form-control" name="end" autocomplete="off" />
													</div>
												</div>
											</div>

											<div class="col-md-4">

												<div class="form-group">
													<label class="control-label">Type</label>
													<select id="ddtype" name="ddtype" class="form-control">
														<option selected="selected" value="-1">Select Type</option>
														<?php 
													foreach($rank->result() as $p)
													{
													?>
														<option value="<?php echo $p->m_des_id; ?>">
															<?php echo $p->m_des_name; ?></option>
														<?php
													}
												?>
													</select>
													<span id="divddtype" style="color:red"/>
												</div>
											</div>

										</div>
										<div class="row">
											<div class="form-group">
												<div class="col-md-offset-4 col-md-8">
													<button class="btn btn-info" type="submit">Submit</button>
													<button type="button" class="btn btn-danger">Cancel</button>
												</div>
											</div>
										</div>
										<?php echo form_close(); ?>
									</div>
								</div>
							</div>

							<div class="col-sm-12">
								<div class="card-box table-responsive">
									<h4 class="m-t-0 header-title">
										<b>
											<?php echo $table_name; ?>
										</b>
<!--button onclick="exportTableToExcel('datatable', '<?=$table_name; ?>')" class="btn btn-success btn-xs pull-right">Export Data</button-->
									</h4>

									<table id="datatable" class="table table-striped table-bordered">
										<thead>
											<tr>
												<th>S No.</th>
												<th nowrap>Action</th>
												<th>LoginId</th>
												<th>Name</th>
												<th>Type</th>
												<th>Date</th>
												<th>City</th>
												<th>Mobile No</th>
												<th>Topup Date</th>
 											</tr>
										</thead>
										<tbody id="userid">
											<?php
									$sn=1;
									foreach($rid->result() as $rows)
									{?>								
											<tr>									
												<td>
													<?php echo $sn;?>
												</td>
												<td nowrap>
												<a href="<?=base_url()?>member/view_member_edit/<?= $rows->regid; ?>" title="Edit Profile"><i class="fa fa-pencil text-primary"></i></a> | 
												<a href="<?= base_url(); ?>member/resend_msg/<?= $rows->regid; ?>" title="Send Sms"><i class="md md-email text-primary"></i></a>
 
												</td>
												<td>
													<?php echo $rows->Login_Id;?></td>
												<td>
													<?php echo $rows->Associate_Name;?></td>
												<td>
													<?php echo $rows->DESIGNATION_S;?></td>
												<td>
													<?php echo date('d-m-y h:i:s',strtotime($rows->Joining_Date));?></td>
												<td>
													<?php echo $rows->City;?></td>
												<td>
													<?php echo $rows->Mobile_No;?></td>
												<td>
													<?php echo ($rows->TOPDATE == '')?("Non TopUp"):$rows->TOPDATE;?></td> 
											</tr>   
											<?php $sn++; }?>                   
										</tbody>
									</table>
								</div>
							</div>	
						</div>
