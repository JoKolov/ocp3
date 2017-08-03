<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Modèle de la page compte
 *
 * File Last Update : 2017 08 02
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

	// Vérification des données envoyées
	if($controlChampsOblig === TRUE) // les champs obligatoires sont bien renseignés
	{
		$membre = $_SESSION['membre'];
		// vérification des données des champs obligatoires en prio
		$verifChamps = $membre->setFull($_POST);

		if ($verifChamps === TRUE) // tous les champs sont validés et intégrés dans les attributs de $membre
		{
			// on intègre les champs dans la base de données
			if (MembreMgr::update_membre($membre) === TRUE)
			{
				echo 'UPDATE membre OK';
			}
			else
			{
				echo 'UPDATE membre foiré !!';
			}
		}
		else // certains champs n'ont pas été validés, les champs validés ont été intégrés dans les attributs de $membre
		{
			$erreurs = $verifChamps;
		}
	}
	else // les champs obligatoires ne sont pas tous renseignés
	{

	}
}