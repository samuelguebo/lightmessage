<?php
/*
 * File displaying UI
 * when an error occured
 */
?>
<?php require_once VIEW_DIR . '/header.php';?>

	<h1 class="mt-5"><?php echo APP_NAME; ?></h1>
	<p class="lead"><?php echo APP_SLOGAN; ?></p>
	<hr>
	<p class="tou-description alert alert-warning"><?php echo $error?></p>

<?php require_once VIEW_DIR . '/footer.php';
