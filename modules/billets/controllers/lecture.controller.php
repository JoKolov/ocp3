<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Contrôleur Lecture
 *
 * File Last Update : 2017 09 22
 *
 * File Description :
 * -> compile les données du formulaire à afficher
 *
 */

class LectureController {

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
		$billetId = $request->get()['id'];

		// Est-ce que le billet existe ?
		if (is_null($billetId))
		{
			$response = new Response(['redirect' => Response::urlFormat('defaut', '404')]);
			return $response;
		}

		$billetMgr = new BilletMgr;
		$billet = $billetMgr->select($billetId);

		if (!$billet)
		{
			$response = new Response(['redirect' => Response::urlFormat('defaut', '404')]);
			return $response;			
		}

		$membreMgr = new MembreMgr;
		$auteur = $membreMgr->select($billet->get_auteur_id());

		$action = ['displayView' => $request->getViewFilename()];
		$objects = [
			'billet' => $billet,
			'auteur' => $auteur
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


} // end of class LectureController