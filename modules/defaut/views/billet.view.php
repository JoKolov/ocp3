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
		<h3>Commentaires (<?= $nbCom; ?>)</h3>
	<?php if (empty($comList)) : ?>
		<p>Aucun commentaire</p>
	<?php else : ?>
		<?php foreach ($comGlobalList as $com) : ?>

			<div class="col-sm-offset-<?= $com->get_com_level(); ?> col-sm-7" id="com<?= $com->get_id(); ?>">
				<div class="panel panel-default">
					<div class="panel-body">
						<p><?= $com->get_contenu(); ?></p>
					</div>				

					<div class="panel-footer">
						<span class="pull-right">
							<div class="btn-toolbar" role="toolbar" aria-label="com-toolbar">
								<div class="btn-group btn-group-xs" role="group" aria-label="com-toolbar-btn">
									<a href="?module=commentaires&page=signaler&action=submit&id=<?= $com->get_id(); ?>" type="button" class="btn btn-danger" aria-label="signaler"><i class="fa fa-bullhorn" aria-hidden="true"></i>
										<?= ($com->get_signalement() > 0) ? ' ' . $com->get_signalement() : ''; ?></a>
									<?php if ($com->get_com_level() < Commentaire::COM_LEVEL_MAX) : ?>
									<a href="?module=commentaires&page=repondre&id=<?= $com->get_id(); ?>" type="button" class="btn btn-info" aria-label="repondre"><i class="fa fa-comments" aria-hidden="true"></i> Rép.</a>
									<?php endif; ?>
								</div>
							</div>	
						</span>	
						<?= $com->getAuteur(); ?> le <?= $com->get_date_publie(); ?>
					</div>
				</div>
			</div>

			<?php if (isset($comFormId) AND $comFormId == $com->get_id()) : ?>
				<div class="col-sm-offset-<?= $com->get_com_level() + 1; ?> col-sm-7">
					<?php require (SITE_ROOT . 'modules/commentaires/views/formulaire.view.php'); ?>
				</div>
				<p class="col-xs-12">&nbsp;</p>
			<?php endif; ?>

		<?php endforeach; ?>
	<?php endif; ?>
	</div>
</section>