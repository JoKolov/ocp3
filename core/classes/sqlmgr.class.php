<?php
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : Class
 * FILE/ROLE : SQLmgr (SQL Manager)
 *
 * File Last Update : 2017 07 25
 *
 * File Description :
 * -> gestion de la connexion à la BDD
 * -> contient l'instance PDO en attribut
 * 
 * Design pattern SINGLETON
 * 1 seule instance autorisée
 */

class SQLmgr {

	//------------------------------------------------------------
	// Attributs
	
	protected static $_pdo; 	/* instance PDO */ 



	//------------------------------------------------------------
	// Constructeur
	
	public function __construct() {
		self::set_pdo();
	}



	//------------------------------------------------------------
	// Getteurs
	
	public static function getPDO() { 
		if(!isset(self::$_pdo))
		{
			self::set_pdo();
		}
		return self::$_pdo;
	}



	//------------------------------------------------------------
	// Setteurs
	
	protected static function set_pdo() {
		try // on tente de se connecter à la base sinon on affiche une erreur (catch)
		{
			$bdd = 'mysql:host=' . BDD['host'] . ';dbname=' . BDD['name'] . ';charset=utf8';		
			self::$_pdo = new PDO($bdd,BDD['login'],BDD['password']);
		}

		catch (PDOException $msg)
		{
			print "Erreur !: " . $msg->getMessage() . "<br />
			>>> vérifier les paramètres du fichier config.sql.php <br />";
			die();
		}
	}



	//------------------------------------------------------------
	// Hydratation

	// --- NIL ---



	//------------------------------------------------------------
	// Méthodes

	public static function select($table, $colonnes = '*', $condition = '', $ordre = '') {
		// vérification du formatage de la variable $colonnes
		if(is_array($colonnes))
		{
			$col ='';
			foreach ($colonnes as $key => $value) {
				$col .= $value;
				if(isset($colonnes[$key+1]))
				{
					$col .= ', ';
				}
			}
			$colonnes = $col;
		}

		// formatage de la CONDITION
		if(!is_null($condition) AND $condition <> '')
		{
			$condition = ' WHERE ' . $condition;
		}

		// formatage de l'ORDRE
		if(!is_null($ordre) AND $ordre <> '')
		{
			$ordre = ' ORDER BY ' . $ordre;
		}

		// création de la requête
		$requete =  'SELECT ' . $colonnes . ' FROM ' . $table . $condition . $ordre;

		return $requete;
	}



	//------------------------------------------------------------
	// Méthodes magiques



}