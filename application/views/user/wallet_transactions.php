
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
<div class="row"><div class="col-sm-12">

    <div class="form">
		
		<fieldset>
			<legend><span>Purchase</span></legend>	
			<div>
				
				<input type="hidden" name="total_item" id="total_item" value="1" />
				<div class="form-group row">
					<table class="table table-striped table-bordered">
						<thead>
									<tr>
										<th align="left">S.No</th>
										<th align="left">Date</th>
										<th align="left">Description</th>
										<th align="left">Cr.</th>
										<th align="left">Dr.</th>
									</tr>
								</thead>
								<tbody>
									<?php $sn=1; foreach ($data as $v){ ?>
										<tr>
											<td><?=$sn++;?></td>
											<td><?=date("d/m/Y H:i",strtotime($v->m_datetime));?></td>
											<td><?=$v->m_description;?></td>
											<td><?=$v->m_cramount;?></td>
											<td><?=$v->m_dramount?></td>
										</tr>
									<?php } ?>
								</tbody>
						</table>
					</div>		
				</div>		
			</fieldset>
			
			
		</div>	
		
	</div></div>
	
	
			