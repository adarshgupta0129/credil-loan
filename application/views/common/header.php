<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="<?php echo DESCRIPTION; ?>">
        <meta name="author" content="<?php echo SITE_NAME; ?>">

        <link rel="shortcut icon" href="<?php echo base_url(); ?>favicon/favicon.png">

        <title><?php echo SITE_NAME." | ".$page; ?></title>
		<meta property="og:image" content="<?php echo base_url(); ?>favicon/favicon.png" />
		<link href="<?php echo base_url(); ?>application/libraries/assets/css/editor.css"  rel="stylesheet" type="text/css" /> 
        <link href="<?php echo base_url(); ?>application/libraries/assets/plugins/morris/morris.css"  rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>application/libraries/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>application/libraries/assets/css/core.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>application/libraries/assets/css/components.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>application/libraries/assets/css/icons.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>application/libraries/assets/css/pages.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>application/libraries/assets/css/responsive.css" rel="stylesheet" type="text/css" />
        
		<script src="<?php echo base_url(); ?>application/libraries/assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>application/libraries/assets/js/modernizr.min.js"></script>
        <?php
        if($this->router->fetch_method() != 'dashboard' && $this->router->fetch_method() != 'index' )
        {
        ?>
        <!-- Custom Date Picker Js -->
        <link href="<?php echo base_url(); ?>application/libraries/assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
        <!-- Custom box css -->
        <link href="<?php echo base_url(); ?>application/libraries/assets/plugins/custombox/css/custombox.css" rel="stylesheet">
        <?php
        }
        ?>
</head>
<style>

.select2-results__option {
    color: #000!important;
}
.select2-container--default .select2-selection--multiple .select2-selection__choice {
    background-color: #424242!important;
}
	</style>
