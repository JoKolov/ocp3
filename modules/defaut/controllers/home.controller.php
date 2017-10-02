<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Defaut
 * FILE/ROLE : Contrôleur d'affichage de la page d'accueil
 *
 * File Last Update : 2017 09 26
 *
 * File Description :
 * -> compile les données du formulaire à afficher
 *
 */

class HomeController {

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
		// préparation de la réponse
		$response = new Response;
		$viewFilename = file_exists(APP['theme-dir'] . $request->getViewName() . '.php') ? APP['theme-dir'] . $request->getViewName() . '.php' : $request->getViewFilename();

		$action = ['displayView' => $viewFilename];
		$response->setAction($action);

		$objects['membre'] = $request->getMembre();


		// récupération du dernier Billet publié
		$billetMgr = new BilletMgr;
		$billets = $billetMgr->selectList(1,0,"statut = '" . Billet::STATUT['publier'] . "'", 'last_date DESC');

		if (!is_null($billets))
		{
			$objects['billet'] = $billets[0];		
		}


		$response->setObjects($objects);
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
		return $this->actionView($request);
	}


} // end of class HomeController