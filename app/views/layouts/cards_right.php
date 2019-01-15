<?php if(Users::currentUser()) : ?>
<div class="card gedf-card">
	<div class="card-body">
		<h5 class="card-title">People you may know</h5>
		<h6 class="card-subtitle mb-2 text-muted"></h6>
		<p class="card-text"></p>
		<?php
		$uSql = 'SELECT * FROM users WHERE id != 1 AND id != '.Users::currentUser()->id.' ORDER BY rand() LIMIT 5';
		$users = DB::getInstance()->query($uSql)->results();
		foreach($users as $user) : ?>
			<div class="media text-muted pt-3">
		  	<img data-src="http://lorempixel.com/30/30/" alt="" class="mr-2 rounded">
		  	<div class="media-body pb-3 mb-0 small lh-125 border-bottom border-gray">
		  	  <div class="d-flex justify-content-between align-items-center w-100">
		  		<strong class="text-gray-dark"><?=$user->first_name.' '.$user->last_name;?></strong>

		  	  </div>
		  	  <span class="d-block">@<?=$user->username;?>
				  <?php
				  // if($)
				  ?>
				  <a class="pull-right mr-2 btn btn-sm btn-primary" href="#">Follow</a></span>
		  	</div>
		    </div>
		<?php endforeach; ?>
		<div class="my-3 p-3 bg-white rounded shadow-sm">
			<small class="d-block text-right">
				<a href="#">All suggestions</a>
			</small>
		</div>
	</div>
</div>
<?php endif; ?>
