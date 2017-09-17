<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la page modification du compte utilisateur
 *
 * File Last Update : 2017 08 17
 *
 * File Description :
 * -> affiche le formulaire de tous les champs du membre
 * -> affiche les éventuelles erreurs si une information $_GET['error'] existe
 */
//------------------------------------------------------------
// HTML
?>
<section>
	<div class="row">
		<div class="col-sm-2">
			<div style="width:100px; height:100px; background-image: url('<?= $var['value']['avatar']; ?>'); background-size: cover; border-radius:5%;" class="">
			</div>
		</div>

		<div class="col-sm-10">
			<h3 class="text-right">Modifier mon compte : <?= $var['value']['pseudo']; ?></h3>

			<?php
			if ($var['error']['success'] <> '') {
			?>
				<div class="alert alert-success" role="alert">
				  <strong><?= $var['error']['success']; ?></strong>
				</div>
			<?php 
			}
			else
			{
				echo $var['error']['success'];
			}
			?>
		</div>
	</div>	
	


	<form method="post" action="?module=membres&page=modification&action=submit" enctype="multipart/form-data" class="form-horizontal">
		<div class="form-group">
			<label for="avatar" class="col-sm-2 control-label">Avatar</label>
			<div class="col-sm-10">
				<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
				<input type="file" class="form-control" placeholder="votre image" name="avatar" id="avatar">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['avatar']; ?>
				<?= $var['error']['avatar.upload']; ?>
				<?= $var['error']['avatar.source']; ?>
				<?= $var['error']['avatar.format']; ?>
				<?= $var['error']['avatar.sqlupdate']; ?>
				<?= $var['error']['avatar.sqlinsert']; ?>
				<?= $var['error']['avatar.sql']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="pseudo" class="col-sm-2 control-label">Pseudo</label>
			<div class="col-sm-10">
				<input type="text" class="form-control col-xs-12 col-sm-8" placeholder="mon pseudo" name="pseudo" id="pseudo" value="<?= $var['value']['pseudo']; ?>">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['pseudo']; ?>
				<?= $var['error']['pseudo.req']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="nom" class="col-sm-2 control-label">Nom</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" placeholder="mon nom" name="nom" id="nom" value="<?= $var['value']['nom']; ?>">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['nom']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="prenom" class="col-sm-2 control-label">Prénom</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" placeholder="mon prenom" name="prenom" id="prenom"  value="<?= $var['value']['prenom']; ?>">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['prenom']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="date_birth" class="col-sm-2 control-label">Date de Naissance</label>
			<div class="col-sm-10">
				<input type="date" class="form-control" placeholder="" name="date_birth" id="date_birth"  value="<?= $var['value']['pdate_birth']; ?>">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['date_birth']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="email" class="col-sm-2 control-label">Adresse Email</label>
			<div class="col-sm-10">
				<input type="email" class="form-control" placeholder="mon adresse email" name="email" id="email"  value="<?= $var['value']['email']; ?>">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['email']; ?>
				<?= $var['error']['email.req']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="col-sm-2 control-label">Mot de passe</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" placeholder="mon nouveau mot de passe" name="password" id="password">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['password']; ?>
				<?= $var['error']['password.req']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="passwordconf" class="col-sm-2 control-label">Confirmation du Mot de passe</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" placeholder="je confirme mon nouveau mot de passe" name="passwordconf" id="passwordconf">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['passwordconf']; ?>
				<?= $var['error']['passwordconf.req']; ?>
			</div>
		</div>

		<div class="text-center">
			<button type="submit" class="btn btn-primary btn-block">Modifier</button>
			<a href="index.php?module=membres&page=compte" class="btn btn-default btn-block">Retour au compte <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
		</div>
	</form>
</section>