<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Controller
 *
 * File Last Update : 2017 07 26
 *
 * File Description :
 * -> vérifie l'intégrité des fichiers du module
 * -> défini les constantes nécessaires au module
 * -> appel les modèles du module
 * -> appel les vues du module
 * -> renvoi au controleur principal la vue demandée
 */


// constantes du fichier
define ('MODULE_MEMBRES', 'membres');							// nom du module

//---
//page connexion
define ('COMVIEW', array(
	'error-pseudo'		=> "L'identification a échoué : il manquait le pseudo...",
	'error-password'	=> "L'identification a échoué : il manquait le mot de passe...",
	'error-notfound'	=> "L'identification a échoué : login et/ou mot de passe incorrectes."
	));

// on vérifie que c'est bien ce controlleur qui est appelé
if(isset($_GET['module']) AND $_GET['module'] == MODULE_MEMBRES)
{
	
	if(get_model()) // si on trouve le model
	{
		echo '<br />modele trouvé <br />';
	}
	else
	{
		echo '<br />modele introuvable <br />';
	}

	/*
	/------------------------------------------------------------
	// UTILISATEUR CONNECTE
	if (isset($_SESSION['pseudo'])) // utilisateur connecté
	{
		echo '<p>Bonjour ' . $_SESSION['pseudo'] . '</p>';
		// afficher le pseudo
		// afficher le bouton de déconnexion
	}
	//------------------------------------------------------------
	// UTILISATEUR NON CONNECTE
	else // utilisateur non connecté
	{
		// va chercher modèle !
		get_model();
	}
	*/
//---
}

?>