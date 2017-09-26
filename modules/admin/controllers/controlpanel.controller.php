<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Admin
 * FILE/ROLE : Panneau de contrôle
 *
 * File Last Update : 2017 09 24
 *
 * File Description :
 * -> effectue l'action demandée par la requête
 * -> compile les données pour la vue
 *
 */

class ControlPanelController {

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
		user_connected_only();
		admin_only();


		//--- récupération des billets
		$billetMgr = new BilletMgr;
		$billets = $billetMgr->select_multi(['statut' => 'Brouillon'], [2, 0], ['last_date' => 'DESC']);

	
		$action = ['displayView' => $request->getViewFilename()];
		$objects = [
			'membre' 		=> $request->getMembre(),
			'billets'		=> $billets
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
		$this->actionView($request);
	}


} // end of class ControlPanelController