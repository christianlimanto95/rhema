<html>
<head>
	<title><?php echo $title; ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1">
    <meta name="robots" content="nofollow" />
	<link rel="stylesheet" href="<?php echo base_url("assets/css/login.css?v=2"); ?>" />
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
<div class="notification"></div>
<div class="container">
    <div class="head">
        <div class="logo" style="background-image: url(<?php echo base_url("assets/icons/logo_white.png"); ?>);"></div>
    </div>
    <div class="form-item">
        <div class="form-label">Username <span class="error error-username"></span></div>
        <input type="text" class="form-input input-username" maxlength="30" autofocus="autofocus" />
    </div>
    <div class="form-item">
        <div class="form-label">Password <span class="error error-password"></span></div>
        <input type="password" class="form-input input-password" maxlength="30" />
    </div>
    <div class="btn-login">LOGIN</div>
</div>
<script>
var do_login_url = "<?php echo base_url("login/do_login"); ?>";
var admin_url = "<?php echo base_url("admin"); ?>";
</script>
<script src="<?php echo base_url("assets/js/common/jquery-3.2.1.min.js"); ?>" defer></script>
<script src="<?php echo base_url("assets/js/login.js?v=2"); ?>" defer></script>
</body>
</html>