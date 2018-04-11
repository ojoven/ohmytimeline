<main id="main-container" class="view-list-page">

	<span class="title"><?php echo __("Add this page to your home screen and you'll be in your OMT timeline list in a single click."); ?></span>

	<a href="#" class="btn btn-main" id="to-add-cookie" onclick="addCookie();"><?php echo __("Go to My Timeline!"); ?></a>

	<div class="disclaimer">
		<?php echo __("If you're in the desktop or prefer to link to the list via browser URL you can go to the list through:"); ?>
		<br>
		<a target="_blank" href="https://twitter.com/<?php echo $username; ?>/lists/<?php echo $slug; ?>">
			https://twitter.com/<?php echo $username; ?>/lists/<?php echo $slug; ?>
		</a>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>

	<script>

		var urlTwitterApp = 'twitter://list?screen_name=<?php echo $username; ?>&slug=<?php echo $slug; ?>';

		var added = Cookies.get('added');
		if (added) {
			window.location.href = urlTwitterApp;
		}

		function addCookie() {
			var added = Cookies.set('added', true);
			window.location.href = urlTwitterApp;
		}

	</script>

</main>