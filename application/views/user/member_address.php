<div class="row">
	<div class="col-md-12">
		<h4 id="das" class="page-title"><?php echo $page; ?></h4>
		<ol class="breadcrumb">
			<li><a href="">User</a></li>
			<li class="active"><?php echo $form; ?></li>
		</ol>
	</div>
	
</div>
<!-- Member Address -->
<div class="row">
	
	<div class="col-lg-12">
		<div class="card-box">
			<h4 class="m-t-0 header-title"><b>Member Address</b></h4>
			<p class="text-muted font-13 m-b-10"></p>
			
			<table class="table">
			  <thead class="thead-dark">
				<tr>
				  <th scope="col">S.No.</th>
				  <th scope="col">Name</th>
				  <th scope="col">Mobile</th>
				  <th scope="col">City</th>
				  <th scope="col">State</th>
				  <th scope="col">Pincode</th>
				  <th scope="col">Address</th>
				  <th scope="col">Landmark 1</th>
				    <th scope="col">Landmark  2</th>
				  <th scope="col">Actions</th>
				</tr>
			  </thead>
			  <tbody>
				<?php $a=1; foreach($result as $res){?>
				<tr>
					<td><?= $a;?></td>
					<td><?= $res->user_addr_name;?></td>
					<td><?= $res->user_addr_mobile;?></td>
					<!--<td><?= $res->user_addr_email;?></td>-->
					<td><?= $res->State;?></td>
					<td><?= $res->City;?></td>
					<td><?= $res->user_addr_pincode;?></td>
					<td><?= $res->user_addr_address;?></td>
					<td><?= $res->user_addr_landmark1;?></td>
					<td><?= $res->user_addr_landmark2;?></td>
					<td><a href="JavaScript:Void(0);" class="btn-sm btn-success" data-toggle="modal" onclick="get_data1('<?= $res->user_addr_id;?>')" data-target="#Editaddress">Edit</a>&nbsp;<a    class="btn-sm btn-danger" href="<?=base_url();?>Userprofile/delete_address/<?=$res->user_addr_id;?>" >Delete</a></td>
				</tr>
				<?php $a++ ;}?>
			  </tbody>
			</table>
			
		</div>
	</div>
</div>

<!-- Modal -->
	<div class="modal fade" id="Editaddress" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Edit Address</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="las la-times"></i>
					</button>
				</div>
				<div class="modal-body">
					<form action="<?= base_url()?>Userprofile/update_address" class="needs-validation form_submit" novalidate>
						<div class="row">
							<div class="col-md-12 mb-3">
								<label for="firstName">Name*</label>
								<input type="text" class="form-control" name="user_addr_name" id="name" placeholder="Name" value="" required>
								<span class="erruser_addr_name"></span>
							</div>
							<div class="col-md-6 mb-3">
								<label for="lastName">Mobile No*</label>
								<input type="text" class="form-control" name="user_addr_mobile" id="mobile" placeholder="Mobile No" value="" required>
								<span class="erruser_addr_mobile"></span>
							</div>
							<input type ="hidden" id ="userid" name="userid">
							<!--<div class="col-md-6 mb-3">
								<label for="email">Email* </label>
								<input type="email" class="form-control" name="user_addr_email" id="email" placeholder="you@example.com">
								<span class="erruser_addr_email"></span>
							</div>-->
							
							
							<div class="col-md-6 mb-3">
								<label for="lastName">Address*</label>
								<input type="text" class="form-control" name="user_addr_address" id="address" placeholder="Address (House No, Building, Street, Area)*" value="" required>
								<span class="erruser_addr_address"></span>
							</div>
							<div class="col-md-6 mb-3">
								<label for="state">State</label>
								
								<select onchange="stat()" class="form-control" name="user_addr_state" id="state" required>
								<option value="">Choose...</option>
								<?php  foreach ($loc as $data ) {?>
								<option value="<?=$data->loc_id?>"><?=$data->loc_name?></option>
								<?php } ?>
							</select>
								<span class="erruser_addr_state"></span>

							</div>
							<div class="col-md-6 mb-3">
								<label for="state">City</label>
								<select class="form-control" name="user_addr_city" id="city" required>
									<option value="">Choose...</option>
								</select>
								<span class="erruser_addr_city"></span>
							</div>
							<div class="col-md-6 mb-3">
							<label for="firstName">Landmark 1 *</label>
							<input type="text" class="form-control" name="user_Landmark1" id="Landmark1" placeholder="Landmark 2 " value="" required>
							<span class="erruser_Landmark1"></span>
						</div>
						<div class="col-md-6 mb-3">
							<label for="lastName">Landmark 2 *</label>
							<input type="text" class="form-control" name="user_Landmark2" id="Landmark2" placeholder="Landmark 2 " value="" required>
							<span class="erruser_Landmark2"></span>
						</div>
							<input type="hidden"id="jay">
							<div class="col-md-6">
								<label for="zip">Zip</label>
								<input type="text" name="user_addr_pincode" class="form-control" id="zip" placeholder="Enter pincode" required>
								<input type="hidden" name="user_addr_id" class="form-control" id="member_id" required>
								<span class="erruser_addr_pincode"></span>
							</div>
							<div class="col-md-6">
								<label for="zip">&nbsp;</label>
								<button type="submit" class="btn btn-primary btn-block">Update Address</button>
								
							</div>
							
							
						</div>
						
					</form>	

					</div>
					
				</div>
			</div>
		</div>
		<script>
		function get_data1(id){
			$.ajax({
	url: "<?php echo base_url(); ?>Userprofile/edit_address",
	type: "post",
	dataType: "json",
	data: {
	id: id,
	},
		success: function(data) {
				if (data.response === 'success') {
				$("#name").val(data.post.user_addr_name);
				$("#mobile").val(data.post.user_addr_mobile);
				$("#address").val(data.post.user_addr_address);
				//
				//dataClsField.find('option[value="'+ myValue +'"]').prop('selected', 'selected');
			     var st=(data.post.user_addr_state_id);
				 var ct=(data.post.user_addr_city_id);
				  var ct1=(data.post.City);
				$("#state option[value='"+st+"']").attr('selected', 'selected');  
			    $('#city').html('<option value="' + ct + '">' + ct1 + '</option>');
				$("#zip").val(data.post.user_addr_pincode);
		    	$("#Landmark1").val(data.post.user_addr_landmark1);
				$("#Landmark2").val(data.post.user_addr_landmark2);
				$("#userid").val(data.post.user_addr_id);
				} else {
			alert('error');
				}
				}
	
	});	
			}
			function stat(){
			var stateid = $('#state').val();
			
			if(stateid != '')
			{
			$.ajax({
				url:"<?php echo base_url(); ?>welcome/fetch_city",
				method:"POST",
				data:{stateid:stateid},
				success:function(data)
				{
					$('#city').html(data);
				}
			});
		}
		else
		{
			$('#city').html('<option value="">Select City</option>');
		}
	}
		</script>
		
	