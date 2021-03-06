<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Classe Membre
 *
 * File Last Update : 2017 08 29
 *
 * File Description :
 * -> gestion des attributs du membre connecté
 * -> contient en attribut tous les éléments de la table Membres
 * -> permet de contrôler l'intégrité des données du membres avant insertion dans la BDD
 */

class Membre {
	
	//------------------------------------------------------------
	// Attributs
	
	protected $_id;
	protected $_pseudo;
	protected $_nom;
	protected $_prenom;
	protected $_email;
	protected $_password;
	protected $_date_create;
	protected $_date_create_format; 	// date formatée jj/mm/aaaa à HHhMM
	protected $_date_birth;
	protected $_date_birth_format; 		// date formatée jj/mm/aaaa
	protected $_type_id;				// id du type de compte
	protected $_type;
	protected $_avatar_id;				// id de l'avatar
	protected $_avatar;					// url de l'avatar
	protected $_admin;					// BOOL qui indique si le membre est un admin

	protected $_hashThePassword;		// BOOL pour indiquer si la password doit être haché ou non

	const PSEUDO_MIN_LENGHT 	= 4;
	const PSEUDO_MAX_LENGHT 	= 100;
	const NOM_MAX_LENGHT 		= 100;
	const PRENOM_MAX_LENGHT 	= 100;
	const EMAIL_MAX_LENGHT 		= 255;
	const PASSWORD_MIN_LENGHT	= 8; 
	const PASSWORD_MAX_LENGHT 	= 255;
	const AVATAR_PAR_DEFAUT 	= APP['url-website'] . '/upload/avatars/default.png';
	const AVATAR_ID_DEFAUT 		= 1; // avatar par défaut
	const COMPTE_ABONNE_ID 		= 2; // compte abonné par défaut



	//------------------------------------------------------------
	// Constructeur
	public function __construct(array $donnees = [], bool $hash = TRUE) {
		// attributs par défaut
		$this->set_type_id(self::COMPTE_ABONNE_ID); // compte abonné
		$this->set_avatar_id(self::AVATAR_ID_DEFAUT); // avatar par défaut
		$this->_hashThePassword = $hash;

		// on hydrate l'objet avec les données envoyées
		if (!empty($donnees))
		{
			$this->setFull($donnees, $hash);
		}
	}



	//------------------------------------------------------------
	// Getteurs
	
	public function get_id() 					{ return $this->_id; 				}
	public function get_pseudo() 				{ return $this->_pseudo; 			}
	public function get_nom() 					{ return $this->_nom;				}
	public function get_prenom() 				{ return $this->_prenom; 			}
	public function get_email() 				{ return $this->_email;				}
	public function get_password()				{ return $this->_password; 			}
	public function get_date_create() 			{ return $this->_date_create; 		}
	public function get_date_create_format()	{ return $this->_date_create_format; }
	public function get_date_birth() 			{ return $this->_date_birth; 		}
	public function get_date_birth_format() 	{ return $this->_date_birth_format; }
	public function get_type_id() 				{ return $this->_type_id; 			}
	public function get_type() 					{ return $this->_type; 				}
	public function get_avatar_id() 			{ return $this->_avatar_id; 		}
	public function get_avatar() 				{ return $this->_avatar; 			}
	public function is_admin()					{ return $this->_admin;				}

	protected function IMustHashThePassword()
	{ 
		if (!$this->_hashThePassword)
		{
			$this->_hashThePassword = TRUE;
			return FALSE;
		}
		return TRUE;
	}



	//------------------------------------------------------------
	// Setteurs
	
	public function set_id($id) {
		$id = (int) $id;
		if(isset($id) AND $id > 0)
		{
			$this->_id = $id;
			return TRUE;
		}
		return FALSE;
	}

	/**
	 * set_pseudo : vérifie l'entrée et l'enregistre dans l'attribut si elle est valide
	 * @param [type] $pseudo []
	 * @return <true : le pseudo est enregistré, false : le pseudo est invalide>
	 * Le pseudo doit contenir au moins "PSEUDO_MIN_LENGHT" caractères,
	 * doit obligatoirement commencer par une lettre et peut seulement contenir 
	 * des caractères alphanumériques et des tirets _ ou - (pas d'espace !)
	 */
	public function set_pseudo($pseudo) {
		if(is_string($pseudo) AND strlen($pseudo) <= self::PSEUDO_MAX_LENGHT)
		{
			$pseudo = htmlspecialchars($pseudo); 	// retrait des balises html
			$pseudo = trim($pseudo); 				// retrait des espaces en début en fin de chaine
			$char_limit = strlen($pseudo) - 1;		// on récupère la longueur de chaine -1 pour le contrôle des caractères suivants la première lettre
			$pattern = '#^[a-zA-Z]{1}[a-zA-Z0-9_-]{' . $char_limit .'}#'; // liste des caractères autorisés

			if (preg_match($pattern, $pseudo) AND strlen($pseudo) >= self::PSEUDO_MIN_LENGHT) // on vérifie que le formatage est correct
			{
				$this->_pseudo = $pseudo;
				return TRUE;
			}
		}
		return FALSE;
	}

