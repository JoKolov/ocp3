<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Vue de l'inscription
 *
 * File Last Update : 2017 08 30
 *
 * File Description :
 * -> affiche le formulaire d'édition d'un nouveau billet
 * -> affiche les éventuelles erreurs si une information $_GET['error'] existe
 */

//------------------------------------------------------------
// Protocoles de sécurités
user_connected_only();
admin_only();


//------------------------------------------------------------
// Génération des valeurs à afficher
set_view_var();
$var = $_SESSION['view_var'];
if (isset($_GET['id']))
{
	$var['value']['id'] = $_GET['id'];
}
else
{
	$var['value']['id'] = "";
}



//------------------------------------------------------------
// HTML
?>


<section>

	<div class="row">
		<div class="col-sm-12">
			<h3>Editeur de billet</h3>

			<?php
				/**
				 * Affichage de la confirmation d'enregistrement
				 */
				if ($var['success']['1'] <> '')
				{
			?>
				<div class="alert alert-success" role="alert">
				  <strong><?= $var['success']['1']; ?></strong>
				</div>
			<?php 
				}

				/**
				 * Affichage des erreurs
				 */
				if (isset($var['error']))
				{
				 	echo $var['error']['error'];
				}
			?>
		</div>
	</div>

	<form method="post" action="?module=billets&action=enregistrer">
	
		<div class="form-group">
			<label for="titre" class="col-sm-12 control-label"><?= $var['label']['titre']; ?></label>
			<div class="col-sm-12">
				<input type="text" class="form-control" placeholder="<?= $var['placeholder']['titre']; ?>" name="titre" id="titre" value="<?= $_SESSION['billet']['edition']['titre']; ?>">
			</div>
			<div class="col-sm-12">
				<?= $var['error']['titre']; ?>
			</div>
		</div>
		<p>&nbsp;</p>
		<div class="form-group">
			<label for="contenu" class="col-sm-12 control-label"><?= $var['label']['contenu']; ?></label>
			<div class="col-sm-12"><?= $var['error']['contenu']; ?></div>
			<div class="col-sm-12">
				<textarea class="form-control" rows="20" placeholder="<?= $var['placeholder']['contenu']; ?>" name="contenu" id="contenu"><?= $_SESSION['billet']['edition']['contenu']; ?></textarea>
			</div>
			<div class="col-sm-12">
			</div>
		</div>
		<p>&nbsp;</p>
		<div class="form-group">
			<label for="extrait" class="col-sm-12 control-label"><?= $var['label']['extrait']; ?></label>
			<div class="col-sm-12">
				<textarea class="form-control" rows="3" placeholder="<?= $var['placeholder']['extrait']; ?>" name="extrait" id="extrait"><?= $_SESSION['billet']['edition']['extrait']; ?></textarea>
			</div>
			<div class="col-sm-12">
				<?= $var['error']['extrait']; ?>
			</div>
		</div>
		<p>&nbsp;</p>
		<div class="btn-group col-xs-12" role="group" id="billet-menu-edit-nonactive">
			<input type="hidden" name="id" value="<?= $var['value']['id'] ?>" />
			<button type="submit" class="btn btn-primary col-xs-6" name="sauvegarder" value="sauvegarder">Sauvegarder</button>
			<button type="submit" class="btn btn-warning col-xs-6" name="publier" value="publier"><strong>Publier</strong></button>
		</div>
			
	</form>

</section>