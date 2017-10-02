<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : 
 * FILE/ROLE : config.sql.php
 *
 * File Last Update : 2017 08 08
 *
 * File Description :
 * -> Défini les paramètres de connexion à la base de données
 */

if (APP['url-server'] == "localhost") {
	define("BDD", array(
		'host' 		=> 	'localhost', 	// serveur
		'name' 		=>	'ocp3_blog',	// nom de la base de données
		'login' 	=> 	'root',			// identifiant de connexion à la base de données
		'password' 	=>	'root'));		// mot de passe de connexion (MAMP = 'root', WAMP ='')
}
else {
	define("BDD", array(
		'host' 		=> 	'cl1-sql22', 	// serveur
		'name' 		=>	'p6379_2',		// nom de la base de données
		'login' 	=> 	'p6379_2',		// identifiant de connexion à la base de données
		'password' 	=>	'@de$86h3LL'));	// mot de passe de connexion (MAMP = 'root', WAMP ='')
}