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

		$limit = 3;
		$offset = 0;

		// on cherche des commentaires à modérer
		$comMgr = new CommentaireMgr;
		$listReportedCom = $comMgr->selectList($limit, $offset, "signalement > 0", "signalement DESC");
		$listWaitingCom = $comMgr->selectList($limit, $offset, "approuve = '0'", "date_trie ASC");

		// nombre de commentaires à modérer
		$nbReportedCom = $comMgr->getNbSignalements();
		$nbWaitingCom = $comMgr->getNbApprobations();




		// réponse
		$action = ['displayView' => $request->getViewFilename()];
		$objects = [
			'membre' 			=> $request->getMembre(),
			'listReportedCom'	=> $listReportedCom,
			'nbReportedCom'		=> $nbReportedCom,
			'listWaitingCom'	=> $listWaitingCom,
			'nbWaitingCom'		=> $nbWaitingCom
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