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

		$action = ['displayView' => $request->getViewFilename()];

		// récupération de l'affichage des attributs du profil du membre
		$membre =  $request->getMembre();
		$userViewProfile = '';
		foreach ($membre->getPublicAttributs() as $attributName => $attributValue)
		{
			$userViewProfile .= '<p>' . ucfirst($attributName) . ' : ' . $attributValue . '</p>';
		}

		// AFFICHAGE ABONNES
		if (!$membre->is_admin())
		{
			$objects = [
				'membre' => $membre,
				'values' => new ViewValues(['userProfile' => $userViewProfile])
			];

			$response = new Response($action, $objects);

			return $response;
		}

		// AFFICHAGE RESERVE AUX ADMINS
		// préparation affichage des billets dans la vue
		$billetMgr = new BilletMgr;
		$billets = $billetMgr->select_multi();
		$billetsListe = '';
		foreach ($billets as $value) {
			$billetsListe .= '<p><a href="?module=billets&page=lecture&id=' . $value->get_id() . '">' . $value->get_titre() . '</a> [ ' . '<a href="?module=billets&page=edition&id=' . $value->get_id() . '">' . 'éditer' . '</a> ][ ' . $value->get_statut() . ' ]</p>';
		}
		if ($billetsListe == '') { $billetsListe = '<p>Aucun billet</p>'; }
		$billetsNbBrouillon = $billetMgr->count('', "statut = '" . Billet::STATUT['sauvegarder'] . "'");
		$billetsNbPublication = $billetMgr->count('', "statut = '" . Billet::STATUT['publier'] . "'");
		$billetsNbSuppression = $billetMgr->count('', "statut = '" . Billet::STATUT['supprimer'] . "'");

		$billetsSum = [
			'liste'		=>	$billetsListe,
			'brouillon'	=>	$billetsNbBrouillon,
			'publie'	=>	$billetsNbPublication,
			'corbeille'	=>	$billetsNbSuppression
		];

		$objects = [
			'membre' => $membre,
			'error' => "mon message",
			'values' => new ViewValues(['userProfile' => $userViewProfile, 'billetsSum' => $billetsSum])
		];

		$response = new Response($action, $objects);

		return $response;
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