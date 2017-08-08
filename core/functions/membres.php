<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres (emplacement dans CORE/functions)
 * FILE/ROLE : fonctions spécifiques au module 'membres'
 *
 * File Last Update : 2017 08 08
 *
 * File Description :
 * -> Fonctions spécifiques au module "membres"
 */

function user_connected_only()
{
	if(!isset($_SESSION['pseudo'])) { header("Location: ?module=membres&page=connexion&error=user-access"); die; }
}