<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : Class
 * FILE/ROLE : ErrorsInView
 *
 * File Last Update : 2017 09 14
 *
 * File Description :
 * -> gère l'affichage des erreurs dans les vues
 */

Class ErrorsInView {

	//============================================================
	// Attributs
	protected $_errorsTable;		// Tableau des erreurs	[$key = nom erreur, $value = texte erreur]


	//============================================================
	// Constructeur et méthodes magiques
	public function __construct(array $errorsTable = null)
	{
		if (!is_null($errorsTable))
		{
			$this->_errorsTable = $errorsTable;
		}

		return $this;
	}
	

	//============================================================
	// Getteurs
	// -- NIL --


	//============================================================
	// Setteurs
	// -- NIL --


	//============================================================
	// Methodes

//------------------------------------------------------------
// Création du tableau des variables pour une vue spécifique
function getErrorsTable(array $errorsToPublish = array())
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
function errorFormatHTML($error)
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


} // end of class ErrorsInView