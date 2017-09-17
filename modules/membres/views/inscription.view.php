<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de l'inscription
 *
 * File Last Update : 2017 09 13
 *
 * File Description :
 * -> affiche le formulaire d'inscription
 * -> affiche les éventuelles erreurs si une information $_GET['error'] existe
 */

//------------------------------------------------------------
// HTML
?>


<section>

	<div class="row">
		<div class="col-sm-12">
			<h3>Inscription</h3>
			<?= $var['error']['error']; ?>
			<?= $var['error']['sql']; ?>
		</div>
	</div>

	<form method="post" action="?module=membres&page=inscription&action=submit" class="form-horizontal">
	
		<div class="form-group">
			<label for="pseudo" class="col-sm-2 control-label">Pseudo</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" placeholder="au moins 4 caractères alphanumeriques sans espace, - et _ tolérés" name="pseudo" id="pseudo" value="">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['pseudo']; ?>
			</div>
		</div>
	
		<div class="form-group">
			<label for="email" class="col-sm-2 control-label">Adresse Email</label>
			<div class="col-sm-10">
				<input type="email" class="form-control" placeholder="monemail@mondomaine.fr" name="email" id="email" value="">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['email']; ?>
			</div>
		</div>

		<div class="form-group">
			<label for="password" class="col-sm-2 control-label">Mot de passe</label>
			<div class="col-sm-10">
				<input type="password" class="form-control" placeholder="au moins 8 caractères dont au moins 1 chiffre" name="password" id="password">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['password']; ?>
			</div>
		</div>

		<div class="">
			<button type="submit" class="btn btn-primary btn-block">Inscription</button>
			<a href="index.php?module=membres&page=connexion" class="btn btn-default btn-block">Se connecter <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
		</div>
			
	</form>

</section>