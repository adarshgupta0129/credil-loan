
	<!-- Start content -->
    
		
			<?php
				$tot_car_fund = 0;
				$tot_sgm = 0;
				$tot_tgi = 0;
				$tot_sgm_pool = 0;
				$tot_sgm_royality = 0;
				$tot_store_referral = 0;
				$tottt = 0 ;
				$tot_team = 0 ;
				$tot_gm_performance_fund=0;
				$tot_travel_fund=0;
				$tot_consumer_bonus_fund=0;
				$tot_self =0;	
			?>
			<!-- Page-Title -->
			<div class="row">
				<div class="col-sm-12">
					<h4 id="das"  class="page-title"><?php echo $form_name; ?></h4>
					<ol class="breadcrumb">
						<li><a href="<?php echo base_url(); ?>master/index">Dashboard</a></li>
						<li class="active"><?php echo $form_name; ?></li>
					</ol>
				</div>
			</div>
			
			<div class="row">
				<div class="col-sm-12">
					<div class="wrapper1">
						<div class="div1"></div>
					</div>
					<div class="card-box table-responsive wrapper2" style="width: 100%; overflow-x: scroll; overflow-y: hidden;">
						<form method="post" action="<?php echo base_url()?>Admin_closing/user_invoice">
							<div class="col-md-8 pull-left" >
								<div class="row">
									<div class="col-md-3">
										<input type="hidden" value="<?php echo $this->uri->segment(3)?>" name="txtuserid">
										From Date - <input type="text" value="<?php echo $start_date ; ?>" name="start_date" class="col-md-3 form-control" readonly><br>
									</div>
									<div class="col-md-3">
										To Date - <input type="text" value="<?php echo $end_date ; ?>" name="end_date"  class="col-md-3 form-control" readonly>
									</div>
									
									<!--div class="col-md-3" style="padding-top: 18px;" id="invoice_date2">
										<select class="form-control opt" name="dd_closing_date">
											<option value="-1">--Select--</option>
											<?php /* foreach($closig_date as $rows) {?>
												<option value="<?php echo $rows->tr_closing_date?>"><?php echo $rows->tr_closing_date?></option>
											<?php } */ ?>
											<option value="2019-07-31"> 2019-07-31 </option>
											<option value="2019-08-31"> 2019-08-31 </option>
										</select>
									</div>
									<div class="col-md-3" style="padding-top: 18px;" id="invoice_date">
										<button type="submit" class="btn btn-primary">Submit</button>
									</div-->
									
									
								</div>
								
							</div>
						</form>
						<div class="col-md-12" align="right" id="print_div">
							<button class=""  style="margin-right:20px; padding: 5px 18px; background-color: #337ab7;color: #fff; border: none;" onclick="print_invoice()">Print</button>	
						</div>
						
						<table id="datatable" class="table table-striped table-bordered">
							<tbody>
								
								<tr>
									<td height="30" colspan="2" align="center"> <strong>USER ID :   </strong><?php echo 
									$rec->or_m_user_id?></td>
									<td height="30" colspan="2" align="center"> <strong>USER NAME :   </strong><?php echo 
									$rec->or_m_name?></td>
									<td height="30" colspan="2" align="center"> <strong>USER RANK :  </strong><?php echo 
									$rec->m_des_name?></td>
								</tr>
								<tr>
									<td height="30" colspan="2" align="center"><strong>BV BASE BUSINESS INCENTIVE </strong></td> 
									<td height="30" rowspan="5" align="center">INCOME</td>
									<td height="30" rowspan="5" align="center">ADMIN <br>CHARGE @ 6%</td>
									<td height="30" rowspan="5" align="center"> TDS @ <br>5% OR 20%</td>
									<td height="30" rowspan="5" align="center"> TOTAL</td>
								</tr>
								<tr>
									<td >SELF BV</td> 
									<td align="center"><?=$rec->SELF_BV?></td>
								</tr>
								<tr>
									<td >LEFT GROUP BV</td> 
									<td align="center"><?=$rec->LEFT_BV?></td>
									
								</tr>
								<tr>
									<td >RIGHT GROUP BV</td> 
									<td align="center"><?=$rec->RIGHT_BV?></td>
								</tr>
								<tr>
									<td >TOTAL BV FOR INCENTIVE</td> 
									<td align="center"><?=$rec->SELF_BV+$rec->LEFT_BV+$rec->RIGHT_BV ?></td>
								</tr>
								<tr> 
									<td height="30" colspan="2" ><strong>SELF BV INCENTIVE (AS PAR RANK %)</strong> </td>
									<?php if(!empty($self))
										{?>
										<td height="30"><?= $tot_self = $self->tr42_income+$self->tr42_admin+$self->tr42_tds  ?></td>
										<td height="30"><?=$self->tr42_admin ?></td>
										<td height="30"><?=$self->tr42_tds ?></td>
										<td height="30"><?=$self->tr42_income ?></td>
										<?php }
										else
										{?>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										
									<?php }?>
									
								</tr>
								<tr>
									<td height="30" colspan="2" ><strong>TEAM SALES INCENTIVE@ (8% TO 41%)</strong> </td>
									<?php if(!empty($team))
										{?>
										<td height="30"><?=$tot_team = $team->tr42_income+$team->tr42_admin+$team->tr42_tds  ?></td>
										<td height="30"><?=$team->tr42_admin ?></td>
										<td height="30"><?=$team->tr42_tds ?></td>
										<td height="30"><?=$team->tr42_income ?></td>
										<?php }
										else
										{?>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										
									<?php }?>	
								</tr>
								<tr>
									<td height="30" colspan="2" ><strong>GM PERFORMANCE FUND INCENTIVE @ 2%</strong> </td>
									<?php if(!empty($gm_performance_fund))
										{?>
										<td height="30"><?=$tot_gm_performance_fund = $gm_performance_fund->tr42_income+$gm_performance_fund->tr42_admin+$gm_performance_fund->tr42_tds  ?></td>
										<td height="30"><?=$gm_performance_fund->tr42_admin ?></td>
										<td height="30"><?=$gm_performance_fund->tr42_tds ?></td>
										<td height="30"><?=$gm_performance_fund->tr42_income ?></td>
										<?php }
										else
										{?>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										
									<?php }?>
									
								</tr>
								<tr>
									<td height="30" colspan="2" ><strong>TRAVEL FUND@2%</strong> </td>
									
									<?php if(!empty($travel_fund))
										{?>
										<td height="30"><?=$tot_travel_fund= $travel_fund->tr42_income+$travel_fund->tr42_admin+$travel_fund->tr42_tds  ?></td>
										<td height="30"><?=$travel_fund->tr42_admin ?></td>
										<td height="30"><?=$travel_fund->tr42_tds ?></td>
										<td height="30"><?=$travel_fund->tr42_income ?></td>
										<?php }
										else
										{?>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										
									<?php }?>
								</tr>
								<tr>
									<td height="30" colspan="2" ><strong>CAR FUND@2%</strong> </td>
									
									<?php if(!empty($car_fund))
										{?>
										<td height="30"><?= $tot_car_fund = $car_fund->tr42_income+$car_fund->tr42_admin+$car_fund->tr42_tds  ?></td>
										<td height="30"><?=$car_fund->tr42_admin ?></td>
										<td height="30"><?=$car_fund->tr42_tds ?></td>
										<td height="30"><?=$car_fund->tr42_income ?></td>
										<?php }
										else
										{?>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										
									<?php }?>
								</tr>
								<tr>
									<td height="30" colspan="2" ><strong>CHAMPION BONUS@ 4%</strong> </td>
									
									<?php if(!empty($consumer_bonus_fund))
										{?>
										<td height="30"><?=$tot_consumer_bonus_fund = $consumer_bonus_fund->tr42_income+$consumer_bonus_fund->tr42_admin+$consumer_bonus_fund->tr42_tds  ?></td>
										<td height="30"><?=$consumer_bonus_fund->tr42_admin ?></td>
										<td height="30"><?=$consumer_bonus_fund->tr42_tds ?></td>
										<td height="30"><?=$consumer_bonus_fund->tr42_income ?></td>
										<?php }
										else
										{?>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										
									<?php }?>
								</tr>
								<tr>
									<td height="30" colspan="2" ><strong>SENIOR GENERAL MANAGER FUND @4%</strong> </td>
									
									<?php if(!empty($sgm_fund))
										{?>
										<td height="30"><?=$tot_sgm = $sgm_fund->tr42_income+$sgm_fund->tr42_admin+$sgm_fund->tr42_tds  ?></td>
										<td height="30"><?=$sgm_fund->tr42_admin ?></td>
										<td height="30"><?=$sgm_fund->tr42_tds ?></td>
										<td height="30"><?=$sgm_fund->tr42_income ?></td>
										<?php }
										else
										{?>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										
									<?php }?>
									
								</tr>
								<tr>
									<td height="30" colspan="2" ><strong>TEAM GROWTH INCENTIVE@2%</strong> </td>
									
									<?php if(!empty($tgi))
										{?>
										<td height="30"><?=$tot_tgi=$tgi->tr42_income+$tgi->tr42_admin+$tgi->tr42_tds  ?></td>
										<td height="30"><?=$tgi->tr42_admin ?></td>
										<td height="30"><?=$tgi->tr42_tds ?></td>
										<td height="30"><?=$tgi->tr42_income ?></td>
										<?php }
										else
										{?>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										
									<?php }?>
								</tr>
								<tr>
									<td height="30" colspan="2" ><strong>SGM POOL FUND@2%</strong> </td>
									
									<?php if(!empty($sgm_pool_fund))
										{?>
										<td height="30"><?=$tot_sgm_pool = $sgm_pool_fund->tr42_income+$sgm_pool_fund->tr42_admin+$sgm_pool_fund->tr42_tds  ?></td>
										<td height="30"><?=$sgm_pool_fund->tr42_admin ?></td>
										<td height="30"><?=$sgm_pool_fund->tr42_tds ?></td>
										<td height="30"><?=$sgm_pool_fund->tr42_income ?></td>
										<?php }
										else
										{?>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										
									<?php }?>
								</tr>
								<tr>
									<td height="30" colspan="2" ><strong>SGM ROYALITY FUND@5%</strong> </td>
									
									
									<?php if(!empty($sgm_royality_fund))
										{?>
										<td height="30"><?=$tot_sgm_royality= $sgm_royality_fund->tr42_income+$sgm_royality_fund->tr42_admin+$sgm_royality_fund->tr42_tds  ?></td>
										<td height="30"><?=$sgm_royality_fund->tr42_admin ?></td>
										<td height="30"><?=$sgm_royality_fund->tr42_tds ?></td>
										<td height="30"><?=$sgm_royality_fund->tr42_income ?></td>
										<?php }
										else
										{?>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										
									<?php }?>
								</tr>
								<tr>
									<td height="30" colspan="2" ><strong>FRANCHISE REFERRAL INCENTIVE @ 1%</strong> </td>
									
									<?php if(!empty($store_referral_commission))
										{?>
										<td height="30"><?=$tot_store_referral = $store_referral_commission->tr42_income+$store_referral_commission->tr42_admin+$store_referral_commission->tr42_tds  ?></td>
										<td height="30"><?=$store_referral_commission->tr42_admin ?></td>
										<td height="30"><?=$store_referral_commission->tr42_tds ?></td>
										<td height="30"><?=$store_referral_commission->tr42_income ?></td>
										<?php }
										else
										{?>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										<td height="30"> 0.00 </td>
										
									<?php }?>
								</tr>
								<?php  $tottt = $tot_self+$tot_team+$tot_gm_performance_fund+$tot_travel_fund+$tot_car_fund+$tot_consumer_bonus_fund+$tot_sgm+$tot_tgi+$tot_sgm_pool+$tot_sgm_royality+$tot_store_referral; ?>
								<tr>
									<td height="30" colspan="2" ><strong>GRAND TOTAL</strong> </td>
									<td height="30"><strong><?=$tottt?></strong></td>
									<td height="30"><strong> <?=$rec->tr42_admin?></strong></td>
									<td height="30"><strong> <?=$rec->tr42_tds?></strong></td>
									<td height="30"> <strong>
										<?php echo $tottt - ($rec->tr42_tds + $rec->tr42_admin) ?>
										
									</strong></td>
								</tr>
								
								<tr>
									<td height="10" colspan="10" align="center" >
										<p style="float:right; margin-top: -30px;"><strong></strong><br/><br/> <strong> Uniqueforce Health Care Pvt. Ltd </strong>&nbsp;&nbsp;</p>
									</td>
								</tr>
								
							</tbody>
						</table>
					</div>
				</div>		
			</div>
		
		
		<script>
			function print_invoice() {
				var div = document.getElementById("print_div");
				if (div.style.display !== " none")
				{
					div.style.display = "none";
				}
				$('#invoice_date').hide();
				$('#invoice_date2').hide();
				window.print();
				
			}
		</script>										