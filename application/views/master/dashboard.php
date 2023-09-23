
			<?php if(session('usertype') == "1") { ?>
            <div class="row">
                <div class="col-sm-12">
                    <h4 style="float:left;" class="page-title">Admin Dashboard</h4></br></br>
				</div>
			</div>
			<?php } else { ?>	
			 <div class="row">
                <div class="col-sm-12">
                    <h4 style="float:left;" class="page-title">Welcome to SubAdmin Dashboard, <?=session('name')?></h4></br></br>
 				</div>
			</div>
			<?php } ?>
		