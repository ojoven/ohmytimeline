<?php if ($authenticated) {?>
	<form id="main-form" action="<?php echo Router::url("/api/updatelist"); ?>" method="post" target="progress">
	<input type="hidden" name="user_id" value="<?php echo $user['User']['user_id']; ?>">
<?php } else {?>

	<form id="main-form" action="<?php echo Router::url("/api/authorize"); ?>" method="post">
	<?php }?>

	<div class="form-container">
		<input type="hidden" name="visibility" id="form-visibility" value="<?php echo (isset($visibility)) ? $visibility : 1; ?>">
		<input type="hidden" name="optimization" id="form-optimization" value="<?php echo (isset($optimization)) ? $optimization: 1; ?>">
		<input type="submit" style="display:none;">
		<a href="#" id="to-send-form" class="btn btn-main" data-to-authorize="<?php echo ($authenticated) ? "0" : "1"; ?>"><?php echo __("Create list!"); ?></a>

		<div id="settings" hidden>
			<div class="settings-option visibility">
				<div class="supra-option left active" data-value="1">
					<span class="option"><?php echo __("Public List"); ?></span>
					<span class="info"><?php echo __("The list will be available to the public"); ?></span>
				</div>
				<div class="supra-option right" data-value="0">
					<span class="option"><?php echo __("Private List"); ?></span>
					<span class="info"><?php echo __("The list will be available just for you"); ?></span>
				</div>
				<div class="clear"></div>
			</div>

		</div>
		<div class="disabler"></div>
	</div>

</form>
<iframe id="progress" name="progress"></iframe>

<div id="progress-render">
<span id="progress-message" class="">
	<?php if ($authenticated) {
		echo __("*Lists will have a max. number of 1000 users");
	} else {
		echo __("*You'll be redirected to sign in with Twitter<br>[No automatic tweets nor similar shit, promised]");
	} ?>
</span>
<div id="progress-bar"></div>
<div class="clear"></div>
</div>