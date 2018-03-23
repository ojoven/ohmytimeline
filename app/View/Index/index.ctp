<?php //if ($authenticated) {
	if (0) { ?>
	<form id="main-form" action="<?php echo Router::url("/api/updatelist"); ?>" method="post" target="progress">
	<input type="hidden" name="user_id" value="<?php echo $user['User']['user_id']; ?>">
<?php } else {?>

	<form id="main-form" action="<?php echo Router::url("/api/authorize"); ?>" method="post">
	<?php }?>

	<div class="form-container">
		<input type="submit" style="display:none;">
		<a href="#" id="to-send-form" class="btn btn-main" data-to-authorize="<?php echo ($authenticated) ? "0" : "1"; ?>"><?php echo __("Create list!"); ?></a>

		<div class="disabler"></div>
	</div>

</form>
<iframe id="progress" name="progress"></iframe>

<div id="progress-render">
<span id="progress-message" class="">
	<?php if ($authenticated) {
		echo __("*The list will have a max. number of 5000 users");
	} else {
		echo __("*You'll be redirected to sign in with Twitter<br>[No automatic tweets nor similar shit, promised]");
	} ?>
</span>
<div id="progress-bar"></div>
<div class="clear"></div>
</div>