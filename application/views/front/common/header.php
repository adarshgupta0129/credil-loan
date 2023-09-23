<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="keywords" content="" />
		<meta name="author" content="" />
		<meta name="robots" content="" />
		<meta name="description" content="<?php echo SITE_NAME; ?> - <?php echo DESCRIPTION; ?> "/>
		<meta property="og:image" content="<?php echo base_url(); ?>favicon/favicon.png" />
		<meta property="og:title" content="<?php echo SITE_NAME; ?> - <?php echo DESCRIPTION; ?> "/>
		<meta property="og:description" content="<?php echo SITE_NAME; ?> - <?php echo DESCRIPTION; ?> "/>
		<meta name="format-detection" content="telephone=no">
		<link rel="icon" href="<?php echo base_url() ?>favicon/favicon.png" type="image/x-icon" />
		<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url() ?>favicon/favicon.png" />
		<title><?php echo SITE_NAME; ?> - <?php echo DESCRIPTION; ?> </title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/plugins.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/plugins/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/plugins/line-awesome/css/line-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/plugins/themify/themify-icons.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/plugins/flaticon/restaurant/flaticon.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/style.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/templete.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url() ?>assets/css/line-awesome.min.css">
		<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/combining.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/counterup.min.js"></script>
		<script src="<?php echo base_url() ?>assets/js/main.js"></script>
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/owlcarousel/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo base_url() ?>assets/owlcarousel/owl.theme.default.min.css">
		<script src="<?php echo base_url() ?>assets/owlcarousel/owl.carousel.js"></script>	
		<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js" integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="  crossorigin="anonymous"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	
		<input type="hidden" id="baseurl" value="<?php echo base_url(); ?>" />
		<input type="hidden" id="txtmethod" value="<?php echo $this->router->fetch_method(); ?>" />
		<input type="hidden" id="txtclass" value="<?php echo $this->router->fetch_class(); ?>" />
		
		<script src="<?php echo base_url(); ?>application/third_party/js/check.js"></script>
		<script src="<?php echo base_url(); ?>application/third_party/js/custom.js"></script>
		<script src="<?php echo base_url(); ?>application/third_party/js/front.js"></script>
	</head>
	<body id="bg">
		<?php if($this->session->flashdata("error")){?>	
			<div class="alert alert-danger alert-dismissible alert1">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><?= $this->session->flashdata("error"); ?></strong>
			</div>
			<?php } if($this->session->flashdata("success")){?>
			<div class="alert alert-success alert-dismissible alert1">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
				<strong><?= $this->session->flashdata("success"); ?></strong>
			</div>
		<?php } ?>
	<div class="page-wraper">			