<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Commentaire
 * FILE/ROLE : Répondre à un commentaire
 *
 * File Last Update : 2017 09 28
 *
 * File Description :
 * -> affiche le formulaire d'ajout de commentaire
 *
 */

class RepondreController {

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
		$idCom = $request->get()['id'];
		$idCom = (int) $idCom;

		$comMgr = new CommentaireMgr;
		$com = $comMgr->select($idCom);

		// le commentaire à commenter n'existe pas
		if (!is_object($com))
		{
			$action = ['redirect' => $request->getLastUrl()];
			$flash = new FlashValues(['warning' => "une erreur est survenue : impossible de répondre au commentaire n° {$idCom}"]);
			$objects = [
				'flash'	=> $flash
			];

			return new Response($action, $objects);			
		}

		// le commentaire existe, on peut afficher le formulaire
		$url = $request->getLastUrl() . "#com$idCom";
		$action = ['redirect' => $url];
		$flash = new FlashValues(['comFormId' => $idCom]);
		$objects = [
			'flash'	=> $flash
		];

		return new Response($action, $objects);
	}


} // end of class RepondreController