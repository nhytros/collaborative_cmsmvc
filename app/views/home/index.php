<?php $this->setPageTitle(t('welcome')); ?>

<?php $this->start('head'); ?>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<h1 class="text-center"><?=t('welcome');?></h1>
<div id="my_carousel" class="carousel slide carousel-fade" data-ride="carousel" data-interval="5319">
	<div class="carousel-inner">
		<div class="carousel-item active">
			<img class="d-block w-100" src="<?=base_url('/public/images/main/citizens.jpg');?>" alt="First slide">
			<div class="carousel-caption d-none d-md-block">
				<div class="row">
					<div class="col-6">
						<ul>
							<li>Registrati come cittadino</li>
							<li>Ottieni un passaporto</li>
							<li>Gira per la città</li>
						</ul>
					</div>
					<div class="col-6">
						<div class="carousel-caption align-items-center">
							<span class="gradient-flag">Diventa cittadino di Anthal</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="carousel-item">
			<img class="d-block w-100" src="<?=base_url('/public/images/main/citizens.jpg');?>" alt="Second slide">
			<div class="carousel-caption d-none d-md-block text-left">
				<h5><a class="text-warning" href="https://www.flickr.com/photos/ittfworld/collections/72157690129937915/">Source Photos:<br>2017<br>World Junior<br>Table Tennis<br>Championships</a></h5>
			</div>
		</div>
		<div class="carousel-item">
			<img class="d-block w-100" src="<?=base_url('/public/images/main/city-2.jpg');?>" alt="Third slide">
			<div class="carousel-caption d-md-block text-center">
				<h1><a class="text-dark" href="#">Trova una casa<br>in affitto<br>o in vendita</a></h1>
			</div>
		</div>
		<div class="carousel-item">
			<img class="d-block w-100" src="<?=base_url('/public/images/main/job.jpg');?>" alt="Third slide">
			<div class="carousel-caption d-none d-md-block">
				<h1><a class="text-danger" href="#">Cerca un lavoro</a></h1>
			</div>
		</div>
	</div>
	<a class="carousel-control-prev" href="#my_carousel" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#my_carousel" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>
	<ol class="carousel-indicators">
		<li data-target="#my_carousel" data-slide-to="0" class="active"></li>
		<li data-target="#my_carousel" data-slide-to="1"></li>
		<li data-target="#my_carousel" data-slide-to="2"></li>
		<li data-target="#my_carousel" data-slide-to="3"></li>
	</ol>
</div>
<div class="alert alert-warning mb-4" role="alert">
	<h2 class="alert-heading">We're hiring!</h2>
	<p>Aliter enim explicari, quod quaeritur, non potest. Cur deinde Metrodori liberos commendas? Inquit, dasne adolescenti veniam?
		Praeteritis, inquit, gaudeo. <a href="#0" class="alert-link">De hominibus dici non necesse est</a>.</p>
	</div>

	<div class="row no-gutters bg-light p-4 mb-4">
		<div class="col-12 col-lg-6 mb-4mb-lg-0">
			<div class="row">
				<div class="col-12 col-sm-6 text-center">
					<img src="http://placehold.it/300x300" class="img-fluid rounded-circle mb-4 mb-lg-0">
				</div>
				<div class="col-12 col-sm-6">
					<h2>What we do</h2>
					<p>Sed nunc, quod agimus; Duo Reges: constructio interrete. Quod ea non occurrentia fingunt, vincunt Aristonem; Ut optime,
						secundum naturam affectum esse possit. Cur iustitia laudatur? Velut ego nunc moveor.</p>
						<button type="button" class="btn btn-lg btn-primary">Read more</button>
					</div>
				</div>
			</div>
			<div class="col-12 col-lg-6">
				<div class="row">
					<div class="col-12 col-sm-6 text-center">
						<img src="http://placehold.it/300x300" class="img-fluid rounded-circle mb-4 mb-lg-0">
					</div>
					<div class="col-12 col-sm-6">
						<h2>What we do</h2>
						<p>Sed nunc, quod agimus; Duo Reges: constructio interrete. Quod ea non occurrentia fingunt, vincunt Aristonem; Ut optime,
							secundum naturam affectum esse possit. Cur iustitia laudatur? Velut ego nunc moveor.</p>
							<button type="button" class="btn btn-lg btn-primary">Read more</button>
						</div>
					</div>
				</div>
			</div>

			<div class="row mb-4">
				<div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-3">
					<div class="card">
						<div class="card-header small">Published: <?=date('Y. d/m',rand(1514764800,1546898897));?></div>
						<div class="card-body">
							<h2 class="card-title">News item</h2>
							<p class="card-text">Comprehensum, quod cognitum non habet? Age, inquies, ista parva sunt. Bonum incolumis acies: misera caecitas. Falli igitur possumus.</p>
						</div>
						<div class="card-footer">
							<a href="#0" class="btn btn-block btn-primary">read more</a>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-3">
					<div class="card">
						<div class="card-header small">Published: <?=date('Y. d/m',rand(1514764800,1546898897));?></div>
						<div class="card-body">
							<h2 class="card-title">News item</h2>
							<p class="card-text">Comprehensum, quod cognitum non habet? Age, inquies, ista parva sunt. Bonum incolumis acies: misera caecitas. Falli igitur possumus.</p>
						</div>
						<div class="card-footer">
							<a href="#0" class="btn btn-block btn-primary">read more</a>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-3">
					<div class="card">
						<div class="card-header small">Published: <?=date('Y. d/m',rand(1514764800,1546898897));?></div>
						<div class="card-body">
							<h2 class="card-title">News item</h2>
							<p class="card-text">Comprehensum, quod cognitum non habet? Age, inquies, ista parva sunt. Bonum incolumis acies: misera caecitas. Falli igitur possumus.</p>
						</div>
						<div class="card-footer">
							<a href="#0" class="btn btn-block btn-primary">read more</a>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-lg-6 col-xl-3 mb-3">
					<div class="card">
						<div class="card-header small">Published: <?=date('Y. d/m',rand(1514764800,1546898897));?></div>
						<div class="card-body">
							<h2 class="card-title">News item</h2>
							<p class="card-text">Comprehensum, quod cognitum non habet? Age, inquies, ista parva sunt. Bonum incolumis acies: misera caecitas. Falli igitur possumus.</p>
						</div>
						<div class="card-footer">
							<a href="#0" class="btn btn-block btn-primary">read more</a>
						</div>
					</div>
				</div>
			</div>

			<?php $this->end(); ?>
