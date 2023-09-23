
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
											<div class="col-sm-12">
								<div class="card-box table-responsive">
									<h4 class="m-t-0 header-title">
										<b>
											<?php echo $table_name; ?>
										</b>
										<button onclick="exportTableToExcel('datatable', '<?=$table_name; ?>')" class="btn btn-success btn-xs pull-right">Export Data</button>
									</h4>
									<table id="datatable" class="table table-striped table-bordered">
											<thead>
												<tr>
													<th>S No.</th>
													<th>Login Id</th>
													<th>Sub Admin Name</th>
													<th>Main menu</th>
													<th>Sub Menu</th> 
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<?php 
													$sn=1;
													if(!empty($menu))
													{
													foreach($menu->result() as $m)
													{
													?>
													<tr>
														<td><?= $sn++; ?></td>
														<td><?=	$m->login_id; ?></td>
														<td><?=	$m->sub_admin_name; ?></td>
														<td><?=	$m->mainmenu; ?></td>
														<td><?=	$m->submenu; ?></td>
														<td><a href="<?=base_url()?>subadmin/delete_assign_menu/<?= $m->assin_id; ?>" title="Delete"><i class="fa fa-trash text-danger"></i></a></td>
													</tr>
												<?php 
													}
													}
													?>
											</tbody>
									</table>
								</div>
							</div>	
						</div>
				