<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : fontions
 * FILE/ROLE : Common (fonctions communes)
 *
 * File Last Update : 2017 08 30
 *
 * File Description :
 * -> contient des fonctions basiques communes à l'appli
 */

//------------------------------------------------------------
// Autoload générique
/**
 * gene_autoload : charge les classes appelées
 * @param  string $dossier : url du dossier contenant les classes
 * @param  		  $class   : nom de la classe appelée
 */
function gene_autoload(string $dossier, $class)
{
	$file = SITE_ROOT . '/' . $dossier . strtolower($class) . '.class.php';
	if(file_exists($file)) { require($file); }
}

//------------------------------------------------------------
// Autoload générique
/**
 * autoload_modules : charge les classes appelées appartenant à des modules indépendants
 * Récupère les noms des dossiers contenus dans le dossier des modules
 * Peut ainsi charger les classes de modules indépendants
 */
function autoload_modules($class)
{
	$dir = SITE_ROOT . '/modules';
	$modules = scandir($dir); // scan du dossier des modules

	foreach ($modules as $module)
	{
		if (!preg_match("#\.#", $module)) // si c'est bien un dossier (et pas un fichier)
		{
			gene_autoload('modules/' . $module . '/classes/', $class);
		}
	}
}



//------------------------------------------------------------
/**
 * Hash d'un mot de passe
 */
function get_hash($text) {
	return hash('sha256', 'b!:' . $text . '/?e9');
}



//------------------------------------------------------------
// Fonction pour vérifier que tous les champs obligatoires d'un formulaire sont transmis
/**
 * [control_post description]
 * @param  [array] $array [tableau de référence contenant toutes les $key valides obligatoires]
 * @param  [array] $post  [tableau du $_POST que l'on souhaite contrôler]
 * @return [boolean/string]      [renvoi 'true' si le contrôle est OK, sinon un 'string' avec les $key manquantes]
 */
function control_post(array $array, array $post) {
	
	// contrôle de $post
	foreach ($array as $key => $value) {
		if(!isset($post[$key]) OR $post[$key] == '')
		{
			if(!isset($erreur)) { $erreur = $key; }
			else /************/	{ $erreur .= $key; }
		}
	}

	// retour de validation du contrôle
	if(!isset($erreur))	{ return TRUE; }
	else 				{ return $erreur; }
}



//------------------------------------------------------------
//fonction de formatage de l'URL de redirection
function url_format(string $module, string $action = '', string $page ='', array $param = [])
{
	$url = '?module=' . $module;

	if($action <> '') 	{ $url .= '&action=' . $action; }
	if($page <> '') 	{ $url .= '&page=' . $page; }

	if(isset($param))
	{
		foreach ($param as $key => $value) {
			debug_var($param[$key]);
			$url .= '&' . $key . '=' . $value;
		}
	}

	return $url;
}



//------------------------------------------------------------
// formatage dans les balises alert boostrap
function error_format_form($text)
{
	return '<div class="alert alert-danger" role="alert"><strong>' . $text . '</strong></div>';
}



//------------------------------------------------------------
// contrôle un $_GET['error'] pour formatter le texte à afficher dans le code HTML
function errorView(array $comView, array $get)
{
	// $errViewReady tableau des erreurs formatées et prête à être intégrées au code HTML

	foreach ($comView as $key => $value)
	{
		// récupération des $key valides contenues dans le $comView
		// exemple $comView['error-login']
		// on récupère avec explode : $getKey = error et $getValue = login
		// on pourra ensuite vérifier si $get[$getKey] existe et contrôler son contenu
		list($getKey, $getValue) = explode('-', $key, 2);
		$pattern = '#' . $getValue . '#';

		if(isset($get[$getKey]) AND preg_match($pattern, $get[$getKey]))
		{
			$errViewReady[$getValue] = error_format_form($comView[$key]);
		}
		else
		{
			$errViewReady[$getValue] = '';
		}
	}

	if(isset($errViewReady)) 	{ return $errViewReady; }
	else 						{ return ''; }
}



//------------------------------------------------------------
// Création du tableau des variables pour une vue spécifique
function set_view_var($module = null, $page = null, $get = null)
{
	// setteur
	if (is_null($module) AND isset($_GET['module']))	{ $module = &$_GET['module']; }
	if (is_null($page) AND isset($_GET['page']))		{ $page = &$_GET['page']; }
	if (is_null($get) AND isset($_GET))					{ $get = $_GET; }

	// invlidité de la fonction
	if (is_null($module) OR is_null($page))
		{ return FALSE; }

	// on retire de la var $_GET toutes les lignes inutiles
	foreach (MVC_GET as $value) {
		if (isset($get[$value])) { unset($get[$value]); }
	}

	// on travaille avec une constante qui existe !
	// exemple : MEMBRES_CONNEXION
	$tableConst = strtoupper($module) . "_" . strtoupper($page);
	if (defined($tableConst)) 
	{
		// on récupère le tableau des constantes
		$tableConst = constant($tableConst);

		$view = [];

		// on parcours le tableau de constantes 
		// pour trouver les créer les variables qui nous interessent
		foreach ($tableConst as $key => $value) {
			// on extrait le type et la clé de la clé du tableau des constantes
			// exemple : $tableConst[$key = 'label.pseudo']
			// on extrait : $type = label et $cle = pseudo
			list($type, $cle) = explode('.', $key);
			// Si le type contient _GET, on sait qu'il est dépandant d'une valeur $_GET
			if (preg_match("#^_GET#", $type))
			{
				$type = str_replace('_GET', '', $type);
				if (!isset($get[$type]) OR !preg_match("#" . $cle . "#", $get[$type]) AND $cle <> $type)
				{
					$value = '';
				}
			}
			if ($type == 'error' AND $value <> '')
			{ $value = error_format_form($value); }

			$view[$type][$cle] = $value;
		}
		$_SESSION['view_var'] = $view;
		return TRUE;
	}
	return FALSE;
}



//------------------------------------------------------------
// DEBUG -> var_dump dans le code
function debug_var($var)
{
	echo '<pre>';
	echo var_dump($var);
	echo '</pre>';
}