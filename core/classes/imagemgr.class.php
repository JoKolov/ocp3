<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : Class
 * FILE/ROLE : image Manager
 *
 * File Last Update : 2017 08 23
 *
 * File Description :
 * -> gestion des images dans la BDD
 */

class ImageMgr {

	//------------------------------------------------------------
	// Attributs

	// contantes
	const DB_NAME 	= BDD['name'];
	const TABLE_IMAGES 	= 'ocp3_Images';
	const LIST_INSERT = '(source, billet, vignette, avatar, description)';

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

	public function set_map()	{ return $this->setteur_map(); }

	/**
	 * set_map récupère les noms des colonnes de la table membres
	 */
	public function setteur_map()
	{
		$sql = 'SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH 
				FROM INFORMATION_SCHEMA.COLUMNS 
				WHERE TABLE_NAME = "' . self::TABLE_IMAGES . '" AND TABLE_SCHEMA = "' . self::DB_NAME . '" 
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


	//------------------------------------------------------------
	// Méthodes

	//-------------------------
	// Enregistrer une image
	public function insert(Image $image)
	{
		$sql = 'INSERT INTO ' . self::TABLE_IMAGES . ' (source, billet, vignette, avatar, description) 
				VALUES (:source, :billet, :vignette, :avatar, :description)';
		
		$values = array(
			':source'		=> $image->get_source(),
			':billet'		=> $image->get_billet(),
			':vignette'		=> $image->get_vignette(),
			':avatar'		=> $image->get_avatar(),
			':description'	=> $image->get_description());

		$req = SQLmgr::getPDO()->prepare($sql);

		return $req->execute($values);
	}


	//-------------------------
	// Récupérer une image
	// $critere = array($key = colonne, $value = valeur recherchée)
	public function select(array $critere)
	{
		foreach ($critere as $key => $value) {
			$colonne = $key;
			$valeur_cherchee = $value;
		}

		$sql = 'SELECT id, source, billet, vignette, avatar, description 
				FROM ' . self::TABLE_IMAGES . ' 
				WHERE ' . $colonne . ' = ?';

		$req = SQLmgr::getPDO()->prepare($sql);
		$rep = $req->execute(array($valeur_cherchee));

		if ($req->execute())
		{
			// on renvoi un tableau avec toutes les données de l'image en question
			return $req->fetch();
		}
		return FALSE; // image non trouvée
	}


	//-------------------------
	// Supprimer une image
	// $id = id de l'image à supprimer
	public function delete(int $id)
	{
		if ($id > 1)
		{
			$sql = 'DELETE FROM ' . self::TABLE_IMAGES . '
					WHERE id =' . $id;

			$req = SQLmgr::getPDO()->prepare($sql);

			return $req->execute();
		}
		return FALSE;
	}
}