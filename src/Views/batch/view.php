<?php
/**
 * UI for creating a batch
 */
require_once ROOT . '/src/Views/header.php';?>
 
 <section class="batch">
	<h3><?php echo $batch['title'];?> 
	<a href="/batch/update/<?php echo $batch['_id']?>" class="btn btn-warning btn-sm btn-update"><i class="fa fa-edit"></i> Edit</a>
	<a href="/batch/delete/<?php echo $batch['_id']?>" class="btn btn-danger btn-sm btn-delete"><i class="fa fa-trash"></i> Delete</a>
	</h3>
	<div class="card">
		<div class="card-body">
		<span class="badge badge-success">content</span>
		<h4><strong><?php echo $batch['subject'];?></strong></h4>
		<pre><?php echo $batch['body'];?></pre>
		</div>
	</div>
</section>
<section class="messages">
	<?php if ( !empty( $messages ) ) {?>
		<table id="messages-table" class="table table-striped sortable">
			<thead>
				<tr>
					<!-- <th>#</th> -->
					<th class="sorttable_nosort"><input type="checkbox" id="check-all"></th>
					<th>Page</th>
					<th>Wiki</th>
					<th>Status</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $messages as $message ) {?>
					<?php if ( $message['status'] === true ) {?>
					<tr id="message-<?php echo $message['_id'];?>" class="delivered">
						<td></td>
						<td><a href="https://<?php echo $message['wiki']?>/wiki/<?php echo trim( $message['page'] )?>"><?php echo $message['page']?></a></td>
						<td><?php echo $message['wiki']?></td>
						<td><?php echo "delivered"; ?> <span class="indicator"></span></td>
					</tr>
					<?php } else {?>
					<tr id="message-<?php echo $message['_id'];?>" batchid="<?php echo $batch['_id']?>">
						<td><input type="checkbox" name="<?php echo $message['_id'];?>"></td>
						<td><a href="https://<?php echo trim( $message['wiki'] )?>/wiki/<?php echo $message['page']?>"><?php echo $message['page']?></a></td>
						<td><?php echo $message['wiki']?></td>
						<td><?php echo "pending"; ?> <span class="indicator"></span></td>
					</tr>
					<?php } ?>
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