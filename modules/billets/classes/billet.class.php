<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Classe Membre
 *
 * File Last Update : 2017 08 31
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
			// Champs géré par tinyMCE
			// protection contre les scripts
			$forbidden_tags = array('<script>', '</script>', '<?php', '<?=', '?>');
			foreach ($forbidden_tags as $value) {
				$text = str_replace($value, htmlspecialchars($value), $text);
			}

			$this->_contenu = $text;
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
		$id = (int) $id;
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
		$this->_date_publie = $date;
		return TRUE;
	}


	//====================
	// SET DATE_MODIF
	//====================
	protected function setteur_date_modif($date)
	{
		$this->_date_modif = $date;
		return TRUE;
	}


	//====================
	// SET IMAGE ID
	//====================
	protected function setteur_image_id($id)
	{
		$id = (int) $id;
		if (is_int($id) AND $id > 0)
		{
			$this->_image_id = $id;
			return TRUE;
		}

		// Erreur
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