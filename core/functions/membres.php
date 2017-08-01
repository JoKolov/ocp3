<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres (emplacement dans CORE/functions)
 * FILE/ROLE : fonctions spécifiques au module 'membres'
 *
 * File Last Update : 2017 07 31
 *
 * File Description :
 * -> Fonctions spécifiques au module "membres"
 */

function user_connected()
{
	if(!isset($_SESSION['pseudo'])) { header("Location: ?module=membres&page=connexion"); die; }
}