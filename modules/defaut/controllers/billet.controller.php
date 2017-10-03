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
		$commentaires = $comMgr->selectList(null, 0, "billet_id = '" . $billet->get_id() . "' AND approuve = '1'", 'date_trie DESC');
		//--> $commentaireManager->recupererParBillet($billet);

		// Trie et ordonnancemant des commentaires
		$commentairesPremierNiveau = [];
		$commentairesParId = [];
		foreach ($commentaires as $idCom => $com)
		{
			$commentairesParId[$com->get_id()] = $com;
		}

		foreach ($commentairesParId as $com)
		{
			if ($com->get_com_id() == 0) /// $com->isFirstLevel()
			{
				$commentairesPremierNiveau[] = $com;
			}
			else
			{
				$commentairesParId[$com->get_com_id()]->_enfants[] = $com;
			}
		}


		$membreMgr = new MembreMgr;

		foreach($commentaires as $com)
		{
			$auteur = $membreMgr->select( $com->get_auteur_id());
			$com->setAuteur((is_object($auteur)) ? $auteur->get_pseudo() : 'Anonyme');
		}

		
		$auteur = $membreMgr->select($billet->get_auteur_id());	//getAuteurBillet
		$nbComBillet = $comMgr->getNbComBillet($billetId);

		// Image à la Une
		$imageManager = new ImageMgr;
		$imageBillet = $imageManager->selectForBillet($billet);

		$action = ['displayView' => $request->getViewFilename()];
		$objects = [
			'membre' 	=> $request->getMembre(),
			'billet' 	=> $billet,
			'auteur' 	=> $auteur,
			'nombreCommentaires' 	=> count($commentaires),
			'commentairesPremierNiveau' => $commentairesPremierNiveau,
			'imageBillet' => $imageBillet
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