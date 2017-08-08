<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Vue de l'inscription
 *
 * File Last Update : 2017 08 08
 *
 * File Description :
 * -> affiche le formulaire d'inscription
 * -> affiche les éventuelles erreurs si une information $_GET['error'] existe
 */


//------------------------------------------------------------
// Définition des commentaires de champ
$commentaire_login = '<em>Au moins ' . Membre::PSEUDO_MIN_LENGHT . ' caractères alphanumériques sans espace (- et _ tolérés)</em>';
$commentaire_email = '';
$commentaire_password = '';
$commentaire_sql = '';




//------------------------------------------------------------
// Erreur login
if (isset($_GET['error']))
{
	// erreur login
	if (preg_match('#login#', $_GET['error']))
	{
		$commentaire_login = '<div class="alert alert-danger" role="alert"><strong>ERREUR "login" : ' . $commentaire_login . '</strong></div>';
	}

	// erreur email
	if (preg_match('#email#', $_GET['error']))
	{
		$commentaire_email = '<div class="alert alert-danger" role="alert"><strong>ERREUR "email" : L\'adresse email doit être valide</strong></div>';
	}

	// erreur mot de passe
	if (preg_match('#password#', $_GET['error']))
	{
		$commentaire_password = '<div class="alert alert-danger" role="alert"><strong>ERREUR "password" : Au moins 8 caractères dont au moins 1 chiffre</strong></div>';
	}

	// erreur sql
	if (preg_match('#sql#', $_GET['error']))
	{
		$commentaire_sql = '<div class="alert alert-danger" role="alert"><strong>ERREUR : votre identifiant ou email existe déjà.</strong></div>';
	}
}




//------------------------------------------------------------
// Récupération des données valides du formulaire rempli la fois précédente
// Affichera ces données dans les champs correspondants
$ePOST = array('login' => '', 'email' => '');

function verifPOST($ePOST)
{
	foreach ($ePOST as $key => $value) {
		if(isset($_SESSION[$key])) { $ePOST[$key] = &$_SESSION[$key]; }
	}
	return $ePOST;
}

$ePOST = verifPOST($ePOST);


//------------------------------------------------------------
// HTML
?>


<section>
	<form method="post" action="?module=membres&action=inscription">
		<h3>Inscription</h3>
		<?php echo $commentaire_sql; ?>
		<p>
			<input type="text" class="form-control" placeholder="login" name="login" id="login" value="<?php echo $ePOST['login']; ?>">
			<?php echo $commentaire_login; ?>
		</p>
		<p>
			<input type="email" class="form-control" placeholder="adresse email" name="email" id="email" value="<?php echo $ePOST['email']; ?>">
			<?php echo $commentaire_email; ?>
		</p>
		<p>
			<input type="password" class="form-control" placeholder="mot de passe" name="password" id="password">
			<?php echo $commentaire_password; ?>
		</p>
		<p>
			<button type="submit" class="btn btn-default">Valider</button>
		</p>
	</form>
</section>