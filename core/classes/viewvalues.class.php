<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : Class
 * FILE/ROLE : ViewValues
 *
 * File Last Update : 2017 09 20
 *
 * File Description :
 * -> gère les données à afficher dans une vue
 * -> permet de récupérer une donnée spécifique
 */

class ViewValues {

	//============================================================
	// Attributs
	protected $_values;			// [key = nom du groupe de valeurs => value = [key = nomVariable => value = texte]]


	//============================================================
	// Constructeur et méthodes magiques
	public function __construct(array $values = [])
	{
		$this->_values = $values;
	}


	//============================================================
	// Getteurs

	public function getValues($valuesKey = null)
	{
		if (is_null($valuesKey))
		{
			return $this->_values;
		}

		if (!array_key_exists($valuesKey, $this->_values))
		{
			throw new Exception("ViewValues :: 49 >> La clé '$valuesKey' n'existe pas", 1);
		}

		return $this->_values[$valuesKey];
	}


	//============================================================
	// Setteurs

	public function setValues(array $values, string $nameOfValues = null)
	{
		if (is_null($nameOfValues))
		{
			$this->_values = $values;
		}
		else
		{
			$this->_values[$nameOfValues] = $values;
		}
	}


	//============================================================
	// Methodes
	// -- NIL --


} // end of class ViewValues