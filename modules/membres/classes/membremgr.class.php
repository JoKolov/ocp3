<?php
/**
 * 
 */
class MembreMgr {

	// enregistrer un membre
	public static function insert_membre(Membre $membre)
	{
		$sql = 	'INSERT INTO membres(pseudo, email, password,date_create) 
				VALUES(:pseudo, :email, :password, NOW())';
		$values = array(
			':pseudo'	=> $membre->get_pseudo(),
			':email'	=> $membre->get_email(),
			':password'	=> Membre::hashPassword($membre->get_password()));

		try {
			$req = SQLmgr::getPDO()->prepare($sql);
			$req->execute($values);
			return true;
		} catch (PDOException $msg) {
			echo "<br />ERREUR !: l'insertion dans la base de données à échoué !<br />
			Erreur PDO !: " . $msg . '<br />';
			return false;
			die();
		}
	}


	// Chercher un membre
	


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