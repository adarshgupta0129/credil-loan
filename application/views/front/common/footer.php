</div>
</div>
<style>	.theme-btn{display:none} </style>

<footer class="site-footer " style="background-image: url(<?php echo base_url() ?>assets/images/background/bg2.jpg); background-size: cover;">
	<!-- Footer Top Part -->
	<div class="footer-top bg-line-top">
		<div class="container">
			<div class="row">
				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
					<div class="widget widget_getintuch">
						<h5 class="footer-title text-white">Contact Us</h5>
						<ul>
							<li>
								<i class="fa fa-map-marker"></i> 
								<p><?php echo ADDRESS; ?></p>
							</li>
							<li>
								<i class="fa fa-phone"></i> 
								<p><?php echo CONTACT1; ?></p>
							</li>
							<li>
								<i class="fa fa-mobile"></i> 
								<p><?php echo CONTACT1; ?></p>
							</li>
							
							<li>
								<i class="fa fa-envelope"></i> 
								<p><?php echo EMAIL; ?></p>
							</li>
						</ul>
					</div>
				</div>
				
				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
					<div class="widget widget_services border-0">
						<h4 class="footer-title">Quick Links</h4>
						<ul class="list-2">
							
							<li><a href="<?php echo base_url() ?>">About Us</a></li>
							<li><a href="<?php echo base_url() ?>">Careers</a></li>
							<li><a href="<?php echo base_url() ?>">Contact Us</a></li>
							<li><a href="<?php echo base_url() ?>">Terms &amp; Conditions</a></li>
							<li><a href="<?php echo base_url() ?>">Disclaimer</a></li>
							<li><a href="<?php echo base_url() ?>">Terms Of Use</a></li>
							<li><a href="<?php echo base_url() ?>">Privacy Policy</a></li>
							<li><a href="<?php echo base_url() ?>">FAQs</a></li>
							<li><a href="<?php echo base_url() ?>">Franchise</a></li>
							
						</ul>
					</div>
				</div>
				<div class="col-xl-4 col-lg-6 col-md-6 col-sm-6">
					<div class="widget border-0">
						<h4 class="footer-title">Opening Hours</h4>
						<p class="m-b20">Our support available to help you 24 hours a day, seven days a week.</p>
						<ul class="work-hour-list">
							<li>
								<span class="day"><span>Monday to Friday</span></span> 
								<span class="timing">7AM - 5PM</span>
							</li>
							<li>
								<span class="day"><span>Saturday</span></span>
								<span class="timing">10AM - 5PM</span>
							</li>
							<li>
								<span class="day"><span>Sunday</span></span>
								<span class="timing">Closed</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Footer Bottom Part -->
	<div class="footer-bottom">
		<div class="container">
			<div class="row">
				<div class="col-lg-6 col-md-6 text-left"> <span>Copyright © 2020 <?php echo SITE_NAME; ?>. all rights reserved.</span> </div>
				
				<div class="col-lg-6 col-md-6 text-right">
					<div class="dlab-social-icon">
						<ul>
							<li><a class="site-button sharp-sm fa fa-facebook" href="javascript:void(0);"></a></li>
							<li><a class="site-button sharp-sm fa fa-twitter" href="javascript:void(0);"></a></li>
							<li><a class="site-button sharp-sm fa fa-linkedin" href="javascript:void(0);"></a></li>
							<li><a class="site-button sharp-sm fa fa-instagram" href="javascript:void(0);"></a></li>
						</ul>
					</div>
				</div>
				
			</div>
		</div>
	</div>
</footer> 
<button class="scroltop icon-up" type="button"><i class="fa fa-arrow-up"></i></button>
<a class="whatshop btn btn-success" style="position: fixed;bottom: 5%;left: 10px;" target="_blank" href="https://api.whatsapp.com/send?phone=918960776570&amp;text=Hello..."><i class="fa fa-whatsapp"></i></a>

<script src="<?php echo base_url(); ?>application/third_party/js/bootbox.js"></script>
<script src="<?php echo base_url(); ?>application/third_party/js/jquery.blockUI.js"></script>

<!-- Modal -->
<div class="modal fade" id="DeliveryLocation" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">			
			<div class="modal-body">
				<h3 class="text-center">Choose your Delivery Location</h3>
				<p class="text-center">Where would you like to get the product delivered?</p>
				<div class="input-group mb-3 Pincode">
					<span class="input-group-text" id="basic-addon1"><i class="las la-map-marker"></i></span>
					<input type="text" id="pincode1" name="pincode1" class="form-control" placeholder="Enter Pincode" value="<?=get('pincode')?>" maxlength="6" />
				</div>
				<div class="input-group mb-3">
					<button type="submit" class="btn btn-info btn-block" onclick="set_pincode($('#pincode1').val());window.location.reload(true)" data-dismiss="modal">Continue</button>
				</div>					
			</div>				
		</div>
	</div>
</div>
<script>
	//-----------------------------------------mainHeader Search  start------------------------------------------------
// $("#mainHeaderSearch").keydown(function(event) {
// 	if (event.keyCode == 13)
// 		window.location.href=baseUrl+"/s?q="+$(this).val();
// });

$('#mainHeaderSearch').autocomplete({
		source: function( request, response ) {
			$.ajax({
				dataType: "json",
				type : 'Get',
				url: baseUrl+'/Welcome/mainSearchResult',
				data:{like:$( "#mainHeaderSearch" ).val()},
				success: function(data) {
					$('#mainHeaderSearch').removeClass('ui-autocomplete-loading');  
					response(data);
				},
				error: function(data) {
					$('input.suggest-user').removeClass('ui-autocomplete-loading');  
				}
			});
		},
		minLength: 2,
		scroll: true,
		open: function() {},
		close: function() {},
		focus: function(event,ui) {
			$('#mainHeaderSearch').val(ui.item.focus);
			return false;
		},
		select: function(event, ui) {
			$('#mainHeaderSearch').val(ui.item.print);
			return false;
		}
	}).autocomplete( "instance" )._renderItem = function( ul, item ) {
	return $( "<li>" )
	.append( "<div>" + item.label + "</div>" )
		.appendTo( ul );
	};

//-----------------------------------------mainHeader Search  end------------------------------------------------
</script>

</body>
</html>
