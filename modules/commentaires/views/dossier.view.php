<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Vue du panneau d'un dossier de billet
 *
 * File Last Update : 2017 09 29
 *
 * File Description :
 * -> affiche le panneau de contrôle des billets du dossier demandé
 */
//------------------------------------------------------------
// HTML
?>
<section>

	<h1><i class="fa fa-book" aria-hidden="true"></i> Gestion des Commentaires</h1>

	<!-- MENU -->
	<?php require_once(SITE_ROOT . 'modules/commentaires/views/admin-nav.view.php'); ?>
	
	<!-- BLOC INFO -->
	<?php if (isset($danger)) : ?>
		<p class="alert alert-danger" role="alert"><strong><?= $danger; ?></strong></p>
	<?php endif ?>
	<?php if (isset($warning)) : ?>
		<p class="alert alert-warning" role="alert"><strong><?= $warning; ?></strong></p>
	<?php endif ?>
	<?php if (isset($success)):  ?>
		<p class="alert alert-success" role="alert"><strong><?= $success; ?></strong></p>
	<?php endif ?>


	<!-- LISTE DES COMMENTAIRES -->
	<?php if ($dossier == 'signalement') : ?>
		<h3><i class="fa fa-bullhorn" aria-hidden="true"></i> Liste des signalements</h3>
	<?php else : ?>
		<h3><i class="fa fa-gavel" aria-hidden="true"></i> Liste des commentaires en attente de validation</h3>
	<?php endif; ?>
	<?php if (empty($comList)) : ?>
		<p>Aucun commentaire</p>
	<?php else : ?>
		<?php foreach ($comList as $com) : ?>
			<div class="col-sm-12">
				<div class="panel panel-<?= ($dossier == 'signalement') ? 'danger' : 'warning'; ?>">
					<div class="panel-heading">
						<?= ($dossier == 'signalement') ? "<strong>Signalé {$com->get_signalement()} fois</strong>" : "Commentaire Anonyme non publié" ?>
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




	<!-- PAGINATION -->
	<?php 
	if (count($pagination) > 1)
	{
	?>
	<nav aria-label="Page navigation">
	  <ul class="pagination">
	    
	    <?php
	    	if ($pagiActive > 0)
	    	{
	    	?>
	    	<li>
	    		<a href="?module=billets&page=dossier&dossier=<?= $dossier; ?>&nav=<?= $pagiActive; ?>" aria-label="Previous">
	    	<?php
	    	}
	    	else
	    	{
	    	?>
	    	<li class="disabled">
	    		<a href="#" aria-label="Previous">
	    	<?php	
	    	}
	    ?>
	        <span aria-hidden="true">&laquo;</span>
	      </a>
	    </li>

	<?php
		foreach ($pagination as $pagi => $page)
		{
			if ($pagi == $pagiActive)
			{ ?>
				<li class="active"><a href="?module=billets&page=dossier&dossier=<?= $dossier; ?>&nav=<?= $page; ?>"><?= $page;?></a></li>
	<?php	}
			else
			{ ?>
				<li><a href="?module=billets&page=dossier&dossier=<?= $dossier; ?>&nav=<?= $page; ?>"><?= $page;?></a></li>
	<?php	} 
	?>
	    
	<?php
		}
	?>

	    <?php
	    	if (isset($pagination[$pagiActive+1]))
	    	{
	    	?>
	    	<li>
	    		<a href="?module=billets&page=dossier&dossier=<?= $dossier; ?>&nav=<?= $pagiActive + 2; ?>" aria-label="Next">
	    	<?php
	    	}
	    	else
	    	{
	    	?>
	    	<li class="disabled">
	    		<a href="#" aria-label="Next">
	    	<?php	
	    	}
	    ?>
	        <span aria-hidden="true">&raquo;</span>
	      </a>
	    </li>

	  </ul>
	</nav>
	<?php 
	}
	?>

</section>