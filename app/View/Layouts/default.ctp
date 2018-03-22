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
	<link href="https://fonts.googleapis.com/css?family=Cookie|Kaushan+Script|Londrina+Solid|Nanum+Pen+Script|Passion+One" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>

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
	<h1>Oh, my Timeline!</h1>

	<h2 class="big-description">
		Bring back your Twitter Timeline.<br>
	</h2>

	<h3>
		<?php echo __("There's no secret."); ?><br>
		<?php echo __("I create a Twitter list with the people you follow."); ?><br>
		<?php echo __("Did you know that Twitter lists include...?"); ?>
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

		<!-- BUTTON -->
		<a href="#" class="fancy-button bg-gradient4"><span><?php echo __("Bring back my Twitter TL!"); ?></span></a>

	</section>

	<?php echo $this->fetch('content'); ?>

	<!-- ADDITIONAL INFORMATION -->
	<section class="information">

		<div class="container">

			<div class="columns">

				<div class="block why">
					<h3>
						<?php echo __("Why omt"); ?>
					</h3>
					<p><?php echo __("I created a side project some time ago (whoinfluenc.es) and I realized, when browsing the lists' tweets, that all the annoyting features of my main TL were not there!"); ?></p>
				</div>

				<div class="block hack-ux">
					<h3>
						<?php echo __("Hacking the UX"); ?>
					</h3>
					<p><?php echo __("Everywhere you are, browser or Twitter app for Android or iOS. Your Twitter Timeline wherever you are."); ?></p>
				</div>

				<div class="block open">
					<h3>
						<?php echo __("Safe and sound"); ?>
					</h3>
					<p><?php echo __("This is another open source side project from M.T. Ugarte. No side issues expected. Please check the code."); ?></p>
				</div>

			</div>

		</div>

	</section>

</main>

<!-- FOOTER -->
<footer>
	<span><?php echo __("Made with ❤ by <a target='_blank' href='https://twitter.com/ojoven'>@ojoven</a>"); ?></span>
</footer>

<!-- JS -->
<script type="text/javascript">
	urlBase = "<?php echo Router::url("/");?>";
</script>

<script src="<?php echo Router::url("/js/app.min.js?v=" . Functions::majestic_get_current_version('js')); ?>"></script>

</body>
</html>