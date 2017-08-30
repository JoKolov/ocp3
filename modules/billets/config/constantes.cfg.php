<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : constantes / erreurs
 *
 * File Last Update : 2017 08 29
 *
 * File Description :
 * -> liste des erreurs générées dans les modèles
 */

//------------------------------------------------------------
// Gestion des fichiers MVC
define ('MODULE_BILLETS', 'billets');	// nom du module



//------------------------------------------------------------
// Champs des formulaires
define ('BILLETS_FORM', array(
	'titre'				=>	TRUE,
	'contenu'			=>	TRUE,
	'extrait'			=> 	FALSE,
	'id'				=>	FALSE
	//----------
	)
);



//------------------------------------------------------------
// Constantes de la page Nouveau (billet)
define ('BILLETS_EDITION', array(
	'_GETerror.error'			=> 	"Echec enregistrement !",
	'_GETerror.titre'			=>	"Donnez un titre au billet",
	'_GETerror.contenu'			=>	"Le billet doit contenir du texte",
	'_GETerror.extrait'			=>	"L'extrait est incorrect",
	'_GETsuccess.1'				=>	"Modifications enregistrées :)",
	'label.titre'				=>	"Titre *",
	'label.contenu'				=>	"Billet *",
	'label.extrait'				=>	"Extrait",
	'placeholder.titre'			=>	"titre du billet",
	'placeholder.contenu'		=>	"",
	'placeholder.extrait'		=>	"court extrait du billet ou court résumé attractif"
	)
);