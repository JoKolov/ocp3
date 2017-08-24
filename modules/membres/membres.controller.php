<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Controller
 *
 * File Last Update : 2017 08 08
 *
 * File Description :
 * -> vérifie l'intégrité des fichiers du module
 * -> défini les constantes nécessaires au module
 * -> appel les modèles du module
 * -> appel les vues du module
 * -> renvoi au controleur principal la vue demandée
 */

//------------------------------------------------------------
// chargement des classes du module Membres

function membres_autoload($class) { gene_autoload('modules/membres/classes/', $class); }
spl_autoload_register('membres_autoload');



//------------------------------------------------------------
// début de session
session_start();


//------------------------------------------------------------
// constantes du fichier
define ('MODULE_MEMBRES', 'membres');	// nom du module


//tableau des erreurs à afficher
define ('COMVIEW', array(
	'error-pseudo'		=> "L'identification a échoué : il manquait le pseudo...",
	'error-password'	=> "L'identification a échoué : il manquait le mot de passe...",
	'error-notfound'	=> "L'identification a échoué : login et/ou mot de passe incorrectes."
	));



//------------------------------------------------------------
// on vérifie que c'est bien ce controlleur qui est appelé
if(isset($_GET['module']) AND $_GET['module'] == MODULE_MEMBRES)
{

	if(get_model()) // si on trouve le model
	{
		// charge les données pour la vue
		// et on renvoi vers la vue
		$fonctionModele = 'modele_' . $_GET['action'];
		if(function_exists($fonctionModele))
		{
			header('Location: ' . $fonctionModele());
		}
	}
}

?>