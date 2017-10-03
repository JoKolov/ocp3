<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Commentaires
 * FILE/ROLE : Commentaire Manager
 *
 * File Last Update : 2017 10 02
 *
 * File Description :
 * -> gestion des commentaires dans la BDD
 */

class CommentaireMgr {

	//------------------------------------------------------------
	// Attributs
	private static $_lastId;			// Dernier id dans la table commentaires

	// contantes
	const DB_NAME 			= BDD['name'];

	const TABLE_COM 	= 'ocp3_Commentaires';

	// mapping de la table
	private static $_map; 	// tableau contenant les colonnes de la table
							// $key = titre colonne // $value = type donnée,*max lenght* (si existe)


	//------------------------------------------------------------
	// Constructeur
	
	public function __construct() {
		self::setMap();
		self::setLastId();
	}



	//------------------------------------------------------------
	// Getteurs
	
	public function getMap()			{ return $this->_map; 			}
	public function getLastId()			{ return self::$_lastId; 		}
	public function getNewId()			{ return $this->getteurNewId();	}

	public function getNbSignalements()			{ return $this->countNbSignalements(); 	}
	public function getNbApprobations()			{ return $this->countNbApprobations(); 	}
	public function getNbCom($auteurId = null)	{ return $this->countNbCom($auteurId); 	}
	public function getNbComBillet($billetId = null)	{ return $this->countNbComBillet($billetId); 	}


	//----------
	// GET NEW ID
	public function getteurNewId()
	{
		$id = $this->getLastId() + 1;
		return $id;
	}



	//------------------------------------------------------------
	// Setteurs

	private static function setMap()					{ return self::setteurMap(); 		}
	private static function setLastId($id = null)		{ return self::setteurLastId($id); 	}

