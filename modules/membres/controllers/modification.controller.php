<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Modèle de la page compte
 *
 * File Last Update : 2017 08 29
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
// CONSTANTES DU MODELE
define('MEMBRES_MODIFICATION_FORM', array(
	));



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
		'nom'			=> '',
		'prenom'		=> '',
		'date_birth'	=> '');

	$champsPassword = array(
		'password'		=> '',
		'password-conf'	=> '');

	// Controle des champs envoyés
	$controlChampsOblig = control_post($champsObligatoires, $_POST); // vérifie que les champs obligatoires ont bien été envoyés


	// Vérification des données envoyées
	if ($controlChampsOblig === TRUE) // les champs obligatoires sont bien renseignés
	{
		// on récupère l'objet membre déjà instancié
		$membre = $_SESSION['membre'];

		//=====================
		// CONTROLE DES CHAMPS PASSWORD
		// si les 2 champs sont remplis et sont identiques, c'est bon, 
		// sinon on créer une erreur
		$controlChampsPassword = control_post($champsPassword, $_POST);
		$erreurs['error'] = check_password($controlChampsPassword);
		// on détruit l'erreur si elle est FALSE
		if (!$erreurs['error']) { unset($erreurs['error']); } 


		//=====================
		// CONTROLE DES AUTRES CHAMPS
		if (!isset($erreurs['error']))
		{
			// vérification des données des champs obligatoires en prio
			$verifChamps = $membre->setFull($_POST);

			// vérification de l'avatar
			$verifAvatar = check_avatar();
			if ($verifAvatar !== TRUE)
			{
				// l'avatar n'a pas été mis à jour !!
				if (isset($verifChamps['error'])) { $verifChamps['error'] .= 'avatar'; }
				else { $verifChamps = $verifAvatar; }
			}

			if ($verifChamps === TRUE) // tous les champs sont validés et intégrés dans les attributs de $membre
			{
				// on intègre les champs dans la base de données
				if (MembreMgr::update_membre($membre) === TRUE)
				{
					$_SESSION['membre'] = $membre;
					return url_format('membres','','modification',array('success' => TRUE));
				}
				else
				{
					$erreurs['error'] = 'sql';
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
		$erreurs['error'] = $controlChampsOblig; // erreurs champs requis
	}

	// on renvoi vers la page du formulaire avec les erreurs
	return url_format('membres','','modification', $erreurs);
}



function modification_action()
{

}



//------------------------------------------------------------
// VERIFICATION DE L'AVATAR
function check_avatar()
{
	if (isset($_FILES['image']) AND $_FILES['image']['error'] == 0)
	{
		// on créer une image à partir de l'image uploadée
		$image = new Image;

		// on vérifie que le fichier envoyé entre dans les critères
		// si c'est ok, le fichier temporaire est copié dans le dossier images
		if ($image->setfrom_FILE($_FILES['image']))
		{
			$membre = $_SESSION['membre'];

			// on met à jour le nom de l'image dans le dossier
			$image->renameFromId($membre->get_id());

			// on créer un avatar
			if ($image->set_avatar())
			{
				// on peut supprimer l'image source
				$image->delete('source');

				// on créer le manager qui appelera la base donnée de l'image
				$imageMgr = new ImageMgr;

				// on met à jour la description de l'image
				$image->set_description('Avatar de ' . $membre->get_pseudo());

				// si le membre possède déjà un avatar personnel,
				// on ne sauvegarde pas la nouvelle image dans la BDD
				// car la nouvelle a écrasé l'ancienne sur le serveur
				$avatar_id = $membre->get_avatar_id();
				if ($avatar_id > 1)
				{
					// on récupère les données de l'avatar AVANT UPDATE pour supprimer le fichier du serveur si le nom est différent
					$imageOld = $imageMgr->select(array('id' => $avatar_id));
					if ($imageOld->get_avatar() <> $image->get_avatar())
					{
						$imageOld->delete();
					}
					unset($imageOld);

					// on UPDATE le fichier dans la BDD (en cas de changement de type notamment, ex : jpeg devient png)
					$image->set_id($avatar_id);
					if ($imageMgr->update($image))
					{
						$membre->set_avatar($image->get_avatar());
						$_SESSION['membre'] = $membre;
						return TRUE;
					}
					return FALSE;
				}
				// Si le membre n'avait pas d'avatar personnalisé
				// on enregistre l'image dans la BDD
				else
				{
					// on tente une insertion dans la base de données
					if ($imageMgr->insert($image))
					{
						// on recherche immédiatement l'image enregistrée pour récupérer l'id
						// et mettre à jour l'instance membre
						$reqAvatar = $imageMgr->select(array('avatar' => $image->get_avatar()));
						if ($reqAvatar !== FALSE)
						{
							// mise à jour de l'objet membre
							unset($image);
							$membre->set_avatar_id($reqAvatar->get_id());
							$membre->set_avatar($reqAvatar->get_avatar());
							$_SESSION['membre'] = $membre;
							return TRUE;
						}
					}
				}
			}
		}
		$erreur['error'] = 'avatar';
		return $erreur;
	}

	return TRUE;
}



//------------------------------------------------------------
// VERIFICATION DU PASSWORD
function check_password($controlChampsPassword)
{
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
				return "password";
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
			return "password";
		}
	}
	return FALSE;
}; 