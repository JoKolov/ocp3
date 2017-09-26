<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Billets
 * FILE/ROLE : Panneau de contrôle
 *
 * File Last Update : 2017 09 24
 *
 * File Description :
 * -> effectue l'action demandée par la requête
 * -> compile les données pour la vue
 *
 */

class AdminController {

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

	/**
	 * ------------------------------
	 * [actionView description]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function actionView($request)
	{
		user_connected_only();
		admin_only();

		//--- récupération des billets
		$listeBrouillon = self::setBilletListInTable(5,0,'Brouillon');
		$listePublication = self::setBilletListInTable(5,0,'Publication');
		$listeCorbeille = self::setBilletListInTable(5,0,'Corbeille', TRUE);
		//--- fin récupération billets
	
		$action = ['displayView' => $request->getViewFilename()];
		$objects = [
			'membre' 			=> $request->getMembre(),
			'listeBrouillon' 	=> $listeBrouillon,
			'listePublication' 	=> $listePublication,
			'listeCorbeille' 	=> $listeCorbeille
		];

		$response = new Response($action, $objects);

		return $response;
	}


	/**
	 * ------------------------------
	 * [actionSubmit description]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function actionSubmit($request)
	{
		$this->actionView($request);
	}


	/**
	 * ------------------------------
	 * [setBilletListInTable description]
	 * @param integer     $limit  [description]
	 * @param integer     $offset [description]
	 * @param string|null $statut [description]
	 */
	public static function setBilletListInTable($limit = 0, $offset = 0, string $statut = null, bool $deleteInsteadMoveTrash = FALSE)
	{
		if (!is_null($statut) AND !in_array($statut, Billet::STATUT))
		{
			$statut = null;
		}
		else
		{
			$statut = ['statut' => $statut];
		}

		$billetMgr = new BilletMgr;
		$billets = $billetMgr->select_multi($statut, [$limit, $offset], ['last_date' => 'DESC']);

		if (empty($billets))
		{
			return '<p>Aucun</p>';
		}

		if ($limit <=0)
		{
			$limit = '';
		}

		$billetsListe = '
			<div class="table-responsive">
				<table class="table table-hover">
					<thead>
						<tr>
							<td><strong>' . $limit . ' Derniers Billets</strong></td>
							<td><strong>Date modif</strong></td>
							<td><strong>Actions</strong></td>
						</tr>
					</thead>
					<tbody>';

		foreach ($billets as $billet) {
			$billetsListe .= '
				<tr>
					<td><a href="?module=billets&page=edition&id=' . $billet->get_id() . '">' . $billet->get_titre() . '</a></td>
					<td>' . $billet->get_date_modif() . '</td>
					<td>
						<div class="btn-group text-right" role="group" aria-label="billet-' . $billet->get_id() . '">
							<a href="?module=billets&page=lecture&id=' . $billet->get_id() . '" class="btn btn-default" role="button" alt="voir le billet"><i class="fa fa-eye" aria-hidden="true"></i></a>
							<a href="?module=billets&page=edition&id=' . $billet->get_id() . '" class="btn btn-default" role="button" alt="éditer le billet"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>';
			if (!$deleteInsteadMoveTrash)
			{
				$billetsListe .= '
							<a href="?module=billets&page=supprimer&action=submit&id=' . $billet->get_id() . '" class="btn btn-warning" role="button" alt="supprimer le billet"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
			}

			else
			{
				$billetsListe .= '
							<a href="?module=billets&page=effacer&action=submit&id=' . $billet->get_id() . '" class="btn btn-danger" role="button" alt="effacer le billet"><i class="fa fa-eraser" aria-hidden="true"></i></a>';
			}
			$billetsListe .= '
						</div>
					</td>
				</tr>';
		}

		$billetsListe .= '
				 	</tbody>
				</table>
			</div>';	

		return $billetsListe;	
	}

} // end of class ControlPanelController