	/**
	 * setMap récupère les noms des colonnes de la table membres
	 */
	private static function setteurMap()
	{
		if (!isset(self::$_map))
		{
			$sql = 'SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH 
					FROM INFORMATION_SCHEMA.COLUMNS 
					WHERE TABLE_NAME = "' . self::TABLE_COM . '" AND TABLE_SCHEMA = "' . self::DB_NAME . '" 
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
	private static function setteurLastId($id = null)
	{
		// on va chercher une valeur d'id
		if (is_null($id))
		{
			$sql = 'SELECT MAX(id) FROM ' . self::TABLE_COM;
			$req = SQLmgr::prepare($sql);
			$req->execute();
			$id = $req->fetch(PDO::FETCH_ASSOC);
			$id = (int) $id['MAX(id)'];
		}
		
		if (is_int($id) AND $id > 0)
		{
			self::$_lastId = $id;
		}
		else
		{
			self::$_lastId = 0;
		}
	}


	//------------------------------------------------------------
	// Méthodes

	//-------------------------
	// Enregistrer un commentaire
	public function insert(commentaire $commentaire)
	{
		$sql = 'INSERT INTO ' . self::TABLE_COM . ' (
					billet_id, 
					com_id, 
					com_level, 
					auteur_id, 
					contenu, 
					date_publie,
					approuve,  
					signalement) 
				VALUES (
					:billet_id, 
					:com_id, 
					:com_level,
					:auteur_id, 
					:contenu, 
					NOW(),
					:approuve,  
					:signalement)  ';

		$values = array(
			':billet_id'	=> $commentaire->get_billet_id(),
			':com_id'		=> $commentaire->get_com_id(),
			':com_level'	=> $commentaire->get_com_level(),
			':auteur_id'	=> $commentaire->get_auteur_id(),
			':contenu'		=> $commentaire->get_contenu(),
			':approuve'		=> $commentaire->get_approuve(),
			':signalement'	=> 0
			);

		$req = SQLmgr::prepare($sql);
		$rep = $req->execute($values);
		if ($rep)
		{
			$idCommentaire = SQLmgr::getLastId();
			self::setLastId($idCommentaire); 
			return $idCommentaire;
		}

		return $rep;
	}



	//-------------------------
	// Modifier un commentaire
	public function update(commentaire $commentaire)
	{
		$sql = 'UPDATE ' . self::TABLE_COM . ' 
				SET billet_id 	= :billet_id, 
					com_id 		= :com_id, 
					com_level 	= :com_level,
					auteur_id 	= :auteur_id, 
					contenu 	= :contenu, 
					approuve 	= :approuve, 
					signalement	= :signalement 
				WHERE id=:id';
		
		$values = array(
			':billet_id'	=> $commentaire->get_billet_id(),
			':com_id'		=> $commentaire->get_com_id(),
			':com_level' 	=> $commentaire->get_com_level(),
			':auteur_id'	=> $commentaire->get_auteur_id(),
			':contenu'		=> $commentaire->get_contenu(),
			':approuve'		=> $commentaire->get_approuve(),
			':signalement'	=> $commentaire->get_signalement(),
			':id'			=> $commentaire->get_id()
			);

		$req = SQLmgr::prepare($sql);

		return $req->execute($values);
	}



	//-------------------------
	// Récupérer un commentaire
	// $id = id du commentaire à récupérer
	public function select(int $id)
	{
		if ($id <= 0)
		{
			return FALSE;
		}

		$sql = 'SELECT 
			id,
			billet_id, 
			com_id, 
			com_level, 
			auteur_id, 
			contenu, 
			DATE_FORMAT(date_publie, "%d/%m/%Y à %k\h%H") AS date_publie,
			approuve,  
			signalement
				FROM ' . self::TABLE_COM . ' 
				WHERE id=' . $id;

		$req = SQLmgr::prepare($sql);
		$rep = $req->execute();
		$donnees = $req->fetch(PDO::FETCH_ASSOC);

		if (!$rep OR !$donnees)
		{
			return FALSE;
		}

		$commentaire = New Commentaire;
		$commentaire->setValues($donnees); // on hydrate l'objet commentaire avec les données de la BDD
		return $commentaire; // on renvoi le commentaire hydraté
	}


	//-------------------------
	// Supprimer un commentaire
	// $id = id du commentaire à supprimer
	public function delete(int $id)
	{
		if ($id > 0)
		{
			$sql = 'DELETE FROM ' . self::TABLE_COM . '
					WHERE id =' . $id;

			$req = SQLmgr::prepare($sql);

			return $req->execute();
		}
		return FALSE;
	}


	//-------------------------
	// Supprimer un commentaire ou effacer son contenu s'il a des enfants
	public function tryDelete(Commentaire $commentaire)
	{
		// chercher tous les enfants du commentaire à supprimer
		$billetId = $commentaire->get_billet_id();
		$commentaireLevel = $commentaire->get_com_level();
		$limit = null;
		$offset = 0;
		$where = "billet_id = '{$billetId}' AND com_level > '{$commentaireLevel}'";
		$orderby = "date_trie ASC";
		$commentairesEnfants = $this->selectList($limit, $offset, $where, $orderby);
		if (empty($commentairesEnfants))
		{
			return $this->delete($commentaire->get_id());
		}
		else
		{
			$commentaire->set_contenu("commentaire supprimé");
			$commentaire->set_auteur_id(0);
			return $this->update($commentaire);
		}
		return FALSE;
	}


	//-------------------------
	// Supprimer un commentaire et réaffecter ses enfants
	public function deleteAndRechild(Commentaire $commentaire)
	{
		// chercher le parent du commentaire à supprimer
		$idParentCommentaire = $commentaire->get_com_id();
		if (is_null($idParentCommentaire))
		{
			$idParentCommentaire = 0;
		}

		// chercher tous les enfants du commentaire à supprimer
		$billetId = $commentaire->get_billet_id();
		$commentaireLevel = $commentaire->get_com_level();
		$limit = 0;
		$offset = 0;
		$where = "billet_id = '{$billetId}' AND com_level > '{$commentaireLevel}'";
		$orderby = "date_trie ASC";
		$commentairesEnfants = $this->selectList($limit, $offset, $where, $orderby);
		foreach ($commentairesEnfants as $commentaireEnfant)
		{
			if ($commentaireEnfant->get_id_com() == $commentaire->get_id())
			{
				$commentaireEnfant->set_id_com($idParentCommentaire);
			}
			$commentaireEnfantNewLevel = $commentaireEnfant->get_com_level() - 1;
			($commentaireEnfantNewLevel < 0) ? 0 : $commentaireEnfantNewLevel;
			$commentaireEnfant->set_com_level($commentaireEnfantNewLevel);
		}
		
		// supprimer le commentaire
		$delete = $this->delete($commentaire->get_id());
		
		// réaffecter les enfants au parent du commentaire supprimé
		foreach ($commentairesEnfants as $commentaireEnfant)
		{
			$update = $this->update($commentaireEnfant);
		}

		return $delete;
	}


	//-------------------------
	// Supprimer un commentaire
	// $id = id du commentaire à supprimer
	public function deleteFromBillet(Billet $billet)
	{
		$billetId = $billet->get_id();

		$sql = 'DELETE FROM ' . self::TABLE_COM . " WHERE billet_id = '{$billetId}'";

		$req = SQLmgr::prepare($sql);

		return $req->execute();
	}



	//-------------------------
	// Récupérer plusieurs commentaires
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
			billet_id, 
			com_id, 
			com_level, 
			auteur_id, 
			contenu, 
			date_publie AS date_trie,
			DATE_FORMAT(date_publie, "%d/%m/%Y à %k\h%H") AS date_publie,
			approuve,  
			signalement
			FROM ' . self::TABLE_COM . $sqlwhere . $sqlorderby . $sqllimit;

		$req = SQLmgr::prepare($sql);
		$rep = $req->execute();

		if ($rep)
		{
			$commentaires = [];
			while ($donnees = $req->fetch(PDO::FETCH_ASSOC)) {
				$commentaire = New commentaire;
				$commentaire->setValues($donnees); // on hydrate l'objet commentaire avec les données de la BDD
				array_push($commentaires, $commentaire);
			}

			return $commentaires; // on renvoi la liste des commentaires
		}
		else
		{
			return; // erreur dans la requête
		}
	}


