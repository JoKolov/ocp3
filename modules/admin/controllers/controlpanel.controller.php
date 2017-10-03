<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Admin
 * FILE/ROLE : Panneau de contrôle
 *
 * File Last Update : 2017 09 26
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


		//--- récupération des infos commentaires
		$comMgr = new commentaireMgr;
		$infoCom['nbSignalements'] = $comMgr->getNbSignalements();
		$infoCom['nbApprobations'] = $comMgr->getNbApprobations();
		$infoCom['nbCommentaires'] = $comMgr->getNbCom();

		//--- récupération des infos billets
		$infoBillets['nbBrouillons'] = BilletMgr::getNbBrouillon();
		$infoBillets['nbPublications'] = BilletMgr::getNbPublication();
		$infoBillets['nbCorbeille'] = BilletMgr::getNbCorbeille();
		$infoBillets['nbBillets'] = BilletMgr::countNbBillets();

		$billetMgr = new BilletMgr;
		$derniersBrouillons = $billetMgr->select_multi(['statut' => 'Brouillon'], [2, 0], ['last_date' => 'DESC']);

		//--- récupérations des infos membres
		$infoMembres['nbAbonnes'] = MembreMgr::countNbAbonnes();
		$membreManager = new MembreMgr;
		$derniersMembres = $membreManager->selectListOfLastRegistered(3);

		$action = ['displayView' => $request->getViewFilename()];
		$objects = [
			'membre' 		=> $request->getMembre(),
			'infoCom'		=> $infoCom,
			'infoBillets'	=> $infoBillets,
			'infoMembres'	=> $infoMembres,
			'derniersMembres' => $derniersMembres,
			'derniersBrouillons' => $derniersBrouillons
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