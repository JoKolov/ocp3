<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la page compte membre
 *
 * File Last Update : 2017 08 08
 *
 * File Description :
 * -> affiche le tableau de bord du compte utilisateur
 * -> informations sur le compte
 * -> outils et services disponibles
 */

//------------------------------------------------------------
// HTML
/** Champs du compte membre à afficher
 * PSEUDO 												20%
 * NOM 													20%
 * PRENOM 												20%
 * EMAIL
 * PASSWORD
 * DATE_BIRTH 											20%
 * TYPE_ID (type de compte : ex : administrateur)
 * AVATAR_ID (afficher l'avatar et son url) 			20%
 */

//------------------------------------------------------------
// Protocoles de sécurités
user_connected_only();



//------------------------------------------------------------
// Code à mettre dans le controleur
$membre = $_SESSION['membre']; // on récupère l'objet membre contenu dans la variable $_SESSION
$formValue = $membre->getPublicAttributs(); // on récupère tous les attibuts de l'objet dans un tableau



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
						<a href="?module=billets&page=brouillon" type="button" class="btn btn-default" aria-label="Brouillon"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>Brouillon (x)</a>
						<a href="?module=billets&page=corbeille" type="button" class="btn btn-default" aria-label="Corbeille"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Corbeille (x)</a>
					</div>
					<div class="panel panel-default">
						<div class="panel-body">
							<p>Liste des billets</p>
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