
	<!-- Start content -->
	
		

			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 id="das"  class="page-title">
						<?php echo $page; ?>
					</h4>
					<ol class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li class="active">
							<?php echo $form_name; ?>
						</li>
					</ol>
				</div>
			</div>
			<!-- Page-Title -->
			<div class="row">
				<div class="col-lg-4">
					<div class="card-box">
						<h3 class="form-section"><?php echo $form_name; ?></h3>
						<p class="text-muted font-13 m-b-30"/>
									<form class="form form-horizontal" action="<?= base_url() ?>subadmin/insert_assign_menu" method="post" id="menuform">
										<div class="form-body">
											
											<div class="form-group row">
												<label class="col-md-3 label-control">Sub Admin</label>
												<div class="col-md-9">
													<select id="txtsname" name="txtsname" class="form-control opt">
														<option value="-1">Select Sub Admin</option>
														<?php
															foreach($sadmin->result() as $pic)
															{
															?>
															<option value="<?= $pic->sub_admin_id; ?>"><?= $pic->sub_admin_name; ?></option>
															<?php
															}
														?> 
													</select>
													<span id="divtxtsname" style="color:red"></span>
													<input type="hidden" id="txtquid" name="txtquid" />
												</div>
											</div>
											
										</div>
										
										<div class="form-actions text-right">
											<button type="button" onclick="conwv('menuform')" class="btn btn-success btn-sm mr-1"><i class="la la-check-square-o"></i> Save</button>
											<button type="reset" class="btn btn-danger btn-sm"><i class="ft-x"></i> Cancel</button>
										</div>
									</form>
									
								</div>
							</div> 
						<div class="col-sm-8">
								<div class="card-box table-responsive">
									<h4 class="m-t-0 header-title">
										<b>
											<?php echo $table_name; ?>
										</b>
 									</h4>

									<table id="datatable" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th>S.No</th>
													<th><input type="checkbox" id="checkAll" name="checkAll" value="" onClick="chbcheckall()"></th>
													<th>Main Menu</th>
													<th>Sub Menu</th>
												</tr>
											</thead>
											<tbody id="userid">
												<?php
													$sn = 0;
													if(!empty($menu)) 
													{													
														foreach($menu->result() as $row)
														{
														?>
														<tr>
															<td><?= ++$sn; ?></td>
															<td><input type="checkbox" id="<?= $row->menu_id; ?>" name="<?= $row->menu_id; ?>" value="<?= $row->menu_id; ?>" onClick="chbchecksin()"></td>
															<td><?= $row->mainmenu; ?></td>
															<td><?= $row->submenu; ?></td>
														</tr>
														<?php
														}
													}
												?>
											</tbody>
									</table>
								</div>
							</div>	
					 