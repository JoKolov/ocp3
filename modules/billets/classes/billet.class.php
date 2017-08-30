<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Classe Membre
 *
 * File Last Update : 2017 08 30
 *
 * File Description :
 * -> gestion des attributs des billets
 * -> contient en attribut tous les éléments de la table Billets
 * -> permet de contrôler l'intégrité des données du billet avant insertion dans la BDD
 */

class Billet {
	
	//------------------------------------------------------------
	// Attributs
	
	// liés à la BDD
	protected $_id;				// BDD : id
	protected $_titre;			// BDD : titre
	protected $_contenu;		// BDD : contenu
	protected $_extrait;		// BDD : extrait
	protected $_auteur_id;		// BDD : auteur_id
	protected $_date_publie;	// BDD : date_publie (date de publication)
	protected $_date_modif;		// BDD : date_modif (date de modification)
	protected $_image_id;		// BDD : image_id (image à la une)
	protected $_statut;			// BDD : statut (brouillon, publié, supprimé)

	// spécifiques à la classe
	protected $_auteur;			// instance Membre de l'auteur (lié à $_auteur_id)
	protected $_image; 			// instance Image de l'image à la une (lié à $_image_id)
	protected $_titre_temp;
	protected $_contenu_temp;
	protected $_extrait_temp;

	// constantes de la classe
	const TITRE_MAX_LENGHT 	= 255;
	const STATUT = array(
		'sauvegarder'	=>	'Brouillon',
		'publier'		=>	'Publication',
		'supprimer'		=>	'Corbeille');


	//------------------------------------------------------------
	// Constructeur et méthodes magiques
	// 
	public function __construct() {

	}



	//------------------------------------------------------------
	// Getteurs
	
	// liés à la BDD
	public function get_id()			{ return $this->_id; 			}
	public function get_titre()			{ return $this->_titre; 		}
	public function get_contenu()		{ return $this->_contenu; 		}
	public function get_extrait()		{ return $this->_extrait; 		}
	public function get_auteur_id()		{ return $this->_auteur_id; 	}
	public function get_date_publie()	{ return $this->_date_publie; 	}
	public function get_date_modif()	{ return $this->_date_modif; 	}
	public function get_image_id()		{ return $this->_image_id; 		}
	public function get_statut()		{ return $this->_statut; 		}

	// spécifiques à la classe
	public function get_auteur()		{ return $this->_auteur; 		}
	public function get_image()			{ return $this->_image; 		}



	//------------------------------------------------------------
	// Setteurs
	
	// liés à la BDD
	public function set_id($id)						{ return $this->setteur_id($id); 				}
	public function set_titre($text)				{ return $this->setteur_titre($text); 			}
	public function set_contenu($text)				{ return $this->setteur_contenu($text); 		}
	public function set_extrait($text)				{ return $this->setteur_extrait($text); 		}
	public function set_auteur_id($id)				{ return $this->setteur_auteur_id($id); 		}
	public function set_date_publie($date)			{ return $this->setteur_date_publie($date); 	}
	public function set_date_modif($date)			{ return $this->setteur_date_modif($date); 		}
	public function set_image_id($id)				{ return $this->setteur_image_id($id); 			}
	public function set_statut($statut)				{ return $this->setteur_statut($statut); 		}

	// spécifiques à la classe
	public function set_auteur()					{ return $this->setteur_auteur(); 				}
	public function set_image()						{ return $this->setteur_image(); 				}


	//====================
	// SET ID
	//====================
	protected function setteur_id($id)
	{
		$id = (int) $id;
		if (is_int($id) AND $id > 0)
		{
			$this->_id = $id;
			return TRUE;
		}
		return FALSE;
	}


	//====================
	// SET TITRE
	//====================
	protected function setteur_titre($text)
	{
		if (is_string($text) AND $text <> '' and strlen($text) <= self::TITRE_MAX_LENGHT)
		{
			$text = htmlspecialchars($text);
			$this->_titre = $text;
			return TRUE;
		}

		// Erreur
		$this->_titre = '';
		return FALSE;
	}


	//====================
	// SET CONTENU
	//====================
	protected function setteur_contenu($text)
	{
		if (is_string($text) AND $text <> '')
		{
			// Champs géré par tinyMCE lors de l'édition
			// tinyMCE protège contre l'injection de script
			$this->_contenu = htmlspecialchars($text);
			return TRUE;
		}

		// Erreur
		$this->contenu = '';
		return FALSE;
	}


	//====================
	// SET EXTRAIT
	//====================
	protected function setteur_extrait($text)
	{
		if (is_string($text) OR $text == '')
		{
			$text = htmlspecialchars($text);
			$this->_extrait = $text;
			return TRUE;
		}

		// Erreur
		$this->extrait = '';
		return FALSE;
	}


	//====================
	// SET AUTEUR_ID
	//====================
	protected function setteur_auteur_id($id)
	{
		if (is_int($id) AND $id > 0)
		{
			$this->_auteur_id = $id;
			return TRUE;
		}

		// Erreur
		return FALSE;
	}


	//====================
	// SET DATE_PUBLIE
	//====================
	protected function setteur_date_publie($date)
	{
		return FALSE;
	}


	//====================
	// SET DATE_MODIF
	//====================
	protected function setteur_date_modif($date)
	{
		return FALSE;
	}


	//====================
	// SET IMAGE ID
	//====================
	protected function setteur_image_id($id)
	{
		return FALSE;
	}


	//====================
	// SET STATUT
	//====================
	protected function setteur_statut($statut)
	{
		foreach (self::STATUT as $key => $value)
		{
			if (is_string($statut) AND $statut == $value)
			{
				$this->_statut = $statut;
				return TRUE;
			}
		}

		// Erreur
		$this->_statut = self::STATUT['sauvegarder']; // dans le doute on sauvegarde
		return FALSE;
	}


	//====================
	// SET AUTEUR
	//====================
	protected function setteur_auteur()
	{
		return FALSE;
	}


	//====================
	// SET IMAGE
	//====================
	protected function setteur_image()
	{
		return FALSE;
	}



	//------------------------------------------------------------
	// Hydratation
	/**
	 * [setFull permet d'hydrater l'objet en appelant les méthodes selon les clés du tableau en argument]
	 * @param array $donnees [tableau contenant des $key associées à des $value]
	 * @return   	TRUE si toutes les données ont été setté correctement, FALSE si aucune donnée n'a été envoyée, string contenant le nom des données non settés
	 */

	public function setFull(array $donnees) {

	}



	//------------------------------------------------------------
	// Méthodes


}