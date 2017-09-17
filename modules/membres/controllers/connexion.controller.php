<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Controlleur connexion
 *
 * File Last Update : 2017 09 13
 *
 * File Description :
 * -> vérifie l'intégrité des données transmises par le formulaire de connexion
 * -> vérifie l'existence du membre dans la base de données
 * -> on renvoi une erreur si l'athentification échoue
 */

Class ConnexionController {

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
			'error'			=> 	"Echec connexion !",
			'pseudo'		=>	"Entrez votre pseudo ;)",
			'password'		=>	"Entrez votre password ;)",
			'notfound'		=>	"Mauvais login / mot de passe :("
		];
	}


	//============================================================
	// Setteurs
	// -- NIL --


	//============================================================
	// Methodes

	public function actionView($request)
	{
		return [
			'file'		=> $request->getViewFilename(),
			'errors'	=> setViewErrorValues($this->getErrorsTable())
		];
	}

	public function actionSubmit($request)
	{
		// récupération des données postées par l'utilisateur
		$post = $request->getPost(['pseudo', 'password']);

		// vérification des données du formulaire grâce au modèle
		$connexion = $this->connexionUsingModel($post);

		// La connexion a échoué, des erreurs sont remontées
		if (array_key_exists('error', $connexion))
		{
			$url = url_format('membres', '', 'connexion', $connexion);
			
			// on créer les messages d'erreurs
			$errorsFound = explode('-', $connexion['error']); // tableau contenant les erreurs séparées par un -
			$viewErrors = setViewErrorValues($this->getErrorsTable(), $errorsFound);

			return [
				'url'		=> $url, 
				'errors' 	=> $viewErrors
			];
		}

		// La connexion est validée
		$membre = $connexion['membre'];
		$request->setSessionVar(array(
			'pseudo' 	=> $membre->get_pseudo(),
			'membre'	=> $membre
			)
		);
		
		$url = url_format('membres','','compte');
		
		return [
			'url'		=> $url,
			'errors'	=> setViewErrorValues($this->getErrorsTable())
		];
	}



	private function connexionUsingModel($post)
	{

		///  1  ///
		// Tous les champs obligatoires sont-ils renseignés ?
		$missingFields = formMissingRequiredFields([
			'pseudo'	=>	TRUE,
			'password'	=>	TRUE
		], $post);

		// Il manque un ou des champs obligatoires
		if (!is_null($missingFields))
		{
			return ['error' => $missingFields];
		}

		///  2  ///
		// Les données renseignées sont-elles acceptables ?
		$membre = MembreMgr::login_check($post);

		// Les données sont refusées
		if (!is_object($membre))
		{
			return ['error' => 'notfound'];
		}

		// La connexion est accepté => pas d'erreur
		return ['membre' => $membre];
	}


} // end of class ConnexionController