<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * INDEX.PHP
 * FILE/ROLE : fichier parent
 *
 * File Last Update : 2017 07 25
 *
 * File Description :
 * -> charge la session
 * -> charge les fichiers du CORE
 * -> appel les controleurs de l'appli
 * -> récupère le statut du contrôleur appelé
 * -> renvoi la vue appropriée
 */

session_start();

/**
 * >>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
 * MEMO
 * -> Créer une focntion pour charger les fichiers CORE
 * -> Créer l'autoload des classes
 * -> Créer le contrôle des contrôleurs
 * -> Gérer l'affichage avec plus de précision
 * <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
 */
require('core/config.sql.php');
require('core/classes/sqlmgr.class.php');
require('modules/membres/classes/membre.class.php');
require('modules/membres/classes/membremgr.class.php');
require('core/functions/mvc.php');


get_controller();
get_view();


?>