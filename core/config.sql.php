<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : 
 * FILE/ROLE : config.sql.php
 *
 * File Last Update : 2017 07 25
 *
 * File Description :
 * -> Défini les paramètres de connexion à la base de données
 */

define("BDD", array(
	'host' 		=> 	'localhost', 	// serveur
	'name' 		=>	'ocp3_blog',	// nom de la base de données
	'login' 	=> 	'root',			// identifiant de connexion à la base de données
	'password' 	=>	'root'));		// mot de passe de connexion (MAMP = 'root', WAMP ='')