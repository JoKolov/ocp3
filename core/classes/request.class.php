<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : Class
 * FILE/ROLE : Request
 *
 * File Last Update : 2017 09 26
 *
 * File Description :
 * -> gestion des appels des éléments du MVC
 * -> Controleur
 * -> Modèle
 * -> Vue
 */

class Request {
	//------------------------------------------------------------
	//------------------------------------------------------------
	// Attributs

	protected $_session;						// $_SESSION sécurisé
	protected $_get;							// $_GET sécurisé
	protected $_post;							// $_POST sécurisé
	protected $_files;							// $_FILES sécurisé
	protected $_cookie;
	protected $_server;



	// attributs static
	// --NIL--
	

	// constantes
	const DIR_MODULES 			= SITE_ROOT . 'modules/';
	const DIR_CONTROLLERS 		= 'controllers/';				// dossier des controlleurs d'un module
	const DIR_VIEWS 			= 'views/';						// dossier des vues d'un module
	const DIR_CONFIG			= 'config/';					// dossier des constantes d'un module
	const FILE_EXT_CONTROLLER 	= '.controller.php';
	const FILE_EXT_VIEW 		= '.view.php';
	const FILE_EXT_CONFIG 		= '.cfg.php';
	const GET_MODULE 			= 'module';
	const GET_CONTROLLER 		= 'page';
	const GET_VIEW 				= 'page';
	const GET_ACTION 			= 'action';
	const GET_ERROR 			= 'error';
	const VIEW_404 				= SITE_ROOT . 'modules/erreurs/views/404.view.php';




	//------------------------------------------------------------
	//------------------------------------------------------------
	// Constructeur et méthodes magiques
	
	public function __construct($session, $get, $post = null, $files = null, $cookie = null, $server = null) {
		
		// Enregistrement des variables globales
		$this->setSession($session);
		$this->setGet($get);
		$this->setPost($post);
		$this->setFiles($files);
		$this->setCookie($cookie);
		$this->setServer($server);

	}




	//------------------------------------------------------------
	//------------------------------------------------------------
	// Hydratation

	// --- NIL ---




	//------------------------------------------------------------
	//------------------------------------------------------------
	// Getteurs
	
	public function session()			{ return $this->_session; }
	public function get()				{ return $this->_get; }
	public function post()				{ return $this->_post; }
	public function files()				{ return $this->_files; }
	public function cookie()			{ return $this->_cookie; }
	public function server()			{ return $this->_server; }

	/**
	 * Liste des autres getteurs incluant un script :
	 * 
	 * getModuleList()			-	@return array 	: liste des modules valides
	 * getModule()				-	@return string 	: nom du module courant
	 * getModuleDir()			-	@return string 	: chemin du dossier du module courant
	 * 
	 * getControllerList()		- 	@return array 	: liste des controleurs valides
	 * getControllerName() 		- 	@return string 	: nom du controleur courant
	 * getControllerFilename() 	- 	@return string 	: chemin du fichier du controleur courant
	 * 
	 * getViewList() 			- 	@return array 	: liste des vues valides
	 * getViewName() 			- 	@return string 	: nom de la vue courante
	 * getViewFilename() 		- 	@return string 	: chemin du fihier de la vue courante
	 * 
	 */

	/**
	 * ====================
	 * 
	 * getModuleList()
	 * 
	 * @return  array : tableau contenant la liste des noms de module valides
	 */
	protected function getModuleList() {

		if (!file_exists(self::DIR_MODULES))
		{
			throw new Exception("Error Processing Request : no module found", 1);
		}

		$moduleList = scandir(self::DIR_MODULES);
		// on récupère tous les éléments de la liste qui ne contiennent pas de point
		$moduleList = preg_grep ("#\.#", $moduleList, PREG_GREP_INVERT); 

		return $moduleList;
	}


	// ====================
	/**
	 * Récupérer le nom du module actif
	 * 
	 * @return string : nom du module actif
	 * 
	 */
	protected function getModuleName()
	{
		if (!isset($this->_get[self::GET_MODULE]))
		{
			return 'defaut';
		}

		if (!in_array($this->_get[self::GET_MODULE], $this->getModuleList()))
		{
			return 'defaut';
		}

		return $this->_get[self::GET_MODULE];
	}


	// ====================
	/**
	 * Récupérer le chemin du dossier du module actif
	 * 
	 * @return string : chemin du dossier du module actif
	 * 
	 */	
	protected function getModuleDir()
	{
		return self::DIR_MODULES . $this->getModuleName() . '/';
	}


	// ====================
	/**
	 * @return array : tableau contenant la liste des controleurs valides
	 */
	protected function getControllerList()
	{
		if (!isset($this->get()[self::GET_CONTROLLER]))
		{
			return array('');
		}

		$controllerList = scandir($this->getModuleDir() . self::DIR_CONTROLLERS);
		$controllerList = str_replace (self::FILE_EXT_CONTROLLER, '', $controllerList);
		$controllerList = preg_grep ("#\.#", $controllerList, PREG_GREP_INVERT);
		
		return $controllerList;
	}
	


