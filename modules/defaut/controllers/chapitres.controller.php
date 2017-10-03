<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Defaut
 * FILE/ROLE : Contrôleur d'affichage des chapitres du blog
 *
 * File Last Update : 2017 10 03
 *
 * File Description :
 * -> compile les données à afficher
 *
 */

class ChapitresController {

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
		// récupération de toutes les publications
		$billetManager = new BilletMgr;
		$billets = $billetManager->selectPublications();

		// récupération des images
		$imageManager = new ImageMgr;
		foreach ($billets as $billet)
		{
			$imageBillet = $imageManager->selectForBillet($billet);
			$billet->setImage($imageBillet->get_billet());
			$billet->setMiniature($imageBillet->get_vignette());
		}

		// préparation de la réponse
		$viewFilename = file_exists(APP['theme-dir'] . $request->getViewName() . '.php') ? APP['theme-dir'] . $request->getViewName() . '.php' : $request->getViewFilename();
		$action = ['displayView' => $viewFilename];
		$objects = [
			'membre'	=> $request->getMembre(),
			'billets'	=> $billets
		];

		return new Response($action, $objects);
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


} // end of class ChapitresController