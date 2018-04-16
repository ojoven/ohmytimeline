<main id="main-container" class="view-list-page">

	<!-- MOBILE -->
	<div class="just-mobile">

		<div class="header">
			<span id="success-mobile" class="success"><?php echo __("List successfully created!"); ?></span>
			<span class="supra-title"><?php echo __("But wait cause there's more..."); ?></span>
			<p class="title"><?php echo __("Pro Tip: Add this page to your home screen and you'll be in your OMT timeline list in a single click."); ?></p>
		</div>

		<a href="#" class="btn btn-main" id="to-add-cookie" onclick="addCookie();"><?php echo __("Go to My Timeline!"); ?></a>

		<div class="disclaimer">
			<?php echo __("If you'd like to access via browser, instead of Twitter app:"); ?>
			<br>
			<a target="_blank" href="https://twitter.com/<?php echo $username; ?>/lists/<?php echo $slug; ?>">
				https://twitter.com/<?php echo $username; ?>/lists/<?php echo $slug; ?>
			</a>
		</div>

	</div>

	<!-- DESKTOP -->
	<div class="hide-mobile">

		<div class="header">
			<span class="success"><?php echo __("List successfully created!"); ?></span>
		</div>

		<a target="_blank" href="https://twitter.com/<?php echo $username; ?>/lists/<?php echo $slug; ?>" class="btn btn-main"><?php echo __("Go to My Timeline!"); ?></a>

		<div class="disclaimer">
			<?php echo __("Tip: add the list as a bookmark for a single click easy access!"); ?>
		</div>

	</div>

	<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

	<script>

		var urlTwitterApp = 'twitter://list?screen_name=<?php echo $username; ?>&slug=<?php echo $slug; ?>';

		var added = Cookies.get('from-home-screen');
		if (added) {
			document.getElementById('success-mobile').style.visibility = "hidden";
			window.location.href = urlTwitterApp;
			/**
			setInterval(function() {
				window.location.href = urlTwitterApp;
			}, 1000);
			**/
		}

		function addCookie() {
			var added = Cookies.set('from-home-screen', true, { expires: 14, path: '' });
			window.location.href = urlTwitterApp;
		}

	</script>

</main>