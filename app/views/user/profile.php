<?php $this->setPageTitle(t('bank_new_account_title')); ?>
<?php
	use CodiceFiscale\Calculator;
	use CodiceFiscale\Subject;
?>
<?php $this->start('head'); ?>
<script type="text/javascript" src="<?=base_url('assets/js/oneClickEdit.js');?>"></script>
<?php $this->end(); ?>

<?php $this->start('body'); ?>
<?php $user = Users::currentUser(); ?>

<div class="container bootstrap snippet">

	<div class="row"><div class="col-sm-10"><h1><?=$user->first_name.' '.$user->last_name;?></h1></div></div>
	<div class="row">
		<div class="col-sm-12">
			<ul class="nav nav-pills mb-4" id="profileTabs" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="idcard-tab" data-toggle="tab" href="#idcard" role="tab" aria-controls="idcard" aria-selected="true"><?=t('lbl_idcard');?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="contacts-tab" data-toggle="tab" href="#contacts" role="tab" aria-controls="contacts" aria-selected="false"><?=t('lbl_contacts');?></a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="other-tab" data-toggle="tab" href="#other" role="tab" aria-controls="other" aria-selected="false">Other</a>
				</li>
			</ul>
			<div class="tab-content" id="profileTabsContent">
				<div class="tab-pane fade show active" id="idcard" role="tabpanel" aria-labelledby="idcard-tab">
					<div class="row">
						<div class="col-md-2">
							<img src="<?=base_url('public/images/profile/'.Users::currentUser()->profile_image);?>" class="img-fluid" alt="<?=Users::displayName();?>">
						</div>
						<div class="col-6">
							<table class="table table-condensed table-hover">
								<tr><td><?=t('lbl_name');?></td><td colspan=2><strong><?=$user->last_name.' '.$user->first_name;?></strong></td>
									<td><?=t('lbl_gender');?> <strong><?=$user->gender;?></strong></td>
								</tr>
								<tr><td colspan=2><?=t('lbl_address');?></td><td><strong><?=$user->address;?><br/>
									<?=$user->address_city;?></strong></td>
									<td>Donatore <strong>O/B</strong></td>
								</tr>
								<tr><td colspan=2><?=t('lbl_birthdate');?></td><td><strong>ATH: <?=Anthal::date('Y.m/d',$user->birth_date);?><br/>
									TER: <?=date('Y. m/d',$user->birth_date);?></strong></td>
									<td>Blood Group: <strong>AB+</strong></td>
								</tr>
								<tr>
									<td colspan=2><?=t('lbl_uuid');?></td><td colspan=2><?=getUUID($user->first_name,$user->last_name,Anthal::date('Y-m-d',$user->birth_date),$user->gender,'A101');?></td>
								</tr>
							</table>
						</div>
					</div>
				</div>

				<div class="tab-pane fade" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
					<div class="col-8">
						<table class="table table-condensed table-hover">
							<tr><td colspan=2><?=t('lbl_homephone');?></td><td colspan=2><strong><?=$user->home_phone;?></strong></td></tr>
							<tr><td colspan=2><?=t('lbl_cellphone');?></td><td colspan=2><strong><?=$user->cell_phone;?></strong></td></tr>
							<tr><td colspan=2><?=t('lbl_workphone');?></td><td colspan=2><strong><?=$user->work_phone;?></strong></td></tr>
							<tr><td colspan=2><?=t('lbl_email');?></td><td colspan=2><?=$user->email;?></td>
							</tr>
						</table>
					</div>
				</div>

				<div class="tab-pane fade" id="other" role="tabpanel" aria-labelledby="other-tab">
					<h2>Other</h2>
					...
				</div>
			</div>
		</div>
	</div><!--/col-9-->
</div><!--/row-->
<?php
function getUUID($fn,$ln,$bd,$g,$d) {
	$subject = new Subject([
	    "name" => $fn,
	    "surname" => $ln,
	    "birthDate" => $bd,
	    "gender" => $g,
	    "belfioreCode" => $d
	]);

	$calculator = new Calculator($subject);
	return $calculator->calculate();
}
?>
<script type="text/javascript">
function oneClickSuccess(resp) {
	var r = JSON.parse(resp);
	if(r.success){
		alert("Data updated");
	} else {
		alert("Something went wrong");
	}
}
$('.oneClickEdit').oneClickEdit({
	url:'/user/parser',
	data:{table:'users'}
},oneClickSuccess);

function callBack(){
	alert("callback");
}
</script>
<?php $this->end(); ?>
