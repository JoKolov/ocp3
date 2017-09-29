<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Commentaires
 * FILE/ROLE : Vue du panneau de contrôle des commentaires
 *
 * File Last Update : 2017 09 26
 *
 * File Description :
 * -> affiche le panneau de contrôle des commentaires
 */
//------------------------------------------------------------
// HTML
?>
<section>

	<h1><i class="fa fa-comments" aria-hidden="true"></i> Gestion des Commentaires</h1>

	<!-- MENU -->
	<?php require_once(SITE_ROOT . 'modules/commentaires/views/admin-nav.view.php'); ?>

	<!-- BLOC INFO -->
	<?php if (isset($danger)) : ?>
		<p class="alert alert-danger" role="alert"><strong><?= $danger; ?></strong></p>
	<?php endif ?>
	<?php if (isset($warning)) : ?>
		<p class="alert alert-warning" role="alert"><strong><?= $warning; ?></strong></p>
	<?php endif ?>
	<?php if (isset($success)) : ?>
		<p class="alert alert-success" role="alert"><strong><?= $success; ?></strong></p>
	<?php endif ?>


	<!-- LISTE DES COMMENTAIRES SIGNALES -->
	<div class="col-sm-6">
	<h3><i class="fa fa-bullhorn" aria-hidden="true"></i> Signalements (<?= $nbReportedCom; ?>)</h3>
	<?php if (empty($listReportedCom)) : ?>
		<p>Aucun commentaire</p>
	<?php else : ?>
		<?php foreach ($listReportedCom as $com) : ?>
			<div class="col-sm-12">
				<div class="panel panel-danger">
					<div class="panel-heading">
						<strong>Signalé <?= $com->get_signalement(); ?> fois</strong>
					</div>
					<div class="panel-body">
						<span class="pull-right">
							<div class="btn-toolbar" role="toolbar" aria-label="com-toolbar">
								<div class="btn-group btn-group" role="group" aria-label="com-toolbar-btn">
									<a href="?module=commentaires&page=approuver&id=<?= $com->get_id(); ?>" type="button" class="btn btn-success" aria-label="approuver" alt="Approuver"><i class="fa fa-check" aria-hidden="true"></i></a>
									<a href="?module=commentaires&page=effacer&action=submit&id=<?= $com->get_id(); ?>" type="button" class="btn btn-danger" aria-label="effacer" alt="Effacer"><i class="fa fa-eraser" aria-hidden="true"></i></a>
								</div>
							</div>	
						</span>	
						<p><?= $com->get_contenu(); ?></p>
					</div>				

					<div class="panel-footer">
						<?= $com->getAuteur(); ?> le <?= $com->get_date_publie(); ?>
					</div>
				</div>
			</div>

		<?php endforeach ?>
	<?php endif ?>
	</div>

	<!-- LISTE DES COMMENTAIRES EN ATTENTE DE VALIDATION -->
	<div class="col-sm-6">
		<h3><i class="fa fa-gavel" aria-hidden="true"></i> En attente de validation (<?= $nbWaitingCom; ?>)</h3>
	<?php if (empty($listWaitingCom)) : ?>
		<p>Aucun commentaire</p>
	<?php else : ?>
		<?php foreach ($listWaitingCom as $com) : ?>
			<div class="col-sm-12">
				<div class="panel panel-warning">
					<div class="panel-heading">
						<strong>Commentaire Anonyme</strong>
					</div>
					<div class="panel-body">
						<span class="pull-right">
							<div class="btn-toolbar" role="toolbar" aria-label="com-toolbar">
								<div class="btn-group btn-group" role="group" aria-label="com-toolbar-btn">
									<a href="?module=commentaires&page=approuver&id=<?= $com->get_id(); ?>" type="button" class="btn btn-success" aria-label="approuver" alt="Approuver"><i class="fa fa-check" aria-hidden="true"></i></a>
									<a href="?module=commentaires&page=effacer&action=submit&id=<?= $com->get_id(); ?>" type="button" class="btn btn-danger" aria-label="effacer" alt="Effacer"><i class="fa fa-eraser" aria-hidden="true"></i></a>
								</div>
							</div>	
						</span>	
						<p><?= $com->get_contenu(); ?></p>
					</div>				

					<div class="panel-footer">
						<?= $com->getAuteur(); ?> le <?= $com->get_date_publie(); ?>
					</div>
				</div>
			</div>

		<?php endforeach ?>
	<?php endif ?>
	</div>

</section>
