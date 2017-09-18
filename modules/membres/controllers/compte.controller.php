<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Membres
 * FILE/ROLE : Modèle de la page compte
 *
 * File Last Update : 2017 09 18
 *
 * File Description :
 * -> affiche les informations du membre
 * -> affiche les liens de modification
 * -> modifie les informations du compte
 * -> renvoi les erreurs de modification
 */

Class CompteController {

	//============================================================
	// Attributs
	// -- NIL --


	//============================================================
	// Constructeur et méthodes magiques
	// -- NIL --
	

	//============================================================
	// Getteurs
	// -- NIL --


	//============================================================
	// Setteurs
	// -- NIL --


	//============================================================
	// Methodes

	public function actionView($request)
	{
		user_connected_only();

		$membre =  $request->getMembre();

		// affichage des attributs du profil du membre
		$userView = '';
		foreach ($membre->getPublicAttributs() as $attributName => $attributValue)
		{
			$userView .= '<p>' . ucfirst($attributName) . ' : ' . $attributValue . '</p>';
		}

		// AFFICHAGE ABONNES
		if (!$membre->is_admin())
		{
			return [
				'file'		=> $request->getViewFilename(),
				'values'	=> [
					'user-profile' 	=> $userView,
					'user-avatar'	=> $membre->get_avatar()
				]
			];		
		}

		// AFFICHAGE RESERVE AUX ADMINS
		// préparation affichage des billets dans la vue
		$billetMgr = new BilletMgr;
		$billets = $billetMgr->select_multi();
		$billetsListe = '';
		foreach ($billets as $value) {
			$billetsListe .= '<p><a href="?module=billets&page=billet&id=' . $value->get_id() . '">' . $value->get_titre() . '</a> [ ' . '<a href="?module=billets&page=edition&id=' . $value->get_id() . '">' . 'éditer' . '</a> ][ ' . $value->get_statut() . ' ]</p>';
		}
		if ($billetsListe == '') { $billetsListe = '<p>Aucun billet</p>'; }
		$billetsNbBrouillon = $billetMgr->count('', "statut = '" . Billet::STATUT['sauvegarder'] . "'");
		$billetsNbPublication = $billetMgr->count('', "statut = '" . Billet::STATUT['publier'] . "'");
		$billetsNbSuppression = $billetMgr->count('', "statut = '" . Billet::STATUT['supprimer'] . "'");

		$billetView = [
			'liste'		=>	$billetsListe,
			'brouillon'	=>	$billetsNbBrouillon,
			'publie'	=>	$billetsNbPublication,
			'corbeille'	=>	$billetsNbSuppression
		];

		return [
			'file'		=> $request->getViewFilename(),
			'values'	=> [
				'user-profile' 	=> $userView,
				'user-avatar'	=> $membre->get_avatar(),
				'billets'	=> $billetView
			]
		];
	}

	public function actionSubmit($request)
	{
		user_connected_only();

		$this->actionView($request);
	}



	private function viewValuesUsingModel($post)
	{

	}


} // end of class CompteController