	// ====================
	/**
	 * Setteur des données du controleur
	 * @param string $controller nom du controlleur
	 */
	protected function getControllerName()
	{
		// aucun controleur appelé
		if (!isset($this->get()[self::GET_CONTROLLER]) OR $this->get()[self::GET_CONTROLLER] == '')
		{
			return 'home';
		}

		// le controleur n'existe pas
		if (!in_array($this->get()[self::GET_CONTROLLER], $this->getControllerList()))
		{
			return '404';
		}

		// le controleur existe
		return $this->get()[self::GET_CONTROLLER];
	}


	// ====================
	/**
	 * Récupérer le chemin du fichier du controleur
	 * 
	 * @return string : chemin du fichier du controleur actif
	 * 
	 */	
	protected function getControllerFilename()
	{
		$controllerName = $this->getControllerName();
		
		// le controleur n'existe pas		
		if (is_null($controllerName))
		{
			return;
		}

		// le controleur existe
		return $this->getModuleDir() . self::DIR_CONTROLLERS . $controllerName . self::FILE_EXT_CONTROLLER;
	}


	// ====================
	/**
	 * @return array : tableau contenant la liste des vues valides
	 */
	protected function getViewList()
	{
		if (!isset($this->Get()[self::GET_VIEW]))
		{
			return array('');
		}

		$viewList = scandir($this->getModuleDir() . self::DIR_VIEWS);
		$viewList = str_replace (self::FILE_EXT_VIEW, '', $viewList);
		$viewList = preg_grep ("#\.#", $viewList, PREG_GREP_INVERT);

		return $viewList;
	}
	


	// ====================
	/**
	 * @return string : nom de la vue demandée
	 */
	public function getViewName()
	{
		// aucune vue appelée
		if (!isset($this->Get()[self::GET_VIEW]) OR $this->Get()[self::GET_VIEW] == '')
		{
			return 'home';
		}

		// la vue n'existe pas
		if (!in_array($this->Get()[self::GET_VIEW], $this->getViewList()))
		{
			return '404';
		}

		// la vue existe
		return $this->Get()[self::GET_VIEW];
	}


	// ====================
	/**
	 * Récupérer le chemin du fichier de la vue
	 * 
	 * @return string : chemin du fichier de la vue active
	 * 
	 */	
	public function getViewFilename()
	{
		return $this->getModuleDir() . self::DIR_VIEWS . $this->getViewName() . self::FILE_EXT_VIEW;
	}


	// ====================
	/**
	 * getActionName récupère le type d'action demandée pour la réponse
	 * 
	 * @return string : nom de l'action
	 * 
	 */	
	public function getActionName()
	{
		$actionsValides = ['submit'];

		// Aucune action n'est appelée => on affiche la vue sans action spécifique
		if (!isset($this->get()[self::GET_ACTION]) OR !in_array($this->get()[self::GET_ACTION], $actionsValides))
			{
				return 'view';
			}

		// L'action n'existe pas
		return $this->get()[self::GET_ACTION];
	}


	// ====================
	/**
	 * getMembre récupère l'instance membre de l'ustilisateur connecté
	 * 
	 * @return Membre instance membre
	 * 
	 */	
	public function getMembre()
	{
		return $this->session()['membre'];
	}


	// ====================
	/**
	 * getLastUrl récupère la dernière URL connue si elle existe
	 * 
	 * @return string : nom de l'action
	 * 
	 */	
	public function getLastUrl()
	{
		$flash = new FlashValues;
		return $flash->getValues('previousUrl');
	}





	//------------------------------------------------------------
	//------------------------------------------------------------
	// Setteurs

	/**
	 * Liste des setteurs incluant un script :
	 * 
	 * setSession 		: $_session
	 * setGet 			: $_get
	 * setPost 			: $_post
	 * setFiles 		: $_files
	 * setCookie		: $_cookie
	 * setServer 		: $_server
	 * 
	 */

	// ====================
	/**
	 * setSession() récupère et traite la variable $_SESSION 
	 * @param array|null $session : $_SESSION
	 */
	public function setSession(array $session = null)
	{
		if (!is_null($session))
		{
			$this->_session = $session;
		}
	}


	// ====================
	/**
	 * setGet() récupère et traite la variable $_GET
	 * @param array|null $get : $_GET
	 */
	public function setGet(array $get = null)
	{
		if (!is_null($get))
		{
			// retrait de symboles à risque : . / < >
			$get = str_replace(array('.','/','<','>'), '', $get);

			$this->_get = $get;
		}
	}


	// ====================
	/**
	 * setPost() récupère et traite la variable $_POST 
	 * @param array|null $post : $_POST
	 */
	public function setPost(array $post = null)
	{
		if (!is_null($post))
		{
			$this->_post = $post;
		}
	}


	// ====================
	/**
	 * setFiles() récupère et traite la variable $_FILES 
	 * @param array|null $post : $_FILES
	 */
	public function setFiles(array $files = null)
	{
		if (!is_null($files))
		{
			$this->_files = $files;
		}
	}


