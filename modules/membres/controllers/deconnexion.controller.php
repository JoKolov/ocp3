<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Modèle de la déconnexion
 *
 * File Last Update : 2017 08 08
 *
 * File Description :
 * -> détruit la session
 * -> renvoi vers le formulaire de connexion
 *
 *
 * Utilisation des classes suivantes :
 * Membre
 * MembreMgr
 */


// fin de la session
$_SESSION = array();
session_destroy();

function modele_deconnexion()
{
	return url_format('membres','','connexion'); // on renvoi vers la page de connexion
}