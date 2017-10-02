<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Commentaires
 * FILE/ROLE : Classe Commentaire
 *
 * File Last Update : 2017 09 26
 *
 * File Description :
 * -> gestion des attributs des commentaires
 * -> contient en attribut tous les éléments de la table Commentaire
 * -> permet de contrôler l'intégrité des données du commentaire avant insertion dans la BDD
 */

class Commentaire {
	
	//------------------------------------------------------------
	// Attributs
	
	// liés à la BDD
	protected $_id;					// BDD : int > id Commentaire
	protected $_billet_id;			// BDD : int > id Billet commenté
	protected $_com_id;				// BDD : int > id Commentaire commenté
	protected $_com_level;			// BDD : int > niveau d'affichage du commentaire
	protected $_auteur_id;			// BDD : int > id Membre
	protected $_contenu;			// BDD : text
	protected $_date_publie;		// BDD : datetime > date_publie (date de publication)
	protected $_approuve;			// BDD : tinyint > TRUE (1) FALSE (0)
	protected $_signalement;		// BDD : int > nombre de signalements

	public $_enfants = [];			// tableau d'enfants
	protected $_auteur;				// récupéré par controleur


	// constantes de la classe
	const COM_LEVEL_MAX = 5;


	//------------------------------------------------------------
	// Constructeur et méthodes magiques
	// 
	public function __construct() {

	}



	//------------------------------------------------------------
	// Getteurs
	
	// liés à la BDD
	public function get_id()			{ return $this->_id; 			}
	public function get_billet_id()		{ return $this->_billet_id; 	}
	public function get_com_id()		{ return $this->_com_id; 		}
	public function get_com_level()		{ return $this->_com_level; 	}
	public function get_auteur_id()		{ return $this->_auteur_id; 	}
	public function get_contenu()		{ return $this->_contenu; 		}
	public function get_date_publie()	{ return $this->_date_publie; 	}
	public function get_approuve()		{ return $this->_approuve; 		}
	public function get_signalement()	{ return $this->_signalement; 	}
	public function getAuteur()			{ return $this->_auteur; 		}



	//------------------------------------------------------------
	// Setteurs
	
	// liés à la BDD
	public function set_id($id)						{ return $this->setteur_id($id); 				}
	public function set_billet_id($id)				{ return $this->setteur_billet_id($id); 		}
	public function set_com_id($id)					{ return $this->setteur_com_id($id); 			}
	public function set_com_level($nombre)			{ return $this->setteur_com_level($nombre); 	}
	public function set_auteur_id($id)				{ return $this->setteur_auteur_id($id); 		}
	public function set_contenu($text)				{ return $this->setteur_contenu($text); 		}
	public function set_date_publie($date)			{ return $this->setteur_date_publie($date); 	}
	public function set_approuve($etat)				{ return $this->setteur_approuve($etat); 		}
	public function set_signalement($nombre)		{ return $this->setteur_signalement($nombre); 	}

	// non lié à la BDD
	public function setAuteur($auteur)				{ $this->_auteur = $auteur; }


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
	// SET BILLET_ID
	//====================
	protected function setteur_billet_id($id)
	{
		$id = (int) $id;
		if (is_int($id) AND $id > 0)
		{
			$this->_billet_id = $id;
			return TRUE;
		}

		// Erreur
		return FALSE;
	}


	//====================
	// SET COM_ID
	//====================
	protected function setteur_com_id($id)
	{
		if (is_null($id) OR $id == '')
		{
			$this->_com_id = 0;
			return TRUE;
		}

		if ($id >= 0)
		{
			$this->_com_id = $id;
			return TRUE;
		}

		// Erreur
		return FALSE;
	}


	//====================
	// SET COM_LEVEL
	//====================
	protected function setteur_com_level($nombre)
	{
		$nombre = (int) $nombre;
		if ($nombre < 0)
		{
			$nombre = 0;
		}
		if ($nombre > 5)
		{
			$nombre = 5;
		}
		$this->_com_level = $nombre;
		return TRUE;
	}


	//====================
	// SET AUTEUR_ID
	//====================
	protected function setteur_auteur_id($id)
	{
		$id = (int) $id;
		if ($id < 0) { $id = 0; }
		$this->_auteur_id = $id;
		return TRUE;
	}



	//====================
	// SET TITRE
	//====================
	protected function setteur_contenu($text)
	{
		if (is_string($text) AND $text <> '')
		{
			$text = htmlspecialchars($text, ENT_NOQUOTES);
			$this->_contenu = $text;
			return TRUE;
		}

		// Erreur
		$this->_contenu = '';
		return FALSE;
	}


	//====================
	// SET DATE_PUBLIE
	//====================
	protected function setteur_date_publie($date)
	{
		$this->_date_publie = $date;
		return TRUE;
	}


	//====================
	// SET IMAGE ID
	//====================
	protected function setteur_approuve($etat)
	{
		if ($etat === TRUE OR $etat == 1 OR $etat === FALSE OR $etat == 0)
		{
			$this->_approuve = $etat;
			return TRUE;
		}

		return FALSE;
	}


	//====================
	// SET IMAGE ID
	//====================
	protected function setteur_signalement($nombre)
	{
		$nombre = (int) $nombre;
		$this->_signalement = $nombre;
		return TRUE;
	}


	//------------------------------------------------------------
	// Hydratation
	/**
	 * [ setValues permet d'hydrater l'objet en appelant les méthodes selon les clés du tableau en argument]
	 * @param array $donnees [tableau contenant des $key associées à des $value]
	 * @return   	TRUE si toutes les données ont été setté correctement, FALSE si aucune donnée n'a été envoyée, string contenant le nom des données non settés
	 */

	public function setValues(array $donnees) {
		foreach ($donnees as $key => $value)
		{
			$method = 'set_' . $key;
			if (method_exists($this, $method))
			{
				if ($this->$method($value))
				{
					unset($donnees[$key]);
				}
			}
		}

		if (in_array(FALSE, $donnees))
		{
			return $donnees;
		}

		return $this;
	}



	//------------------------------------------------------------
	// Méthodes


}