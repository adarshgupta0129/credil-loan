
<div class="row">
	<div class="col-sm-12">
		<h4 id="das"  class="page-title">Customer Details</h4>
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url(); ?>master/index">Dashboard</a></li>
			<li class="active">Customer Details</li>
		</ol>
	</div>
</div>


<div class="row">
	<div class="col-md-12">
		<div class="card-box">
		    <div class=" card-body">
		
				<div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th class="border-0  font-weight-bold" align="left">S.No</th>
                            <th class="border-0  font-weight-bold" align="left">Joining Date</th>
                            <th class="border-0  font-weight-bold" align="left">Name</th>
                            <th class="border-0  font-weight-bold" align="left">Contact</th>
                            <th class="border-0  font-weight-bold" align="left">Introducer</th>
                        </tr>
                        <?php foreach($customer as $k=>$v): ?>
                            <tr>
                                <td><?=$k+1?></td>
                                <td><?=$v->user_joining_date?></td>
                                <td><?=$v->user_name?></td>
                                <td><?=$v->user_mobile_no?><br><?=$v->user_email?></td>
                                <td><?=$v->intro?><br><?=$v->intro_mobile?></td>
                            </tr>
                        <?php endforeach ?>
                    </table>
                </div>
			
			</div>
		</div>
		
	</div>
</div>



	