	//-------------------------
	// Comptage nombres de commentaires signalés
	public function countNbSignalements()
	{
		$sql = "SELECT COUNT(*) FROM " . self::TABLE_COM . " WHERE signalement > 0";
		$req = SQLmgr::prepare($sql);
		$req->execute();
		return $req->fetch()[0];
	}


	//-------------------------
	// Comptage nombres de commentaires en attente d'approbation
	public function countNbApprobations()
	{
		$sql = "SELECT COUNT(*) FROM " . self::TABLE_COM . " WHERE approuve = '0'";
		$req = SQLmgr::prepare($sql);
		$req->execute();
		return $req->fetch()[0];
	}


	//-------------------------
	// Comptage nombres de commentaires (tous ou pour un auteur particulier)
	public function countNbCom($auteurId = null)
	{
		// auteurId > 0 = commentaires de ce membre
		// auteurId = 0 = commentaires anonymes
		// auteurId = null = tous les commentaires

		if (is_null($auteurId))
		{
			$where = '';
		}
		else
		{
			$where = " WHERE auteur_id = '{$auteurId}'";
		}

		$sql = "SELECT COUNT(*) FROM " . self::TABLE_COM . $where;
		$req = SQLmgr::prepare($sql);
		$req->execute();
		return $req->fetch()[0];
	}


	//-------------------------
	// Comptage nombres de commentaires (tous ou pour un auteur particulier)
	public function countNbComBillet($billetId = null)
	{

		if (is_null($billetId))
		{
			$where = '';
		}
		else
		{
			$where = " WHERE billet_id = '{$billetId}' AND approuve = '1'";
		}

		$sql = "SELECT COUNT(*) FROM " . self::TABLE_COM . $where;
		$req = SQLmgr::prepare($sql);
		$req->execute();
		return $req->fetch()[0];
	}


	/**
	 * récupère le niveau le plus élevé des commentaires : com_level MAX
	 */
	private function getComLevelMax()
	{
		$sql = 'SELECT MAX(com_level) FROM ' . self::TABLE_COM;
		$req = SQLmgr::prepare($sql);
		$req->execute();
		$comLevels = $req->fetch(PDO::FETCH_ASSOC);
		$comLevelMax = (int) $comLevels['MAX(com_level)'];
		return $comLevelMax;
	}



	//-------------------------
	// Récupérer tous les commentaires d'un billet
	// $where 	: array('colonne' => 'valeur')
	// $limit 	: array(int - nombre de résultats max => int - à partir de quelle valeur commencer)
	// $sortby 	: array('colonne' => 'ordre ASC/DESC')
	public function selectListForBillet(Billet $billet)
	{

		$billetId = $billet->get_id();
		$limit = 0;
		$offset = 0;
		$where = "billet_id = '{$billetId}'";
		$orderby = "date_trie ASC";

		return $this->selectList($limit, $offset, $where, $orderby);

	}
}