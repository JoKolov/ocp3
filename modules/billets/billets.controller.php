<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Controller
 *
 * File Last Update : 2017 08 30
 *
 * File Description :
 * -> vérifie l'intégrité des fichiers du module
 * -> défini les constantes nécessaires au module
 * -> appel les modèles du module
 * -> appel les vues du module
 * -> renvoi au controleur principal la vue demandée
 */

//------------------------------------------------------------
// début de session
session_start();



//------------------------------------------------------------
// constantes du fichier
require ('modules/billets/config/constantes.cfg.php');



//------------------------------------------------------------
// on vérifie que c'est bien ce controlleur qui est appelé
if(isset($_GET['module']) AND $_GET['module'] == MODULE_BILLETS)
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