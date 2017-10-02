<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Contrôleur Edition
 *
 * File Last Update : 2017 09 22
 *
 * File Description :
 * -> compile les données du formulaire à afficher
 *
 */

class EditionController {

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
			'error'			=> 	"Echec de l'enregistrement !",
			'titre'			=>	"Titre : donnez un titre au billet",
			'contenu'		=>	"Texte : le billet doit contenir du texte",
			'extrait'		=>	"Extrait : l'extrait est incorrect",
			'image'			=>	"Image : fichiers autorisés jpeg/png/gif",
			'sql'			=>	"Une erreur inattendue est survenue, réessayez l'enregistrement"
		];
	}


	//============================================================
	// Setteurs
	// -- NIL --


	//============================================================
	// Methodes

	/**
	 * ------------------------------
	 * [actionView description]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function actionView($request)
	{
		user_connected_only();
		admin_only();

		// Voulons-nous éditer un nouveau billet ?
		if (!is_null($request->get()['id']))
		{
			$billetMgr = new BilletMgr;
			$billet = $billetMgr->select($request->get()['id']);
			if ($billet->get_image_id() > 0)
			{
				$imageManager = new ImageMgr;
				$imageBillet = $imageManager->select(['id' => $billet->get_image_id()]);
				$billet->setImage($imageBillet->get_billet());
				$billet->setMiniature($imageBillet->get_vignette());
			}
		}

		if (!$billet)
		{
			$billet = new Billet;
		}

		$action = ['displayView' => $request->getViewFilename()];
		$objects = [
			'values' => new ViewValues(['userValues' => $values, 'errors' => setViewErrorValues($this->getErrorsTable())]),
			'membre' => $request->getMembre(),
			'billet' => $billet
		];

		$response = new Response($action, $objects);

		return $response;
	}


	/**
	 * ------------------------------
	 * [actionSubmit description]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function actionSubmit($request)
	{
		user_connected_only();
		admin_only();
		
		// récupération des données postées par l'utilisateur
		$post = $request->getPost(['titre', 'contenu', 'extrait', 'id', 'publier', 'sauvegarder']);
		$files = $request->getFiles(['imageBillet']);

		// vérification des données du formulaire grâce au modèle
		$billetOuErreur = $this->checkEditValues($post);

		// L'édition a échoué, des erreurs sont remontées
		if (array_key_exists('error', $billetOuErreur))
		{
			// on créer les messages d'erreurs
			$errors = $billetOuErreur['error'];		
			$errors['error'] = $this->getErrorsTable()['error'];
			foreach ($errors as $errorName => $errorText)
			{
				if (array_key_exists($errorName, $this->getErrorsTable()))
				{
					$errors[$errorName] = $this->getErrorsTable()[$errorName];
				}
			}

			// on renvoi la réponse à la requête !
			$action = ['redirect' => $request->getLastUrl()];
			$flash = new FlashValues(['errors' => $errors]);

			$response = new Response($action, ['flash' => $flash]);

			return $response;
		}

		// L'édition est validée
		$billet = $billetOuErreur['billet'];
		$billetMgr = new BilletMgr;

		if (!is_null($billet->get_id()))
		{
			$billet = $billetMgr->select($billet->get_id());
		}

		// check de l'image à la une
		if ($files['imageBillet']['name'] != '')
		{
			// vérification du fichier envoyé et création de l'image
			$imageBillet = new Image;
			$imageBillet = $imageBillet->createForBillet($files['imageBillet'], $billet);

			if (!$imageBillet)
			{
				$action = ['redirect' => $request->getLastUrl()];
				$flash = new FlashValues(['errors' => ['image' => "L'image n'a pas été prise en compte"]]);
				$response = new Response($action, ['flash' => $flash]);
				return $response;				
			}

			// enregistrement de l'image
			$imageManager = new ImageMgr;

			if ($billet->get_image_id() > 0)
			{
				//update
				$imageBillet->set_id($billet->get_image_id());
				$imageManager->update($imageBillet);
			}
			else
			{
				//insert
				$insert = $imageManager->insert($imageBillet);
				$urlImageBillet = $imageBillet->get_billet();
				$imageBillet = $imageManager->select(['billet' => $urlImageBillet]);
				$billet->set_image_id($imageBillet->get_id());
			}
		}


		$membre = $request->getMembre();

		$billet->set_auteur_id($membre->get_id());

		// On fait quoi du billet ? publication ou enregistrement seulement ?
		if (isset($post['publier']))
		{
			$billet->set_statut(Billet::STATUT['publier']);
		}
		else
		{
			$billet->set_statut(Billet::STATUT['sauvegarder']);
		}

		// Est-ce un nouveau billet ou un billet existant ?
		if (is_null($billet->get_id()))
		{
			// nouveau billet ou id erroné
			$billet->set_id($billetMgr->get_new_billets_id());

			// >>>>>
			// INSERT
			if (!$billetMgr->insert($billet))
			{
				$errors = ['sql' => "Une erreur inattendue est survenue, réessayez l'enregistrement"];
				$action = ['redirect' => $request->getLastUrl()];
				$flash = new FlashValues(['errors' => $errors]);
				$response = new Response($action, ['flash' => $flash]);
				return $response;
			}
		}
		else
		{
			// billet existant

			// >>>>>
			// UPDATE
			if (!$billetMgr->update($billet))
			{
				$errors = ['sql' => "Une erreur inattendue est survenue, réessayez l'enregistrement"];
				$action = [
					'redirect' => Response::urlFormat('billets','edition', '', [
						'id' => $billet->get_id()
					])
				];
				$flash = new FlashValues(['errors' => $errors]);
				$response = new Response($action, ['flash' => $flash]);
				return $response;
			}		
		}

		// Réponse à la requête
		$action = ['redirect' => Response::urlFormat('billets','edition', '', ['id' => $billet->get_id()])];
		$flash = new FlashValues(['success' => "Billet enregistré :)"]);
		$response = new Response($action, ['flash' => $flash]);

		return $response;
	}


	/**
	 * ------------------------------
	 * [checkEditValues description]
	 * @param  array  $post [description]
	 * @return [type]       [description]
	 */
	private function checkEditValues(array $post)
	{
		///  1  ///
		// Tous les champs obligatoires sont-ils renseignés ?
		$missingFields = missingRequiredFields([
			'titre'		=>	TRUE,
			'contenu'	=>	TRUE
		], $post);

		// Il manque un ou des champs obligatoires
		if (!empty($missingFields))
		{
			return ['error' => $missingFields];
		}

		///  2  ///
		// Les données renseignées sont-elles acceptables ?
		$billet = new Billet;

		if ($post['id'] == '')
		{
			unset($post['id']);
		}

		$billet->setValues($post);
		// Les données sont refusées
		if (!is_object($billet))
		{
			return ['error' => $billet];
		}

		// les données sont acceptées
		return ['billet' => $billet];

	}


} // end of class EditionController