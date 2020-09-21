<?php
/**
 * UI for creating a batch
 */
require_once ROOT . '/src/Views/header.php';?>
 
 <section class="batch">
	<h3><?php echo $batch['title'];?> <a href="/batch/update/<?php echo $batch['_id']?>" class="btn btn-warning btn-sm btn-update"><i class="fa fa-edit"></i> Edit</a></h3>
	<div class="card">
		<div class="card-body">
		<span class="badge badge-success">content</span>
		<h4><strong><?php echo $batch['subject'];?></strong> </h4>
		<?php echo $batch['body'];?>
		</div>
	</div>
</section>
<section class="messages">
	<?php if ( !empty( $messages ) ) {?>
		<table id="messagees-table" class="table table-striped sortable">
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
				<tr>
					<td><?php echo $message['page']?></td>
					<td><?php echo $message['wiki']?></td>
					<td><?php echo $message['status'] === true ? "delivered" : "pending"; ?></td>
				</tr>
			<?php }  ?>
			</tbody>
		</table>
	
	<?php } else { ?>
		<div class="alert alert-warning" role="alert">
			There seems to be no messages yet.
		</div>
	<?php } ?>
</section>

<!-- floating button -->
<div class="sendButton"><i class="fa fa-paper-plane"></i></div>

 <?php
require_once ROOT . '/src/Views/footer.php';