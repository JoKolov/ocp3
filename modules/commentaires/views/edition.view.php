<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Commentaires
 * FILE/ROLE : Edition du commentaire
 *
 * File Last Update : 2017 08 31
 *
 * File Description :
 * -> affiche le formulaire d'édition d'un commetnaire
 * -> affiche les éventuelles erreurs
 */
//------------------------------------------------------------
// HTML
?>

<section>

	<div class="row">
		<div class="col-sm-12">
			<h3>Editeur de Commentaire</h3>

			<?php
				/**
				 * Affichage de la confirmation d'enregistrement
				 */
				if (isset($success))
				{
			?>
				<div class="alert alert-success" role="alert">
				  <strong><?= $success; ?></strong>
				</div>
			<?php 
				}

				/**
				 * Affichage des erreurs
				 */
				if (isset($errors))
				{
				 	echo $errors['error'];
				 	echo $errors['sql'];
				}
			?>
		</div>
	</div>

	<form method="post" action="?module=commentaires&page=admin&action=submit">
	
		<div class="form-group">
			<label for="titre" class="col-sm-12 control-label">Titre</label>
			<div class="col-sm-12">
				<input type="text" class="form-control" placeholder="titre du billet" name="titre" id="titre" value="<?= $billet->get_titre(); ?>">
			</div>
			<div class="col-sm-12">
				<?= $errors['titre']; ?>
			</div>
		</div>
		<p>&nbsp;</p>
		<div class="form-group">
			<label for="contenu" class="col-sm-12 control-label">Texte</label>
			<div class="col-sm-12"><?= $errors['contenu']; ?></div>
			<div class="col-sm-12">
				<textarea class="form-control" rows="20" placeholder="contenu du billet" name="contenu" id="contenu"><?= $billet->get_contenu(); ?></textarea>
			</div>
			<div class="col-sm-12">
			</div>
		</div>
		<p>&nbsp;</p>
		<div class="form-group">
			<label for="extrait" class="col-sm-12 control-label">Extrait</label>
			<div class="col-sm-12">
				<textarea class="form-control" rows="3" placeholder="court extrait du billet ou court résumé attractif" name="extrait" id="extrait"><?= $billet->get_extrait(); ?></textarea>
			</div>
			<div class="col-sm-12">
				<?= $errors['extrait']; ?>
			</div>
		</div>
		<p>&nbsp;</p>
		<div class="form-group">
			<label for="image" class="col-sm-2 control-label">Image</label>
			<div class="col-sm-10">
				<input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
				<input type="file" class="form-control" placeholder="votre image" name="image" id="image">
			</div>
			<div class="col-sm-12">
				<?= $errors['image']; ?>
			</div>
		</div>
		<p>&nbsp;</p>
		<div class="btn-group col-xs-12" role="group" id="billet-menu-edit-nonactive">
			<input type="hidden" name="id" value="<?= $billet->get_id(); ?>" />
			<button type="submit" class="btn btn-primary col-xs-6" name="sauvegarder" value="sauvegarder">Sauvegarder</button>
			<button type="submit" class="btn btn-warning col-xs-6" name="publier" value="publier"><strong>Publier</strong></button>
		</div>
			
	</form>

</section>