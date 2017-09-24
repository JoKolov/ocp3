<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Modèle de la page enregistrer (un billet)
 *
 * File Last Update : 2017 08 31
 *
 * File Description :
 * -> contrôle les données envoyées par le formulaire
 * -> enregistre les données dans la BDD
 * -> renvoi vers la page d'édition du billet avec les éventuelles erreurs 
 */


//--------------------------------------------------
// COMMUNICATION AVEC LE CONTROLEUR

function modele_enregistrer()
{
	$get = action_enregistrer();
	return url_format('billets','','edition', $get);
}



//--------------------------------------------------
// RECUPERE LES VARIABLES NECESSAIRES POUR LA VUE

function action_enregistrer()
{
	// initialisation des variables
	$get['error'] = '';
	$billet = new Billet;

	// on vérifie que l'on a reçu des données du formulaire
	if (isset($_POST))
	{
		$_SESSION['billet']['edition'] = [];
		// on vérifie que les champs obligatoires sont bien complétés
		foreach (BILLETS_FORM as $key => $value)
		{
			if ($value AND (!isset($_POST[$key]) OR $_POST[$key] == ''))
			{
				// cette donnée est obligatoire mais elle est absente du formulaire ou vide
				// on enregistre le nom du champs dans les erreurs
				$get['error'] .= $key . '_';
			}
			// création du tableau des "value" de la vue
			$_SESSION['billet']['edition'][$key] = $_POST[$key];
		}

		// tous les champs obligatoires sont remplis
		if ($get['error'] == '')
		{
			// on contrôle les valeurs
			foreach (BILLETS_FORM as $key => $value)
			{
				$method = 'set_' . $key;
				if (method_exists('Billet', $method) AND !$billet->$method($_POST[$key]))
				{
					$get['error'] .= $key . '_';
				}
			}

			// toutes les données sont valides
			if ($erreurs['error'] == '')
			{
				// Hydratation du billet
				// -> auteur_id
				// -> image_id
				// -> statut
				
				// ==========
				// ID du Billet
				// on vérifie s'il s'agit d'un billet existant
				// si c'est le cas, on intègre l'id du billet dans l'instance $billet
				// et on récupère prévoit le renvoi de l'id en méthode _GET
				if (isset($_POST['id']) AND $billet->set_id($_POST['id']))
				{
					$get['id'] = $_POST['id'];
				}

				// ==========
				// AUTEUR du Billet
				$membre = $_SESSION['membre'];
				$billet->set_auteur_id($membre->get_id());

				// ==========
				// IMAGE du Billet
// +++++ TBD +++++

				// ==========
				// STATUT du billet
				if (isset($_POST['publier']))	{ $billet->set_statut(Billet::STATUT['publier']); }
				else 							{ $billet->set_statut(Billet::STATUT['sauvegarder']); }

				$billetMgr = new BilletMgr;

				// INSERT SQL
				// ==========>
				if (is_null($billet->get_id()))
				{
					if (!$billetMgr->insert($billet))
					{
						$get['error'] .= 'insert_';
						return $get;
					}
					else
					{
						// on récupère l'id du billet inséré
						$get['id'] = $billetMgr->get_last_billets_id();
					}
				}

				// UPDATE SQL
				// ==========>
				else
				{
					if (!$billetMgr->update($billet))
					{
						$get['error'] .= 'update_';
						return $get;
					}
				}

				// Insertion confirmée
				unset($get['error']);
				$get['success'] = TRUE;
				return $get;	
			}
		}
	}
	// le formulaire est vide
	else
	{
		$get['error'] = 'nodata';
	}

	// on renvoi vers la page d'édition avec les erreurs
	return $get;
}
