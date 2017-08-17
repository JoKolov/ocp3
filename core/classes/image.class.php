<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : Class
 * FILE/ROLE : image
 *
 * File Last Update : 2017 08 16
 *
 * File Description :
 * -> gestion des images
 * -> Contrôle des images reçues
 * -> Création des miniatures
 */

class Image {
	//------------------------------------------------------------
	// Attributs
	
	protected $_name;			// nom du fichier
	protected $_type;			// type du fichier
	protected $_size;			// taille du fichier
	protected $_tmp_name;		// chemin d'accès temporaire du fichier
	protected $_img_sizes		// taille de l'image en px

	protected $_id; 			// champ id dans BDD
	protected $_source			// champ source dans BDD, chemin d'accès au fichier
	protected $_fromSQL			// indication de la provenance des données

	//------------------------------------------------------------
	// Constructeur
	
	public function __construct(array $donnees = [], $fromSQL = FALSE) {
		$this->set_fromSQL($fromSQL); // on indique 

	}



	//------------------------------------------------------------
	// Getteurs
	
	public get_name()			{ return $this->_name; }
	public get_type()			{ return $this->_type; }
	public get_size()			{ return $this->_size; }
	public get_tmp_name()		{ return $this->_tmp_name; }
	public get_id()				{ return $this->_id; }
	public get_source()			{ return $this->_source; }


	//------------------------------------------------------------
	// Setteurs
	
	// SET _name 					::::::::::::::::::::::::::::::
	public set_fromSQL(bool $fromSQL) {
		$this->_fromSQL = $fromSQL;
	}

	// SET _name 					::::::::::::::::::::::::::::::
	public set_name(string $name) {
		$pattern = '#.[a-zA-Z]{3,4}$#';
		if (preg_match($pattern, $,$name))
		{
			$this->_name = $name;
			return TRUE;
		}
		return FALSE;
	}

	// SET _type 					::::::::::::::::::::::::::::::
	public set_type() {

	}

	// SET _size 					::::::::::::::::::::::::::::::
	public set_size() {
		
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