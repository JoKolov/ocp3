<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de la connexion
 *
 * File Last Update : 2017 08 08
 *
 * File Description :
 * -> affiche le formulaire de connexion
 * -> affiche les éventuelles erreurs si une information $_GET['error'] existe
 */

/**
 * [$error contient les erreurs formatées en code HTML]
 * @var [array]
 */
$error = errorView(COMVIEW, $_GET);



//------------------------------------------------------------
// HTML
?>
<section>
	<form method="post" action="?module=membres&action=connexion">
		<h3>Connexion</h3>
		<?php
			/**
			 * Affichage des erreurs
			 */
			foreach ($error as $key => $value) {
			 	echo $value;
			 };
		?>
		<p>
			<input type="text" class="form-control" placeholder="pseudo" name="pseudo" id="pseudo">
		</p>
		<p>
			<input type="password" class="form-control" placeholder="mot de passe" name="password" id="password">
		</p>
		<p>
			<button type="submit" class="btn btn-default">Valider</button>
		</p>
	</form>
	<div>
		<p class="text-right">
			Pas encore de compte ? ..... <a href="index.php?module=membres&page=inscription">Inscris-toi vite !</a>
		</p>
	</div>
</section>