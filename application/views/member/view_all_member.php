<div class="row">
	<div class="col-sm-12">
		<h4 id="das" class="page-title">
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
	<div class="col-lg-12">
		<div class="card-box">
			<h4 class="m-t-0 header-title">
				<b>
					Search <?php echo uri(4); ?>
				</b>
			</h4>
			<p class="text-muted font-13 m-b-30">

			<div class="form">
				<?php $this->load->view('report/common_search') ?>
			</div>
		</div>
	</div>

	<div class="col-sm-12">
		<div class="card-box table-responsive">
			<h4 class="m-t-0 header-title">
				<b>
				View All <?php echo uri(4); ?>
				</b>
				<button onclick="exportTableToExcel('datatable', '<?= $table_name; ?>')" class="btn btn-success btn-xs pull-right">Export Data</button>
			</h4>
				<?php $this->load->view('report/common_view_all_member') ?>
		</div>
	</div>
</div>