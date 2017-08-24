<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * INDEX.PHP
 * FILE/ROLE : fichier parent
 *
 * File Last Update : 2017 08 15
 *
 * File Description :
 * -> charge la session
 * -> charge les fichiers du CORE
 * -> appel les controleurs de l'appli
 * -> récupère le statut du contrôleur appelé
 * -> renvoi la vue appropriée
 */



/**
 * >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
 * MEMO
 * -> Créer une fonction pour charger les fichiers CORE
 * -> Créer le contrôle des contrôleurs
 * -> Gérer l'affichage avec plus de précision
 * <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
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
// Appel du contrôleur approprié
get_controller();



//------------------------------------------------------------
// Appel de la vue appropriée
if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } // activation de la session si elle ne l'ai pas déjà
get_view();

?>