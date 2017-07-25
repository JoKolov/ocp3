<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : Class
 * FILE/ROLE : MVC
 *
 * File Last Update : 2017 07 25
 *
 * File Description :
 * -> gestion des appels des éléments du MVC
 * -> Controleur
 * -> Modèle
 * -> Vue
 */

class MVC {
	//------------------------------------------------------------
	// Attributs
	
	protected $_controller; 		// contient l'adresse du fichier du controller
	protected $_model;				// contient l'adresse du fichier du model
	protected $_view;				// contient l'adresse du fichier de la view dynamique

	protected $_header; 			// contient l'url de la prochaine page à appeler

	protected static $theme;		// contient les adresses des fichiers du thème

	//------------------------------------------------------------
	// Constructeur
	
	public function __construct() {
		
	}



	//------------------------------------------------------------
	// Getteurs
	
	public get_controller()		{ return $this->_controller; }
	public get_model()			{ return $this->_model; }
	public get_view()			{ return $this->_view; }



	//------------------------------------------------------------
	// Setteurs
	
	public set_controller() {

	}

	public set_model() {

	}

	public set_view() {
		
	}

	//------------------------------------------------------------
	// Hydratation

	// --- NIL ---



	//------------------------------------------------------------
	// Méthodes

	/**
	 * Affiche la vue demandée à l'intérieur de la vue globale
	 */
	public displayView($view)
	{

	}



	//------------------------------------------------------------
	// Méthodes magiques

}

?>