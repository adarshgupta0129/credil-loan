
			<!-- Page-Title -->
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
				<div class="col-lg-4">
					<div class="card-box"> 	
							<div class="form">
								<?= form_open(fetch_class().'/add_admin_bank',array("class" => "", "id" => "signupForm")); ?>
													 
								<div class="form-group">
                                    <label class="control-label">Bank</label>								
                                    <select class="form-control opt select2" name="ddbank" id="ddbank">
                                        <?php
                                            foreach($banks as $bk)
                                            {
                                            ?>
                                            <option value="<?= $bk->bank_id; ?>"><?= $bk->bank_name; ?></option>
                                            <?php
                                            }
                                        ?>
                                    </select>
                                    <span id="divddbank" style="color:red"></span>
				                </div>
                                				 
								<div class="form-group">
									<label class="control-label">Account No.<span class="required">*</span></label> 
									<input type="number" id="txtac" name="txtac" class="form-control empty" placeholder="Enter Account No.">
									<span id="divtxtac" style="color:red"></span>
								</div>
                                				 
								<div class="form-group">
									<label class="control-label">IFSC<span class="required">*</span></label> 
									<input type="text" id="txtifsc" name="txtifsc" class="form-control empty" placeholder="Enter IFSC">
									<span id="divtxtifsc" style="color:red"></span>
								</div>
                                				 
								<div class="form-group">
									<label class="control-label">Branch<span class="required">*</span></label> 
									<input type="text" id="txtbranch" name="txtbranch" class="form-control empty" placeholder="Enter Branch">
									<span id="divtxtbranch" style="color:red"></span>
								</div>
                                				 
								<div class="form-group">
									<label class="control-label">Address</label> 
									<input type="text" id="txtaddress" name="txtaddress" class="form-control" placeholder="Enter Address">
									<span id="divtxtaddress" style="color:red"></span>
								</div>
							</div>
							
							<div class="form-group">								
								<button class="btn btn-info" type="button" onclick="check_submit('signupForm')">Submit</button>								
							</div>
							<?php echo form_close(); ?>
						</div>
					</div>
	
				
				<div class="col-sm-8">
					<div class="card-box table-responsive">
						<h4 class="m-t-0 header-title"><b><?php echo $table; ?></b></h4>
						<table id="datatable-buttons" class="table table-striped table-bordered">
							<thead>
								<tr>
									<th>S.No</th>
 									<th>Name</th>
 									<th>Account No.</th>
 									<th>IFSC</th>
 									<th>Branch</th>
 									<th>Address</th>                                    
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php 
									$sn=1;
									foreach($adminBank as $unit) {
									if($unit->ad_bank_status==1) {
										$status = "success"; $stat = 0;
									} else {
										$status = "danger"; $stat = 1;
									}
								?>												
									<tr class="<?=$status?>">
										<td><?=$sn++; ?></td>
                                        <td>
                                            <select class="form-control opt slog_group" onchange="update_value('<?= $unit->ad_bank_id; ?>', this.value, 'adminBankName')" >
                                                <?php foreach($banks as $v){ ?>
                                                <option value="<?=$v->bank_id?>" <?= $unit->ad_bank_bank_id == $v->bank_id ? "selected" : ""?>><?=$v->bank_name?></option>
                                                <?php } ?>
                                            </select>
                                        </td>
  										<td><input type="text" class="form-control" value="<?= $unit->ad_bank_ac; ?>" onblur="update_value('<?= $unit->ad_bank_id; ?>', this.value, 'adminBankAc')" /> </td>
  										<td><input type="text" class="form-control" value="<?= $unit->ad_bank_ifsc; ?>" onblur="update_value('<?= $unit->ad_bank_id; ?>', this.value, 'adminBankIfsc')" /> </td>
  										<td><input type="text" class="form-control" value="<?= $unit->ad_bank_branch; ?>" onblur="update_value('<?= $unit->ad_bank_id; ?>', this.value, 'adminBankBranch')" /> </td>
  										<td><input type="text" class="form-control" value="<?= $unit->ad_bank_address; ?>" onblur="update_value('<?= $unit->ad_bank_id; ?>', this.value, 'adminBankAddress')" /> </td>
										<td>
											<a href="javascript:void(0);"  class="btn btn-default" onclick="change_status('<?=$unit->ad_bank_id?>','<?=$stat?>', 'adminBank')"><span class='fa fa-refresh' title="Change Status"></span></a>									
										</td>
									</tr>
								<?php } ?>            
							</tbody>
						</table>
					</div>
				</div>
			</div> 