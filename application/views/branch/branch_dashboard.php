
<?php if(session('usertype') == "2") { ?>
            <div class="row">
                <div class="col-sm-12">
                    <h4 style="float:left;" class="page-title">Branch Dashboard</h4></br></br>
				</div>
			</div>
			<?php } else { ?>	
			 <div class="row">
                <div class="col-sm-12">
                    <h4 style="float:left;" class="page-title">Welcome to SubAdmin Dashboard, <?=session('name')?></h4></br></br>
 				</div>
			</div>
			<?php } ?>
		