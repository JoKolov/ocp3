<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Admin
 * FILE/ROLE : Vue du panneau de contrôle
 *
 * File Last Update : 2017 09 26
 *
 * File Description :
 * -> affiche le panneau de contrôle
 */
//------------------------------------------------------------
// HTML
?>
<section>

	<h1>Tableau de bord</h1>


	<!-- BLOCS LIGNE 1 -->
	<div class="col-xs-12">

		<div class="col-sm-4">
			<div>
				<div class="panel panel-default">
					<div class="panel-heading">Commentaires</div>
					<ul class="list-group">
						<a href="?module=commentaires&page=dossier&dossier=signalement" type="button" class="list-group-item list-group-item-<?= ($infoCom['nbSignalements'] > 0) ? 'danger' : 'success'; ?>" aria-label="signalements">
							<i class="fa fa-bullhorn" aria-hidden="true"></i> <?= ($infoCom['nbSignalements'] > 0) ? $infoCom['nbSignalements'] . ' signalement(s)' : 'Aucun signalement'; ?>
						</a>
						<a href="?module=commentaires&page=dossier&dossier=approuve" type="button" class="list-group-item list-group-item-<?= ($infoCom['nbApprobations'] > 0) ? 'warning' : 'success'; ?>" aria-label="Dernier-brouillon">
							<i class="fa fa-gavel" aria-hidden="true"></i> <?= ($infoCom['nbApprobations'] > 0) ? $infoCom['nbApprobations'] . ' à valider' : 'Aucune validation en attente'; ?>
						</a>
					</ul>
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div>
				<div class="panel panel-primary">
					<div class="panel-heading">Ecriture</div>
					<ul class="list-group">
						<a href="?module=billets&page=edition" type="button" class="list-group-item list-group-item-info" aria-label="Nouveau"><i class="fa fa-plus" aria-hidden="true"></i> Nouveau</a>
						<?php if (!empty($derniersBrouillons)) : ?>
							<?php foreach ($derniersBrouillons as $brouillon) : ?>
								<a href="?module=billets&page=edition&id=<?= $brouillon->get_id(); ?>" type="button" class="list-group-item" aria-label="Dernier-brouillon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <?= $brouillon->get_titre(); ?></a>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</div>
			</div>		
		</div>

		<div class="col-sm-4">
			<div>
				<div class="panel panel-primary">
					<div class="panel-heading">Edition</div>
					<ul class="list-group">
						<a href="?module=billets&page=dossier&dossier=brouillon" type="button" class="list-group-item" aria-label="Brouillon"><span class="badge"><?= $infoBillets['nbBrouillons']; ?></span><i class="fa fa-folder-open" aria-hidden="true"></i> Brouillons</a>
						<a href="?module=billets&page=dossier&dossier=publication" type="button" class="list-group-item" aria-label="Publication"><span class="badge"><?= $infoBillets['nbPublications']; ?></span><i class="fa fa-folder" aria-hidden="true"></i> Publications</a>
						<a href="?module=billets&page=dossier&dossier=corbeille" type="button" class="list-group-item" aria-label="Corbeille"><span class="badge"><?= $infoBillets['nbCorbeille']; ?></span><i class="fa fa-trash" aria-hidden="true"></i> Corbeille</a>
					</ul>
				</div>
			</div>		
		</div>

	</div>


	<!-- BLOCS LIGNE 2 -->
	<div class="col-xs-12">

		<div class="col-sm-4">
			<div>
				<div class="panel panel-default">
					<div class="panel-heading">Derniers membres</div>
					<ul class="list-group">
						<?php if (empty($derniersMembres)) : ?>
							<li class="list-group-item">Aucun Abonné</li>
						<?php else : ?>
							<?php foreach($derniersMembres as $dernierMembre) : ?>
								<li class="list-group-item"><?= $dernierMembre->get_pseudo(); ?></li>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div>
				<div class="panel panel-default">
					<div class="panel-heading">Mon Compte</div>
					<ul class="list-group">
						<a href="?module=membres&page=compte" type="button" class="list-group-item" aria-label="compte"><i class="fa fa-user" aria-hidden="true"></i> Voir mon profil</a>
						<a href="?module=membres&page=modification" type="button" class="list-group-item" aria-label="modif-profil"><i class="fa fa-address-card" aria-hidden="true"></i> Modifier mon profil</a>
					</ul>
				</div>
			</div>		
		</div>

		<div class="col-sm-4">
			<div>
				<div class="panel panel-default">
					<div class="panel-heading">Statistiques</div>
					<ul class="list-group">
						<li class="list-group-item">
					    	<span class="badge"><?= $infoBillets['nbBillets']; ?></span>
					    	Nb total de billets
						</li>
						<li class="list-group-item">
					    	<span class="badge"><?= $infoCom['nbCommentaires']; ?></span>
					    	Nb total de commentaires
						</li>
						<li class="list-group-item">
					    	<span class="badge"><?= $infoMembres['nbAbonnes']; ?></span>
					    	Nb total d'abonnés
						</li>
					</ul>
				</div>
			</div>		
		</div>

	</div>

</section>