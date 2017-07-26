<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Classe MembreMgr (Membre Manager)
 *
 * File Last Update : 2017 07 26
 *
 * File Description :
 * -> gestion des requêtes SQL entre la BDD et la classe Membre
 */

class MembreMgr {

	//------------------------------------------------------------
	// Attributs
	const TABLE = 'membres';




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
			$req->execute($values);
			return TRUE;
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
	


	// chercher un type d'utilisateur
	public static function select_type()
	{
		$sql = SQLmgr::select('membres_types', 'type');
		$req = SQLmgr::getPDO()->prepare($sql);
		$req->execute();
		$tableDonnees = array();
		while ($donnees = $req->fetch(PDO::FETCH_ASSOC))
		{
			array_push($tableDonnees, $donnees['type']);
		}
		return $tableDonnees;
	} 

}