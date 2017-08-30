<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres (emplacement dans CORE/functions)
 * FILE/ROLE : fonctions spécifiques au module 'membres'
 *
 * File Last Update : 2017 08 29
 *
 * File Description :
 * -> Fonctions spécifiques au module "membres"
 */

function user_connected_only()
{
	if(!isset($_SESSION['pseudo'])) { header("Location: ?module=membres&page=connexion&error=user-access"); die; }
}

function admin_only()
{
	if(isset($_SESSION['pseudo'])) 
	{ 
		$membre = $_SESSION['membre'];	
		if ($membre->get_type_id() <> 1)
		{
			header("Location: ?module=membres&page=compte&access=admin-only"); die;
		}
	}
}