<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Commentaire
 * FILE/ROLE : Enregistrer un commentaire
 *
 * File Last Update : 2017 09 25
 *
 * File Description :
 * -> ajouter un commentaire dans la BDD
 *
 */

class AjouterController {

	//============================================================
	// Attributs
	// -- NIL --


	//============================================================
	// Constructeur et méthodes magiques
	// -- NIL --
	

	//============================================================
	// Getteurs
	// -- NIL --

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
		return $this->actionSubmit($request);
	}


	/**
	 * ------------------------------
	 * [actionSubmit description]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function actionSubmit($request)
	{
		// récupération des données du formulaire
		$post = $request->getPost([
			'contenu',
			'billet_id',
			'com_id',
			'com_level',
			'auteur_id'
		]);

		// vérification existence des champs obligatoires
		$requiredFields = [
			'contenu'	 => TRUE, 
			'billet_id'	 => TRUE 
		];
		$missingRequiredFields = missingRequiredFields($requiredFields, $post);

		// il manque un ou des champs obligatoires
		if (!empty($missingRequiredFields))
		{
			$action = ['redirect' => Response::urlFormat('commentaires','admin')];
			$errorsValues = [
				'contenu' 	=> 'le commentaire doit contenir un texte',
				'billet_id' => "le commentaire n'est lié à aucun billet"
			];
			foreach ($missingRequiredFields as $keyError => $requiredInfo)
			{
				if (array_key_exists($keyError, $errorsValues))
				{
					$errors[$keyError] = $errorsValues[$keyError];
				}
			}
			$flash = new FlashValues(['errors' => $errors]);

			return new Response($action, ['flash' => $flash, 'membre' => $request->getMembre()]);
		}

		// tous les champs requis sont renseignés
		// contrôle des valeurs des champs
		$com = new Commentaire();
		$com = $com->setValues($post);

		// des erreurs sont remontées
		if (!is_object($com))
		{
			$action = ['redirect' => Response::urlFormat('commentaires','admin')];
			$flash = new FlashValues(['errors' => $com]);
			return new Response($action, ['flash' => $flash, 'membre' => $request->getMembre()]);
		}

		// le commentaire est validé
		// avant l'insertion en BDD, on contrôle :
		// -> l'auteur : anonyme ou membre ?
		// -> le commentaire concerne un billet ou un aure commentaire ?
		
		$membre = $request->getMembre();
		(is_null($membre)) ? $com->set_auteur_id(0) : $com->set_auteur_id($membre->get_id());
		(is_null($membre)) ? $com->set_approuve(FALSE) : $com->set_approuve(TRUE);

		($com->get_com_id() > 0) ? $com->set_com_level($com->get_com_level()+1) : $com->set_com_level(0);

		// enregistrement du commetnaire
		$comMgr = new CommentaireMgr;

		$confirmInsertion = $comMgr->insert($com);
		$idCom = $comMgr->getLastId();

		if (!$confirmInsertion)
		{
			// erreur d'insertion du commentaire
			$action = ['redirect' => Response::urlFormat('commentaires','admin')];
			$flash = new FlashValues(['errors' => ['sql' => 'commentaire non enregistré']]);
			return new Response($action, ['flash' => $flash, 'membre' => $request->getMembre()]);			
		}

		$url = $request->getLastUrl() . '#com' . $idCom;
		$action = ['redirect' => $url];
		$flash = new FlashValues(['success' => "Commentaire enregistré :)"]);
		$objects = [
			'membre' => $request->getMembre(),
			'com' 	=> $com,
			'flash'	=> $flash
		];

		return new Response($action, $objects);
	}


} // end of class AjouterController