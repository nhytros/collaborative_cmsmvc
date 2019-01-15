<div class="card">
	<div class="card-body">
		<img src="<?=base_url('public/images/profile/'.Users::currentUser()->profile_image);?>" class="img-fluid" alt="<?=Users::displayName();?>">
		<div class="h5">@<?=Users::currentUser()->username;?></div>
		<div class="h7 text-muted"><?=Users::displayName();?></div>
		<div class="h7"><?=Users::currentUser()->bio;?>
		</div>
	</div>
	<ul class="list-group list-group-flush">
		<div class="panel panel-default">
			<div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
			<div class="panel-body"><a class="pull-right" href="http://jjnhytros.ath">jjnhytros.ath</a></div>
		</div>

		<li class="list-group-item">
			<div class="h6 text-muted">Cash <span class="pull-right"><small>5000</small></span></div>
		</li>
		<li class="list-group-item">
			<div class="h6 text-muted">Bank <span class="pull-right"><small>800</small></span></div>
		</li>
		<li class="list-group-item">
			<div class="h6 text-muted">Followers <span class="pull-right"><small>1452352</small></span></div>
		</li>
		<li class="list-group-item">
			<div class="h6 text-muted">Following <span class="pull-right"><small>1002</small></span></div>
		</li>
		<li class="list-group-item">
			<div class="h6 text-muted">Shares <span class="pull-right"><small>125488</small></span></div>
		</li>
		<li class="list-group-item">
			<div class="h6 text-muted">Likes <span class="pull-right"><small>13424</small></span></div>
		</li>
		<li class="list-group-item">
			<div class="h6 text-muted">Posts <span class="pull-right"><small>3782</small></span></div>
		</li>
		<li class="list-group-item"><strong>Motto</strong>: <small><em>Ariez Nhytrox</em></small></li>
		<li class="list-group-item">
			<div class="panel panel-default">
				<div class="panel-heading">Social Media</div>
				<div class="panel-body">
					<i class="fa fa-facebook fa-2x"></i> <i class="fa fa-github fa-2x"></i> <i class="fa fa-twitter fa-2x"></i> <i class="fa fa-pinterest fa-2x"></i> <i class="fa fa-google-plus fa-2x"></i>
				</div>
			</div>
		</li>
	</ul>
</div>
