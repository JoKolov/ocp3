<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Classe MembreMgr (Membre Manager)
 *
 * File Last Update : 2017 09 15
 *
 * File Description :
 * -> gestion des requêtes SQL entre la BDD et la classe Membre
 */

class MembreMgr {

	//------------------------------------------------------------
	// Attributs

	// contantes
	const DB_NAME 	= BDD['name'];
	const T_MEMBRES = 'ocp3_Membres';
	const T_MEMBRES_TYPES 	= 'ocp3_Membres_types';

	const TABLE_MEMBRES = 'ocp3_Membres';

	// mapping de la table
	private $_map; 	// tableau contenant les colonnes de la table
					// $key = titre colonne // $value = type donnée,*max lenght* (si existe)
	private $_lastId;	// dernier id de la table Membres


	//------------------------------------------------------------
	// Constructeur
	
	public function __construct() {
		$this->set_map();
		$this->setLastId();
	}



	//------------------------------------------------------------
	// Getteurs
	public function getMap()	{ return $this->_map; }
	public function getLastId()	{ return $this->_lastId; }


	//------------------------------------------------------------
	// Setteurs

	/**
	 * set_map récupère les noms des colonnes de la table membres
	 */
	public function set_map()
	{
		$sql = 'SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH 
				FROM INFORMATION_SCHEMA.COLUMNS 
				WHERE TABLE_NAME = "' . self::T_MEMBRES . '" AND TABLE_SCHEMA = "' . self::DB_NAME . '" 
				ORDER BY ORDINAL_POSITION';
		$req = SQLmgr::prepare($sql);
		$req->execute();
		if($req->execute() !== FALSE) {
			while($mapping = $req->fetch())
			{
				$this->_map[$mapping["COLUMN_NAME"]] = $mapping["DATA_TYPE"] . ',' . $mapping['CHARACTER_MAXIMUM_LENGTH'];
			}
			return $this->_map;
		}
		return FALSE;
	}


