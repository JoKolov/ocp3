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
	<div class="btn-group btn-group-justified" role="group">
		<a href="?module=billets&page=edition" type="button" class="btn btn-primary" aria-label="Nouveau"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Nouveau</a>
		<a href="?module=billets&page=dossier&dossier=brouillon" type="button" class="btn btn-default" aria-label="Brouillon"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>Brouillons (<?= $nbBrouillons; ?>)</a>
		<a href="?module=billets&page=dossier&dossier=publication" type="button" class="btn btn-default" aria-label="Publie"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>Publications (<?= $nbPublications; ?>)</a>
		<a href="?module=billets&page=dossier&dossier=corbeille" type="button" class="btn btn-warning" aria-label="Corbeille"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Corbeille (<?= $nbCorbeille; ?>)</a>
	</div>
	
	<!-- BLOC INFO -->
	<?php if (isset($warning)) : ?>
		<p class="alert alert-warning" role="alert"><strong><?= $warning; ?></strong></p>
	<?php endif ?>
	<?php if (isset($success)):  ?>
		<p class="alert alert-success" role="alert"><strong><?= $success; ?></strong></p>
	<?php endif ?>

	<p>&nbsp;</p>

	<div class="panel panel-default">
		<div class="panel-heading"><a href="?module=billets&page=dossier&dossier=brouillon" aria-label="Brouillon"><h3><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Brouillons</h3></a></div>
		<?php if (empty($listeBrouillon)) : ?>
			<div class="panel-body"><p>Aucun</p></div>
		<?php else : ?>
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<td><strong><?= $limit; ?> Derniers Billets</strong></td>
							<td><strong>Date modif</strong></td>
							<td class="text-right"><strong>Actions</strong></td>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($listeBrouillon as $billet) : ?>
						<tr>
							<td><a href="?module=billets&page=edition&id=<?= $billet->get_id(); ?>"><?= $billet->get_titre(); ?></a></td>
							<td><?= $billet->get_date_modif(); ?></td>
							<td>
								<div class="btn-group pull-right" role="group" aria-label="billet-<?= $billet->get_id(); ?>">
									<a href="?module=billets&page=lecture&id=<?= $billet->get_id(); ?>" class="btn btn-default" role="button" alt="voir le billet"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="?module=billets&page=edition&id=<?= $billet->get_id(); ?>" class="btn btn-default" role="button" alt="éditer le billet"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<a href="?module=billets&page=supprimer&action=submit&id=<?= $billet->get_id(); ?>" class="btn btn-warning" role="button" alt="supprimer le billet"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				 	</tbody>
				</table>
			</div>					
		<?php endif ?>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading"><a href="?module=billets&page=dossier&dossier=publication" aria-label="Publie"><h3><i class="fa fa-eye" aria-hidden="true"></i></i> Billets Publiés</h3></a></div>
		<?php if (empty($listePublication)) : ?>
			<div class="panel-body"><p>Aucun</p></div>
		<?php else : ?>
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<td><strong><?= $limit; ?> Derniers Billets</strong></td>
							<td><strong>Date modif</strong></td>
							<td class="text-right"><strong>Actions</strong></td>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($listePublication as $billet) : ?>
						<tr>
							<td><a href="?module=billets&page=edition&id=<?= $billet->get_id(); ?>"><?= $billet->get_titre(); ?></a></td>
							<td><?= $billet->get_date_modif(); ?></td>
							<td>
								<div class="btn-group pull-right" role="group" aria-label="billet-<?= $billet->get_id(); ?>">
									<a href="?module=billets&page=lecture&id=<?= $billet->get_id(); ?>" class="btn btn-default" role="button" alt="voir le billet"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="?module=billets&page=edition&id=<?= $billet->get_id(); ?>" class="btn btn-default" role="button" alt="éditer le billet"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<a href="?module=billets&page=supprimer&action=submit&id=<?= $billet->get_id(); ?>" class="btn btn-warning" role="button" alt="supprimer le billet"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				 	</tbody>
				</table>
			</div>					
		<?php endif ?>
	</div>


	<div class="panel panel-default">
		<div class="panel-heading"><a href="?module=billets&page=dossier&dossier=corbeille" aria-label="Corbeille"><h3><i class="fa fa-trash-o" aria-hidden="true"></i> Billets Supprimés</h3></a></div>
		<?php if (empty($listeCorbeille)) : ?>
			<div class="panel-body"><p>Aucun</p></div>
		<?php else : ?>
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<td><strong><?= $limit; ?> Derniers Billets</strong></td>
							<td><strong>Date modif</strong></td>
							<td class="text-right"><strong>Actions</strong></td>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($listeCorbeille as $billet) : ?>
						<tr>
							<td><a href="?module=billets&page=edition&id=<?= $billet->get_id(); ?>"><?= $billet->get_titre(); ?></a></td>
							<td><?= $billet->get_date_modif(); ?></td>
							<td>
								<div class="btn-group pull-right" role="group" aria-label="billet-<?= $billet->get_id(); ?>">
									<a href="?module=billets&page=lecture&id=<?= $billet->get_id(); ?>" class="btn btn-default" role="button" alt="voir le billet"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="?module=billets&page=edition&id=<?= $billet->get_id(); ?>" class="btn btn-default" role="button" alt="éditer le billet"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<a href="?module=billets&page=effacer&action=submit&id=<?= $billet->get_id(); ?>" class="btn btn-danger" role="button" alt="effacer le billet"><i class="fa fa-eraser" aria-hidden="true"></i></a>
								</div>
							</td>
						</tr>
					<?php endforeach ?>
				 	</tbody>
				</table>
			</div>					
		<?php endif ?>
	</div>


</section>