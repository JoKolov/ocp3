<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Supprimer un billet
 *
 * File Last Update : 2017 09 24
 *
 * File Description :
 * -> met un billet à la corbeille
 *
 */

class SupprimerController {

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

		$this->actionSubmit();


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

		if (!is_object($billet))
		{
			return new Response(['redirect' => $request->getLastUrl()]);
		}

		$billet->set_statut(Billet::STATUT['supprimer']);
		$repSQL = $billetMgr->update($billet);

		// Réponse à la requête
		$action = ['redirect' => $request->getLastUrl()];
		$flash = new FlashValues(['success' => "Billet [ " . $billet->get_titre() . " ] déplacé dans la corbeille"]);
		$response = new Response($action, ['flash' => $flash]);

		return $response;	
	}


} // end of class ControlPanelController