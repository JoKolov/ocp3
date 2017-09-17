<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Modèle de la page compte
 *
 * File Last Update : 2017 09 13
 *
 * File Description :
 * -> affiche les informations du membre
 * -> affiche les liens de modification
 * -> modifie les informations du compte
 * -> renvoi les erreurs de modification
 */

Class CompteController {

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

	public function actionView($request)
	{
		return [
			'file'		=> $request->getViewFilename()
		];
	}

	public function actionSubmit($request)
	{
		$this->actionView($request);
	}



	private function viewValuesUsingModel($post)
	{

	}


} // end of class CompteController