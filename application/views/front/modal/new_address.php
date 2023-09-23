<div class="modal fade" id="newAddress" tabindex="-1" role="dialog" aria-labelledby="newAddressLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Add New Address</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<i class="las la-times"></i>
				</button>
			</div>
			<div class="modal-body">
				<form action="<?= base_url()?>Welcome/insert_address" class="needs-validation form_submit" novalidate>
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="firstName">Name <span style="color:red">*</span></label>
							<input type="text" class="form-control" name="user_addr_name" id="firstName" placeholder="Name" value="<?=session('name')?>" required>
							<span class="erruser_addr_name"></span>
						</div>
						<div class="col-md-6 mb-3">
							<label for="lastName">Mobile No <span style="color:red">*</span></label>
							<input type="text" class="form-control" name="user_addr_mobile" id="user_addr_mobile" placeholder="Mobile No" value="<?=session('mobile_no')?>" required>
							<span class="erruser_addr_mobile"></span>
						</div>
						
						<div class="col-md-12 mb-3">
							
							<label for="lastName">Address <span style="color:red">*</span></label>
							<input type="text" class="form-control" name="user_addr_address" id="user_addr_address" placeholder="Address (House No, Building, Street, Area)" value="" required>
							<span class="erruser_addr_address"></span>
						</div>
						
						<!--div class="col-md-6 mb-3">
							<label for="state">State</label>
							
							<select onchange="stat()" class="custom-select d-block w-100" name="user_addr_state" id="state" required>
								<option value="">Choose...</option>
								<?php  foreach ($loc as $data ) {?>
									<option value="<?=$data->loc_id?>"><?=$data->loc_name?></option>
								<?php } ?>
							</select>
							<span class="erruser_addr_state"></span>
							
						</div>
						<div class="col-md-6 mb-3">
							<label for="state">City <span style="color:red">*</span></label>
							<select class="custom-select d-block w-100" name="user_addr_city" id="city" required>
								<option value="">Choose...</option>
								
							</select>
							<span class="erruser_addr_city"></span>
						</div-->
						
						<div class="col-md-6 mb-3">
							<label for="firstName">Landmark 1 </label>
							<input type="text" class="form-control" name="user_Landmark1" id="user_Landmark1" placeholder="Landmark 1 " value="" required>
							<span class="erruser_Landmark1"></span>
						</div>
						<div class="col-md-6 mb-3">
							<label for="lastName">Landmark 2 </label>
							<input type="text" class="form-control" name="user_Landmark2" id="user_Landmark2" placeholder="Landmark 2 " value="" required>
							<span class="erruser_Landmark2"></span>
						</div>
						<div class="col-md-6">
							<label for="zip">Zip <span style="color:red">*</span></label>
							<input type="number" name="user_addr_pincode" class="form-control" id="zip" placeholder="Enter Pincode" value="<?=get('pincode')?>" required>
							<span class="erruser_addr_pincode"></span>
						</div> 
						<div class="col-md-6">
							<label for="zip">&nbsp;</label>
							<button type="submit" class="btn btn-primary btn-block">Save Address</button> 
						</div> 
					</div> 
				</form>	 
			</div>
		</div>
	</div>
</div>