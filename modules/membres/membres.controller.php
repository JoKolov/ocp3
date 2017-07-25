<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Controller
 *
 * File Last Update : 2017 07 25
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
if(isset($_GET['module'])) 	{ $nom_module = $_GET['module']; }	// 
if(isset($_GET['action'])) 	{ $nom_action = $_GET['action']; }	// 
if(isset($_GET['page'])) 	{ $nom_page = $_GET['page']; }		// 

// on vérifie que c'est bien ce controlleur qui est appelé
if(isset($_GET['module']) AND $_GET['module'] == MODULE_MEMBRES)
{
	//------------------------------------------------------------
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
//---
}

?>