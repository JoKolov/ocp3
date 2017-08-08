<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Modèle de la page compte
 *
 * File Last Update : 2017 08 08
 *
 * File Description :
 * -> contrôle les données du formulaire de modification
 * -> modifie les données dans la base de données si tout est ok
 * -> sinon renvoi un tableau d'erreurs et redirige vers la page de modification
 *
 * Utilisation des classes suivantes :
 * Membre
 * MembreMgr
 */


//------------------------------------------------------------
// COMMUNICATION AVEC CONTROLEUR
// renvoi une url
function modele_modification()
{
	// Définition des champs disponibles
	$champsObligatoires = array(
		'pseudo'		=> '',
		'email'			=> '');

	$champsOption = array(
		'avatar'	=> '',
		'nom'			=> '',
		'prenom'		=> '',
		'date_birth'	=> '');

	$champsPassword = array(
		'password'		=> '',
		'password-conf'	=> '');


	// Controle des champs envoyés
	$controlChampsOblig = control_post($champsObligatoires, $_POST); // vérifie que les champs obligatoires ont bien été envoyés

	//if (isset($_POST['avatar']) AND $_POST['avatar'] == '') { unset($_POST['avatar']); }

	// Vérification des données envoyées
	if ($controlChampsOblig === TRUE) // les champs obligatoires sont bien renseignés
	{
		// on récupère l'instance membre du membre connecté
		$membre = $_SESSION['membre'];

		// contrôle des champs password
		// si les 2 champs sont remplis et sont identiques, c'est bon, 
		// sinon on créer une erreur
		$controlChampsPassword = control_post($champsPassword, $_POST);
		$verifPassword = function($controlChampsPassword) {
			if ($controlChampsPassword) // si = TRUE ou string
			{
				if ($controlChampsPassword === TRUE)
				{
					if ($_POST['password'] === $_POST['password-conf'])
					{
						unset($_POST['password-conf']); // le password peut être testé dans l'instance $membre
						return FALSE;
					}
					else
					{
						unset($_POST['password']);
						unset($_POST['password-conf']);
						return "diff";
					}
				}
				elseif ($_POST['password'] == '' AND $_POST['password-conf'] =='')
				{
					unset($_POST['password']);
					unset($_POST['password-conf']);
					return FALSE;
				}
				else
				{
					unset($_POST[$controlChampsPassword]);
					return "less";
				}
			}
			return FALSE;
		}; 

		$erreurs['error-password'] = $verifPassword($controlChampsPassword);
		if (!$erreurs['error-password']) { unset($erreurs['error-password']); } // on détruit l'erreur si elle est FALSE

		if (!isset($erreurs['error-password']))
		{
			// vérification des données des champs obligatoires en prio
			$verifChamps = $membre->setFull($_POST);

			if ($verifChamps === TRUE) // tous les champs sont validés et intégrés dans les attributs de $membre
			{
				// on intègre les champs dans la base de données
				if (MembreMgr::update_membre($membre) === TRUE)
				{
					return url_format('membres','','modification',array('success' => TRUE));
				}
				else
				{
					$erreurs['error-sql'] = 'db';
				}
			}
			else // certains champs n'ont pas été validés, les champs validés ont été intégrés dans les attributs de $membre
			{
				$erreurs = $verifChamps; // tableau contenant les erreurs : $table['error'] = string contenant les erreurs
				// renvoyer vers la page de modification avec les erreurs $erreurs (url?error=$erreurs)
			}
		}
	}
	else // les champs obligatoires ne sont pas tous renseignés
	{
		// $controlChampsOblig = string contenant les noms des champs non renseignés
		$erreurs['error-req'] = $controlChampsOblig; // erreurs champs requis
	}

	// on renvoi vers la page du formulaire avec les erreurs
	return url_format('membres','','modification', $erreurs);
}