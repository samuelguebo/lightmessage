<?php
/**
 * UI for creating a batch
 */

 require_once '../header.php';?>
 
 <div class="row">

		<form action="/batch/create" method="post" class="col-md-6">
				<div class="form-group">
					<label for="wiki">Title of batch</label>
					<input type="text" class="form-control" name="title" placeholder="Wikitech newsletter (Spanish)">
				</div>
				<div class="form-group">
						<textarea name="wikicode" class="form-control" rows="5" cols="80" style="display:none" ></textarea>
				</div>


				<!-- Diffs -->
			{% if diffs %}
			<div class="list-group">
			  <a href="#" class="list-group-item active">Latest diff</a>
				{% for diff in diffs %}
					<p class="list-group-item">
						<a href="https://meta.wikimedia.org/wiki/Special:Diff/{{diff.revid}}">{{diff.revid}}</a> by {{diff.user}} // {{diff.comment}}
					</p>
				{% endfor %}
			</div>
			{% endif %}
			<br>
			<button type="submit" class="btn btn-primary mb-2">Generate</button>
			<a class="btn btn-danger mb-2" href="{{noticeboard_url}}" target="_blank"><i class="fa fa-edit"></i> Edit page</a>
			
		</form>



	</div>
 <?php
 require_once '../footer.php';
