<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * MODULE : Defaut
 * FILE/ROLE : Contrôleur d'affichage d'un billet
 *
 * File Last Update : 2017 09 26
 *
 * File Description :
 * -> compile les données du formulaire à afficher
 *
 */

class BilletController {

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
		$billetId = $request->get()['id'];

		// Est-ce que le billet existe ?
		if (is_null($billetId))
		{
			$response = new Response(['redirect' => Response::urlFormat('defaut', '404')]);
			return $response;
		}

		$billetMgr = new BilletMgr;
		$billet = $billetMgr->select($billetId);

		if (!$billet)
		{
			$response = new Response(['redirect' => Response::urlFormat('defaut', '404')]);
			return $response;			
		}

		// liste des commentaires
		$comMgr = new CommentaireMgr;
		$comList = $comMgr->selectList(null, 0, "billet_id = '" . $billet->get_id() . "' AND approuve = '1'", 'date_trie ASC');

		// Trie et ordonnancemant des commentaires
		$sqlWhere = "billet_id = '" . $billet->get_id() . "' AND approuve = '1' AND com_level = '0'";
		$comListUn = $comMgr->selectList(null, 0, $sqlWhere, 'date_trie DESC');
		$comGlobalList = [];
		foreach ($comListUn as $com)
		{
			array_push($comGlobalList, $com);
			$nextLevel = $com->get_com_level() + 1;
			$sqlWhere = "com_id = '" . $com->get_id() . "' AND approuve = '1' AND com_level = '" . $nextLevel . "'";
			$comListDeux = $comMgr->selectList(null, 0, $sqlWhere, 'date_trie ASC');
			if (!empty($comListDeux))
			{
				foreach ($comListDeux as $com)
				{
					array_push($comGlobalList, $com);
					$nextLevel = $com->get_com_level() + 1;
					$sqlWhere = "com_id = '" . $com->get_id() . "' AND approuve = '1' AND com_level = '" . $nextLevel . "'";
					$comListTrois = $comMgr->selectList(null, 0, $sqlWhere, 'date_trie ASC');
					if (!empty($comListTrois))
					{
						foreach ($comListTrois as $com)
						{
							array_push($comGlobalList, $com);
							$nextLevel = $com->get_com_level() + 1;
							$sqlWhere = "com_id = '" . $com->get_id() . "' AND approuve = '1' AND com_level = '" . $nextLevel . "'";
							$comListQuatre = $comMgr->selectList(null, 0, $sqlWhere, 'date_trie ASC');
							if (!empty($comListQuatre))
							{
								foreach ($comListQuatre as $com)
								{
									array_push($comGlobalList, $com);
									$nextLevel = $com->get_com_level() + 1;
									$sqlWhere = "com_id = '" . $com->get_id() . "' AND approuve = '1' AND com_level = '" . $nextLevel . "'";
									$comListCinq = $comMgr->selectList(null, 0, $sqlWhere, 'date_trie ASC');
									if (!empty($comListCinq))
									{
										foreach ($comListCinq as $com)
										{
											array_push($comGlobalList, $com);
											$nextLevel = $com->get_com_level() + 1;
											$sqlWhere = "com_id = '" . $com->get_id() . "' AND approuve = '1' AND com_level = '" . $nextLevel . "'";
											$comListSix = $comMgr->selectList(null, 0, $sqlWhere, 'date_trie ASC');
											if (!empty($comListSix))
											{
												foreach ($comListSix as $com)
												{
													array_push($comGlobalList, $com);										
												}
											}					
										}
									}
								}						
							}
						}					
					}				
				}
			}
		}

		$membreMgr = new MembreMgr;

		foreach($comList as $com)
		{
			$auteur = $membreMgr->select( $com->get_auteur_id());
			$com->setAuteur((is_object($auteur)) ? $auteur->get_pseudo() : 'Anonyme');
		}

		
		$auteur = $membreMgr->select($billet->get_auteur_id());	
		$nbComBillet = $comMgr->getNbComBillet($billetId);

		$action = ['displayView' => $request->getViewFilename()];
		$objects = [
			'membre' 	=> $request->getMembre(),
			'billet' 	=> $billet,
			'auteur' 	=> $auteur,
			'comList' 	=> $comList,
			'nbCom' 	=> $nbComBillet,
			'comGlobalList' => $comGlobalList
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
		return $this->actionView($request);
	}


} // end of class BilletController