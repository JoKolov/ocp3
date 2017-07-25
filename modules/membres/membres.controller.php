<?php

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

		// MODELES
		if(isset($_GET['action'])) // si on veut effectuer une action
		{
			// on créer le lien vers le fichier du modèle
			$file = 'modules/' . MODULE_MEMBRES . '/modeles/' . $_GET['action'] . '.mod.php';
			if(file_exists($file)) // si le fichier existe, on l'intègre
			{
				require($file);
			}
			else // sinon on affiche une erreur
			{
				echo 'Erreur !: le fichier ' . $file . ' est introuvable. <br />';
			}
		}


		// VUES
		if(isset($_GET['page'])) // si on veut effectuer une action
		{
			// on créer le lien vers le fichier du modèle
			$file = 'modules/' . MODULE_MEMBRES . '/views/' . $_GET['page'] . '.view.php';
			if(file_exists($file)) // si le fichier existe, on l'intègre
			{
				require($file);
			}
			else // sinon on affiche une erreur
			{
				echo 'Erreur !: le fichier ' . $file . ' est introuvable. <br />';
			}
		}

	}
//---
}

?>