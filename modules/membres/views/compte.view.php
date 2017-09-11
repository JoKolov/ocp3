<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la page compte membre
 *
 * File Last Update : 2017 08 31
 *
 * File Description :
 * -> affiche le tableau de bord du compte utilisateur
 * -> informations sur le compte
 * -> outils et services disponibles
 */

// Protocoles de sécurités
user_connected_only();



//------------------------------------------------------------
// Code à mettre dans le controleur
$membre = $_SESSION['membre']; // on récupère l'objet membre contenu dans la variable $_SESSION
$formValue = $membre->getPublicAttributs(); // on récupère tous les attibuts de l'objet dans un tableau

//-----
// CODE A DEPLACER
$billetMgr = new BilletMgr;
$billets = $billetMgr->select_multi();
$billets_vue = '';
foreach ($billets as $value) {
	$billets_vue .= '<p><a href="?module=billets&page=billet&id=' . $value->get_id() . '">' . $value->get_titre() . '</a> [ ' . '<a href="?module=billets&page=edition&id=' . $value->get_id() . '">' . 'éditer' . '</a> ][ ' . $value->get_statut() . ' ]</p>';
}
if ($billets_vue == '') { $billets_vue = '<p>Aucun billet</p>'; }
$nb_brouillons = $billetMgr->count('', "statut = '" . Billet::STATUT['sauvegarder'] . "'");
$nb_publies = $billetMgr->count('', "statut = '" . Billet::STATUT['publier'] . "'");
$nb_supprimes = $billetMgr->count('', "statut = '" . Billet::STATUT['supprimer'] . "'");

//-----


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
			<div class="compte-avatar col-sm-6" style="background-image: url('<?php echo $membre->get_avatar(); ?>');"></div>
			<div class="col-sm-6">
				<?php 
				// affichage des attributs du profil
				foreach ($formValue as $key => $value) {
					echo '<p>' . ucfirst($key) . ' : ' . $value . '</p>';
				}
				?>
			</div>

			<!-- RESERVE AUX ADMIN -->
			<?php 
				if ($membre->is_admin() === TRUE)
				{
			?>
				<div class="col-xs-12">
					<h3>Billets</h3>
					<div class="btn-group" role="group">
						<a href="?module=billets&page=edition" type="button" class="btn btn-default" aria-label="Nouveau"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Nouveau</a>
						<a href="?module=billets&page=brouillons" type="button" class="btn btn-default" aria-label="Brouillon"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>Brouillon (<?= $nb_brouillons; ?>)</a>
						<a href="?module=billets&page=publications" type="button" class="btn btn-default" aria-label="Publie"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>Publié (<?= $nb_publies; ?>)</a>
						<a href="?module=billets&page=corbeille" type="button" class="btn btn-default" aria-label="Corbeille"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Corbeille (<?= $nb_supprimes; ?>)</a>
					</div>
					<div class="panel panel-default">
						<div class="panel-body">
							<?= $billets_vue; ?>
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