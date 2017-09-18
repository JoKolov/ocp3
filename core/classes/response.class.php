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

Class Response {

	//============================================================
	// Attributs
	
	protected $_request;

	protected $_errorsTable;		// Tableau des erreurs	[$key = nom erreur, $value = texte erreur]
	protected $_viewFilename;
	protected $_viewConstant;
	protected $_viewFlash;
	protected $_redirectUrl;
	protected $_responseAction;

	//============================================================
	// Constructeur et méthodes magiques

	public function __construct(Request $request, $responseAction)
	{
		$this->_request = $request;
		$this->_responseAction = $request->getActionName();

	}

	//============================================================
	// Getteurs
	protected function getRequest()
	{
		return $this->_request;
	}

	protected function getAction()
	{
		return $this->_responseAction;
	}


	//============================================================
	// Setteurs
	public function setConstantValues(array $viewValues)
	{

	}


	//============================================================
	// Methodes

	public function runResponse($responseAction = null)
	{
		if (!is_null ($responseAction))
		{
			$this->_responseAction = $responseAction;
		}

		if ($this->getAction() == 'submit')
		{
			return $this->redirect();
		}

		return $this->displayView();
	}

	/**
	 * displayView affiche le code HTML de la page demandée
	 */
	public function displayView($viewFilename, $viewConstant = null)
	{
		$var['error'] = errorFormatHTML($view['errors']);
		$var['value'] = $view['values'];

		// $error = tableau des erreurs de la page => $flash['error']
		// $value = tableau des donnees de la page => $constant
		foreach ($this->getViewConstant() as $varViewName => $tableViewValues)
		{
			${$varViewName} = $tableViewValues;
		}

		// si on a des données en flash display, on les ajoute et/ou on remplace les données en constant display
		foreach ($this->getViewFlash() as $varViewName => $tableViewValues)
		{
			${$varViewName} = $tableViewValues;
		}

		// traitement spécifiques des variables d'erreur $error
		if (isset($error))
		{
			$blocError = $this->setBlocError($error);
		}

		// début du code HTML
		// affichage header
		require_once (SITE_ROOT . 'themes/default/header.php');

		// affichage nav
		require_once (SITE_ROOT . 'themes/default/nav.php');

		// affichage view
		if ($viewFilename <> '') { require_once ($viewFilename); }

		// affichage footer
		require_once (SITE_ROOT . 'themes/default/footer.php');
	}


	/**
	 * redirect effectue une redirection
	 */
	public function redirect($url = null, $viewFlash = null)
	{
		$this->getRequest()->setSessionVar(['flash' => $flash)]);

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
		$panelTitleOpen 	= 	'<div class="panel-heading"><h3 class="panel-title">';
		$panelTitleClose 	= 	'</h3></div>';
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

			if ($errorName <> 'error' AND $panelBody)
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
			if ($errorText <> '')
			{
				$error[$errorKey] = $openBal . $errorText . $closeBal;
			}
		}
		return $error;
	}

	return '';
}



//------------------------------------------------------------
//fonction de formatage de l'URL de redirection
public function url_format(string $module, string $action = '', string $page ='', array $param = [])
{
	$url = '?module=' . $module;

	if($action <> '') 	{ $url .= '&action=' . $action; }
	if($page <> '') 	{ $url .= '&page=' . $page; }

	if(isset($param))
	{
		foreach ($param as $key => $value) {
			$url .= '&' . $key . '=' . $value;
		}
	}

	return $url;
}



//------------------------------------------------------------
// formatage dans les balises alert boostrap
public function error_format_form($text)
{
	return '<div class="alert alert-danger" role="alert"><strong>' . $text . '</strong></div>';
}


} // end of class Response