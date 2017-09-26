<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Admin
 * FILE/ROLE : Vue du panneau de contrôle
 *
 * File Last Update : 2017 09 24
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
				<div class="panel panel-success">
					<div class="panel-heading">Aucun signalement</div>
					<div class="panel-body">
						<p text-center><i class="fa fa-eye" aria-hidden="true"></i></p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div>
				<div class="panel panel-primary">
					<div class="panel-heading">Rédaction Billet</div>
					<ul class="list-group">
						<a href="?module=billets&page=edition" type="button" class="list-group-item list-group-item-info" aria-label="Nouveau"><i class="fa fa-plus" aria-hidden="true"></i> Nouveau</a>
						<a href="?module=billets&page=edition" type="button" class="list-group-item" aria-label="Dernier-brouillon"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Dernier brouillon</a>
					</ul>
				</div>
			</div>		
		</div>

		<div class="col-sm-4">
			<div>
				<div class="panel panel-primary">
					<div class="panel-heading">Dossiers Billets</div>
					<ul class="list-group">
						<a href="?module=billets&page=dossier&dossier=brouillon" type="button" class="list-group-item" aria-label="Brouillon"><span class="badge"><?= BilletMgr::getNbBrouillon(); ?></span><i class="fa fa-folder-open" aria-hidden="true"></i> Brouillons</a>
						<a href="?module=billets&page=dossier&dossier=publication" type="button" class="list-group-item" aria-label="Publication"><span class="badge"><?= BilletMgr::getNbPublication(); ?></span><i class="fa fa-folder" aria-hidden="true"></i> Publications</a>
						<a href="?module=billets&page=dossier&dossier=corbeille" type="button" class="list-group-item" aria-label="Corbeille"><span class="badge"><?= BilletMgr::getNbCorbeille(); ?></span><i class="fa fa-trash" aria-hidden="true"></i> Corbeille</a>
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
					<div class="panel-heading">Top Membres</div>
					<div class="panel-body">
						<p text-center>à venir</p>
					</div>
				</div>
			</div>
		</div>

		<div class="col-sm-4">
			<div>
				<div class="panel panel-default">
					<div class="panel-heading">Compte</div>
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
					    	<span class="badge"><?= BilletMgr::countNbBillets(); ?></span>
					    	Nb total de billets
						</li>
						<li class="list-group-item">
					    	<span class="badge">0</span>
					    	Nb total de commentaires
						</li>
						<li class="list-group-item">
					    	<span class="badge"><?= MembreMgr::countNbAbonnes(); ?></span>
					    	Nb total d'abonnés
						</li>
					</ul>
				</div>
			</div>		
		</div>

	</div>

</section>