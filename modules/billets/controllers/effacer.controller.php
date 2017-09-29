<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Effacer un billet de la BDD
 *
 * File Last Update : 2017 09 25
 *
 * File Description :
 * -> efface le billet de la BDD
 *
 */

class EffacerController {

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

		$idBillet = (int) $request->get()['id'];

		$billetMgr = new BilletMgr;
		$billet = $billetMgr->select($idBillet);
		$billetdeleted = $billetMgr->delete($idBillet);

		if (!$billetdeleted)
		{
			$flash = new FlashValues(['warning' => "Billet [ " . $billet->get_titre() . " ] déplacé dans la corbeille"]);
		}
		else
		{
			$flash = new FlashValues(['success' => "Billet [ " . $billet->get_titre() . " ] effacé !"]);
		}


		// Réponse à la requête
		$action = ['redirect' => $request->getLastUrl()];
		$response = new Response($action, ['flash' => $flash]);

		return $response;	
	}


} // end of class EffacerController