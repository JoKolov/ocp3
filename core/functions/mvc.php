<?php
/**
 * getcontroller.php
 */

//------------------------------------------------------------
// appel du controlleur de la page demandée
function get_controller()
{
	// vérifie si le controlleur existe
	// et le renvoi
	

	// on récupère les valeurs de l'URL si elles existent
	if(isset($_GET['module']))
	{
		$module = &$_GET['module'];

		// on créer le lien vers le fichier du modèle
		$file = 'modules/' . $module . '/' . $module . '.controller.php';

		// si le fichier existe, on l'inclu
		// sinon on lance l'erreur 404
		if(file_exists($file))
		{
			require($file);
		}
		else
		{
			require('themes/default/error404.php');
		}
	}
	else
	{
		// on affiche la page d'accueil
	}
	
}



//------------------------------------------------------------
// appel du model de la page demandée
function get_model()
{
	$module = &$_GET['module'];

	// vérifie sur le modele existe et le renvoi
	if(isset($_GET['action'])) // si on veut effectuer une action
	{
		$action = &$_GET['action'];
		// on créer le lien vers le fichier du modèle
		$file = 'modules/' . $module . '/modeles/' . $action . '.mod.php';
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



//------------------------------------------------------------
// appel de l'affichage de la page demandée
function get_view()
{
	// vérifie si la vue existe et la renvoi
}