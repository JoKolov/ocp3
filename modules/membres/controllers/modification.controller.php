<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Modèle de la page compte
 *
 * File Last Update : 2017 09 19
 *
 * File Description :
 * -> contrôle les données du formulaire de modification
 * -> modifie les données dans la base de données si tout est ok
 * -> sinon renvoi un tableau d'erreurs et redirige vers la page de modification
 */

class ModificationController {

	//============================================================
	// Attributs
	// -- NIL --


	//============================================================
	// Constructeur et méthodes magiques
	// -- NIL --
	

	//============================================================
	// Getteurs
	private function getErrorsTable()
	{
		return [
			'error'				=>	"Echec modification !",
			'pseudo.req'		=>	"Pseudo obligatoire ;)",
			'pseudo'			=>	"Pseudo : Au moins 4 caractères alphanumériques sans espace (- et _ tolérés)",
			'email.req'			=>	"Adresse email obligatoire ;)",
			'email'				=>	"Email : L'adresse email doit être du type nom@domaine.fr",
			'avatar'			=>	"Avatar : Fichiers autorisés : .jpg, .jpeg, .png, .gif :: 1Mo max",
			'nom'				=>	"Nom : Lettres, espaces, ' et - acceptés",
			'prenom'			=>	"Prénom : Lettres, espaces, ' et - acceptés",
			'date_birth'		=>	"Date de naissance : La date doit être valide ",
			'password'			=>	"Mot de passe : Au moins 8 caractères dont au moins 1 chiffre ;)",
			'password.req'		=>	"Vous devez entrez 2 fois votre nouveau mot de passe",
			'passwordconf.req'	=>	"Vous devez entrez 2 fois votre nouveau mot de passe",
			'password.diff'		=>	"Les 2 passwords doivent être identiques ;),",
			'avatar.upload'		=> 	"Erreur lors de l'upload de l'avatar",
			'avatar.source'		=> 	"Aucun fichier trouvé pour l'avatar",
			'avatar.format'		=> 	"Fichiers autorisés pour l'avatar : .jpg, .jpeg, .png, .gif :: 1Mo max",
			'avatar.sqlupdate'	=> 	"Erreur lors de la mise à jour de l'avatar :  veuillez réessayer svp :)",
			'avatar.sqlinsert'	=> 	"Erreur lors de l'enregistrement de l'avatar : veuillez réessayer svp ;)",
			'avatar.sql'		=> 	"Le nouvel avatar n'a pas été trouvé dans la BDD : veuillez réessyer svp :)"
		];
	}


	//============================================================
	// Setteurs
	// -- NIL --


	//============================================================
	// Methodes

	//------------------------------------------------------------
	public function actionView($request)
	{
		user_connected_only();

		$membre = $request->getMembre();

		$action = ['displayView' => $request->getViewFilename()];
		$objects = [
			'membre' => $membre,
			'values' => new ViewValues(['errors' => setViewErrorValues($this->getErrorsTable())])
		];

		$response = new Response($action, $objects);

		return $response;
	}


	//------------------------------------------------------------
	public function actionSubmit($request)
	{
		user_connected_only();

		// 1) on récupère les données postées par l'utilisateur
		$post 	=  $request->getPost(['pseudo', 'nom', 'prenom', 'date_birth', 'email', 'password', 'passwordconf']);
		$files 	=  $request->getFiles(['avatar']);
		$membre =  $request->getMembre();

		// 2) vérification des données du formulaire grâce au modèle
		$modification = $this->controleDonneesFormulaire($post, $files, $membre);

		// La modification a échoué, des erreurs sont remontées
		if (array_key_exists('error', $modification))
		{
			$url = url_format('membres', '', 'modification');
			
			// on créer les messages d'erreurs
			$errorsFound = explode('-', $modification['error']); // tableau contenant les erreurs séparées par un -
			$sessionErrors = setViewErrorValues($this->getErrorsTable(), $errorsFound);

			$action = ['redirect' => Response::urlFormat('membres','modification')];
			$flash = new FlashValues(['errors' => $sessionErrors]);

			$response = new Response($action, ['flash' => $flash]);

			return $response;
		}

		// La modification est validée
		$membre = $modification['membre'];
		$request->setSessionVar(array(
			'pseudo' 	=> $membre->get_pseudo(),
			'membre'	=> $membre
			)
		);
		
		$flash = new FlashValues(['success' => "Modifications enregistrées :)"]);
		$action = ['redirect' => Response::urlFormat('membres','modification')];

		$response = new Response($action, ['flash' => $flash]);

		return $response;
	}