	// ====================
	/**
	 * setCookie() récupère et traite la variable $_COOKIE
	 * @param array|null $post : $_COOKIE
	 */
	public function setCookie(array $cookie = null)
	{
		if (!is_null($cookie))
		{
			$this->_cookie = $cookie;
		}
	}


	// ====================
	/**
	 * setServer() récupère et traite la variable $_SERVER 
	 * @param array|null $post : $_SERVER
	 */
	public function setServer(array $server = null)
	{
		if (!is_null($server))
		{
			$this->_server = $server;
		}
	}




	//------------------------------------------------------------
	//------------------------------------------------------------
	// Méthodes

	/**
	 * Liste des Méthodes :
	 * 
	 * runController 		: @return mixed : url ou chemin d'un fichier de vue
	 * displayView 			: affiche le code HTML de la page demandée ou effectue une redirection
	 * reqModuleconfig		: récupère les fichiers de configuration du module actif
	 *
	 * getPost				: @return array : les éléments POST demandés
	 * 
	 */


	/**
	 * runController lance le controleur requis
	 * @return mixed : url ou chemin d'un fichier de vue
	 */
	public function runController()
	{

		$module = $this->getModuleName();
		$controllerName = $this->getControllerName();

		// Page d'accueil ou erreur 404
		if (in_array($controllerName, ['404']))
		{
			$action = ['displayView' => APP['theme-dir'] . $controllerName . '.php'];
			$objects = ['membre' => $this->getMembre()];
			return new Response($action, $objects);
		}


		// tous les autres cas
		require_once ($this->getControllerFilename());
		$objectName = ucfirst($controllerName . 'Controller');
		$controller = new $objectName;

		$actionMethod = 'action' . ucfirst($this->getActionName());

		// Aucune méthode n'existe => Erreur
		if (!method_exists($controller, $actionMethod))
		{
			throw new Exception("Request :: 493 >> L'action [{$actionMethod}] n'existe pas dans le controleur [{$controllerName}]", 1);
		}

		$response = $controller->$actionMethod($this);

		return $response;
	}


	/**
	 * getPost() récupère les données POST demandées
	 * @param  string|array|null $postReq clés des données POST souhaitées
	 * @return array 	: données POST réclamées
	 */
	public function getPost($postReq = null)
	{
		if (is_null($postReq))
		{
			return $this->post();
		}

		if (!is_array($postReq))
		{
			$postReq = array($postReq);
		}

		foreach ($postReq as $postKey)
		{
			if (array_key_exists($postKey, $this->post()))
			{
				$post[$postKey] = $this->post()[$postKey];
			}
			else
			{
				$post[$postKey] = null;
			}
		}

		return $post;
	}


	/**
	 * getFiles() récupère les données FILES demandées
	 * @param  string|array|null $filesReq clés des données FILES souhaitées
	 * @return array 	: données FILES réclamées
	 */
	public function getFiles($filesReq = null)
	{
		if (is_null($filesReq))
		{
			return $this->files();
		}

		if (!is_array($filesReq))
		{
			$filesReq = array($filesReq);
		}

		foreach ($filesReq as $filesKey)
		{
			if (array_key_exists($filesKey, $this->files()))
			{
				$files[$filesKey] = $this->files()[$filesKey];
			}
			else
			{
				$files[$filesKey] = null;
			}
		}

		return $files;
	}


	/**
	 * getTable() récupère les données de la table demandées
	 * @param  string $table : nom de la table demandée (ex : post)
	 * @param  string|array|null $tableReq clés des données TABLE souhaitées
	 * @return array 	: tableau des données TABLE réclamées
	 */
	public function getGlobalVar(string $tableName, $specificElement = null)
	{
		if (!in_array($tableName, ['session', 'get', 'post', 'files', 'cookie', 'server']))
		{
			throw new Exception("{$tableName} n'existe pas dans Request", 1);
		}

		if (is_null($specificElement))
		{
			return $this->$tableName();
		}

		if (!is_array($specificElement))
		{
			$specificElement = array($specificElement);
		}

		foreach ($specificElement as $tableKey)
		{
			if (array_key_exists($tableKey, $this->$tableName()))
			{
				$table[$tableKey] = $this->$tableName()[$tableKey];
			}
			else
			{
				$table[$tableKey] = null;
			}
		}

		return $table;
	}


	/**
	 * setSessionVar créer de nouvelles variables dans la SESSION
	 * @param array $var [description]
	 * @return  array : $_SESSION à jour
	 */
	public function setSessionVar(array $var)
	{
		foreach ($var as $key => $value)
		{
			$this->_session[$key] = $value;
		}

		$_SESSION = $this->session();
		return $this->session();
	}


	/**
	 * cleanSessionVar supprime des variables dans la SESSION
	 * @param array $var [description]
	 * @return  array : $_SESSION à jour
	 */
	public function cleanSessionVar($var = null)
	{

		if (is_null($var))
		{
			$this->_session = array();
		}
		elseif (is_string($var))
		{
			unset($this->_session[$var]);

		}

		elseif (is_array($var))
		{
			foreach ($var as $sessionKey)
			{
				unset($this->_session[$sessionKey]);
			}
		}

		$_SESSION = $this->session();
		return $this->session();
	}
	
} // End of class Request
?>