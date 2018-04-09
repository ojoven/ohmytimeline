
<section class="hero">

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

</section>

<!-- MAIN CONTENT -->
<main id="main-container">

	<!-- CTA -->
	<section class="cta">

		<!-- CONTENT -->

		<!-- AUTHENTICATED -->
		<?php if ($authenticated) { ?>

			<div class="to-send-form-container">

				<a href="#" id="to-send-form" class="btn btn-main"><?php echo __("Bring back my Twitter TL!"); ?></a>

				<form id="main-form" action="<?php echo Router::url("/api/createlist"); ?>" method="post" target="progress">

					<div class="form-container">
						<input id="follow-input" type="hidden" name="follow" value="1" />
						<input type="submit" style="display:none;">
					</div>

				</form>
			</div>

			<iframe id="progress" name="progress"></iframe>

			<div id="progress-render">
				<span id="progress-message"></span>
				<div id="progress-bar"></div>
				<div class="clear"></div>
			</div>

			<a href="#" id="to-see-timeline" class="btn btn-main"><?php echo __("See my timeline!"); ?></a>

		<?php } else { ?>

			<!-- NO AUTHENTICATED -->
			<a href="#" id="to-send-form" class="btn btn-main"><?php echo __("Bring back my Twitter TL!"); ?></a>

			<form id="main-form" action="<?php echo Router::url("/api/authorize"); ?>" method="post">

				<div class="form-container">
					<input id="follow-input" type="hidden" name="follow" value="1" />
					<input type="submit" style="display:none;">
				</div>

			</form>
		<?php }?>

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
					<p><?php echo __("For delicious tweets about side projects,<br>creativeness, UX, MEMEs...and <span class='highlighted'>to let me know<br> how Oh My Timeline! works for you!</span>"); ?></p>
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