<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Commentaires
 * FILE/ROLE : Effacer un commentaire
 *
 * File Last Update : 2017 09 28
 *
 * File Description :
 * -> efface le commentaire de la BDD
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

		$idCom = (int) $request->get()['id'];

		$comMgr = new commentaireMgr;
		$com = $comMgr->select($idCom);
		$comDeleted = $comMgr->delete($idCom);

		if (!$comDeleted)
		{
			$flash = new FlashValues(['warning' => "Une erreur est survenue : le commentaire n'a pas été effacé"]);
		}
		else
		{
			$flash = new FlashValues(['success' => "Commentaire effacé !"]);
		}


		// Réponse à la requête
		$action = ['redirect' => $request->getLastUrl()];
		$response = new Response($action, ['flash' => $flash]);

		return $response;	
	}


} // end of class EffacerController