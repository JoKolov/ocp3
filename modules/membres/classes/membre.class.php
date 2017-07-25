<?php
/**
 * 
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
	protected $_date_birth;
	protected $_type;
	protected $_avatar;

	const PSEUDO_MIN_LENGHT 	= 4;
	const PSEUDO_MAX_LENGHT 	= 100;
	const NOM_MAX_LENGHT 		= 100;
	const PRENOM_MAX_LENGHT 	= 100;
	const EMAIL_MAX_LENGHT 		= 255;
	const PASSWORD_MIN_LENGHT	= 8; 
	const PASSWORD_MAX_LENGHT 	= 255;
	const AVATAR_PAR_DEFAUT 	= '';



	//------------------------------------------------------------
	// Constructeur
	public function __construct(array $donnees = []) {
		// on hydrate l'objet avec les données envoyées
		$this->setFull($donnees);
	}



	//------------------------------------------------------------
	// Getteurs
	
	public function get_id() 			{ return $this->_id; }
	public function get_pseudo() 		{ return $this->_pseudo; }
	public function get_nom() 			{ return $this->_nom; }
	public function get_prenom() 		{ return $this->_prenom; }
	public function get_email() 		{ return $this->_email; }
	public function get_password()		{ return $this->_password; }
	public function get_date_create() 	{ return $this->_date_create; }
	public function get_date_birth() 	{ return $this->_date_birth; }
	public function get_type() 			{ return $this->_type; }
	public function get_avatar() 		{ return $this->_avatar; }



	//------------------------------------------------------------
	// Setteurs
	
	public function set_id($id) {
		$id = (int) $id;
		if(isset($id) AND $id > 0)
		{
			$this->_id = $id;
		}
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
				return true;
			}
			else { return false; }
		}
		else
		{
			return false;
		}
	}

	public function set_nom($nom) {
		if(is_string($pseudo) AND strlen($pseudo) <= self::NOM_MAX_LENGHT)
		{
			$this->_nom = $nom;
		}
	}

	public function set_prenom($pseudo) {
		if(is_string($prenom) AND strlen($prenom) <= self::PRENOM_MAX_LENGHT)
		{
			$this->_prenom = $prenom;
		}
	}

	/**
	 * [set_email description]
	 * @param [type] $email [description]
	 */
	public function set_email($email) {

		// return initialisé sur position invalide = false
		$validation = false;

		if(is_string($email) AND strlen($email) <= self::EMAIL_MAX_LENGHT)
		{
			$email = htmlspecialchars($email);
			$email = trim($email);
			$email = strtolower($email); 		// conversion de la chaine en lettres minuscules 

			$pattern = '#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,}$#';

			if (preg_match($pattern, $email))
			{
				$this->_email = $email;
				$validation = true;
			}
		}

		// confirmation d'execution
		return $validation;
	}

	public function set_password($password) {

		// init validation = ERREUR = false
		$validation = false;

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
				$this->_password = $password;
				$validation = true;
			}
		}

		// confirmation d'execution
		return $validation;
	}

	public function set_date_create($date) {
		if(isset($date))
		{
			$this->_date_create = $date;
		}
	}

	public function set_date_birth($date) {
		if(isset($date))
		{
			$this->_date_birth = $date;
		}
	}

	public function set_type($type) {
		if(is_string($type))
		{
			$this->_type = $type;
		}
	}

	public function set_avatar($avatar) {
		if(is_string($avatar) AND file_exists($avatar))
		{
			$this->_avatar = $avatar;
		}
		else
		{
			$this->_avatar = self::AVATAR_PAR_DEFAUT;
		}
	}



	//------------------------------------------------------------
	// Hydratation
	/**
	 * [setFull permet d'hydrater l'objet en appelant les méthodes selon les clés du tableau en argument]
	 * @param array $donnees [tableau contenant des $key associées à des $value]
	 */
	public function setFull(array $donnees) {
		if (isset($donnees))
		{
			foreach ($donnees as $key => $value) {
				$method = 'set_' . $key;
				if (method_exists($this, $method))
				{
					$this->$method($value);
				}
			}
		}
	}


	//------------------------------------------------------------
	// Méthodes
	public function hashPassword($password)
	{
		return hash('sha256', 'b!:' . $password . '/?e9');
	}


	//------------------------------------------------------------
	// Méthodes magiques
	

}