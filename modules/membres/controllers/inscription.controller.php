<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Modèle de l'inscription
 *
 * File Last Update : 2017 09 13
 *
 * File Description :
 * -> vérifie l'intégrité des données transmises par le formulaire d'inscription
 * -> insère les données dans la base de données si elles sont OK
 * -> sinon, renvoi vers le formulaire d'inscription avec les erreurs
 */

class InscriptionController {

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
			'error'			=> 	"Echec inscription !",
			'pseudo'		=>	"Pseudo non valide : au moins 4 caractères alphanumeriques sans espace (- et _ tolérés)",
			'email' 		=>	"Adresse email non valide :(",
			'password'		=>	"Password non valide : au moins 8 caractères dont au moins 1 chiffre ;)",
			'sql'			=>	"Pseudo ou email déjà enregistré :("
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
		$action = ['displayView' => $request->getViewFilename()];
		$objects = [
			'values' => new ViewValues(['errors' => setViewErrorValues($this->getErrorsTable())])
		];

		$response = new Response($action, $objects);

		return $response;
	}


	//------------------------------------------------------------
	public function actionSubmit($request)
	{
		// récupération des données
		$post = $request->getPost(['pseudo', 'email', 'password']);
		
		// vérification des données du formulaire grâce au modele
		$inscription = $this->inscriptionUsingModel($post);

		// l'inscription a échoué, des erreurs sont remontées
		if (array_key_exists('error', $inscription))
		{
			// on créer les messages d'erreurs
			$errorsFound = explode('-', $inscription['error']); // tableau contenant les erreurs séparées par un -
			$viewErrors = setViewErrorValues($this->getErrorsTable(), $errorsFound);

			// digression
			// A ce stade on pourrait même renvoyer les données qui sont bonnes pour les remettre dans les champs du formulaire
			/*foreach ($post as $fieldName => $fieldValue)
			{
				if (!in_array($fieldName, $errorsFound))
				{
					$correctFields[$fieldName] = $fieldValue;
				}
			}*/
			// fin digression ---

			$action = ['redirect' => Response::urlFormat('membres','inscription')];
			$flash = new FlashValues(['errors' => $viewErrors]);

			$response = new Response($action, ['flash' => $flash]);

			return $response;
		}

		// L'inscription est validée
		$membre = $inscription['membre'];
		$request->setSessionVar(array(
			'pseudo' 	=> $membre->get_pseudo(),
			'membre'	=> $membre
			)
		);
		
	
		$action = ['redirect' => Response::urlFormat('membres','compte')];

		$response = new Response($action, ['membre' => $membre]);

		return $response;
	}


	//------------------------------------------------------------
	private function inscriptionUsingModel($post)
	{
		///  1  ///
		// Tous les champs obligatoires sont-ils renseignés ?
		$missingFields = formMissingRequiredFields([
			'pseudo'	=>	TRUE,
			'email'		=> 	TRUE,
			'password'	=> 	TRUE
		], $post);

		// Il manque un ou des champs obligatoires
		if (!is_null($missingFields))
		{
			return ['error' => $missingFields];
		}


		///  2  ///
		// Les données renseignées sont-elles acceptables ?
		$membre = new Membre;
		$membre = $membre->checkInscription([
			'pseudo'	=> $post['pseudo'],
			'email'		=> $post['email'],
			'password'	=> $post['password']
		]);

		// Des données onr été refusées
		if (!is_object($membre))
		{
			return ['error' => $membre];
		}


		///  3  ///
		// Est-ce que le pseudo ou l'email n'existent pas déjà dans la BDD ?
		$enregistrementMembre = MembreMgr::insert_membre($membre);

		// Le membre existe déjà
		if (!$enregistrementMembre)
		{
			return ['error' => 'sql'];
		}


		///  4  ///
		// On récupère une instance de membre
		$membre = MembreMgr::login_check([
			'pseudo'	=> $membre->get_pseudo(),
			'password'	=> $post['password']
		]);

		return ['membre' => $membre];	
	}


} // end of class InscriptionController