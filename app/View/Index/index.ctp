
<!-- AUTHENTICATED -->
<?php if ($authenticated) { ?>

	<form id="main-form" action="<?php echo Router::url("/api/createlist"); ?>" method="post" target="progress">

		<div class="form-container">
			<input type="submit" style="display:none;">
			<a href="#" id="to-send-form" class="btn btn-main" data-to-authorize="<?php echo ($authenticated) ? "0" : "1"; ?>"><?php echo __("Create list!"); ?></a>

			<div class="disabler"></div>
		</div>

	</form>

	<iframe id="progress" name="progress"></iframe>

	<div id="progress-render">
	<span id="progress-message">
		<?php if ($authenticated) {
			echo __("*The list will have a max. number of 5000 users");
		} else {
			echo __("*You'll be redirected to sign in with Twitter<br>[No automatic tweets nor similar shit, promised]");
		} ?>
	</span>
		<div id="progress-bar"></div>
		<div class="clear"></div>
	</div>

<?php } else { ?>

	<!-- NO AUTHENTICATED -->
	<a href="#" id="to-send-form" class="fancy-button bg-gradient4"><span><?php echo __("Bring back my Twitter TL!"); ?></span></a>

	<form id="main-form" action="<?php echo Router::url("/api/authorize"); ?>" method="post">

		<div class="form-container">
			<input type="submit" style="display:none;">
			<a href="#" id="to-send-form" class="btn btn-main" data-to-authorize="<?php echo ($authenticated) ? "0" : "1"; ?>"><?php echo __("Create list!"); ?></a>

			<div class="disabler"></div>
		</div>

	</form>
<?php }?>