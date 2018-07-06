<html>
<head>
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="robots" content="nofollow" />
	<link rel="stylesheet" href="<?php echo base_url("assets/css/common/admindefault.css?v=12"); ?>" />
	<link rel="stylesheet" href="<?php echo base_url("assets/css/" . $page_name . ".css?v=30"); ?>" />
	<?php echo $additional_css; ?>
	<style>
		@font-face {
			font-family: keepcalm;
			src: url(<?php echo base_url("assets/fonts/KeepCalm-Medium.woff"); ?>);
        }
	</style>
</head>
<body>
<div class="loader">
    <svg class="loader-circular">
        <circle class="loader-circular-path" cx="50" cy="50" r="30" fill="none" stroke-width="6" stroke-miterlimit="10"/>
    </svg>
</div>
<div class="menu-container">
	<div class="logo" style="background-image: url(<?php echo base_url("assets/icons/logo_white.png"); ?>);"></div>
	<a href="<?php echo base_url("admin"); ?>" class="menu<?php echo $menu_active["home"]; ?>">Daftar Peserta Tour</a>
    <a href="<?php echo base_url("admin/carousel"); ?>" class="menu<?php echo $menu_active["carousel"]; ?>">Home Carousel</a>
    <a href="<?php echo base_url("admin/tour_highlight"); ?>" class="menu<?php echo $menu_active["tour_highlight"]; ?>">Tour Highlight</a>
    <a href="<?php echo base_url("admin/tour_bonus"); ?>" class="menu<?php echo $menu_active["tour_bonus"]; ?>">Tour Bonus</a>
	<a href="<?php echo base_url("admin/tour_group"); ?>" class="menu<?php echo $menu_active["tour_group"]; ?>">Tour Group</a>
	<a href="<?php echo base_url("admin/tour_package"); ?>" class="menu<?php echo $menu_active["tour_package"]; ?>">Tour Packages</a>
	<a href="<?php echo base_url("admin/article"); ?>" class="menu<?php echo $menu_active["article"]; ?>">Article</a>
    <a href="<?php echo base_url("admin/services"); ?>" class="menu<?php echo $menu_active["services"]; ?>">Services</a>
</div>
<div class="header">
	<div class="menu-title"><?php echo $menu_title; ?></div>
    <div class="admin-menu-icon" style="background-image: url(<?php echo base_url("assets/icons/profile.png"); ?>);"></div>
    <div class="admin-menu-container">
        <a href="<?php echo base_url("admin/settings"); ?>" class="admin-menu" >Settings</a>
        <a href="<?php echo base_url("login/logout"); ?>" class="admin-menu" >Logout</a>
    </div>
</div>
<div class="notification"></div>
<div class="container">
<?php 
    if ($this->session->userdata("success_message")) {
        echo "<div class='success-message'>" . $this->session->userdata("success_message") . "</div>";
    }
    if ($this->session->userdata("error_message")) {
        echo "<div class='error-message'>" . $this->session->userdata("error_message") . "</div>";
    }
?>