	public function set_nom($nom) {
		// $erreur = str_replace('set_', '', __FUNCTION__); // nom de la fonction sans le set_

		if ($this->setNomPrenom($nom, self::NOM_MAX_LENGHT) === TRUE)
		{
			$this->_nom = htmlspecialchars($nom);
			return TRUE;
		}

		return FALSE; // on retourne le nom de la fonction si l'insertion a échouée
	}

	public function set_prenom($prenom) {
		// $erreur = str_replace('set_', '', __FUNCTION__); // nom de la fonction sans le set_

		if ($this->setNomPrenom($prenom, self::PRENOM_MAX_LENGHT) === TRUE)
		{
			$this->_prenom = htmlspecialchars($prenom);
			return TRUE;
		}

		return FALSE; // on retourne le nom de la fonction si l'insertion a échouée
	}

	/**
	 * [set_email description]
	 * @param [type] $email [description]
	 */
	public function set_email($email) {

		if(is_string($email) AND strlen($email) <= self::EMAIL_MAX_LENGHT)
		{
			$email = htmlspecialchars($email);
			$email = trim($email);
			$email = strtolower($email); 		// conversion de la chaine en lettres minuscules 

			$pattern = '#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,}$#';

			if (preg_match($pattern, $email))
			{
				$this->_email = $email;
				return TRUE;
			}
		}

		// confirmation d'execution
		return FALSE;
	}

	public function set_password($password) {

		if (!$this->IMustHashThePassword()) // si pas de hashage, c'est que le password est déjà hashé et donc déjà vérifié
		{ 
			$this->_password = $password;
			return TRUE;
		}

		$password_lenght = strlen($password);
		if(is_string($password) 
			AND $password_lenght >= self::PASSWORD_MIN_LENGHT 
			AND $password_lenght <= self::PASSWORD_MAX_LENGHT)
		{
			//reformatage légé
			$password = htmlspecialchars($password);

			$pattern = '#[0-9]{1,}#';

			if(preg_match($pattern, $password))
			{
				
				$this->_password = get_hash($password); 
				return TRUE;
			}
		}

		// confirmation d'execution
		return FALSE;
	}

	public function set_date_create($date) {
		if(isset($date))
		{
			$this->_date_create = $date;
			$date = new DateTime($date);
			$this->_date_create_format = $date->format('d/m/Y à H\hi');
			return TRUE;
		}
		return FALSE;
	}

	public function set_date_birth($date) {
		if ($date == '')
		{
			$this->_date_birth = $date;
			return TRUE;
		}
		if (isset($date) AND $date <> 0)
		{
			$this->_date_birth = $date;
			$date = new DateTime($date);
			$this->_date_birth_format = $date->format('d/m/Y');
			return TRUE;
		}
		return FALSE;
	}

	public function set_type_id($id) {
		$id = (int) $id;
		if(isset($id) AND $id > 0)
		{
			$this->_type_id = $id;
			$this->set_admin($id);
			return TRUE;
		}
		return FALSE;
	}

	public function set_type($type) {
		if(is_string($type))
		{
			$this->_type = $type;
			return TRUE;
		}
		return FALSE;
	}

	public function set_avatar_id($id) {
		$id = (int) $id;
		if(isset($id) AND $id > 0)
		{
			$this->_avatar_id = $id;
			return TRUE;
		}
		return FALSE;
	}

	public function set_avatar($avatar) {
		if(is_string($avatar) AND $avatar <> '')
		{
			$pattern = '#^http{1}s?://{1}#';
			if (preg_match($pattern, $avatar))
			{
				$this->_avatar = $avatar;
				return TRUE;
			}
			return FALSE;
		}
		else
		{
			$this->_avatar = self::AVATAR_PAR_DEFAUT;
			$this->set_avatar_id(1);
		}
		return TRUE;
	}


