<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * INDEX.PHP
 * FILE/ROLE : fichier parent
 *
 * File Last Update : 2017 09 11
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
define('EXECUTION', TRUE); // limiter les accès aux fichiers à l'appli
define('SITE_ROOT', __DIR__);


//------------------------------------------------------------
// Initialisation des fichiers
$initFile = 'core/init.php';
if (file_exists($initFile)) { require('core/init.php'); }
else { echo "Erreur !: echec de l'initialisation <br /> Fichier init.php introuvable <br />"; die; }


//------------------------------------------------------------
// Initialisation du processus MVC
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); }
$request = new Request($_SESSION, $_GET, $_POST, $_FILES);


//------------------------------------------------------------
// Initialisation du processus MVC
$view = $request->runController();
$viewReponse = $request->displayView($view);


//------------------------------------------------------------
// Suppression de la variable d'affichage des données des vues
unset($_SESSION['view_var']);


?>