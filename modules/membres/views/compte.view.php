<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la page compte membre
 *
 * File Last Update : 2017 09 18
 *
 * File Description :
 * -> affiche le tableau de bord du compte utilisateur
 * -> informations sur le compte
 * -> outils et services disponibles
 */
//------------------------------------------------------------
// HTML
?>
<section>
	<div>
		<h1>Tableau de bord</h1>

		<div class="col-sm-3">
			<h3>Services</h3>
			<?php
				include(SITE_ROOT . 'modules/membres/views/nav.view.php');
			?>
		</div>

		<div class="col-sm-9">
			<h3>Profil</h3>
			<div class="compte-avatar col-sm-6" style="background-image: url('<?= $membre->get_avatar(); ?>');"></div>
			<div class="col-sm-6">
				<?= $values->getValues('userProfile'); ?>
			</div>

			<!-- RESERVE AUX ADMIN -->
			<?php 
				if ($membre->is_admin())
				{
			?>
				<div class="col-xs-12">
					<h3>Billets</h3>
					<div class="btn-group" role="group">
						<a href="?module=billets&page=edition" type="button" class="btn btn-default" aria-label="Nouveau"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Nouveau</a>
						<a href="?module=billets&page=brouillons" type="button" class="btn btn-default" aria-label="Brouillon"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>Brouillon (<?= $values->getValues('billetsSum')['brouillon']; ?>)</a>
						<a href="?module=billets&page=publications" type="button" class="btn btn-default" aria-label="Publie"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>Publié (<?= $values->getValues('billetsSum')['publie']; ?>)</a>
						<a href="?module=billets&page=corbeille" type="button" class="btn btn-default" aria-label="Corbeille"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Corbeille (<?= $values->getValues('billetsSum')['corbeille']; ?>)</a>
					</div>
					<div class="panel panel-default">
						<div class="panel-body">
							<?= $values->getValues('billetsSum')['liste']; ?>
						</div>
					</div>
				</div>
			<?php 
				}
			?>
			<!-- # ADMIN # -->

		</div>
	</div>
</section>