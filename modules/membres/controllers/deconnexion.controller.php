<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Modèle de la déconnexion
 *
 * File Last Update : 2017 09 13
 *
 * File Description :
 * -> détruit la session
 * -> renvoi vers le formulaire de connexion
 */

Class DeconnexionController {

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
	 * actionView déconnecte l'utilisateur et le renvoi vers la page de connexion
	 * @param  Request $request Instance Request
	 * @return array 			Tableau contenant la réponse pour l'affichage de la vue
	 */
	public function actionView($request)
	{
		$request->cleanSessionVar();
		session_destroy();

		return [
			'url'		=> url_format('membres','','connexion')
		];
	}

	/**
	 * actionSubmit déconnecte l'utilisateur
	 * @param  Request $request Instance Request
	 * @return array 			Tableau contenant la réponse pour l'affichage de la vue
	 */
	public function actionSubmit($request)
	{
		$this->actionView($request);
	}

} // end of class DeconnexionController