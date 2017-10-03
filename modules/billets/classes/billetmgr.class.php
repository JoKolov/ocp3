<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Billet Manager
 *
 * File Last Update : 2017 09 24
 *
 * File Description :
 * -> gestion des images dans la BDD
 *
 * ---
 * Classes nécessaires :
 * SQLmgr
 * Billet
 */

class BilletMgr {

	//------------------------------------------------------------
	// Attributs
	private static $_last_billets_id;			// Dernier id dans la table billets

	// contantes
	const DB_NAME 			= BDD['name'];

	const TABLE_BILLETS 	= 'ocp3_Billets';
	const LIST_BILLETS_INSERT 		= '(titre, contenu, extrait, auteur_id, date_publie, date_modif, image_id, statut)';

	// mapping de la table
	private static $_map; 	// tableau contenant les colonnes de la table
							// $key = titre colonne // $value = type donnée,*max lenght* (si existe)


	//------------------------------------------------------------
	// Constructeur
	
	public function __construct() {
		self::set_map();
		self::set_last_billets_id();
	}



	//------------------------------------------------------------
	// Getteurs
	
	public function get_map()				{ return $this->_map; 						}
	public function get_last_billets_id()	{ return self::$_last_billets_id; 			}
	public function get_new_billets_id()	{ return $this->getteur_new_billets_id();	}

	public static function getNbBrouillon()		{ return self::countNbBilletWithStatut('Brouillon'); 	}
	public static function getNbPublication()	{ return self::countNbBilletWithStatut('Publication');	}
	public static function getNbCorbeille()		{ return self::countNbBilletWithStatut('Corbeille'); 	}

	public function getNbBillets()			{ return self::countNbBillets(); 			}


	//----------
	// GET NEW_BILLET_ID
	public function getteur_new_billets_id()
	{
		$id = $this->get_last_billets_id() + 1;
		return $id;
	}



	//------------------------------------------------------------
	// Setteurs

	private static function set_map()							{ return self::setteur_map(); 					}
	private static function set_last_billets_id($id = null)		{ return self::setteur_last_billets_id($id); 	}

	/**
	 * set_map récupère les noms des colonnes de la table membres
	 */
	private static function setteur_map()
	{
		if (!isset(self::$_map))
		{
			$sql = 'SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH 
					FROM INFORMATION_SCHEMA.COLUMNS 
					WHERE TABLE_NAME = "' . self::TABLE_BILLETS . '" AND TABLE_SCHEMA = "' . self::DB_NAME . '" 
					ORDER BY ORDINAL_POSITION';
			$req = SQLmgr::prepare($sql);
			if($req->execute() !== FALSE) {
				while($mapping = $req->fetch())
				{
					self::$_map[$mapping["COLUMN_NAME"]] = $mapping["DATA_TYPE"] . ',' . $mapping['CHARACTER_MAXIMUM_LENGTH'];
				}
			}
		}
		return self::$_map;
	}


	/**
	 * récupère le dernier id de la table billet
	 */
	private static function setteur_last_billets_id($id = null)
	{
		// on va chercher une valeur d'id
		if (is_null($id))
		{
			$sql = 'SELECT MAX(id) FROM ' . self::TABLE_BILLETS;
			$req = SQLmgr::prepare($sql);
			$req->execute();
			$id = $req->fetch(PDO::FETCH_ASSOC);
			$id = (int) $id['MAX(id)'];
		}
		
		if (is_int($id) AND $id > 0)
		{
			self::$_last_billets_id = $id;
		}
		else
		{
			self::$_last_billets_id = 0;
		}
	}


	//------------------------------------------------------------
	// Méthodes

	//-------------------------
	// Enregistrer un billet
	public function insert(Billet $billet)
	{
		$sql = 'INSERT INTO ' . self::TABLE_BILLETS . ' (
					titre, 
					contenu, 
					extrait, 
					auteur_id, 
					date_publie,
					date_modif,  
					image_id, 
					statut) 
				VALUES (
					:titre, 
					:contenu, 
					:extrait, 
					:auteur_id, 
					NOW(), 
					NOW(),
					:image_id, 
					:statut) ';

		$values = array(
			':titre'		=> $billet->get_titre(),
			':contenu'		=> $billet->get_contenu(),
			':extrait'		=> $billet->get_extrait(),
			':auteur_id'	=> $billet->get_auteur_id(),
			':image_id'		=> $billet->get_image_id(),
			':statut'		=> $billet->get_statut()
			);

