<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Commentaire
 * FILE/ROLE : Signaler un commentaire indésirable
 *
 * File Last Update : 2017 09 28
 *
 * File Description :
 * -> enregistrement du signalement dans la BDD
 *
 */

class SignalerController {

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

		// préparation de la réponse
		$response = new Response;
		$response->setAction(['redirect' => $request->getLastUrl()]);

		$idReportedCom = $request->get()['id'];
		$idReportedCom = (int) $idReportedCom;

		$comMgr = new CommentaireMgr;
		$reportedCom = $comMgr->select($idReportedCom);

		// le commentaire n'existe pas
		if (!is_object($reportedCom))
		{
			$flash = new FlashValues(['error' => ['signalement' => "Une erreur est survenue : le commentaire n° {$idReportedCom} n'a pas pu être signalé"]]);
			$response->setObjects(['flash' => $flash]);
			return $response;
		}

		// le commentaire existe
		$nbSignalements = $reportedCom->get_signalement() + 1;
		$reportedCom->set_signalement($nbSignalements);
		$confirmationUpdate = $comMgr->update($reportedCom);

		if (!$confirmationUpdate)
		{
			$flash = new FlashValues(['error' => ['signalement' => "Une erreur est survenue : le commentaire n° {$idReportedCom} n'a pas pu être signalé"]]);
			$response->setObjects(['flash' => $flash]);
			return $response;
		}

		$flash = new FlashValues(['success' => "Le commentaire a été signalé"]);
		$objects = [
			'membre' => $request->getMembre(),
			'flash'	=> $flash
		];

		$response->setAction(['redirect' => $request->getLastUrl() . '#com' . $idReportedCom]);
		$response->setObjects($objects);

		return $response;
	}


} // end of class AjouterController