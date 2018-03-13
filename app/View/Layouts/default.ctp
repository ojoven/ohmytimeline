<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php
	$title = __("realtl.io | Bring back your Twitter TL");
	$description = __("No ads, no faved tweets from people you follow, no suggestions. Your Timeline, clean and sorted.");
	?>
	<title><?php echo $title; ?></title>
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
	<link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz:400,300' rel='stylesheet' type='text/css'>

	<!-- Le icons -->
	<link rel="shortcut icon" href="<?php echo Router::url("/") ?>img/favicon.png">
	<link href="<?php echo Router::url("/") ?>img/favicon.png" type="image/x-icon" rel="icon" />

	<?php echo $this->element('javascript_export'); ?>

</head>

<body>

<?php echo $this->element('analytics_script'); ?>

<?php if ($authenticated) {?>
	<a href="<?php echo Router::url("/api/logout")?>" id="logout">
		<img src="<?php echo Router::url("/img/logout.png"); ?>">
		<span><?php echo __("Logout"); ?></span>
	</a>
<?php }?>

<h1 id="logo">
	<a href="<?php echo Router::url("/");?>">
		<?php if (isset($viewInfluencer)) {
			echo __("Who Influences<br><span class='influencername'>%s</span>?",array("@".$viewInfluencer));
		} else {
			echo __("Who Influences<br><span class='influencername'>the Influencers</span>?");
		} ?>
	</a>
</h1>

<h2 class="subtitle">
	<?php if (isset($viewInfluencer)) {
		echo __("Wanna feel what <span class='influencername'>%s</span> feels on Twitter?<span class='break-desktop'></span> <span class='highlight'>with whoinfluenc.es create a Twitter list of your own with the people he/she is following</span>.",array("@".$viewInfluencer));
	} else {
		echo __("Wanna feel what the influencers feel on their Twitter?<span class='break-desktop'></span> <span class='highlight'>with whoinfluenc.es create <a href='https://twitter.com/whoinfluences/lists/whoinfluences-billgates-2' target='blank'>a Twitter list</a> of your own with the people they're following</span>.");
	} ?>
</h2>

<div class="container main-container">

	<?php echo $this->fetch('content'); ?>

</div> <!-- /container -->

<footer>
	<span class="hide-mobile"><?php echo __("Made with love by <a target='_blank' href='http://twitter.com/ojoven'>@ojoven</a>, creator of DoWrapIt. Send YouTube videos, Spotify playlists, PDF ebooks as gifts at <a target='blank' href='http://dowrap.it'>http://dowrap.it</a>. Wanna try?"); ?></span>
	<span class="hide-desktop"><?php echo __("Made with love by <a target='_blank' href='http://twitter.com/ojoven'>@ojoven</a>, creator of <a target='_blank' href='http://dowrap.it'>DoWrapIt</a>."); ?></span>
</footer>

<?php //echo $this->element('sql_dump');?>

<!-- Le javascript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->

<?php
//echo $this->AssetCompress->script('common');
?>
<script src="<?php echo Router::url("/js/app.min.js?v=" . Functions::majestic_get_current_version('js')); ?>"></script>
<script type="text/javascript" src="<?php echo Router::url("/js/functions.js"); ?>"></script>

<script type="text/javascript">
	urlBase = "<?php echo Router::url("/");?>";
</script>

</body>
</html>