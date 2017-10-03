<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Vue d'un billet
 *
 * File Last Update : 2017 09 22
 *
 * File Description :
 * -> affiche un billet
 */
//------------------------------------------------------------
// HTML
?>

<section>

	<!-- AFFICHAGE DU BILLET -->
	<h6 class="text-right">Publié le <?= $billet->get_date_modif(); ?></h6>
	<?php if (!is_null($imageBillet)) : ?>
		<img src="<?= $imageBillet->get_billet(); ?>" class="img-responsive" alt="Responsive image" />
	<?php endif; ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3><?= $billet->get_titre(); ?></h3>
		</div>
		<div class="panel-body"><?= $billet->get_contenu(); ?></div>
		<div class="panel-footer text-center">
			<?= (is_null($auteur->get_prenom()) OR is_null($auteur->get_nom())) ? $auteur->get_pseudo() : $auteur->get_prenom() . ' ' . $auteur->get_nom(); ?>
		</div>
	</div>

	<p>&nbsp;</p>


	<!-- BLOC INFO COMMENTAIRE -->
	<?php if (isset($warning)) : ?>
		<p class="alert alert-warning" role="alert"><strong><?= $warning; ?></strong></p>
	<?php endif ?>
	<?php if (isset($success)) : ?>
		<p class="alert alert-success" role="alert"><strong><?= $success; ?></strong></p>
	<?php endif ?>


	<!-- FORMULAIRE COMMENTAIRE -->
	<div class="col-sm-8">
		<h3>Laisser un commentaire</h3>
		<?php require (SITE_ROOT . 'modules/commentaires/views/formulaire.view.php'); ?>
	</div>
	<p class="col-xs-12">&nbsp;</p>


	<!-- LISTE DES COMMENTAIRES PUBLIES -->
	<div class="col-sm-12">
		<h3>Commentaires (<?= $nombreCommentaires; ?>)</h3>
	<?php if (empty($commentairesPremierNiveau)) : ?>
		<p>Aucun commentaire</p>
	<?php else : ?>
		<?php foreach ($commentairesPremierNiveau as $com) : ?>

			<?php include(SITE_ROOT . 'modules/commentaires/views/commentaire.view.php'); ?>

		<?php endforeach; ?>
	<?php endif; ?>
	</div>
</section>