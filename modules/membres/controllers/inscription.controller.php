<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Modèle de l'inscription
 *
 * File Last Update : 2017 08 15
 *
 * File Description :
 * -> vérifie l'intégrité des données transmises par le formulaire d'inscription
 * -> *************
 * -> VERIFIER QUE LE MEMBRE N'EXISTE PAS !!!!!
 * -> *************
 * -> insère les données dans la base de données si elles sont OK
 * -> sinon, renvoi vers le formulaire d'inscription avec les erreurs
 *
 *
 * Utilisation des classes suivantes :
 * Membre
 * MembreMgr
 */


//------------------------------------------------------------
// COMMUNICATION AVEC CONTROLEUR
// renvoi une url
function modele_inscription()
{
	$formInscription = array(
	'login'		=>	'',
	'email'		=> 	'',
	'password'	=> 	''
	);

	// récupération des champs dans la variable session
	foreach ($formInscription as $key => $value) {
		if (isset($_POST[$key])) { $_SESSION[$key] = $_POST[$key]; }
	}

	// controle des données du formulaire
	// Controle des champs envoyés
	$controlChamps = control_post($formInscription, $_POST); // vérifie que les champs obligatoires ont bien été envoyés

	if ($controlChamps === TRUE) // les champs sont complétés
	{

		// définition des paramètres par défaut d'un noveau membre
		$formInscription['pseudo'] = $_POST['login'];
		unset($_formInscription['login']);
		$formInscription['email'] = $_POST['email'];
		$formInscription['password'] = $_POST['password'];
		$formInscription['type_id'] = 2; 	// compte abonné
		$formInscription['avatar_id'] = 1; 	// avatar par défaut
		$formInscription['avatar'] = '';

		// test d'insertion des données du nouveau membre
		$membre = new Membre(); // création d'un objet membre
		$verifDonnees = $membre->setFull($formInscription); /*// tentative d'hydratation de l'objet : en cas d'échec, $membre devient un array contenant les erreurs ou FALSE*/
		if ($verifDonnees === TRUE) // tous les champs sont validés par la classe membre
		{
			if (MembreMgr::insert_membre($membre) === TRUE) //on effetue l'insertion dans la BDD
			{
				// on récupère toutes les données de la BDD
				$membre = MembreMgr::login_check(array(
					'pseudo'	=> $membre->get_pseudo(),
					'password'	=> $_POST['password']));
				// on sauvegarde le membre dans la session
				$_SESSION['membre'] = $membre;
				$_SESSION['pseudo'] = $membre->get_pseudo();
				return url_format('membres','','compte'); // on peut se connecter au compte
			}
			else // si l'insertion a échoué
			{
				$erreurs['error'] = 'sql';
			}
		}
		else // certains champs sont incorects
		{
			$erreurs['error'] = &$verifDonnees['error'];
		}
	}
	else // il manque des champs (noms des champs contenus dans $controlChamps)
	{
		$erreurs['error'] = &$controlChamps;
	}


	// En cas d'erreurs, on renvoi vers la page d'inscription avec les erreurs
	return url_format('membres','','inscription', $erreurs);
}