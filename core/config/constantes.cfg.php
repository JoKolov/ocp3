<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : 
 * FILE/ROLE : config.php
 *
 * File Last Update : 2017 08 24
 *
 * File Description :
 * -> Défini les constantes de l'application
 */

$protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"],0,5))=='https'?'https':'http';

define ('APP', [
	'url-protocol'	=> $protocol,
	'url-server'	=> $_SERVER['SERVER_NAME'],
	'url-website'	=> $protocol . '://' . $_SERVER['SERVER_NAME'] . "/",
	'url-dir'		=> 'ocp-three',
	'file-404'		=> 'themes/default/error404.php',
	'theme-dir'		=> SITE_ROOT . 'themes/default/'
]);


// constantes utilisées pour la gestion du MVC dans la variable $_GET  
define ('MVC_GET', array('module', 'action', 'page'));