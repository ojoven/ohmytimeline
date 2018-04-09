<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php $title = __("Oh My Timeline! | Bring back your Twitter TL");
	$description = __("No ads, no faved tweets from people you follow, no suggestions. Your Timeline, clean and sorted."); ?>
	<title><?php echo $title; ?></title>

	<!-- Le meta -->
	<meta name="description" content="<?php echo $description; ?>">
	<meta property="og:title" content="<?php echo $title; ?>"/>
	<meta property="og:description" content="<?php echo $description; ?>" />
	<meta property="og:site_name" content="realtl.io"/>
	<meta property="og:type" content="website"/>
	<meta property="og:url" content="<?php echo Router::url("/",true); ?>"/>
	<meta property="og:image" content="<?php echo Router::url("/img/who-influences-logo-square.png",true)?>"/>

	<!-- Le styles -->
	<link rel="stylesheet" type="text/css" href="/css/style.css?v=<?php echo Functions::majestic_get_current_version('css'); ?>">

	<!-- Le CDNs -->
	<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Cabin|Titillium+Web" rel="stylesheet">
	<!--<link href="https://fonts.googleapis.com/css?family=Londrina+Solid|Arvo|Josefin+Sans|Nunito|Poppins|Raleway" rel="stylesheet">-->
	<!--<link href="https://fonts.googleapis.com/css?family=Cookie|Kaushan+Script|Londrina+Solid|Nanum+Pen+Script|Passion+One|Open+Sans:400,700|Droid+Sans" rel="stylesheet">-->

	<!-- Le icons -->
	<link rel="shortcut icon" href="<?php echo Router::url("/") ?>img/favicon.png">
	<link href="<?php echo Router::url("/") ?>img/favicon.png" type="image/x-icon" rel="icon" />

	<?php echo $this->element('javascript_export'); ?>

</head>

<body>

<!-- GOOGLE ANALYTICS -->
<?php echo $this->element('analytics_script'); ?>

<!-- HEADER -->
<header id="main-header">

	<?php if (isset($authenticated) && $authenticated) {?>
		<div class="container">
			<div class="menu">
				<a href="<?php echo Router::url("/api/logout")?>" id="logout" class="menu-option">
					<span><i class="fas fa-sign-out-alt"></i><?php echo __("Logout"); ?></span>
				</a>
			</div>
		</div>
	<?php }?>

	<h1>O<span class="disappear">h </span>M<span class="disappear">y </span>T<span class="disappear">imeline</span>!</h1>

</header>

<!-- CONTENT -->
<?php echo $this->fetch('content'); ?>

<!-- FOOTER -->
<footer>
	<span><?php echo __("Made with ❤ by <a target='_blank' href='https://twitter.com/ojoven'>@lindydeveloper</a>"); ?></span>
</footer>

<!-- JS -->
<script type="text/javascript">
	urlBase = "<?php echo Router::url("/");?>";
	authenticated = <?php echo (isset($authenticated) && $authenticated) ? "true" : "false"; ?>;
</script>

<script src="<?php echo Router::url("/js/app.min.js?v=" . Functions::majestic_get_current_version('js')); ?>"></script>

</body>
</html>