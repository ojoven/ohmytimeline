<!DOCTYPE html>
<html lang="en">
<head>

	<!-- Google Aalytics -->
	<?php echo $this->element('analytics_script'); ?>

	<!-- Le meta -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php $title = __("Oh My Timeline! | Bring back your Twitter TL");
	$description = __("No ads, no faved tweets from people you follow, no suggestions. Your Timeline, clean and sorted."); ?>
	<title><?php echo $title; ?></title>
	<meta name="description" content="<?php echo $description; ?>">
	<meta property="og:title" content="<?php echo $title; ?>"/>
	<meta property="og:description" content="<?php echo $description; ?>" />
	<meta property="og:site_name" content="http://ohmytimeline.com"/>
	<meta property="og:type" content="website"/>
	<meta property="og:url" content="<?php echo Router::url("/",true); ?>"/>
	<meta property="og:image" content="<?php echo Router::url("/img/omt_square-3.png",true)?>"/>

	<!-- Le styles -->
	<link rel="stylesheet" type="text/css" href="/css/style.css?v=<?php echo Functions::majestic_get_current_version('css'); ?>">

	<!-- Le CDNs -->
	<link href="https://use.fontawesome.com/releases/v5.0.8/css/all.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Cabin|Titillium+Web" rel="stylesheet">

	<!-- Les icons -->
	<link rel="apple-touch-icon" sizes="57x57" href="/apple-icon-57x57.png">
	<link rel="apple-touch-icon" sizes="60x60" href="/apple-icon-60x60.png">
	<link rel="apple-touch-icon" sizes="72x72" href="/apple-icon-72x72.png">
	<link rel="apple-touch-icon" sizes="76x76" href="/apple-icon-76x76.png">
	<link rel="apple-touch-icon" sizes="114x114" href="/apple-icon-114x114.png">
	<link rel="apple-touch-icon" sizes="120x120" href="/apple-icon-120x120.png">
	<link rel="apple-touch-icon" sizes="144x144" href="/apple-icon-144x144.png">
	<link rel="apple-touch-icon" sizes="152x152" href="/apple-icon-152x152.png">
	<link rel="apple-touch-icon" sizes="180x180" href="/apple-icon-180x180.png">
	<link rel="icon" type="image/png" sizes="192x192"  href="/android-icon-192x192.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="96x96" href="/favicon-96x96.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
	<link rel="manifest" href="/manifest.json">
	<meta name="msapplication-TileColor" content="#445E93">
	<meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
	<meta name="theme-color" content="#445E93">

	<?php echo $this->element('javascript_export'); ?>

</head>

<body>

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
		<span><?php echo __("Made with ❤ by <a target='_blank' href='https://twitter.com/lindydeveloper'>@lindydeveloper</a>"); ?></span>
	</footer>

	<!-- JS -->
	<script type="text/javascript">
		urlBase = "<?php echo Router::url("/");?>";
		authenticated = <?php echo (isset($authenticated) && $authenticated) ? "true" : "false"; ?>;
	</script>

	<script src="<?php echo Router::url("/js/app.min.js?v=" . Functions::majestic_get_current_version('js')); ?>"></script>

</body>
</html>