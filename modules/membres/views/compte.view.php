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
				include('modules/membres/views/nav.view.php');
			?>
		</div>

		<div class="col-sm-9">
			<h3>Profil</h3>
			<div class="compte-avatar col-sm-6" style="background-image: url('<?= $var['value']['user-avatar']; ?>');"></div>
			<div class="col-sm-6">
				<?= $var['value']['user-profile']; ?>
			</div>

			<!-- RESERVE AUX ADMIN -->
			<?php 
				if (array_key_exists('billets', $var['value']))
				{
			?>
				<div class="col-xs-12">
					<h3>Billets</h3>
					<div class="btn-group" role="group">
						<a href="?module=billets&page=edition" type="button" class="btn btn-default" aria-label="Nouveau"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Nouveau</a>
						<a href="?module=billets&page=brouillons" type="button" class="btn btn-default" aria-label="Brouillon"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>Brouillon (<?= $var['value']['billets']['brouillon']; ?>)</a>
						<a href="?module=billets&page=publications" type="button" class="btn btn-default" aria-label="Publie"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>Publié (<?= $var['value']['billets']['publie']; ?>)</a>
						<a href="?module=billets&page=corbeille" type="button" class="btn btn-default" aria-label="Corbeille"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Corbeille (<?= $var['value']['billets']['corbeille']; ?>)</a>
					</div>
					<div class="panel panel-default">
						<div class="panel-body">
							<?= $var['value']['billets']['liste']; ?>
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