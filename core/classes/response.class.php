<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : Class
 * FILE/ROLE : Response
 *
 * File Last Update : 2017 09 17
 *
 * File Description :
 * -> gère la réponse du controller
 * -> permet d'afficher la vue
 */

class Response {

	//============================================================
	// Attributs
	
	protected $_action;
	protected $_url;
	protected $_viewFile;
	protected $_objects;


	const ACTION_REDIRECT = 'redirect';
	const ACTION_DISPLAYVIEW = 'displayView';

	//============================================================
	// Constructeur et méthodes magiques

	public function __construct(array $action = null, array $objects = [])
	{
		$this->setAction($action);
		$this->_objects = $objects;
	}

	//============================================================
	// Getteurs

	protected function getAction() 			{ return $this->_action; 	}
	protected function getObjects()			{ return $this->_objects; 	}
	protected function getUrl()				{ return $this->_url; 		}
	protected function getViewFile()		{ return $this->_viewFile; 	}

	protected function getObject($objectName)
	{
		if (is_null($objectName) OR !array_key_exists($objectName, $this->getObjects()))
		{
			return;
		}

		return $this->getObjects()[$objectName];
	}


	//============================================================
	// Setteurs
	
	/**
	 * setAction enregistre le nom de l'action à accomplir en réponse de la requête
	 * @param array $action nom de l'action attendu en réponse
	 */
	public function setAction(array $action)
	{
		$validActions = ['displayView', 'redirect'];

		$actionName = key($action);
		$urlOrFile = $action[$actionName];

		if (!in_array($actionName, $validActions))
		{
			throw new Exception("Response :: setAction >> l'action [$action] n'est pas connue", 1);
		}

		$this->_action = $actionName;

		switch ($actionName) {
			case 'redirect':
				$this->setUrl($urlOrFile);
				break;

			case 'displayView':
				$this->setViewFile($urlOrFile);
				break;
		}
	}

	protected function setUrl($url)
	{
		$patternUrl = "#^" . APP['url-website'] . "#";

		if (!preg_match($patternUrl, $url))
		{
			throw new Exception("Response :: setUrl >> [$url] n'est pas une url valide! : <br /> {$url}", 1);
		}

		$this->_url = $url;
	}

	protected function setViewFile($filename)
	{
		$patternFile = "#^" . SITE_ROOT . ".+\.php$#";

		if (!preg_match($patternFile, $filename) OR !file_exists($filename))
		{
			throw new Exception("Response :: setViewFilename >> $filename n'est pas un fichier valide ! : <br /> {$filename}", 1);
		}

		$this->_viewFile = $filename;
	}



	//============================================================
	// Methodes


	/**
	 * runResponse sélectionne la méthode à utiliser pour lancer la réponse
	 * @param  string $action nom de l'action de la réponse
	 * @return [type]         [description]
	 */
	public function runResponseAction(string $action = null)
	{
		if (!is_null ($action))
		{
			$this->setAction($action);
		}

		if ($this->getAction() == 'redirect')
		{
			return $this->redirect();
		}

		return $this->displayView();
	}

	/**
	 * displayView affiche le code HTML de la page demandée
	 */
	protected function displayView($viewFilename = null)
	{

		if (is_null($viewFilename))
		{
			$viewFilename = $this->getViewFile();
		}

		// récupération des objets nécesaires pour la vue
		foreach ($this->getObjects() as $objetName => $objet)
		{
			${$objetName} = $objet;
		}

		$flash = new FlashValues;

		if (!is_null($flash->getValues()))
		{
			foreach ($flash->getValues() as $valueName => $values)
			{
				${$valueName} = $values;
			}
			// Effacement des éventuels données Flash
			$flash->removeFromSession();
		}

		// enregistrement de l'url active
		$previousUrl = APP['url-website'] . $_SERVER['REQUEST_URI'];
		$flash = new FlashValues(['previousUrl' => $previousUrl]);
		$flash->saveInSession();

		// traitement spécifiques des variables d'erreur $error
		if (isset($errors) AND is_array($errors))
		{
			$blocError = $this->setBlocError($errors);
			$errors = $this->errorFormatHTML($errors);
		}

		// début du code HTML
		// affichage header
		require_once (SITE_ROOT . 'themes/default/header.php');

		// affichage nav
		require_once (SITE_ROOT . 'themes/default/nav.php');

		// affichage de la page demandée
		if (isset($membre) AND $membre->is_admin())
		{
			require_once (SITE_ROOT . 'modules/admin/views/nav.view.php');
		}
		require_once ($viewFilename);

		// affichage footer
		require_once (SITE_ROOT . 'themes/default/footer.php');
	}


