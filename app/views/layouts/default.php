<!DOCTYPE html>
<html lang="<?=Config::get('lang');?>" dir="<?=Config::get('dir');?>">
<head>
	<meta charset="<?=Config::get('charset');?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title><?=$this->pageTitle();?></title>
	<?=$this->template('head_links'); ?>
	<?=$this->content('head');?>
</head>
<body class="adminbody">
	<div id="main">
		<?php include 'nav_user.php'; ?>
		<div class="content-page">
			<!-- Start content -->
			<div class="content">
				<div class="container-fluid">
					<?php if(Config::get('breadcrumbs')) : ?>
						<?=$this->template('breadcrumbs');?>
					<?php endif; ?>
					<div class="row">
						<div class="col-xl-12">
							<?=$this->content('body');?>
						</div>
					</div>
				</div> <!-- END container-fluid -->
			</div> <!-- END content -->
		</div> <!-- END content-page -->
		<?php $this->insert('layouts/footer');?>