	//------------------------------------------------------------
	private function controleDonneesFormulaire(array $post, array $files, Membre $membre)
	{
		///  1  ///
		// Tous les champs obligatoires sont-ils renseignés ?
		$missingFields = formMissingRequiredFields([
			'pseudo'	=>	TRUE,
			'email'		=> 	TRUE
		], $post);

		// Il manque un ou des champs obligatoires
		if (!is_null($missingFields))
		{
			return ['error' => $missingFields];
		}

		// Les champs password sont-ils tous les 2 renseignés avec la même valeur ?
		$missingFields = formMissingRequiredFields([
			'password'		=>	TRUE,
			'passwordconf'	=>	TRUE
		], $post);

		$passwordFieldsMissing = count(explode('-', $missingFields));

		// un champ password a été complété mais pas l'autre
		if ($passwordFieldsMissing == 1)
		{
			return ['error' => $missingFields . '.req'];
		}

		// les 2 champs sont complétés mais ne sont pas identiques
		if ($passwordFieldsMissing != 2 AND $post['password'] != $post['passwordconf'])
		{
			return ['error' => 'password.diff'];
		}


		///  2  ///
		// Check de l'avatar
		$filesImage = $files['avatar'];

		if ($filesImage['name'] != '')
		{
			$avatar = $this->checkAvatar($filesImage, $membre);

			if (array_key_exists('error', $avatar))
			{
				return ['error' => $avatar['error']];
			}

			$membre->set_avatar($avatar['url']);

			if (isset($avatar['id']))
			{
				$membre->set_avatar_id($avatar['id']);
			}
		}


		///  3  ///
		// Les données renseignées sont-elles acceptables ?
		$formPostValues = [
			'pseudo'		=> $post['pseudo'],
			'nom'			=> $post['nom'],
			'prenom'		=> $post['prenom'],
			'date_birth'	=> $post['date_birth'],
			'email'			=> $post['email']
		];

		if ($post['password'] != '') { $formPostValues['password'] = $post['password']; }

		$membre = $membre->checkModification($formPostValues);

		// Des données ont été refusées
		if (!is_object($membre))
		{
			return ['error' => $membre];
		}


		///  4  ///
		// On update la BDD
		$updateMembre = MembreMgr::update_membre($membre);

		// Le membre existe déjà
		if (!$updateMembre)
		{
			return ['error' => 'sql'];
		}

		return ['membre' => $membre];	
	}



	private function checkAvatar(array $filesImage, Membre $membre)
	{
		if ($filesImage['error'] <> 0)
		{
			return ['error' => 'avatar.upload'];
		}

		// on créer une image à partir de l'image uploadée
		$image = new Image;

		// on vérifie que le fichier envoyé entre dans les critères
		if (!$image->createFromFiles($filesImage))
		{
			return ['error' => 'avatar.source'];
		}

		// On contrôle la taille du fichier
		


		// si c'est ok, le fichier temporaire est copié dans le dossier images
		// on met à jour le nom de l'image dans le dossier
		$image->renameFromId($membre->get_id());

		// on créer un avatar
		if (!$image->set_avatar())
		{
			return ['error' => 'avatar.format'];
		}

		// on peut supprimer l'image source
		$image->delete('source');

		// on créer le manager qui appelera la base donnée de l'image
		$imageMgr = new ImageMgr;

		// on met à jour la description de l'image
		$image->set_description('Avatar de ' . $membre->get_pseudo());

		// si le membre possède déjà un avatar personnel,
		// on ne sauvegarde pas la nouvelle image dans la BDD
		// car la nouvelle image a écrasé l'ancienne sur le serveur
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
			if (!$imageMgr->update($image))
			{
				return ['error' => 'avatar.sqlupdate'];
			}

			return ['url' => $image->get_avatar()];
		}
		

		// Si le membre n'avait pas d'avatar personnalisé
		// on enregistre l'image dans la BDD

		// on tente une insertion dans la base de données
		if (!$imageMgr->insert($image))
		{
			return ['error' => 'avatar.sqlinsert'];
		}

		// on recherche immédiatement l'image enregistrée pour récupérer l'id
		// et mettre à jour l'instance membre
		$reqAvatar = $imageMgr->select(array('avatar' => $image->get_avatar()));

		if (!$reqAvatar)
		{
			return ['error' => 'avatar.sql'];
		}
		
		unset($image);

		return [
			'url' 	=> $reqAvatar->get_avatar(),
			'id'	=> $reqAvatar->get_id()
		];		
	}


} // end of class InscriptionController