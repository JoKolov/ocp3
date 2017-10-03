<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Vue du panneau d'un dossier de billet
 *
 * File Last Update : 2017 09 25
 *
 * File Description :
 * -> affiche le panneau de contrôle des billets du dossier demandé
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


	<!-- LISTE DES BILLETS -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<?php if ($dossier == Billet::STATUT['sauvegarder']) : ?>
				<h3><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Brouillons</h3>
			<?php elseif ($dossier == Billet::STATUT['publier']) : ?>
				<h3><i class="fa fa-eye" aria-hidden="true"></i></i> Billets Publiés</h3>
			<?php elseif ($dossier == Billet::STATUT['supprimer']) : ?>
				<h3><i class="fa fa-trash-o" aria-hidden="true"></i> Billets Supprimés</h3>
		<?php endif; ?>
		</div>
		<?php if (empty($billets)) : ?>
			<div class="panel-body"><p>Aucun billet</p></div>
		<?php else : ?>
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<td><strong>Titre</strong></td>
							<td><strong>Date modif</strong></td>
							<td class="text-right"><strong>Actions</strong></td>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($billets as $billet) : ?>
						<tr>
							<td><a href="?module=billets&page=edition&id=<?= $billet->get_id(); ?>"><strong><?= $billet->get_titre(); ?></strong></a></td>
							<td><?= $billet->get_date_modif(); ?></td>
							<td>
								<div class="btn-group pull-right" role="group" aria-label="billet-<?= $billet->get_id(); ?>">
									<a href="?module=billets&page=lecture&id=<?= $billet->get_id(); ?>" class="btn btn-default" role="button" alt="voir le billet"><i class="fa fa-eye" aria-hidden="true"></i></a>
									<a href="?module=billets&page=edition&id=<?= $billet->get_id(); ?>" class="btn btn-default" role="button" alt="éditer le billet"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
									<?php if ($dossier != Billet::STATUT['supprimer']) : ?>
										<a href="?module=billets&page=supprimer&action=submit&id=<?= $billet->get_id(); ?>" class="btn btn-warning" role="button" alt="supprimer le billet"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
									<?php else : ?>
										<a href="?module=billets&page=effacer&action=submit&id=<?= $billet->get_id(); ?>" class="btn btn-danger" role="button" alt="effacer le billet"><i class="fa fa-eraser" aria-hidden="true"></i></a>
									<?php endif; ?>
								</div>
							</td>
						</tr>
					<?php endforeach; ?>
				 	</tbody>
				</table>
			</div>					
		<?php endif; ?>
	</div>




	<!-- PAGINATION -->
	<?php if (count($pagination) > 1) : ?>
	<nav aria-label="Page navigation">
	  <ul class="pagination">
	    
	    <?php if ($pagiActive > 0) : ?>
	    	<li>
	    		<a href="?module=billets&page=dossier&dossier=<?= $dossier; ?>&nav=<?= $pagiActive; ?>" aria-label="Previous">
	    	<?php else : ?>
	    	<li class="disabled">
	    		<a href="#" aria-label="Previous">
	    	<?php endif; ?>
	        <span aria-hidden="true">&laquo;</span>
	      </a>
	    </li>

		<?php foreach ($pagination as $pagi => $page) : ?>
			<?php if ($pagi == $pagiActive) : ?>
				<li class="active"><a href="?module=billets&page=dossier&dossier=<?= $dossier; ?>&nav=<?= $page; ?>"><?= $page;?></a></li>
			<?php else : ?>
				<li><a href="?module=billets&page=dossier&dossier=<?= $dossier; ?>&nav=<?= $page; ?>"><?= $page;?></a></li>
			<?php endif; ?>
		    
		<?php endforeach; ?>

	    <?php if (isset($pagination[$pagiActive+1])) : ?>
	    	<li>
	    		<a href="?module=billets&page=dossier&dossier=<?= $dossier; ?>&nav=<?= $pagiActive + 2; ?>" aria-label="Next">
	    <?php else : ?>
	    	<li class="disabled">
	    		<a href="#" aria-label="Next">
	    <?php endif;  ?>
	        <span aria-hidden="true">&raquo;</span>
	      </a>
	    </li>

	  </ul>
	</nav>
	<?php endif; ?>

</section>