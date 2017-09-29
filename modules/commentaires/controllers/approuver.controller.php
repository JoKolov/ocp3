<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Commentaire
 * FILE/ROLE : Approuver un commentaire
 *
 * File Last Update : 2017 09 28
 *
 * File Description :
 * -> approuve un commentaire signalé ou en attente
 * -> enregistrement de l'approbation dans la BDD
 *
 */

class ApprouverController {

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
		user_connected_only();
		admin_only();
		
		// préparation de la réponse
		$response = new Response;
		$response->setAction(['redirect' => $request->getLastUrl()]);

		$idCom = $request->get()['id'];
		$idCom = (int) $idCom;

		$comMgr = new CommentaireMgr;
		$com = $comMgr->select($idCom);

		// le commentaire n'existe pas
		if (!is_object($com))
		{
			$flash = new FlashValues(['danger' => "le commentaire n°{$idCom} est introuvable"]);
			$response->setObjects(['flash' => $flash]);
			return $response;
		}

		// le commentaire existe
		$com->set_signalement(0);
		$com->set_approuve(TRUE);
		$confirmationUpdate = $comMgr->update($com);

		if (!$confirmationUpdate)
		{
			$flash = new FlashValues(['danger' => "le commentaire n°{$idCom} est introuvable"]);
			$response->setObjects(['flash' => $flash]);
			return $response;
		}

		$flash = new FlashValues(['success' => "Le commentaire est approuvé et publié"]);
		$objects = [
			'membre' => $request->getMembre(),
			'flash'	=> $flash
		];

		$response->setObjects($objects);

		return $response;
	}


} // end of class ApprouverController