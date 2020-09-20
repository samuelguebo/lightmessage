<?php
/*
 * File displaying UI
 * when logged in
 */
?>
<?php require_once '../header.php'; ?>

	  <h1>Akwaba, <?php echo $user->name; ?>. 
	  <a href="./logout" class="btn btn-success btn-logout"><i class="fa fa-sign-out"></i> Logout</a></h1>
	  <p class="lead"><?php echo APP_DESCRIPTION; ?></p>
	<script src="//tools-static.wmflabs.org/cdnjs/ajax/libs/jquery/3.2.1/jquery.slim.min.js"></script>
	<script src="//tools-static.wmflabs.org/cdnjs/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="//tools-static.wmflabs.org/cdnjs/ajax/libs/twitter-bootstrap/4.0.0/js/bootstrap.min.js"></script>

	<script src="public/js/script.js"></script>
<?php require_once '../footer.php';
