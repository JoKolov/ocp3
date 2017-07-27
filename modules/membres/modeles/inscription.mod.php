<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Modèle de l'inscription
 *
 * File Last Update : 2017 07 25
 *
 * File Description :
 * -> vérifie l'intégrité des données transmises par le formulaire d'inscription
 * -> *************
 * -> VERIFIER QUE LE MEMBRE N'EXISTE PAS !!!!!
 * -> *************
 * -> insère les données dans la base de données si elles sont OK
 * -> sinon, renvoi vers le formulaire d'inscription avec les erreurs
 *
 *
 * Utilisation des classes suivantes :
 * Membre
 * MembreMgr
 */

define('URL_INSCRIPTION_ERREUR', 'Location: index.php?module=membres&page=inscription&error=');
$erreur = '';


// ======================================================
// préparation à la mise en conformité avec le nouveau fonctionnement du controleur
$formInscription = array(
	'pseudo'	=>	'',
	'email'		=> 	'',
	'password'	=> 	''
	);
// ======================================================

//------------------------------------------------------------
// Contrôle des données du formulaire d'inscription

// création d'un membre
// cela permettra de contrôler les données enregistrées par le formulaire
// via les setteurs de la classe membre
$membre = new Membre;


// création des données de Session
// Initialisées à zéro pour le moment
$_SESSION['login'] = '';
$_SESSION['email'] = '';
$_SESSION['password'] = '';


// Enregistrement du login (pseudo)
if (isset($_POST['login']) AND $membre->set_pseudo($_POST['login']))
{
	$_SESSION['login'] = $membre->get_pseudo();
}
else
{
	$erreur .= 'login';
}


if (isset($_POST['email']) AND $membre->set_email($_POST['email']))
{
	$_SESSION['email'] = $membre->get_email();
}
else
{
	$erreur .= 'email';
}


if (isset($_POST['password']) AND $membre->set_password($_POST['password']))
{
	$_SESSION['password'] = Membre::hashPassword($membre->get_password());
}
else
{
	$erreur .= 'password';
}




//------------------------------------------------------------
// si la validation échoue, on renvoi vers le formulaire avec les erreurs
if ($erreur <> '')
{
	header(URL_INSCRIPTION_ERREUR . $erreur); // retour au formulaire d'inscription avec une erreur
}
else // si aucune erreur, on enregistre les données dans la base de données
{
	// enregistrement des données dans la BDD
	if (MembreMgr::insert_membre($membre) === TRUE)
	{
		$_SESSION['membre'] = $membre;
		$_SESSION['pseudo'] = $membre->get_pseudo;
		header('Location: index.php?module=membres&page=compte');
	}
	else
	{
		$erreur = 'sql';
		header(URL_INSCRIPTION_ERREUR . $erreur); // retour au formulaire d'inscription avec une erreur
	}
	// renvoi vers la page
}
