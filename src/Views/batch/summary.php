<?php
/**
 * UI for creating a batch
 */
require_once ROOT . '/src/Views/header.php';?>
 
 <section class="batch">
	<h3>All delivered messages (<?php echo count( $messages );?>)</h3>
</section>
<section class="messages">
	<?php if ( !empty( $messages ) ) {?>
		<table id="messages-table" class="table table-striped sortable">
			<thead>
				<tr>
					<!-- <th>#</th> -->
					<th>Page</th>
					<th>Wiki</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $messages as $message ) {?>
					<tr id="message-<?php echo $message['_id'];?>" batchid="<?php echo $message['batchId']?>">
						<td><a href="https://<?php echo trim( $message['wiki'] )?>/wiki/<?php echo $message['page']?>"><?php echo $message['page']?></a></td>
						<td><?php echo $message['wiki']?></td>
						<td><?php echo $message['status'] === true ? "delivered" : $message['status']; ?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	
	<?php } else { ?>
	<div class="alert alert-warning" role="alert">
		There seems to be no messages yet.
	</div>
	<?php } ?>
</section>

<!-- floating button -->
<div id="sendButton"><i class="fa fa-paper-plane"></i></div>

 <?php
require_once ROOT . '/src/Views/footer.php';