<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : fontions
 * FILE/ROLE : Common (fonctions communes)
 *
 * File Last Update : 2017 09 20
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
	$file = $dossier . strtolower($class) . '.class.php';
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
	$dir = SITE_ROOT . 'modules/';
	$modules = scandir($dir); // scan du dossier des modules

	foreach ($modules as $module)
	{
		if (!preg_match("#\.#", $module)) // si c'est bien un dossier (et pas un fichier)
		{
			gene_autoload($dir . $module . '/classes/', $class);
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
	foreach ($array as $arrayKey => $arrayValue) {
		if(!isset($post[$arrayKey]) OR $post[$arrayKey] == '')
		{
			if(!isset($erreur)) { $erreur = $arrayKey; }
			else /************/	{ $erreur .= $arrayKey; }
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
			$url .= '&' . $key . '=' . $value;
		}
	}

	return APP['url-website'] . $url;
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





/////   DESSOUS = A PARTIR DU 11 SEPT 2017   \\\\\
//------------------------------------------------------------
// Cherche un élément manquant dans un formulaire
/**
 * [formMissingRequiredFields description]
 * @param  array  $formReqFields  [description]
 * @param  array  $formUserFields [description]
 * @return [type]                 [description]
 */
function formMissingRequiredFields(array $formReqFields, array $formUserFields)
{
	$missingFields = '';
	
	foreach($formReqFields as $field => $required)
	{
		if ($required AND (is_null($formUserFields[$field]) OR $formUserFields[$field] == ''))
		{
			if ($missingFields == '')
			{
				$missingFields .= $field;
			}
			else
			{
				$missingFields .= '-' . $field;
			}
		}
	}

	if ($missingFields == '')
	{
		return;
	}

	return $missingFields;
}



//------------------------------------------------------------
// Création du tableau des variables pour une vue spécifique
/**
 * setViewVar() créer les variables d'une vue
 * @param [type] $module [description]
 * @param [type] $page   [description]
 * @param [type] $get    [description]
 */
function setViewVar($module, $page, $get)
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
// Création du tableau des variables pour une vue spécifique
function setViewErrorValues(array $errors, array $errorsToPublish = array())
{
	if (empty($errorsToPublish) AND array_key_exists('error', $errors))
	{
		$errors['error'] = '';
	}
	foreach ($errors as $errorKey => $errorMsg)
	{
		if ($errorKey <> 'error' AND !in_array($errorKey, $errorsToPublish))
		{
			$errors[$errorKey] = '';
		}
	}	
	return $errors;
}



//------------------------------------------------------------
// formatage dans les balises alert boostrap
function errorFormatHTML($error)
{
	$openBal = '<div class="alert alert-danger" role="alert"><strong>';
	$closeBal = '</strong></div>';

	if (is_string($error))
	{
		return $openBal . $error . $closeBal;
	}

	if (is_array($error))
	{
		foreach ($error as $errorKey => $errorText)
		{
			if ($errorText <> '')
			{
				$error[$errorKey] = $openBal . $errorText . $closeBal;
			}
		}
		return $error;
	}

	return '';

	
}






//------------------------------------------------------------
// DEBUG -> var_dump dans le code
function debug_var($var, $com = null)
{
	if (!is_null($com))
	{
		echo $com . '<br />';
	}
	echo '<pre>';
	echo var_dump($var);
	echo '</pre>';
}