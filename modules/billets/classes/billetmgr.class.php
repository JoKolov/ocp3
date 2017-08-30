<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Billet Manager
 *
 * File Last Update : 2017 08 30
 *
 * File Description :
 * -> gestion des images dans la BDD
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
	private $_map; 	// tableau contenant les colonnes de la table
					// $key = titre colonne // $value = type donnée,*max lenght* (si existe)


	//------------------------------------------------------------
	// Constructeur
	
	public function __construct() {
		$this->set_map();
		self::set_last_billets_id();
	}



	//------------------------------------------------------------
	// Getteurs
	
	public function get_map()				{ return $this->_map; 						}
	public function get_last_billets_id()	{ return self::$_last_billets_id; 			}
	public function get_new_billets_id()	{ return $this->getteur_new_billets_id();	}


	//----------
	// GET NEW_BILLET_ID
	public function getteur_new_billets_id()
	{
		$id = $this->get_last_billets_id() + 1;
		return $id;
	}



	//------------------------------------------------------------
	// Setteurs

	public function set_map()									{ return $this->setteur_map(); 					}
	private static function set_last_billets_id($id = null)		{ return self::setteur_last_billets_id($id); 	}

	/**
	 * set_map récupère les noms des colonnes de la table membres
	 */
	public function setteur_map()
	{
		$sql = 'SELECT COLUMN_NAME, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH 
				FROM INFORMATION_SCHEMA.COLUMNS 
				WHERE TABLE_NAME = "' . self::TABLE_BILLETS . '" AND TABLE_SCHEMA = "' . self::DB_NAME . '" 
				ORDER BY ORDINAL_POSITION';
		$req = SQLmgr::prepare($sql);
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
					id,
					titre, 
					contenu, 
					extrait, 
					auteur_id, 
					date_publie, 
					image_id, 
					statut) 
				VALUES (
					:id,
					:titre, 
					:contenu, 
					:extrait, 
					:auteur_id, 
					NOW(), 
					:image_id, 
					:statut) ';

		$values = array(
			':id'			=> $this->get_new_billets_id(),
			':titre'		=> $billet->get_titre(),
			':contenu'		=> $billet->get_contenu(),
			':extrait'		=> $billet->get_extrait(),
			':auteur_id'	=> $billet->get_auteur_id(),
			':image_id'		=> 0,
			':statut'		=> $billet->get_statut()
			);

		$req = SQLmgr::prepare($sql);
		$rep = $req->execute($values);
		if ($rep) { self::set_last_billets_id(self::get_new_billets_id()); }

		return $rep;
	}



	//-------------------------
	// Modifier un billet
	public function update(Billet $billet)
	{
		$sql = 'UPDATE ' . self::TABLE_IMAGES . ' 
				SET source = :source, 
					billet = :billet, 
					vignette = :vignette, 
					avatar = :avatar, 
					description = :description 
				WHERE id=:id';
		
		$values = array(
			':source'		=> $image->get_source(),
			':billet'		=> $image->get_billet(),
			':vignette'		=> $image->get_vignette(),
			':avatar'		=> $image->get_avatar(),
			':description'	=> $image->get_description(),
			':id'			=> $image->get_id());

		$req = SQLmgr::prepare($sql);

		return $req->execute($values);
	}



	//-------------------------
	// Récupérer un billet
	// $critere = array($key = colonne, $value = valeur recherchée)
	public function select(array $critere)
	{
		foreach ($critere as $key => $value) {
			if (!isset($condition))
			{
				$condition = $key . ' = ' . $value;
			} 
			else
			{
				$condition .= ' AND ' . $key . ' = ' . $value;
			}
		}

		$sql = 'SELECT id, source, billet, vignette, avatar, description 
				FROM ' . self::TABLE_BILLETS . ' 
				WHERE ' . $condition;

		$req = SQLmgr::prepare($sql);
		$rep = $req->execute();

		if ($rep)
		{
			// on renvoi un tableau avec toutes les données de l'image en question
			$donnees = $req->fetch(PDO::FETCH_ASSOC);
			$image = New Image;
			$image->setFull($donnees, TRUE); // on hydrate l'objet image avec les données de la BDD (TRUE indique à la fonction que les données proviennent de la BDD)
			return $image;
		}
		return FALSE; // image non trouvée
	}


	//-------------------------
	// Supprimer un billet
	// $id = id du billet à supprimer
	public function delete(int $id)
	{
		if ($id > 1)
		{
			$sql = 'DELETE FROM ' . self::TABLE_IMAGES . '
					WHERE id =' . $id;

			$req = SQLmgr::prepare($sql);

			return $req->execute();
		}
		return FALSE;
	}
}