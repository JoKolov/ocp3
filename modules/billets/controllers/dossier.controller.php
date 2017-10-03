<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Panneau des billets d'un dossier spécifique
 *
 * File Last Update : 2017 09 25
 *
 * File Description :
 * -> effectue l'action demandée par la requête
 * -> compile les données pour la vue
 *
 */

class DossierController {

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


		// récupération des données de la requête
		$dossier = $request->get()['dossier'];
		$offset = $request->get()['nav'];


		// contrôle et manipulation des données de la requête
		$dossier = ucfirst($dossier);
		if (!in_array($dossier, Billet::STATUT))
		{
			// Erreur : le dossier n'existe pas
			$action = ['redirect' => $request->getLastUrl()];
			$flash = new FlashValues(['warning' => "Le dossier [{$dossier}] n'existe pas !"]);
			$objects = [
				'membre' 		=> $request->getMembre(),
				'flash' 		=> $flash
			];

			$response = new Response($action, $objects);
			return $response;			
		}

		if (is_null($offset) OR empty($offset))
		{
			$offset = 1;
		}	


		// configuration de l'affichage
		$limit = 20; // 20 billets par page


		// récupération des billets
		$billetMgr = new BilletMgr;
		$billets = $billetMgr->select_multi(['statut' => $dossier], [$limit, $offset], ['last_date' => 'DESC']);


		//--- pagination des billets
		$methodReqNbBillet = "getNb{$dossier}";
		$totalBillets = $billetMgr::$methodReqNbBillet();
		if ($totalBillets > 0)
		{
			$nbPages = $totalBillets / $limit;
			$pagination = [];

			for ($page=0; $page <= $nbPages; $page++) { 
				array_push($pagination, $page + 1);
			}
		}

		$nbBrouillons = BilletMgr::getNbBrouillon();
		$nbPublications = BilletMgr::getNbPublication();
		$nbCorbeille = BilletMgr::getNbCorbeille();


		$action = ['displayView' => $request->getViewFilename()];
		$objects = [
			'membre' 		=> $request->getMembre(),
			'billets' 		=> $billets,
			'pagination'	=> $pagination,
			'pagiActive'	=> $offset-1,
			'dossier'		=> $dossier,
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

} // end of class DossierController