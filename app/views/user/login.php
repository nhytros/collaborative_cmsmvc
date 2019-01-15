<?php $this->setPageTitle(t('login_title')); ?>
<?php $this->start('body'); ?>
<div class="col-sm-9 col-md-7 col-lg-5 mx-auto">
	<div class="card card-signin my-5">
		<div class="card-body">
			<h4 class="card-title text-center"><?=t('login_title');?></h4><hr>
			<?=Form::open('user/login',['name'=>'loginForm','class'=>'form-signin']);?>
			<?=Form::displayErrors($this->displayErrors);?>
			<?=Form::input(['placeholder'=>t('lbl_username'),'name'=>'username','class'=>'form-control','tab-stop'=>'1'],($_POST)?$this->login->username:'','autofocus');?>
			<?=Form::password(['placeholder'=>t('lbl_password'),'name'=>'password','class'=>'form-control','tab-stop'=>'2'],'');?>
			<?=Form::checkbox(['name'=>'remember_me','value'=>'on','checked'=>true,'class'=>'custom-checkbox mb-3','tab-stop'=>'3']);?>&nbsp;<?=t('cbox_pass');?><hr>
			<?=Form::submit(['name'=>'login','class'=>'btn btn-lg btn-primary btn-block text-uppercase','tab-stop'=>'4'],t('login_title'),'',1,0);?>
			<a class="d-block text-center mt-2 small" href="/user/register"><?=t('lbl_register');?></a>
			<?=Form::close();?>
		</div>
	</div>
</div>
<?php $this->template('modals/athTime'); ?>
<?php $this->end(); ?>
