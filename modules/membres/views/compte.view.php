<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la page compte membre
 *
 * File Last Update : 2017 08 04
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
<section class="container">
	<div class="row">
		<h1>Tableau de bord</h1>

		<div class="col-xs-12 col-sm-4">
		<h3>Services</h3>
		<?php
			include('modules/membres/views/nav.view.php');
		?>
		</div>

		<div class="col-xs-12 col-sm-8">
			<h3>Profil</h3>
			<div style="width:200px; height:200px; background-image: url('<?php echo $membre->get_avatar(); ?>'); background-size: cover;">
			</div>
			<?php 
			// affichage des attributs du profil
			foreach ($formValue as $key => $value) {
				echo '<p>' . ucfirst($key) . ' : ' . $value . '</p>';
			}
			?>
		</div>
	</div>
</section>