<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Vue du panneau de contrôle des billets
 *
 * File Last Update : 2017 09 24
 *
 * File Description :
 * -> affiche le panneau de contrôle des billets
 */
//------------------------------------------------------------
// HTML
?>
<section>

	<h1><i class="fa fa-book" aria-hidden="true"></i> Gestion des Billets</h1>

	<!-- MENU -->
		<div class="btn-group btn-group.btn-group-justified" role="group">
			<a href="?module=billets&page=edition" type="button" class="btn btn-primary" aria-label="Nouveau"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Nouveau</a>
			<a href="?module=billets&page=dossier&dossier=brouillon" type="button" class="btn btn-default" aria-label="Brouillon"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>Brouillons (<?= BilletMgr::getNbBrouillon(); ?>)</a>
			<a href="?module=billets&page=dossier&dossier=publication" type="button" class="btn btn-default" aria-label="Publie"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>Publications (<?= BilletMgr::getNbPublication(); ?>)</a>
			<a href="?module=billets&page=dossier&dossier=corbeille" type="button" class="btn btn-warning" aria-label="Corbeille"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Corbeille (<?= BilletMgr::getNbCorbeille(); ?>)</a>
		</div>	
	
	<?php
		if (isset($warning))
		{
	?>
		<p class="alert alert-warning" role="alert"><strong><?= $warning; ?></strong></p>
	<?php
		}
	?>
	<?php
		if (isset($success))
		{
	?>
		<p class="alert alert-success" role="alert"><strong><?= $success; ?></strong></p>
	<?php
		}
	?>


	<h3><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Brouillons</h3>
	<?= $listeBrouillon; ?>

	<h3><i class="fa fa-eye" aria-hidden="true"></i></i> Billets Publiés</h3>
	<?= $listePublication; ?>

	<h3><i class="fa fa-trash-o" aria-hidden="true"></i> Billets Supprimés</h3>
	<?= $listeCorbeille; ?>

</section>