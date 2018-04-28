
<section class="hero">

	<h2 class="big-description">
		<?php echo __("Bring back your <br class='just-mobile'>Twitter Timeline."); ?>
	</h2>

	<div class="little-description">

		<h3>
			<?php echo __("Oh My Timeline! is a simple app that creates a Twitter list with the people you follow and keeps it synchronized. Browsing it is like browsing your timeline with..."); ?>
		</h3>
		<div class="additional-info" style="display:none;">
			<div class='tooltip'>
				Don't like or use lists?<br>
				No worries, with a direct access in the home screen it feels like your real Timeline!
			</div>
			<div class="arrow">
				<div class="curve"></div>
				<div class="point"></div>
			</div>
		</div>
	</div>

	<ul class="main-features fa-ul">
		<li><span class="fa-li"><i class="fas fa-check"></i></span><?php echo __("No ads"); ?></li>
		<li><span class="fa-li"><i class="fas fa-check"></i></span><?php echo __("No faved tweets from people you follow"); ?></li>
		<li><span class="fa-li"><i class="fas fa-check"></i></span><?php echo __("No \"you may have missed\" tweets"); ?></li>
		<li><span class="fa-li"><i class="fas fa-check"></i></span><?php echo __("Only the tweets you ❤ sorted in real time"); ?></li>
		<!--<li><span class="fa-li"><i class="fas fa-check"></i></span><?php echo __("Specially recommended if you use<br>the official Twitter client for Android and iOS"); ?></li>-->
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
			<?php echo __("*You'll be redirected to sign in with Twitter<br>"); ?>
			<?php echo __("[No automatic tweets nor spam, just one thing*]"); ?>
		</div>

	</section>

	<section class="howto">

		<h2><?php echo __("Good! How does this work?"); ?></h2>

		<p>Oh My Timeline! creates automatically <br><b>a list on your Twitter profile with the people you follow:</b></p>

		<img src="<?php echo Router::url("/") ?>img/OMT-follow-to-list-members.jpg" alt="<?php echo __("People you follow -> List members"); ?>"/>

		<p>And so, when browsing the list, <br><b>you'll browse a clean and sorted version of your timeline:</b></p>

		<video controls autoplay loop>
			<source src="<?php echo Router::url("/") ?>img/final.mp4" type="video/mp4">
		</video>

		<p class="little">Cause Twitter lists don't include ads, nor they use any algorithms.<br>Just the tweets from its members sorted in real time.</p>

	</section>


	<section class="reviews">

		<div class="reviews-carousel owl-carousel owl-theme">

			<!-- REVIEW -->
			<div class="review">

				<div class="stars">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
				</div>

				<div class="text">
					<div class="previous">"Ok, let me understand this. What this does is to simply create a list with the people I follow...</div>
					brilliant!"
				</div>

				<div class="from">Guille, basque software developer</div>

			</div>

			<!-- REVIEW -->
			<div class="review">

				<div class="stars">
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
					<i class="fas fa-star"></i>
				</div>

				<div class="text">
					<div class="previous">"I've been testing Oh My Timeline for a few days and I just can say it's amazing! Go checkout and enjoy your TL with</div>
					no ads!"
				</div>

				<div class="from">Iñi, basque software developer</div>

			</div>

			<!-- REVIEW -->
			<div class="review">

				<div class="stars">
					<i class="fas fa-star"></i>
					<i class="far fa-star"></i>
					<i class="far fa-star"></i>
					<i class="far fa-star"></i>
					<i class="far fa-star"></i>
				</div>

				<div class="text">

					<div class="previous">"Ok, if you start using this massively I'll need to put ads and algorithms on Twitter lists, too!</div>
					¯\_(ツ)_/¯
				</div>

				<div class="from">Jack from Twitter <span class="semi-hide">(not real, of course)</span></div>

			</div>

		</div>

	</section>

	<!-- NUMBER OF TIMELINES BROUGHT BACK
	<section class="numbers">

		<div class="main">
			<span class="number">210</span>
			<span class="message"><?php echo __("timelines brought back!"); ?></span>
		</div>

	</section> -->

	<!-- ADDITIONAL INFORMATION -->
	<section class="author">

		<div class="container">

			<div class="avatar-container">
				<img src="<?php echo Router::url("/") ?>img/avatars/avatar_happy_1.jpg" />
				<img src="<?php echo Router::url("/") ?>img/avatars/avatar_happy_1.jpg" />
			</div>

			<div class="follow-container">
				<h3>
					<?php echo __("Hey, this is my side project<br> and I'm <a target='_blank' href='https://twitter.com/lindydeveloper'>@lindydeveloper</a>"); ?>
				</h3>
				<h4>
					<input id="follow" name="follow" type="checkbox" checked />
					<label for="follow"><?php echo __("*Follow me on Twitter"); ?></label>
					<p><?php echo __("For delicious tweets about side projects,<br>creativeness, UX, MEMEs...and to let me know<br> how Oh My Timeline! works for you!"); ?></p>
				</h4>
			</div>

		</div>

	</section>

</main>

<script type="text/javascript">
	fromAuthorized = <?php echo (isset($fromAuthorized) && $fromAuthorized) ? "true" : "false"; ?>;
</script>