	/**
	 * récupère le dernier id de la table
	 */
	private static function setLastId(int $id = null)
	{

		// on va chercher une valeur d'id
		if (is_null($id))
		{
			$sql = 'SELECT MAX(id) FROM ' . self::TABLE_MEMBRES;
			$req = SQLmgr::prepare($sql);
			$req->execute();
			$id = $req->fetch(PDO::FETCH_ASSOC);
			$id = (int) $id['MAX(id)'];
		}
		
		// on enregistre la valeur de l'id
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

	/**
	 * -------------------------
	 * [insert_membre Enregistre un membre dans la BDD]
	 * @param  Membre $membre [Objet Membre]
	 * @return [boolean]      [TRUE si tout s'est bien passé, sinon FALSE]
	 */
	public static function insert_membre(Membre $membre)
	{
		$sql = 	'INSERT INTO ' . self::T_MEMBRES . '(pseudo, email, password, date_create, type_id, avatar_id) 
				VALUES(:pseudo, :email, :password, NOW(), :type_id, :avatar_id)';
		$values = array(
			':pseudo'	=> $membre->get_pseudo(),
			':email'	=> $membre->get_email(),
			':password'	=> $membre->get_password(),
			':type_id'	=> $membre->get_type_id(),
			':avatar_id' => $membre->get_avatar_id()
			);

		try {
			$req = SQLmgr::getPDO()->prepare($sql);
			if ($req->execute($values))
			{
				return TRUE; // l'insertion est confirmée
			}
			else
			{
				return FALSE; // l'insertion a échouée car un membre similaire existe déjà
			}
		} catch (PDOException $msg) {
			echo "<br />ERREUR !: l'insertion dans la base de données a échoué !<br />
			Erreur PDO !: " . $msg . '<br />';
			return FALSE;
			die();
		}
	}


	// contrôle connexion membre
	// si OK => renvoi un objet membre
	// si échec => renvoi FALSE
	public static function login_check(array $post)
	{

		$sql = 'SELECT * FROM ' . self::T_MEMBRES . ' WHERE LOWER(pseudo) = :pseudo AND password = :password';
		
		$pseudo = strtolower(htmlspecialchars($post['pseudo']));	// on compare les pseudo en lettres minuscules
		$password = get_hash(htmlspecialchars($post['password'])); 	// on compare les hash du password

		try {
			$req = SQLmgr::getPDO()->prepare($sql);
			$req->execute(array(
				':pseudo'	=> $pseudo,
				':password'	=> $password
				));
			$donneesMembre = $req->fetch();
		} catch (PDOException $msg) {
			echo "<br />ERREUR !: la connexion à la base de données a échoué !<br />
			Erreur PDO !: " . $msg . '<br />';
			return FALSE;
			die();
		}

		// récupération du type de compte
		if (isset($donneesMembre['type_id'])) {	$type_id = (int) $donneesMembre['type_id']; }
		if (isset($type_id) AND $type_id > 0)
		{
			$sql = 'SELECT type FROM ' . self::T_MEMBRES_TYPES . ' WHERE id = ' . $type_id;
			$req = SQLmgr::prepare($sql);
			if($req->execute() !== FALSE)
			{
				$type = $req->fetch();
				$donneesMembre['type'] = $type['type'];
			}
		}

		// récupération de l'avatar
		if (isset($donneesMembre['avatar_id']) AND (int) $donneesMembre > 0)
		{
			$sql = 'SELECT id, source, avatar FROM ocp3_Images WHERE id = ' . (int) $donneesMembre['avatar_id'];
			$req = SQLmgr::prepare($sql);
			if ($req->execute() !== FALSE)
			{
				$donneesTable = $req->fetch();
				$donneesMembre['avatar'] = $donneesTable['avatar'];
			}

			// nouvelle méthode sans passer par la BDD
		}

		if ($donneesMembre)
		{
			return new Membre($donneesMembre, FALSE); // on renvoi une instance Membre hydratée (FALSE = password à ne pas hasher)
		}
		else
		{
			return FALSE;
		}
	}
	

	//-------------------------
	// Chercher un type d'utilisateur
	public static function select_all_type()
	{
		$sql = SQLmgr::select(self::T_MEMBRES_TYPES, 'id, type');
		$req = SQLmgr::getPDO()->prepare($sql);
		$req->execute();
		$tableDonnees = array();
		while ($donnees = $req->fetch(PDO::FETCH_ASSOC))
		{
			array_push($tableDonnees, $donnees['type']);
		}
		return $tableDonnees;
	}


	//-------------------------
	// Update des données du membre
	public static function update_membre(Membre $membre)
	{
		$sql = 'UPDATE ' . self::T_MEMBRES . ' 
				SET pseudo = :pseudo, 
					nom = :nom, 
					prenom = :prenom, 
					email = :email, 
					password = :password, 
					date_birth = :date_birth, 
					avatar_id = :avatar_id 
				WHERE id = :id';
		
		$req = SQLmgr::prepare($sql);
		
		$donnees = array(	':pseudo'		=>	$membre->get_pseudo(),
							':nom'			=>	$membre->get_nom(),
							':prenom'		=>	$membre->get_prenom(),
							':email'		=>	$membre->get_email(),
							':password'		=>	$membre->get_password(),
							':date_birth'	=>	$membre->get_date_birth(),
							':avatar_id'	=>	$membre->get_avatar_id(),
							':id'			=>	$membre->get_id());
		
		if ($req->execute($donnees) !== FALSE)
		{
			return TRUE; // la requête a bien été effectuée
		}

		return FALSE; // la requête n'a pas fonctionnee
	}


	//-------------------------
	// Update des données du membre
	public function select(int $id)
	{
		$sql = 'UPDATE ' . self::T_MEMBRES . ' 
				SET pseudo = :pseudo, 
					nom = :nom, 
					prenom = :prenom, 
					email = :email, 
					password = :password, 
					date_birth = :date_birth, 
					avatar_id = :avatar_id 
				WHERE id = :id';
		
		$req = SQLmgr::prepare($sql);
		
		$donnees = array(	':pseudo'		=>	$membre->get_pseudo(),
							':nom'			=>	$membre->get_nom(),
							':prenom'		=>	$membre->get_prenom(),
							':email'		=>	$membre->get_email(),
							':password'		=>	$membre->get_password(),
							':date_birth'	=>	$membre->get_date_birth(),
							':avatar_id'	=>	$membre->get_avatar_id(),
							':id'			=>	$membre->get_id());
		
		if ($req->execute($donnees) !== FALSE)
		{
			return TRUE; // la requête a bien été effectuée
		}

		return FALSE; // la requête n'a pas fonctionnee
	}


	//-------------------------

}