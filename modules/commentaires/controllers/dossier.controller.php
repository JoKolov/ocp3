<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Panneau des commentaires d'un dossier spécifique
 *
 * File Last Update : 2017 09 29
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
		$dossiers = ['signalement', 'approuve'];
		if (!in_array($dossier, $dossiers))
		{
			// Erreur : le dossier n'existe pas
			$action = ['redirect' => $request->getLastUrl()];
			$flash = new FlashValues(['warning' => "Le dossier [{$dossier}] n'existe pas !"]);

			$response = new Response($action, ['flash' => $flash]);
			return $response;
		}

		if (is_null($offset) OR empty($offset))
		{
			$offset = 1;
		}


		// configuration de l'affichage
		$limit = 2; // 10 commentaires par page


		// récupération des commentaires
		$comMgr = new CommentaireMgr;
		if ($dossier == 'signalement')
		{
			$comList = $comMgr->selectList($limit, $offset, "signalement > '0'", "signalement DESC");
			$nbCom = $comMgr->getNbSignalements();
		}
		else
		{
			$comList = $comMgr->selectList($limit, $offset, "approuve = '0'", "date_trie ASC");
			$nbCom = $comMgr->getNbApprobations();
		}

		$membreMgr = new MembreMgr;
		foreach ($comList as $com)
		{
			if ($com->get_auteur_id() > 0)
			{
				$auteur = $membreMgr->select($com->get_id());
				$com->setAuteur($auteur->get_pseudo());
			}
			else
			{
				$com->setAuteur('Anonyme');
			}
		}
		

		//--- pagination des commentaires
		if ($nbCom > 0)
		{
			$nbPages = $nbCom / $limit;
			$pagination = [];

			for ($page=0; $page <= $nbPages; $page++) { 
				array_push($pagination, $page + 1);
			}
		}

		// nombre de commentaires signalés et d'approbations en attente
		$nbReportedCom = $comMgr->getNbSignalements();
		$nbWaitingCom = $comMgr->getNbApprobations();

		$action = ['displayView' => $request->getViewFilename()];
		$objects = [
			'membre' 		=> $request->getMembre(),
			'comList' 		=> $comList,
			'pagination'	=> $pagination,
			'pagiActive'	=> $offset-1,
			'dossier'		=> $dossier,
			'nbCom'			=> $nbCom,
			'nbReportedCom'		=> $nbReportedCom,
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

} // end of class DossierController