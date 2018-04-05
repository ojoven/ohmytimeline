<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php $title = __("Oh, my Timeline! | Bring back your Twitter TL");
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
	<link href="https://fonts.googleapis.com/css?family=Londrina+Solid|Titillium+Web" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Arvo|Cabin|Josefin+Sans|Nunito|Poppins|Raleway" rel="stylesheet">
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

	<?php if ($authenticated) {?>
		<div class="container">
			<div class="menu">
				<a href="<?php echo Router::url("/api/logout")?>" id="logout" class="menu-option">
					<span><i class="fas fa-sign-out-alt"></i><?php echo __("Logout"); ?></span>
				</a>
			</div>
		</div>
	<?php }?>

	<h1>O<span class="disappear">h </span>M<span class="disappear">y </span>T<span class="disappear">imeline</span>!</h1>

	<h2 class="big-description">
		Bring back your <br class="just-mobile">Twitter Timeline.<br>
	</h2>

	<h3>
		<?php echo __("1. We create a Twitter list with the people you follow and 2. You add a direct link to the list on your mobile screen. That easy."); ?>
	</h3>

	<ul class="main-features fa-ul">
		<li><span class="fa-li"><i class="fas fa-check"></i></span><?php echo __("No ads"); ?></li>
		<li><span class="fa-li"><i class="fas fa-check"></i></span><?php echo __("No faved tweets from people you follow"); ?></li>
		<li><span class="fa-li"><i class="fas fa-check"></i></span><?php echo __("No \"you may have missed\" tweets"); ?></li>
		<li><span class="fa-li"><i class="fas fa-check"></i></span><?php echo __("Only the tweets you ❤ sorted in real time"); ?></li>
	</ul>

</header>

<!-- MAIN CONTENT -->
<main id="main-container">

	<!-- CTA -->
	<section class="cta">

		<?php /**
		<!-- FOLLOW -->
		<div class="message">
			<?php echo __("To be aware of my other side projects and enjoy tweets and memes about UX, products, etc. why don't you also...?"); ?>
		</div>

		<div class="follow">
			<img src="<?php echo Router::url("/") ?>img/twitter_sad.jpg">

			<div class="form-checkbox">
				<input id="follow-check" type="checkbox" />
				<label for="follow-check">Follow me</label>
			</div>
		</div>
		**/ ?>

		<!-- CONTENT -->
		<?php echo $this->fetch('content'); ?>

		<!-- DISCLAIMER -->
		<div class="disclaimer">
			*You'll be redirected to sign in with Twitter<br>
			[No automatic tweets nor spam, just one thing*]
		</div>

	</section>

	<!-- ADDITIONAL INFORMATION -->
	<section class="author">

		<div class="container">

			<div class="avatar-container">
				<img src="<?php echo Router::url("/") ?>img/avatars/avatar_happy_1.jpg" />
				<img src="<?php echo Router::url("/") ?>img/avatars/avatar_happy_1.jpg" />
			</div>

			<div class="follow-container">
				<h3>
					<?php echo __("This is a side project<br> made by @lindydeveloper"); ?>
				</h3>
				<h4>
					<input id="follow" name="follow" type="checkbox" checked />
					<label for="follow"><?php echo __("*Follow me on Twitter"); ?></label>
					<p><?php echo __("For delicious tweets about side projects,<br>creativeness, UX, MEMEs...and to let me know<br> how Oh My Timeline works for you!"); ?></p>
				</h4>
			</div>

		</div>

	</section>

	<!-- NUMBER OF TIMELINES BROUGHT BACK
	<section class="numbers">

		<div class="main">
			<span class="number">210</span>
			<span class="message">timelines brought back!</span>
		</div>

	</section>
 	-->

</main>

<!-- FOOTER -->
<footer>
	<span><?php echo __("Made with ❤ by <a target='_blank' href='https://twitter.com/ojoven'>@lindydeveloper</a>"); ?></span>
</footer>

<!-- JS -->
<script type="text/javascript">
	urlBase = "<?php echo Router::url("/");?>";
	authenticated = <?php echo ($authenticated) ? "true" : "false"; ?>;
</script>

<script src="<?php echo Router::url("/js/app.min.js?v=" . Functions::majestic_get_current_version('js')); ?>"></script>

</body>
</html>