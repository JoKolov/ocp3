<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Modèle de la page édition (billet)
 *
 * File Last Update : 2017 08 30
 *
 * File Description :
 * -> compile les données du formulaire à afficher
 *
 */


function modele_edition()
{
	$_SESSION['varbug'] = $_SESSION['membre'];
	admin_only();
}
