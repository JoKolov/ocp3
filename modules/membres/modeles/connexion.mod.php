<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Modèle de la connexion
 *
 * File Last Update : 2017 08 18
 *
 * File Description :
 * -> vérifie l'intégrité des données transmises par le formulaire de connexion
 * -> vérifie l'existence du membre dans la base de données
 * -> on renvoi une erreur si l'athentification échoue
 *
 *
 * Utilisation des classes suivantes :
 * Membre
 * MembreMgr
 */

// CONSTANTES
// champs obligatoires du formulaire de connexion
define('LOG_FORM', array(
	'pseudo'	=> '',
	'password'	=> ''));



//------------------------------------------------------------
// COMMUNICATION AVEC CONTROLEUR
function modele_connexion()
{
	$statut_model = connexion_action();
	if ($statut_model === TRUE)
	{
		// $_SESSION['membre'] = instance Membre hydratée
		// renvoyer vers mon compte
		return url_format('membres','','compte');
	}
	else
	{
		// $statut_model = string avec les erreurs
		// renvoyer vers le formulaire
		return url_format('membres','','connexion',$statut_model);
	}
}





/**
 * [model_connexion description]
 * @return [Membre/array] [Renvoi une instance de Membre si tout est OK, sinon renvoi un tableau avec les erreurs]
 */
function connexion_action()
{

//------------------------------------------------------------
// CONTROLE DES DONNEES DU FORMULAIRE
	$control_post = control_post(LOG_FORM, $_POST); // contrôle les données de $_POST

	if($control_post === TRUE)
	{
		// le $_POST contient toutes les données obligatoire
		// on peut faire une recherche dans la base de données
		
		//------------------------------------------------------------
		// RECHERCHE DANS LA BASE DE DONNEES
		$membre = MembreMgr::login_check($_POST);
		if (is_object($membre))
		{
			$_SESSION['membre'] = $membre;
			$_SESSION['pseudo'] = $membre->get_pseudo();
			return TRUE; // tout est OK, on renvoi l'instance de Membre
		}
		else
		{
			$erreur['error'] = 'notfound';
			return $erreur;
		}
	}
	else
	{
		// il manque des données obligatoires dans le $_POST du formualaire
		// on récupère la liste des champs non rempli
		$erreur['error'] = $control_post;
		return $erreur;
	}


//------------------------------------------------------------
// RETOUR

}