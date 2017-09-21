<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : Class
 * FILE/ROLE : FlashValues
 *
 * File Last Update : 2017 09 20
 *
 * File Description :
 * -> gère les variables d'affichage de messages flash
 * -> permet de sauvegarder/supprimer un flash dans la session
 */

class FlashValues {

	//============================================================
	// Attributs
	protected $_flash;

	const SESSION_KEY = 'flashValues';

	//============================================================
	// Constructeur et méthodes magiques
	public function __construct(array $flash = null)
	{
		$this->setValues($flash);
	}


	//============================================================
	// Getteurs

	public function getValues($valuesKey = null)
	{
		if (is_null($valuesKey) OR !array_key_exists($valuesKey, $this->_flash))
		{
			return $this->_flash;
		}

		return $this->_flash[$valuesKey];
	}

	//============================================================
	// Setteurs
	
	public function setValues(array $flash = null)
	{
		if (is_null($flash))
		{
			$flash = $_SESSION[self::SESSION_KEY];
		}

		$this->_flash = $flash;		
	}


	//============================================================
	// Methodes

	/**
	 * [saveInSession description]
	 * @return [type] [description]
	 */
	public function saveInSession()
	{
		$_SESSION[self::SESSION_KEY] = $flash;
	}

	/**
	 * [removeFromSession description]
	 * @return [type] [description]
	 */
	public function removeFromSession()
	{
		unset($_SESSION[self::SESSION_KEY]);
	}


} // end of class FlashValues