		$req = SQLmgr::prepare($sql);
		$rep = $req->execute($values);
		if ($rep)
		{ 
			$id = SQLmgr::getLastId();
			self::set_last_billets_id($id); 
			return $id;
		}
		else
		{
			return FALSE;
		}
	}



	//-------------------------
	// Modifier un billet
	public function update(Billet $billet)
	{
		$sql = 'UPDATE ' . self::TABLE_BILLETS . ' 
				SET titre 		= :titre, 
					contenu 	= :contenu, 
					extrait 	= :extrait, 
					auteur_id 	= :auteur_id, 
					date_modif 	= NOW(), 
					image_id 	= :image_id, 
					statut 		= :statut 
				WHERE id=:id';
		
		$values = array(
			':titre'		=> $billet->get_titre(),
			':contenu'		=> $billet->get_contenu(),
			':extrait'		=> $billet->get_extrait(),
			':auteur_id'	=> $billet->get_auteur_id(),
			':image_id'		=> $billet->get_image_id(),
			':statut'		=> $billet->get_statut(),
			':id'			=> $billet->get_id()
			);

		$req = SQLmgr::prepare($sql);

		return $req->execute($values);
	}



	//-------------------------
	// Récupérer un billet
	// $id = id du billet à récupérer
	public function select(int $id)
	{
		if ($id <= 0)
		{
			return FALSE;
		}

		$sql = 'SELECT id, 
			titre, 
			contenu, 
			extrait, 
			auteur_id, 
			DATE_FORMAT(date_publie, "%d/%m/%Y à %k\h%H") AS date_publie, 
			DATE_FORMAT(date_modif, "%d/%m/%Y à %k\h%H") AS date_modif, 
			image_id, 
			statut 
				FROM ' . self::TABLE_BILLETS . ' 
				WHERE id=' . $id;

		$req = SQLmgr::prepare($sql);
		$rep = $req->execute();
		$donnees = $req->fetch(PDO::FETCH_ASSOC);

		if (!$rep OR !$donnees)
		{
			return FALSE;
		}

		$billet = New Billet;
		$billet->setValues($donnees); // on hydrate l'objet billet avec les données de la BDD
		return $billet; // on renvoi le billet hydraté
	}


	//-------------------------
	// Supprimer un billet
	// $id = id du billet à supprimer
	public function delete(int $id)
	{
		if ($id > 0)
		{
			$sql = 'DELETE FROM ' . self::TABLE_BILLETS . '
					WHERE id =' . $id;

			$req = SQLmgr::prepare($sql);

			return $req->execute();
		}
		return FALSE;
	}



	//-------------------------
	// Récupérer plusieurs billets
	// $where 	: array('colonne' => 'valeur')
	// $limit 	: array(int - nombre de résultats max => int - à partir de quelle valeur commencer)
	// $sortby 	: array('colonne' => 'ordre ASC/DESC')
	public function select_multi(array $where = null, array $limit = null, array $orderby = null)
	{

		// préparation des paramètres conditionnels de la requête
		// WHERE
		$sql_where = '';
		if (!is_null($where))
		{
			foreach ($where as $key => $value) {
				if ($sql_where == '')
				{
					$sql_where = " WHERE {$key} = '{$value}'";
				}
				else
				{
					$sql_where .= " AND {$key} = '{$value}'";
				}
			}
		}
		
		// LIMIT ET OFFSET
		$sql_limit = '';
		if (!is_null($limit))
		{ 
			$limit[1] = (int) $limit[1];
			$offset = (int) $limit[1] - 1;
			if ($offset < 0)
			{
				$offset = 0;
			}
			$offset *= $limit[0];
			$sql_limit = ' LIMIT ' . $limit[0] . ' OFFSET ' . $offset;
		}
	
		// ORDER BY
		$sql_orderby = '';
		if (!is_null($orderby))
		{ 
			foreach ($orderby as $key => $value) {
				if ($sql_orderby == '')
				{
					$sql_orderby = ' ORDER BY ' . $key . ' ' . $value;
				}
				else
				{
					$sql_orderby .= ', ' . $key . ' ' . $value;
				}
			}
		}		


		$sql = 'SELECT 
					id, 
					titre, 
					contenu, 
					extrait, 
					auteur_id, 
					date_modif AS last_date, 
					DATE_FORMAT(date_publie, "%d/%m/%Y à %k\h%H") AS date_publie, 
					DATE_FORMAT(date_modif, "%d/%m/%Y à %k\h%H") AS date_modif, 
					image_id, 
					statut 
				FROM ' . self::TABLE_BILLETS . $sql_where . $sql_orderby . $sql_limit;

		$req = SQLmgr::prepare($sql);
		$rep = $req->execute();

		if ($rep)
		{
			$billets = [];
			while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
				$billet = New Billet;

				$billet->setValues($donnees); // on hydrate l'objet billet avec les données de la BDD
				array_push($billets, $billet);
			}

			return $billets; // on renvoi le billet hydraté
		}
		else
		{
			return; // erreur dans la requête
		}
	}



	//-------------------------
	// Récupérer plusieurs billets
	// $where 	: array('colonne' => 'valeur')
	// $limit 	: array(int - nombre de résultats max => int - à partir de quelle valeur commencer)
	// $sortby 	: array('colonne' => 'ordre ASC/DESC')
	public function selectList(int $limit = null, int $offset = 0, string $where = null, string $orderby = null)
	{

		// préparation des paramètres conditionnels de la requête
		// WHERE
		$sqlwhere = '';
		if (!is_null($where))
		{
			$sqlwhere = " WHERE {$where}";
		}
		
		// LIMIT ET OFFSET
		$sqllimit = '';
		if (!is_null($limit))
		{ 
			$offset = $offset - 1;
			if ($offset < 0)
			{
				$offset = 0;
			}
			$offset *= $limit;
			$sqllimit = ' LIMIT ' . $limit . ' OFFSET ' . $offset;
		}
	
		// ORDER BY
		$sqlorderby = '';
		if (!is_null($orderby))
		{ 
			$sqlorderby = " ORDER BY {$orderby}";
		}	


		$sql = 'SELECT 
					id, 
					titre, 
					contenu, 
					extrait, 
					auteur_id, 
					date_modif AS last_date, 
					date_publie AS date_creation,
					DATE_FORMAT(date_publie, "%d/%m/%Y à %k\h%H") AS date_publie, 
					DATE_FORMAT(date_modif, "%d/%m/%Y à %k\h%H") AS date_modif, 
					image_id, 
					statut 
			FROM ' . self::TABLE_BILLETS . $sqlwhere . $sqlorderby . $sqllimit;

		$req = SQLmgr::prepare($sql);
		$rep = $req->execute();

		if ($rep)
		{
			$billets = [];
			while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
				$billet = New Billet;
				$billet->setValues($donnees); // on hydrate l'objet billet avec les données de la BDD
				array_push($billets, $billet);
			}

			return $billets; // on renvoi la liste des commentaires
		}
		else
		{
			return; // erreur dans la requête
		}
	}


	// récupérer tous les billets publiés
	public function selectPublications($limit = null)
	{
		$offset = 0;
		$where = "statut = 'Publication'";
		$orderby = "date_creation DESC";
		return $this->selectList($limit, $offset, $where, $orderby);
	}


	//-------------------------
	// Compter le nombre de billets selon une condition
	// $colonne = (string) nom de la colonne sur laquelle se fait le comptage
	// $where = (string) condition WHERE (ex : statut = Brouillon)
	public function count(string $colonne = '*', string $where = '')
	{
		if ($colonne <> '*' AND !array_key_exists($colonne, self::$_map))
		{ $colonne = '*'; }

		if ($where <> '') { $where = ' WHERE ' . $where; }

		$sql = 'SELECT COUNT(' . $colonne . ') FROM ' . self::TABLE_BILLETS . $where;

		$req = SQLmgr::prepare($sql);

		$repSQL = $req->execute();

		if ($repSQL)
		{
			$tableNbRecherche = $req->fetch();

			return $tableNbRecherche[0];
		}
		else
		{
			return;
		}
	}


	//-------------------------
	// Comptage nombres de billets dans chaque catégories (statut)
	public static function countNbBilletWithStatut(string $statut)
	{
		if (!in_array($statut, Billet::STATUT))
		{
			return -1;
		}

		$sql = "SELECT COUNT(*) FROM " . self::TABLE_BILLETS . " WHERE statut = '{$statut}'";
		$req = SQLmgr::prepare($sql);
		$req->execute();
		return $req->fetch()[0];
	}


	//-------------------------
	// Comptage nombres de billets dans chaque catégories (statut)
	public static function countNbBillets()
	{
		$sql = "SELECT COUNT(*) FROM " . self::TABLE_BILLETS;
		$req = SQLmgr::prepare($sql);
		$req->execute();
		return $req->fetch()[0];
	}
}