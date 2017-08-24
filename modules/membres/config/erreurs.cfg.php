<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : constantes / erreurs
 *
 * File Last Update : 2017 08 18
 *
 * File Description :
 * -> liste des erreurs générées dans les modèles
 */

/**
 * INSCRIPTION
 * form : pseudo
 * form : email
 * form : password
 * code : erreur insertion sql (pseudo ou email déjà existant)
 * 
 * CONNEXION
 * form : pseudo
 * form : password
 * code : 
 *
 * MODIFICATION
 * form : pseudo * (obligatoire + erreur)
 * form : email * (obligatoire + erreur)
 * form : avatar (multiples raisons)
 * form : nom
 * form : prenom
 * form : date_birth
 * form : password ** (obligatoire si password-conf renseigné + erreur + password/password-conf différents)
 * form : password-conf ** (obligatoire si password renseigné + erreur)
 * code : réussite de la modification
 * code : erreur dans la formulaire
 * 
 */

define ('COMVIEW', array(
	'error-pseudo'		=> "L'identification a échoué : il manquait le pseudo...",
	'error-password'	=> "L'identification a échoué : il manquait le mot de passe...",
	'error-notfound'	=> "L'identification a échoué : login et/ou mot de passe incorrectes."
	));

