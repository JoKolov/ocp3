<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Modèle de la page compte
 *
 * File Last Update : 2017 08 17
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

//--------------------------------------------------------------------------------

	// GESTION DE L'AVATAR
	//$_SESSION['avatar'] = $_FILES['image'];
	if (isset($_FILES['image']) AND $_FILES['image']['error'] == 0)
	{
		$maxSize = 1048576;
		if ($_FILES['image']['name'] <> '' AND $_FILE['avatar-file']['size'] <= $maxSize)
		{
			// contrôle du type de fichier
			$extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
			$extension_upload = strtolower(substr(strrchr($_FILES['image']['name'], '.'),1));
			//1. strrchr renvoie l'extension avec le point (« . »).
			//2. substr(chaine,1) ignore le premier caractère de chaine.
			//3. strtolower met l'extension en minuscules.
			if (in_array($extension_upload,$extensions_valides))
			{
				// on copie le fichier dans le répertoire des images
				$membre = $_SESSION['membre'];
				$nom = get_hash($membre->get_id()) . '.' . $extension_upload;
				$imgName = SITE_ROOT . '/upload/images/' . $nom;
				$deplacement = $resultat = move_uploaded_file($_FILES['image']['tmp_name'],$imgName);
				if ($deplacement)
				{
					// copie du fichier dans le dossier des avatars
					$avatarName = SITE_ROOT . '/upload/avatars/' . $nom;

					// on créer une erreur si la copie foire
					if (!copy($imgName, $avatarName))
					{
						$erreurs['error-av'] = 'copy';
					}
					else
					{
						// on redimensionne l'image
						define('AVATAR_MAX_WIDTH', 200);
						define('AVATAR_MAX_HEIGHT', 200);

						// on créer la miniature vide
						$imgRedim = imagecreatetruecolor(AVATAR_MAX_WIDTH, AVATAR_MAX_HEIGHT);
						$imgSource = imagecreatefromjpeg($avatarName);

						// on récupère les dimensions de l'image source
						$dimSource = getimagesize($avatarName); // [0] = width - [1] = height

						// les dimensions sont supérieures aux dimensions requises, on réduit l'image
						if ($dimSource[0] > AVATAR_MAX_WIDTH OR $dimSource[1] > AVATAR_MAX_HEIGHT)
						{
						// on créer la miniature
						imagecopyresampled($imgRedim, $imgSource, 0, 0, 0, 0, AVATAR_MAX_WIDTH, AVATAR_MAX_HEIGHT, $dimSource[0], $dimSource[1]);

						// on enregistre la miniature en écrasant le fichier existant
						imagejpeg($imgRedim, $avatarName, 100);

						// on détruit les images stockées en ressource PHP
						imagedestroy($imgRedim);
						imagedestroy($imgSource);
						}

					}
					$imgName = APP['url-website'] . '/upload/images/' . $nom;
					$avatarName = APP['url-website'] . '/upload/avatars/' . $nom;

					// fichier à intégrer dans la base de données Images
						// 	-> si l'id de l'avatar est celui par défaut on créer un nouveau fichier
					if ($membre->get_avatar_id() == 1)
					{
						$sql = 'INSERT INTO ocp3_Images 
								(source, avatar, description) 
								VALUES (:source, :avatar, :description)';
						$values = array(
							':source'		=> $imgName,
							':avatar'		=> $avatarName,
							':description'	=> 'avatar de ' . $membre->get_pseudo());
						$req = SQLmgr::getPDO()->prepare($sql);
						if (!$req->execute($values))
						{
							$erreurs['error-av'] = 'sql-insert';
						}


					}
					else //-> sinon on remplace le fichier en utilisant le même id
					{
						//----
					}


						// on met à jour l'objet membre avec les nouvelles données de l'avatar
						$membre->set_avatar($nom);
						$sql = 'SELECT id 
								FROM ocp3_Images 
								WHERE avatar = :avatar';
						$req = SQLmgr::getPDO()->prepare($sql);
						$value = array(':avatar' => $avatarName);
						if (!$req->execute($value))
						{
							$erreurs['error-av'] = 'sql-select';
						}
						else
						{
							$repSQL = $req->fetch();
							$id = $repSQL['id'];
							$membre->set_avatar_id($id);
							$membre->set_avatar($avatarName);
							$_SESSION['membre'] = $membre;
						}

				}
				else
				{
					$erreurs['error-av'] = 'copy';
				}
			}
		}
	}
	// FIN GESTION AVATAR

//--------------------------------------------------------------------------------

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