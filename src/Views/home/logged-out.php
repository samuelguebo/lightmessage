<?php
/*
 * File displaying UI
 * when logged out
 */
?>
<?php require_once VIEW_DIR . '/header.php';?>

		<h1 class="mt-5"><?php echo APP_NAME; ?></h1>
		<p class="lead"><?php echo APP_SLOGAN; ?></p>
		<p class="lead">
			<a class="btn btn-primary btn-lg btn-login md-opjjpmhoiojifppkkcdabiobhakljdgm_doc" href="/login"
				role="button"><i class="fa fa-sign-in"></i> Login with Wikimedia</a>
		</p>
		<p class="tou-description">By logging in, you agree to the <a href="https://wikitech.wikimedia.org/wiki/Wikitech:Cloud_Services_Terms_of_use">Wikimedia Cloud Services Terms of Use</a></p>
		<br>
		<br>

	<?php require_once VIEW_DIR . '/footer.php';
