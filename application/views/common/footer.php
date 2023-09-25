</div>			
</div> <!-- container -->

</div> <!-- content -->

<footer class="footer text-right">
	<?php echo SITE_NAME; ?> © <?php echo date('Y'); ?>. All rights reserved.
</footer>
<!-- End Footer -->

</div>
</div>
<script>
	var resizefunc = [];
</script>
<!--User Defined jQuery  -->
<input type="hidden" id="baseurl" value="<?php echo base_url(); ?>" />
<input type="hidden" id="txtmethod" value="<?php echo $this->router->fetch_method(); ?>" />
<input type="hidden" id="txtclass" value="<?php echo $this->router->fetch_class(); ?>" />

<!--ajax_call jQuery  -->

<script src="<?php echo base_url(); ?>assets/js/ajax_call.js"></script>

<!--Common jQuery  -->

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"  />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" ></script>

<script src="<?php echo base_url(); ?>application/libraries/assets/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>application/libraries/assets/js/detect.js"></script>
<script src="<?php echo base_url(); ?>application/libraries/assets/js/fastclick.js"></script>
<script src="<?php echo base_url(); ?>application/libraries/assets/js/jquery.slimscroll.js"></script>
<script src="<?php echo base_url(); ?>application/libraries/assets/js/waves.js"></script>
<script src="<?php echo base_url(); ?>application/libraries/assets/js/wow.min.js"></script>
<script src="<?php echo base_url(); ?>application/libraries/assets/plugins/peity/jquery.peity.min.js"></script>
<script src="<?php echo base_url(); ?>application/libraries/assets/plugins/notifyjs/js/notify.js"></script>
<script src="<?php echo base_url(); ?>application/libraries/assets/plugins/notifications/notify-metro.js"></script>

<script type="text/javascript">
	jQuery(document).ready(function($) {
		$('.select2').select2({placeholder: ' -- Select data --'});
		
		<?php if($this->session->flashdata("error")){?>
			$.Notification.autoHideNotify('error', 'top right', '<?=$form?>', '<?php echo $this->session->flashdata("error"); ?>');
			<?php } if($this->session->flashdata("success")){?>
			$.Notification.autoHideNotify('success', 'top right', '<?=$form?>', '<?php echo $this->session->flashdata("success"); ?>');
		<?php } ?>
	});
</script>

<?php
	if(fetch_method()=='dashboard' && fetch_method()=='index')
	{
	?> 
	<script src="<?php echo base_url(); ?>application/libraries/assets/plugins/morris/morris.min.js"></script> 
	<script src="<?php echo base_url(); ?>application/libraries/assets/pages/jquery.dashboard.js"></script>
	<?php
		} else {
	?>
	<script src="<?php echo base_url(); ?>application/libraries/assets/plugins/bootstrap-filestyle/js/bootstrap-filestyle.min.js" type="text/javascript"></script>
	<script src="<?php echo base_url(); ?>application/libraries/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js"></script>
	<script src="<?php echo base_url(); ?>application/libraries/assets/plugins/custombox/js/custombox.min.js"></script>
	<script src="<?php echo base_url(); ?>application/libraries/assets/plugins/custombox/js/legacy.min.js"></script>
	<script src="<?php echo base_url(); ?>application/libraries/assets/pages/jquery.form-pickers.init.js"></script>
	<?php
	}
?>

<script src="<?php echo base_url(); ?>application/third_party/js/check.js"></script>
<script src="<?php echo base_url(); ?>application/third_party/js/bootbox.js"></script>
<?php if(session("usertype") <> 2) { ?> 
	<script src="<?php echo base_url(); ?>application/third_party/js/master.js"></script>
<?php } ?>
<script src="<?php echo base_url(); ?>application/third_party/js/custom.js"></script>
<script src="<?php echo base_url(); ?>application/third_party/js/jquery.blockUI.js"></script>
<script src="<?php echo base_url(); ?>application/libraries/assets/js/jquery.core.js"></script>
<script src="<?php echo base_url(); ?>application/libraries/assets/js/jquery.app.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

</body>  
</html>