	public function set_admin($type) {
		if (!is_int($type) OR $type <= 0)
		{
			return FALSE;
		}
		if ($type == 1)
		{
			$this->_admin = TRUE;
			return TRUE;
		}
		else
		{
			$this->_admin = FALSE;
			return TRUE;
		}
	}



	//------------------------------------------------------------
	// Hydratation
	/**
	 * [setFull permet d'hydrater l'objet en appelant les méthodes selon les clés du tableau en argument]
	 * @param array $donnees [tableau contenant des $key associées à des $value]
	 * @return   	TRUE si toutes les données ont été setté correctement, FALSE si aucune donnée n'a été envoyée, string contenant le nom des données non settés
	 */

	public function setFull(array $donnees, bool $hash = TRUE) 
	{

		$checkValues = [];
		foreach ($donnees as $attributName => $attributValue) 
		{
			$method = 'set_' . $attributName;
			if (method_exists($this, $method))
			{
				$checkValues[$attributName] = $this->$method($attributValue);
			}
		}

		if (in_array(FALSE, $checkValues, TRUE))
		{
			// renvoi un string contenant les champs erronés séparés par un "-"
			return implode('-', array_keys($checkValues, FALSE, TRUE));
		}

		return TRUE;
	}



	//------------------------------------------------------------
	// Méthodes
	public function hashPassword($password)
	{
		return get_hash($password);
	}


	// permet de récupréer tous les attributs
	// renvoi un tableau initialisé avec $key et $value
	public function getAttributs()
	{
		$table = array(
			'id'			=>	'',
			'pseudo'		=>	'',
			'nom'			=>	'',
			'prenom'		=>	'',
			'email'			=>	'',
			'password'		=>	'',
			'date_create'	=>	'',
			'date_birth'	=>	'',
			'type'			=>	'',
			'avatar'		=>	'');

		foreach ($table as $key => $value) {
			$method = 'get_' . $key;
			if(method_exists($this, $method))
			{
				$table[$key] = $this->$method();
			}
		}
		return $table; // on renvoi un tableau avec tous les attributs
	}


	// permet de récupréer tous les attributs pour le public
	// renvoi un tableau initialisé avec $key et $value
	public function getPublicAttributs()
	{
		$table = array(
			'pseudo'		=>	'',
			'nom'			=>	'',
			'prenom'		=>	'',
			'email'			=>	'',
			'date_create_format'	=>	'',
			'date_birth_format'	=>	'',
			'type'			=>	'');

		foreach ($table as $key => $value) {
			$method = 'get_' . $key;
			if(method_exists($this, $method))
			{
				if($key == "date_create_format") 		{ $key = "date d'inscription"; }
				elseif($key == 'date_birth_format') 	{ $key = 'date de naissance'; }
				$publicTable[$key] = $this->$method();
			}
		}
		return $publicTable; // on renvoi un tableau avec tous les attributs
	}


	// contrôle du champ nom ou prenom
	protected function setNomPrenom($name, $limitMax = 0)
	{
		if (is_string($name))
		{
			if ($limitMax > 0 AND strlen($name) > $limitMax)
			{
				return FALSE;
			}
			$pattern = "#^[\p{L}\s-']*$#u"; // liste des caractères autorisés (lettres, espaces, tirets et apostrophes) ou rien *
			if (preg_match($pattern, $name))
			{ 
				return TRUE;
			}
		}
		return FALSE;
	}

	// contrôle de l'inscription
	public function checkInscription(array $donnees)
	{
		// Au minimum un membre doit avoir :
		// 1 pseudo
		// 1 email
		// 1 password
		// 1 type de compte (défini par défaut lors de la construction)
		// 1 avatar (défini par défaut lors de la construction)
		
		$checkValues = [
			'pseudo'	=> $this->set_pseudo($donnees['pseudo']),
			'email'		=> $this->set_email($donnees['email']),
			'password'	=> $this->set_password($donnees['password']),
		];

		if (in_array(FALSE, $checkValues, TRUE))
		{
			// renvoi un string contenant les champs erronés séparés par un "-"
			return implode('-', array_keys($checkValues, FALSE, TRUE));
		}

		return $this;
	}

	// contrôle de l'inscription
	public function checkModification(array $donnees)
	{
		foreach ($donnees as $fieldName => $fieldValue) {
			$method = 'set_' . $fieldName;
			$checkValues[$fieldName] = $this->$method($donnees[$fieldName]);
		}

		if (in_array(FALSE, $checkValues, TRUE))
		{
			// renvoi un string contenant les champs erronés séparés par un "-"
			return implode('-', array_keys($checkValues, FALSE, TRUE));
		}

		return $this;
	}




} // end of class Membre