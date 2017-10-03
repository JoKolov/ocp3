<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * INDEX.PHP
 * FILE/ROLE : fichier parent
 *
 * File Last Update : 2017 09 21
 *
 * File Description :
 * -> charge la session
 * -> charge les fichiers du CORE
 * -> appel les controleurs de l'appli
 * -> récupère le statut du contrôleur appelé
 * -> renvoi la vue appropriée
 */

//------------------------------------------------------------
// Initialisation des constantes
ini_set('memory_limit','256M');
define('EXECUTION', TRUE); // limiter les accès aux fichiers à l'appli
define('SITE_ROOT', __DIR__ . '/');

//------------------------------------------------------------
// Initialisation des fichiers
$initFile = SITE_ROOT . 'core/init.php';
if (file_exists($initFile)) { require_once ($initFile); }
else { echo "Erreur !: echec de l'initialisation <br /> Fichier init.php introuvable <br />"; die; }


//------------------------------------------------------------
// Initialisation du processus MVC
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
$request = new Request($_SESSION, $_GET, $_POST, $_FILES);


//------------------------------------------------------------
// Initialisation du processus MVC
//debug_var($_SESSION, "index.php :: 40 >> \$_SESSION");
$response = $request->runController();
$response->runResponseAction();
unset($_SESSION['view_var']);

?>