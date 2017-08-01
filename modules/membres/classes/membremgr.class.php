<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Classe MembreMgr (Membre Manager)
 *
 * File Last Update : 2017 08 01
 *
 * File Description :
 * -> gestion des requêtes SQL entre la BDD et la classe Membre
 */

class MembreMgr {

	//------------------------------------------------------------
	// Attributs

	// contantes
	const TABLE_DB = 'ocp3_blog';
	const TABLE = 'membres';

	// mapping de la table
	private $_map; 	// tableau contenant les colonnes de la table
					// $key = titre colonne // $value = type donnée,*max lenght* (si existe)


	//------------------------------------------------------------
	// Constructeur
	
	public function __construct() {
		$this->set_map();
	}



	//------------------------------------------------------------
	// Getteurs
	public function get_map()	{ return $this->_map; }


	//------------------------------------------------------------
	// Setteurs

	/**
	 * set_map récupère les noms des colonnes de la table membres
	 */
	public function set_map()
	{
		$sql = 'SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH 
				FROM INFORMATION_SCHEMA.COLUMNS 
				WHERE TABLE_NAME = "' . self::TABLE . '" AND TABLE_SCHEMA = "' . self::TABLE_DB . '" 
				ORDER BY ORDINAL_POSITION';
		$req = SQLmgr::prepare($sql);
		$req->execute();
		if($req->execute() !== FALSE) {
			while($mapping = $req->fetch())
			{
				$this->_map[$mapping["COLUMN_NAME"]] = $mapping["DATA_TYPE"] . ',' . $mapping['CHARACTER_MAXIMUM_LENGTH'];
			}
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
		$sql = 	'INSERT INTO membres(pseudo, email, password,date_create) 
				VALUES(:pseudo, :email, :password, NOW())';
		$values = array(
			':pseudo'	=> $membre->get_pseudo(),
			':email'	=> $membre->get_email(),
			':password'	=> Membre::hashPassword($membre->get_password())
			);

		try {
			$req = SQLmgr::getPDO()->prepare($sql);
			if($req->execute($values))
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

		$sql = 'SELECT * FROM membres WHERE LOWER(pseudo) = :pseudo AND password = :password';
		
		$pseudo = strtolower(htmlspecialchars($post['pseudo']));
		$password = get_hash(htmlspecialchars($post['password']));

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

		if ($donneesMembre)
		{
			return new Membre($donneesMembre); // on renvoi une instance Membre hydratée
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
		$sql = SQLmgr::select('membres_types', 'id, type');
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
		//>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
		// script d'update des données
		// avatar
		// pseudo
		// nom
		// prenom
		// date de naissance
		// email
		// mot de passe
		//<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
	}


	//-------------------------

}