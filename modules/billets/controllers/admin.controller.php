<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Panneau de contrôle
 *
 * File Last Update : 2017 09 24
 *
 * File Description :
 * -> effectue l'action demandée par la requête
 * -> compile les données pour la vue
 *
 */

class AdminController {

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
		$limit = 3;
		$offset = 0;

		$billetMgr = new BilletMgr;
		$listeBrouillon = $billetMgr->select_multi(['statut' => 'Brouillon'], [$limit, $offset], ['last_date' => 'DESC']);
		$listePublication = $billetMgr->select_multi(['statut' => 'Publication'], [$limit, $offset], ['last_date' => 'DESC']);
		$listeCorbeille = $billetMgr->select_multi(['statut' => 'Corbeille'], [$limit, $offset], ['last_date' => 'DESC']);

		$nbBrouillons = BilletMgr::getNbBrouillon();
		$nbPublications = BilletMgr::getNbPublication();
		$nbCorbeille = BilletMgr::getNbCorbeille();

		$action = ['displayView' => $request->getViewFilename()];
		$objects = [
			'membre' 			=> $request->getMembre(),
			'listeBrouillon' 	=> $listeBrouillon,
			'listePublication' 	=> $listePublication,
			'listeCorbeille' 	=> $listeCorbeille,
			'limit'				=> $limit,
			'nbBrouillons'		=> $nbBrouillons,
			'nbPublications'	=> $nbPublications,
			'nbCorbeille'		=> $nbCorbeille
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
		return $this->actionView($request);
	}

} // end of class ControlPanelController