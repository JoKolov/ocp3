<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : 
 * FILE/ROLE : init.php
 *
 * File Last Update : 2017 07 27
 *
 * File Description :
 * -> appel les fichiers nécessaires au fonctionnement de l'application
 */


//------------------------------------------------------------
/**
 * req_file()
 * Vérifie si le fichier existe avant d'effectuer un require
 * @param  string $file [chemin du fichier]
 * @return [type]       [require($file) OU erreur]
 */
function req_file(string $file)
{
	if(file_exists($file))
	{
		return require($file);
	}
	else
	{
		echo 'Erreur !: fichier non chargé : ' . $file . '<br />';
		return die;
	}
}


//------------------------------------------------------------
// Chargement des constantes

req_file('core/config.php');
req_file('core/config.sql.php');



//------------------------------------------------------------
// Chargement des fonctions

foreach (glob("core/functions/*.php") as $filename) {
	require($filename);
}



//------------------------------------------------------------
// Chargement des classes du Core

function core_autoload($class) { gene_autoload('core/classes/', $class); }
spl_autoload_register('core_autoload');

