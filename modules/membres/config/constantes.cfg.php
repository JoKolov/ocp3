<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : constantes / erreurs
 *
 * File Last Update : 2017 08 24
 *
 * File Description :
 * -> liste des erreurs générées dans les modèles
 */

//------------------------------------------------------------
// Champs des formulaires
define ('MEMBRES_FORM', array(
	'connexion.pseudo'			=>	"",
	'connexion.password'		=>	"",
	//----------
	'inscription.pseudo'		=>	"",
	'inscription.email'			=>	"",
	'inscription.password'		=>	"",
	//----------
	'modification.pseudo'		=>	"",
	'modification.email'		=>	"",
	'modification.avatar'		=>	"",
	'modification.nom'			=>	"",
	'modification.prenom'		=>	"",
	'modification.date_birth'	=>	"",
	'modification.password'		=>	"",
	'modification.password-conf'	=>	""
	)
);



//------------------------------------------------------------
// Constantes de la page connexion
define ('MEMBRES_CONNEXION', array(
	'_GETerror.error'			=> 	"Echec connexion !",
	'_GETerror.pseudo'			=>	"Entrez votre pseudo ;)",
	'_GETerror.password'		=>	"Entrez votre password ;)",
	'_GETerror.notfound'		=>	"Mauvais login / mot de passe :(",
	'label.pseudo'				=>	"Pseudo",
	'label.password'			=>	"Mot de passe",
	'placeholder.pseudo'		=>	"mon pseudo",
	'placeholder.password'		=>	"mon mot de passe"
	)
);



//------------------------------------------------------------
// Constantes de la page inscription
define ('MEMBRES_INSCRIPTION', array(
	'_GETerror.error'			=>	"Echec inscription !",
	'_GETerror.login'			=>	"Pseudo non valide : au moins 4 caractères alphanumeriques sans espace (- et _ tolérés)",
	'_GETerror.email'			=>	"Adresse email non valide :(",
	'_GETerror.password'		=>	"Password non valide : au moins 8 caractères dont au moins 1 chiffre ;)",
	'_GETerror.sql'				=>	"Pseudo ou email déjà enregistré :(",
	'label.pseudo'				=>	"Pseudo *",
	'label.email'				=>	"Email *",
	'label.password'			=>	"Mot de passe",
	'placeholder.pseudo'		=>	"au moins 4 caractères alphanumeriques sans espace, - et _ tolérés",
	'placeholder.email'			=>	"monemail@mondomaine.fr",
	'placeholder.password'		=>	"au moins 8 caractères dont au moins 1 chiffre",
	)
);



//------------------------------------------------------------
// Constantes de la page modification
define ('MEMBRES_MODIFICATION', array(
	'_GETerror.error'			=>	"Echec modification !",
	'_GETerror.pseudo-req'		=>	"Pseudo obligatoire ;)",
	'_GETerror.pseudo'			=>	"Au moins 4 caractères alphanumériques sans espace (- et _ tolérés)",
	'_GETerror.email-req'		=>	"Adresse email obligatoire ;)",
	'_GETerror.email'			=>	"L'adresse email doit être du type nom@domaine.fr",
	'_GETerror.avatar'			=>	"Fichiers autorisés : .jpg, .jpeg, .png, .gif :: 1Mo max",
	'_GETerror.nom'				=>	"Lettres, espaces, ' et - acceptés",
	'_GETerror.prenom'			=>	"Lettres, espaces, ' et - acceptés",
	'_GETerror.date_birth'		=>	"La date de naissance doit être valide ",
	'_GETerror.password'		=>	"Au moins 8 caractères dont au moins 1 chiffre ;)",
	'_GETerror.password-conf'	=>	"Les 2 passwords doivent être identiques ;),",
	'_GETsuccess.1'				=>	"Modifications enregistrées :)",
	'label.pseudo'				=>	"Pseudo *",
	'label.avatar'				=>	"Avatar",
	'label.nom'					=>	"Nom",
	'label.prenom'				=>	"Prénom",
	'label.date_birth'			=>	"Date de naissance",
	'label.email'				=>	"Email *",
	'label.password'			=>	"Nouveau mot de passe",
	'label.password-conf'		=>	"Confirmation nouveau mot de passe",
	'placeholder.pseudo'		=>	"mon pseudo",
	'placeholder.nom'			=>	"mon nom",
	'placeholder.prenom'		=>	"mon prénom",
	'placeholder.date_birth'	=>	"00/00/0000",
	'placeholder.email'			=>	"monemail@mondomaine.fr",
	'placeholder.password'		=>	"mon mot de passe",
	'placeholder.password-conf'	=>	"confirmation de mon mot de passe"
	)
);