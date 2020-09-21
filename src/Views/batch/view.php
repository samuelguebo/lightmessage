<?php
/**
 * UI for creating a batch
 */
require_once ROOT . '/src/Views/header.php';?>
 
 <section class="batch">
	<h1><?php echo $batch['title'];?></h1>
	<h4><strong>Subject:</strong> <?php echo $batch['subject'];?> <a href="/batch/edit/<?php echo $batch['_id']?>" class="btn btn-warning btn-sm btn-update"><i class="fa fa-edit"></i> Update</a></h4>
	<hr>
</section>
<section class="messages">
	<?php if ( !empty( $messages ) ) {?>
		<h5 class="title">Current list of messagees (<?php echo count( $messages ) ?>)</h5>
		<table id="messagees-table" class="table table-striped sortable">
		<tbody>
			<?php foreach ( $messages as $message ) {?>
				<tr>
					<td><a href="/message/view/<?php echo $message['_id']?>"><?php echo $message['title']?></a> </td>
				</tr>
			<?php }  ?>
			</tbody>
		</table>
	
	<?php } else { ?>
		<div class="alert alert-warning" role="alert">
			There seems to be no messages yet./a>.
		</div>
	<?php } ?>
</section>
 <?php
require_once ROOT . '/src/Views/footer.php';