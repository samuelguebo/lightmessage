<?php
/**
 * UI for creating a batch
 */

 require_once ROOT . '/src/Views/header.php';?>
 
 <div class="row">

		<form action="/batch/save" method="post" class="col-md-12">
				<!-- Title -->
				<div class="form-group">
					<label for="wiki">Title of batch</label>
					<input type="text" class="form-control" name="title" placeholder="Wikitech newsletter (Spanish)">
				</div>

				<!-- Wikicode -->
				<div class="form-group">
					<textarea name="wikicode" class="form-control" rows="5" cols="80" placeholder="Insert recipient list as wikicode"></textarea>
				</div>
				
				<!-- Subject -->
				<div class="form-group">
					<label for="wiki">Message subject</label>
					<input type="text" class="form-control" name="subject" placeholder="Hello Jane Doe">
				</div>

				<!-- Body -->
				<div class="form-group">
					<textarea name="body" class="form-control" rows="5" cols="80" placeholder="Insert message body here"></textarea>
				</div>

			<br>
			<button type="submit" class="btn btn-primary mb-2"><i class="fa fa-save"></i> Save</button>			
		</form>



	</div>
 <?php
require_once ROOT . '/src/Views/footer.php';