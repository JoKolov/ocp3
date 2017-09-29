<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Commentaires
 * FILE/ROLE : Fomulaire édition commentaire
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

	<form method="post" action="?module=commentaires&page=ajouter&action=submit">

		<div class="form-group">
			<label for="contenu" class="col-sm-12 control-label">Commentaire</label>
			<div class="col-sm-12"><?= $errors['contenu']; ?></div>
			<div class="col-sm-12">
				<textarea class="form-control" rows="5" placeholder="votre commentaire" name="contenu" id="commentaire"></textarea>
			</div>
			<div class="col-sm-12">
			</div>
		</div>
		<div class="btn-group col-xs-12" role="group" id="commentaire-form-submit">
			<input type="hidden" name="billet_id" value="<?= (isset($billet)) ? $billet->get_id() : 1; ?>" />
			<input type="hidden" name="com_id" value="<?= (isset($com)) ? $com->get_id() : 0; ?>" />
			<input type="hidden" name="com_level" value="<?= (isset($com)) ? $com->get_com_level() : 0; ?>" />
			<input type="hidden" name="auteur_id" value="<?= (isset($membre)) ? $membre->get_id() : 0; ?>" />
			<button type="submit" class="btn btn-primary" name="envoyer" value="envoyer">Envoyer</button>
		</div>

	</form>