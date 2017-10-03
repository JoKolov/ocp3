<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Defaut
 * FILE/ROLE : Contrôleur d'affichage de la page d'accueil
 *
 * File Last Update : 2017 09 26
 *
 * File Description :
 * -> compile les données du formulaire à afficher
 *
 */

class HomeController {

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
		// préparation de la réponse
		$response = new Response;
		$viewFilename = file_exists(APP['theme-dir'] . $request->getViewName() . '.php') ? APP['theme-dir'] . $request->getViewName() . '.php' : $request->getViewFilename();

		$action = ['displayView' => $viewFilename];
		$response->setAction($action);

		$objects['membre'] = $request->getMembre();


		// récupération du dernier Billet publié
		$billetMgr = new BilletMgr;
		//$billets = $billetMgr->selectList(4,0,"statut = '" . Billet::STATUT['publier'] . "'", 'last_date DESC');
		$billets = $billetMgr->selectPublications(4);

		// Image à la Une
		$imageManager = new ImageMgr;
		foreach ($billets as $billet)
		{
			$imageBillet = $imageManager->selectForBillet($billet);
			// ajout après soutenance
			if (!is_null($imageBillet))
			{
				$billet->setImage($imageBillet->get_billet());
				$billet->setMiniature($imageBillet->get_vignette());
			}
			// fin ajout après soutenance
		}

		if (!empty($billets))
		{

			$objects['dernierBillet'] = $billets[0];
			unset($billets[0]);
		}

		$objects['billets'] = $billets;



		$response->setObjects($objects);
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


} // end of class HomeController