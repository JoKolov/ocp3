<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : fontions
 * FILE/ROLE : Common (fonctions communes)
 *
 * File Last Update : 2017 08 03
 *
 * File Description :
 * -> contient des fonctions basiques communes à l'appli
 */

//------------------------------------------------------------
// Autoload générique
/**
 * [gene_autoload : charge les classes appelées]
 * @param  string $dossier : url du dossier contenant les classes
 * @param  		  $class   : nom de la classe appelée
 */
function gene_autoload(string $dossier, $class)
{
	$file = $dossier . $class . '.class.php';
	if(file_exists($file)) { require($file); }
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
// DEBUG -> var_dump dans le code
function debug_var($var)
{
	echo '<pre>';
	echo var_dump($var);
	echo '</pre>';
}