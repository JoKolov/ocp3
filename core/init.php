<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : 
 * FILE/ROLE : init.php
 *
 * File Last Update : 2017 09 13
 *
 * File Description :
 * -> appel les fichiers nécessaires au fonctionnement de l'application
 */


//------------------------------------------------------------
// Chargement des constantes
// tous les fichiers .php contenus dans le dossier config

foreach (glob(SITE_ROOT . "core/config/*.php") as $filename) {
	require($filename);
}



//------------------------------------------------------------
// Chargement des fonctions
// tous les fichiers .php contenus dans le dossier functions

foreach (glob(SITE_ROOT . "core/functions/*.php") as $filename) {
	require($filename);
}



//------------------------------------------------------------
// Chargement des classes du Core

function core_autoload($class) { gene_autoload(SITE_ROOT . 'core/classes/', $class); }
spl_autoload_register('core_autoload');

// Chargement de toutes les classes de chaque module
spl_autoload_register('autoload_modules');