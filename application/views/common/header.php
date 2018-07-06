<!DOCTYPE html>
<html>
<head>
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1" />
    <meta property="og:title" content="<?php echo $title; ?>" />
    <meta property="og:type" content="website" />
    <meta property="og:image" content="<?php echo base_url("assets/icons/logo.png"); ?>" />
    <meta property="og:url" content="<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />
	<?php if (isset($meta_description)) {
        echo "<meta name='description' content='" . $meta_description . "' />";
        echo "<meta name='og:description' content='" . $meta_description . "' />";
	} ?>
	<link rel="stylesheet" href="<?php echo base_url("assets/css/common/default.css?v=26"); ?>" />
	<link rel="stylesheet" href="<?php echo base_url("assets/css/" . $page_name . ".css?v=59"); ?>" />
    <?php echo $additional_css; ?>
    <style>
        @font-face {
			font-family: keepcalm;
			src: url(<?php echo base_url("assets/fonts/KeepCalm-Medium.woff"); ?>);
        }
    </style>
</head>
<body>
<div class="header-fixed">
    <a href="<?php echo base_url(); ?>" class="logo" style="background-image: url(<?php echo base_url("assets/icons/logo.png"); ?>);"></a>
    <div class="header-menu-container">
        <a href="<?php echo base_url(""); ?>" class="header-menu<?php echo $header_menu["home"]; ?>" >HOME</a>
        <a href="<?php echo base_url("register-tour"); ?>" class="header-menu<?php echo $header_menu["register_tour"]; ?>" >REGISTER TOUR</a>
        <a href="<?php echo base_url("services"); ?>" class="header-menu<?php echo $header_menu["services"]; ?>" >SERVICES</a>
        <a href="<?php echo base_url("tour_packages"); ?>" class="header-menu<?php echo $header_menu["tour_packages"]; ?>" >TOUR PACKAGES</a>
        <a href="<?php echo base_url("article"); ?>" class="header-menu<?php echo $header_menu["article"]; ?>" >ARTICLE</a>
        <a href="<?php echo base_url("about"); ?>" class="header-menu<?php echo $header_menu["about"]; ?>" >ABOUT</a>
        <a href="<?php echo base_url("contact"); ?>" class="header-menu<?php echo $header_menu["contact_us"]; ?>" >CONTACT US</a>
    </div>
</div>
<a href="<?php echo base_url(); ?>" class="logo-mobile">
    <div class="logo-mobile-blue" style="background-image: url(<?php echo base_url("assets/icons/logo.png"); ?>);"></div>
    <div class="logo-mobile-white" style="background-image: url(<?php echo base_url("assets/icons/logo_white.png"); ?>);"></div>
</a>
<div class="menu-icon" id="menu-icon">
    <div class="menu-icon-line menu-icon-line-1"></div>
    <div class="menu-icon-line menu-icon-line-2"></div>
    <div class="menu-icon-line menu-icon-line-3"></div>
</div>
<div class="header-menu-container-mobile"></div>
<div class="header-menu-mobile-center">
    <a href="<?php echo base_url(""); ?>" class="header-menu-mobile<?php echo $header_menu["home"]; ?>" >HOME</a><br />
    <a href="<?php echo base_url("register-tour"); ?>" class="header-menu-mobile<?php echo $header_menu["register_tour"]; ?>" >REGISTER TOUR</a><br />
    <a href="<?php echo base_url("services"); ?>" class="header-menu-mobile<?php echo $header_menu["services"]; ?>" >SERVICES</a><br />
    <a href="<?php echo base_url("tour_packages"); ?>" class="header-menu-mobile<?php echo $header_menu["tour_packages"]; ?>" >TOUR PACKAGES</a><br />
    <a href="<?php echo base_url("article"); ?>" class="header-menu-mobile<?php echo $header_menu["article"]; ?>" >ARTICLE</a><br />
    <a href="<?php echo base_url("about"); ?>" class="header-menu-mobile<?php echo $header_menu["about"]; ?>" >ABOUT</a><br />
    <a href="<?php echo base_url("contact"); ?>" class="header-menu-mobile<?php echo $header_menu["contact_us"]; ?>" >CONTACT US</a>
</div>
<div class="notification"></div>
<script>
var vw = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
var vh = Math.max(document.documentElement.clientHeight, window.innerHeight || 0);
if (vw < 1025) {
    isMobile = true;
    if (vw >= 768) {
        isTablet = true;
    } else {
        isTablet = false;
    }
} else {
    isMobile = false;
}
</script>
<div class="container">