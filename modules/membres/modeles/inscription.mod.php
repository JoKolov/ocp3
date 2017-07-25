<?php

echo 'Hello, je suis le modèle et je dois inscrire les données dans la base de données : <br />';
echo '<pre>';
echo var_dump($_POST);
echo '</pre>';

/**
 * Utilisation des classes suivantes :
 * Membre
 * MembreMgr
 */

define('URL_INSCRIPTION_ERREUR', 'Location: index.php?module=membres&page=inscription&error=');
$erreur = '';

/**
 * Contrôle des données du formulaire d'inscription
 */
$membre = new Membre;
if (isset($_POST['login']) AND $membre->set_pseudo($_POST['login']))
{
	$_SESSION['login'] = $membre->get_pseudo();
	echo 'Le pseudo du membre est : ' . $membre->get_pseudo() . '<br />';
}
else
{
	$erreur .= 'login';
	$_SESSION['login'] = '';
}


if (isset($_POST['email']) AND $membre->set_email($_POST['email']))
{
	$_SESSION['email'] = $membre->get_email();
	echo 'L\'adresse email du membre est : ' . $membre->get_email() . '<br />';
}
else
{
	$erreur .= 'email';
	$_SESSION['email'] = '';
}


if (isset($_POST['password']) AND $membre->set_password($_POST['password']))
{
	$_SESSION['password'] = $membre->get_password();
	echo 'Le mot de passe du membre est : ' . $membre->get_password() . '<br />';
}
else
{
	$erreur .= 'password';
}



// si la validation échoue, on renvoi vers le formulaire avec les erreurs
if ($erreur <> '')
{
	header(URL_INSCRIPTION_ERREUR . $erreur); // retour au formulaire d'inscription avec une erreur
}
else // si aucune erreur, on enregistre les données dans la base de données
{
	// enregistrement des données dans la BDD
	if (MembreMgr::insert_membre($membre))
	{
		header('Location: index.php?membre-enregistre');
	}
	else
	{
		header('Location: index.php?membre-non-enregistre');
	}
	// renvoi vers la page
}