	/**
	 * redirect effectue une redirection
	 */
	protected function redirect($url = null)
	{
		if (is_null($url))
		{
			$url = $this->getUrl();
		}

		// enregistrement du flash s'il existe
		if (array_key_exists('flash', $this->getObjects()))
		{
			$flash = $this->getObject('flash');
			$flash->saveInSession();
		}

		// redirection
		header('Location: ' . $url); die;
	}

	/**
	 * 
	 */
	public function setBlocError(array $errors)
	{
		// aucune erreurs dans le tableau (toutes les valeurs = '')
		if ($errors['error'] == '')
		{
			return '';
		}

		$panelDangerOpen 	= '<div class="panel panel-danger">';
		$panelTitleOpen 	= 	'<div class="panel-heading"><h3 class="panel-title"><strong>';
		$panelTitleClose 	= 	'</strong></h3></div>';
		$panelBodyOpen 		= 	'<div class="panel-body">';
		$panelBodyClose 	= 	'</div>';	
		$panelDangerClose 	= '</div>';

		$blocError = $panelDangerOpen . $panelTitleOpen . $errors['error'] . $panelTitleClose;
		
		$panelBody = FALSE;
		foreach ($errors as $errorName => $errorValue)
		{
			if ($errorName <> 'error' AND !$panelBody)
			{
				$blocError .= $panelBodyOpen . '<p>' . $errorValue . '</p>';
				$panelBody = TRUE;
			}

			elseif ($errorName <> 'error' AND $panelBody)
			{
				$blocError .= '<p>' . $errorValue . '</p>';
			}
		}

		if ($panelBody)
		{
			$blocError .= $panelBodyClose;
		}

		$blocError .= $panelDangerClose;

		return $blocError;
	}




	//------------------------------------------------------------
	//fonction de formatage de l'URL de redirection
	public static function urlFormat(string $module, string $page ='', string $action = '', array $param = [])
	{
		$url = '?module=' . $module;

		if($page <> '') 	{ $url .= '&page=' . $page; }
		if($action <> '') 	{ $url .= '&action=' . $action; }

		if(isset($param))
		{
			foreach ($param as $key => $value) {
				$url .= '&' . $key . '=' . $value;
			}
		}

		return APP['url-website'] . $url;
	}



	//------------------------------------------------------------
	// formatage dans les balises alert boostrap
	public function errorFormatHTML($error)
	{
		$openBal = '<div class="alert alert-danger" role="alert"><strong>';
		$closeBal = '</strong></div>';

		if (is_string($error))
		{
			return $openBal . $error . $closeBal;
		}

		if (is_array($error))
		{
			foreach ($error as $errorKey => $errorText)
			{
				if ($errorText != '')
				{
					$error[$errorKey] = $openBal . $errorText . $closeBal;
				}
			}
			return $error;
		}

		return '';
	}



//------------------------------------------------------------
// Création du tableau des variables pour une vue spécifique
public function setViewErrorValues(array $errors, array $errorsToPublish = array())
{
	if (empty($errorsToPublish) AND array_key_exists('error', $errors))
	{
		$errors['error'] = '';
	}
	foreach ($errors as $errorKey => $errorMsg)
	{
		if ($errorKey <> 'error' AND !in_array($errorKey, $errorsToPublish))
		{
			$errors[$errorKey] = '';
		}
	}	
	return $errors;
}


} // end of class Response