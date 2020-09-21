<?php
/*
 * File displaying UI
 * when logged in
 */
?>
<?php require_once VIEW_DIR . '/header.php'; ?>
	
	<h1>Akwaba, <?php echo $user; ?>.</h1>
	<p class="lead"><?php echo APP_DESCRIPTION; ?></p>
	<hr>
	<section class="batches">
		<?php if ( !empty( $batches ) ) {?>
			<h5 class="title">Current list of batches (<?php echo count( $batches ) ?>)</h5>
			<table id="batches-table" class="table table-striped sortable">
			<tbody>
				<?php foreach ( $batches as $batch ) {?>
					<tr>
						<td><a href="/batch/view/<?php echo $batch['_id']?>"><?php echo $batch['title']?></a> </td>
					</tr>
				<?php }  ?>
				</tbody>
			</table>
		
		<?php } else { ?>
			<div class="alert alert-warning" role="alert">
				There seems to be no batches yet. You can go ahead and <a href="/batch/create">create one now</a>.
			</div>
		<?php } ?>
	</section>

	<script src="public/js/script.js"></script>
<?php require_once VIEW_DIR . '/footer.php';
