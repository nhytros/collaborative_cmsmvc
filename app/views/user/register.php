<?php $this->setPageTitle(t('register_title')); ?>
<?php $this->start('body'); ?>
<div class="col-lg-10 col-xl-9 mx-auto">
	<div class="card card-signin flex-row my-5">
		<div class="card-body">
			<h4 class="card-title text-center"><?=t('register_title');?></h4>
			<?=Form::open('',['name'=>'registerForm','class'=>'form-signin']);?>
			<?=Form::displayErrors($this->displayErrors);?>
			<div class="row">
				<div class="form-group col-6">
					<?=Form::input(['placeholder'=>t('lbl_username'),'name'=>'username','class'=>'form-control','tab-stop'=>'1',$this->register->username,'autofocus']);?>
				</div>
				<div class="form-group col-6">
					<?=Form::input(['placeholder'=>t('lbl_email'),'name'=>'email','class'=>'form-control','tab-stop'=>'2'],$this->register->email);?>
				</div>
			</div>
			<div class="row">
				<div class="form-group col-6">
					<?=Form::input(['placeholder'=>t('lbl_firstname'),'name'=>'first_name','class'=>'form-control','tab-stop'=>'3'],$this->register->first_name);?>
				</div>
				<div class="form-group col-6">
					<?=Form::input(['placeholder'=>t('lbl_lastname'),'name'=>'last_name','class'=>'form-control','tab-stop'=>'4'],$this->register->last_name);?>
				</div>
				<div class="form-group col-4">
					<?php
					$options = [
						'username'		=> t('lbl_username'),
						'first_name'	=> t('lbl_firstname'),
						'last_name'		=> t('lbl_lastname'),
						'full_name_fl'	=> t('lbl_fullname_fl'),
						'full_name_lf'	=> t('lbl_fullname_lf'),
					];
					$display_name = ['username'];
					echo t('lbl_public_name');
					echo Form::dropdown(['name'=>'display_name'],$options,'username',['class'=>'form-control here','tab-stop'=>'5']);
					?>
				</div>
				<div class="form-group col-8">
					<?=Form::password(['placeholder'=>t('lbl_password'),'name'=>'password','class'=>'form-control','tab-stop'=>'6'],'');?>
					<?=Form::password(['placeholder'=>t('lbl_confirm_password'),'name'=>'cpassword','class'=>'form-control','tab-stop'=>'7'],$this->register->getConfirm());?>
				</div>

			</div>
			<?=Form::hidden('bio','');?>
			<?=Form::hidden('created_at',time());?>
			<?=Form::hidden('status',1);?>
			<?=Form::hidden('role',2);?>
			<?=Form::hidden('last_login',null);?>
			<?php /* $selected=$this->post['display_name']; ?>
			<select class="form-control here" name="display_name" id="display_name" tab-stop=5>
			<option value="username" <?=($this->post['display_name'] == 'username')?'selected':'';?>>nome utente</option>
			<option value="first_name" <?=($this->post['display_name'] == 'first_name')?'selected':'';?>>Nome</option>
			<option value="last_name" <?=($this->post['display_name'] == 'last_name')?'selected':'';?>>Cognome</option>
			<option value="full_name_fl" <?=($this->post['display_name'] == 'full_name_fl')?'selected':'';?>>Nome Cognome</option>
			<option value="full_name_lf" <?=($this->post['display_name'] == 'full_name_lf')?'selected':'';?>>Cognome Nome</option>
			</select>
			<label for="display_name" class="col-form-label">Nome pubblico</label>
			</div>
			*/ ?>
			<hr>
			<div class="row">
				<?=Form::submit(['name'=>'register','class'=>'btn btn-lg btn-primary btn-block text-uppercase','tab-stop'=>'8'],t('btn_confirm_registration'),'',1,0);?>
			</div>
			<a class="d-block text-center mt-2 small" href="/user/login"><?=t('login');?></a>
			<hr class="my-4">
			<?=Form::close();?>
		</div>
	</div>
</div>
<?php $this->end(); ?>
