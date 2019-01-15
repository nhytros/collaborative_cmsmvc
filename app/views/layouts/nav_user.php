<!-- top bar navigation -->
<div class="headerbar">
	<!-- LOGO -->
	<div class="headerbar-left">
		<a href="<?=config('site_url');?>" class="logo"><img alt="logo" class="img-fluid" src="/public/images/logo.png" /> <span><?=config('site_name');?></span></a>
	</div>
	<nav class="navbar-custom">
		<ul class="list-inline float-right mb-0">
			<?php if(Users::currentUser()): ?>
				<li class="list-inline-item dropdown notif">
					<a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
						<i class="fa fa-fw fa-question-circle"></i>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-arrow-success dropdown-lg">
						<!-- item-->
						<div class="dropdown-item noti-title">
							<h5><small>Help and Support</small></h5>
						</div>
						<!-- item-->
						<a target="_blank" href="https://www.pikeadmin.com" class="dropdown-item notify-item">
							<p class="notify-details ml-0">
								<b>Do you want custom development to integrate this theme?</b>
								<span>Contact Us</span>
							</p>
						</a>
						<!-- item-->
						<a target="_blank" href="#0" class="dropdown-item notify-item">
							<p class="notify-details ml-0">
								<b>Lorem ipsum</b>
								<span>Lorem</span>
							</p>
						</a>
						<!-- All-->
						<a title="Lorem ipsum" target="_blank" href="#0" class="dropdown-item notify-item notify-all">
							<i class="fa fa-link"></i> Lorem ipsum
						</a>
					</div>
				</li>
				<li class="list-inline-item dropdown notif">
					<a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
						<i class="fa fa-fw fa-envelope-o"></i><span class="notif-bullet"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-arrow-success dropdown-lg">
						<!-- item-->
						<div class="dropdown-item noti-title">
							<h5><small><span class="label label-danger pull-xs-right">12</span>Contact Messages</small></h5>
						</div>

						<!-- item-->
						<a href="#" class="dropdown-item notify-item">
							<p class="notify-details ml-0">
								<b>John Doe</b>
								<span>New message received</span>
								<small class="text-muted">2 minutes ago</small>
							</p>
						</a>
						<!-- item-->
						<a href="#" class="dropdown-item notify-item">
							<p class="notify-details ml-0">
								<b>Jane Doe</b>
								<span>New message received</span>
								<small class="text-muted">15 minutes ago</small>
							</p>
						</a>
						<!-- item-->
						<a href="#" class="dropdown-item notify-item">
							<p class="notify-details ml-0">
								<b>J.J.</b>
								<span>New message received</span>
								<small class="text-muted">Yesterday, 14:36</small>
							</p>
						</a>
						<!-- All-->
						<a href="#" class="dropdown-item notify-item notify-all">
							View All
						</a>

					</div>
				</li>
				<li class="list-inline-item dropdown notif">
					<a class="nav-link dropdown-toggle arrow-none" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
						<i class="fa fa-fw fa-bell-o"></i><span class="notif-bullet"></span>
					</a>
					<div class="dropdown-menu dropdown-menu-right dropdown-arrow dropdown-lg">
						<!-- item-->
						<div class="dropdown-item noti-title">
							<h5><small><span class="label label-danger pull-xs-right">5</span>Alerts</small></h5>
						</div>
						<!-- item-->
						<a href="#" class="dropdown-item notify-item">
							<div class="notify-icon bg-faded">
								<img src="assets/images/avatars/avatar2.png" alt="img" class="rounded-circle img-fluid">
							</div>
							<p class="notify-details">
								<b>John Doe</b>
								<span>User registration</span>
								<small class="text-muted">3 minutes ago</small>
							</p>
						</a>

						<!-- item-->
						<a href="#" class="dropdown-item notify-item">
							<div class="notify-icon bg-faded">
								<img src="assets/images/avatars/avatar3.png" alt="img" class="rounded-circle img-fluid">
							</div>
							<p class="notify-details">
								<b>Jane Dow</b>
								<span>Task 2 completed</span>
								<small class="text-muted">12 minutes ago</small>
							</p>
						</a>
						<!-- item-->
						<a href="#" class="dropdown-item notify-item">
							<div class="notify-icon bg-faded">
								<img src="assets/images/avatars/avatar4.png" alt="img" class="rounded-circle img-fluid">
							</div>
							<p class="notify-details">
								<b>Michael Smith</b>
								<span>New job completed</span>
								<small class="text-muted">35 minutes ago</small>
							</p>
						</a>
						<!-- All-->
						<a href="#" class="dropdown-item notify-item notify-all">
							View All Allerts
						</a>
					</div>
				</li>
				<li class="list-inline-item dropdown">
					<a class="nav-link dropdown-toggle nav-user" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
						<img src="<?=base_url('public/images/profile/'.Users::currentUser()->profile_image);?>" class="img-fluid avatar-rounded" alt="<?=Users::displayName();?>">
						<?=Users::currentUser()->username;?>
					</a>
					<div class="dropdown-menu dropdown-menu-right profile-dropdown">
						<!-- item-->
						<div class="dropdown-item noti-title">
							<h5 class="text-overflow"><small><?=t('hello');?>, <?=Users::currentUser()->first_name;?></small> </h5>
						</div>
						<a class="dropdown-item" href="<?=base_url('user/profile');?>"><?=getIcon('fa,user');?> <?=t('id_card');?></a>
						<div class="dropdown-divider"></div>
						<a href="#" class="dropdown-item">
							<a class="dropdown-item" href="<?=base_url('user/logout');?>"><?=getIcon('fa,sign-out');?> <span><?=t('logout');?></span></a>
						</a>
					</div>
				</li>
			<?php else: ?>
				<li class="list-inline-item">
					<a class="nav-item text-white" href="<?=base_url('user/register');?>"><?=getIcon('fa,user-plus');?> <?=t('register');?></a>
				</li>
				<li class="list-inline-item">
					<a class="nav-item text-white" href="<?=base_url('user/login');?>"><?=getIcon('fa,sign-in');?> <?=t('login');?></a>
				</li>
			<?php endif; ?>
		</ul>
		<ul class="list-inline menu-left mb-0">
			<li class="float-left">
				<button class="button-menu-mobile open-left">
					<i class="fa fa-fw fa-bars"></i>
				</button>
			</li>
		</ul>
	</nav>
</div>
<!-- End Navigation -->
