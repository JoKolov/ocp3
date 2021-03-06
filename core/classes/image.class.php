<?php
if (!defined('EXECUTION')) exit;
/**
 * @project : Blog Jean Forteroche
 * @author  <joffreynicoloff@gmail.com>
 * 
 * CORE : Class
 * FILE/ROLE : image
 *
 * File Last Update : 2017 08 29
 *
 * File Description :
 * -> gestion des images
 * -> Contrôle des images reçues
 * -> Création des miniatures
 */

class Image {
	//------------------------------------------------------------
	// Attributs
	
	// liés à $_FILE
	protected $_name;				// nom du fichier
	protected $_size;				// taille du fichier
	protected $_tmp_name;		// chemin d'accès temporaire du fichier

	// liés à la BDD
	protected $_id; 				// champ id dans BDD
	protected $_source;			// url de l'image source
	protected $_billet;			// url de l'image du billet
	protected $_vignette;		// url de l'image de la vignette
	protected $_avatar;			// url de l'image de l'avatar
	protected $_description;	// description de l'image
	protected $_fromSQL;			// indication de la provenance des données

	// liés à la classe
	protected $_type;				// type du fichier (différent du type $_FILE)
	protected $_img_sizes;		// taille de l'image en px
	protected $_filename;		// nom du fichier incluant le type

	// constantes
	const CHEMIN_SOURCE 		= 	'upload/images/';
	const CHEMIN_BILLET 		= 	'upload/billets/';
	const CHEMIN_VIGNETTE 		= 	'upload/vignettes/';
	const CHEMIN_AVATAR 		= 	'upload/avatars/';
	const DIR_SOURCE 			= 	SITE_ROOT . self::CHEMIN_SOURCE;
	const DIR_BILLET 			= 	SITE_ROOT . self::CHEMIN_BILLET;
	const DIR_VIGNETTE 			= 	SITE_ROOT . self::CHEMIN_VIGNETTE;
	const DIR_AVATAR 			= 	SITE_ROOT . self::CHEMIN_AVATAR;
	const URL_SOURCE 			= 	APP['url-website'] . self::CHEMIN_SOURCE;
	const URL_BILLET 			= 	APP['url-website'] . self::CHEMIN_BILLET;
	const URL_VIGNETTE 			= 	APP['url-website'] . self::CHEMIN_VIGNETTE;
	const URL_AVATAR 			= 	APP['url-website'] . self::CHEMIN_AVATAR;
	const IMG_DEFAUT_AVATAR_ID 	= 	1;
	const IMG_DEFAUT_AVATAR 	= 	APP['url-website'] . '/upload/avatars/default.png';
	const IMG_DEFAUT_BILLET 	= 	'';
	const IMG_DEFAUT_VIGNETTE 	= 	'';
	const IMG_SIZE_MAX 			= 	1048576;
	const AVATAR_MAX_SIZE		= 	1048576;
	const BILLET_MAX_SIZE		=	5242880;
	const IMG_WIDTH_MAX			=	7000;
	const IMG_HEIGHT_MAX		= 	7000;
	const IMG_SURFACE_MAX		= 	37000000;
	const AVATAR_MAX_WIDTH 		= 	200;
	const AVATAR_MAX_HEIGHT 	= 	200;
	const BILLET_MAX_WIDTH	 	= 	1140;
	const BILLET_MAX_HEIGHT 	= 	400;
	const VIGNETTE_MAX_WIDTH	= 	160;
	const VIGNETTE_MAX_HEIGHT 	= 	80;



	//------------------------------------------------------------
	// Constructeur et méthodes magiques
	
	public function __construct(array $donnees = [], $fromSQL = FALSE) {
		$this->set_fromSQL($fromSQL); // on indique si les données proviennent de la BDD
	}



	//------------------------------------------------------------
	// Getteurs
	
	protected function get_fromSQL()		{ return $this->_fromSQL; 				}
	public function get_name()				{ return $this->_name; 					}
	public function get_filename()			{ return $this->_filename;				}
	public function get_type()				{ return $this->_type; 					}
	public function get_size()				{ return $this->_size; 					}
	public function get_img_sizes()			{ return $this->_img_sizes; 			}
	public function get_img_width()			{ return $this->_img_sizes['width']; 	}
	public function get_img_height()		{ return $this->_img_sizes['height']; 	}
	public function get_tmp_name()			{ return $this->_tmp_name; 				}
	public function get_id()				{ return $this->_id; 					}
	public function get_source()			{ return $this->_source; 				}
	public function get_billet()			{ return $this->_billet; 				}
	public function get_vignette()			{ return $this->_vignette; 				}
	public function get_avatar()			{ return $this->_avatar; 				}
	public function get_description()		{ return $this->_description; 			}



	//------------------------------------------------------------
	// Setteurs
	
	protected function set_fromSQL(bool $fromSQL)				{ return $this->setteur_fromSQL($fromSQL); 			}
	public function set_name(string $name) 						{ return $this->setteur_name($name); 				}
	public function set_filename(string $name)					{ return $this->setteur_filename(); 				}
	public function set_type($name) 							{ return $this->setteur_type($name); 				}
	public function set_size(int $size)							{ return $this->setteur_size($size); 				}
	public function set_img_sizes()								{ return $this->setteur_img_sizes(); 				}
	public function set_source($url = null)						{ return $this->setteur_source($url); 				}
	public function set_billet($url = null)						{ return $this->setteur_billet($url); 				}
	public function set_vignette($url = null)					{ return $this->setteur_vignette($url); 			}
	public function set_avatar($url = null)						{ return $this->setteur_avatar($url); 				}
	public function set_description(string $description = null)		{ return $this->setteur_description($description); 	}
	public function set_id(int $id)								{ return $this->setteur_id($id); 					}


	//==============================
	// SET _fromSQL
	protected function setteur_fromSQL(bool $fromSQL) {
		$this->_fromSQL = $fromSQL;
		return TRUE;
	}


	//==============================
	// SET _name
	protected function setteur_name(string $name) {
		// le nom du fichier doit se terminer par :
		// un point suivi de 3 ou 4 lettres
		$pattern = '#.[a-zA-Z]{3,4}$#';
		$extension_upload = strtolower(strrchr($name, '.'));
		if ($name <> '' AND preg_match($pattern, $name))
		{
			// on transforme les espaces en caractères url (%20) après avoir retiré l'extension du nom du fichier
			$this->_name = urlencode(str_replace($extension_upload, '', $name));
			$this->_filename = $name;
			return TRUE;
		}
		return FALSE;
	}


	//==============================
	// SET _filename
	protected function setteur_filename(string $filename = '') {
		if ($filename <> '' AND $this->set_name($filename))
		{
			$this->_filename = $filename;
			return TRUE;
		}

		$name = $this->get_name();
		$type = $this->get_type();
		if (!is_null($name) AND !is_null($type))
		{
			$this->_filename = $name . '.' . $type;
			return TRUE;
		}
		return FALSE;
	}


	//==============================
	// SET _type
	protected function setteur_type($name) {
		$extensions_valides = array('jpg', 'jpeg', 'gif', 'png');
		$extension_upload = strtolower(substr(strrchr($name, '.'),1));
		//1. strrchr renvoie l'extension avec le point (« . »).
		//2. substr(chaine,1) ignore le premier caractère de chaine.
		//3. strtolower met l'extension en minuscules.
		if (in_array($extension_upload,$extensions_valides))
		{
			$this->_type = $extension_upload;
			return TRUE;
		}
		return FALSE;
	}


	//==============================
	// SET _size
	protected function setteur_size(int $size) {
		$this->_size = $size;
		return TRUE;
	}


	//==============================
	// SET _img_sizes
	protected function setteur_img_sizes() {
		$filename = self::DIR_SOURCE . $this->get_filename();
		if (file_exists($filename))
		{
			list($width, $height) = getimagesize($filename);

			$imageSurface = $width * $height;
			if ($imageSurface > self::IMG_SURFACE_MAX)
			{
				return FALSE;
			}

			$this->_img_sizes['width'] = $width;
			$this->_img_sizes['height'] = $height;
			return TRUE;
		}
		return FALSE;
	}


	//==============================
	// SET _source	
	protected function setteur_source($url = null) {
		// si on a une url en provenance de la BDD on la prend
		if (!is_null($url) OR $this->get_fromSQL())
		{
			$this->_source = $url;
			return TRUE;
		}

		// creation de l'image source
		$filename = $this->get_filename();
		if ($filename <> '' AND !is_null($filename))
		{
			$this->_source = self::URL_SOURCE . $filename;
			return TRUE;
		}
		return FALSE;
	}


	//==============================
	// SET _billet
	protected function setteur_billet($url = null) {
		$this->_billet = $url;
		return TRUE;
	}


	//==============================
	// SET _vignette
	protected function setteur_vignette($url = null) {
		$this->_vignette = $url;
		return TRUE;
	}


	//==============================
	// SET _avatar 
	protected function setteur_avatar($url = null) {
		// si on a une url en provenance de la BDD on la prend
		if (!is_null($url) OR $this->get_fromSQL())
		{
			$this->_avatar = $url;
			return TRUE;
		}

		// créer une image tampon
		// redimensionne l'image aux cotes de l'avatar
		// copie l'image tampon dans le dossier des avatars
		
		$source = self::DIR_SOURCE . $this->get_filename();
		$avatar = self::DIR_AVATAR . $this->get_filename();

		//copie de l'image source dans le dossier avatar
		if (!copy($source, $avatar))
		{
			return FALSE; // échec de la copie
		} 

		// redimensionnement
		if (!$this->resize($avatar, self::AVATAR_MAX_WIDTH, self::AVATAR_MAX_HEIGHT))
		{
			return FALSE; // échec redimensionnement
		}

		// on défini l'attribut
		$this->_avatar = self::URL_AVATAR . $this->get_filename();
		return TRUE;
	}


	//==============================
	// SET _description
	protected function setteur_description(string $description = null) {
		if (is_null($description)) return TRUE;
		$this->_description = htmlspecialchars($description);
		return TRUE;
	}


	//==============================
	// SET _id
	protected function setteur_id(int $id) {
		if ($id > 0)
		{
			$this->_id = $id;
			return TRUE;
		}
		return FALSE;
	}


	//------------------------------------------------------------
	// Hydratation

	// Argument : tableau ayant pour clés les noms des methodes
	// 						et  pour valeurs les valeurs associées
	// Vérifie si la méthode 'clé' existe dans les methodes de la classe
	// Execute la methode si elle existe
	// Et change la valeur au résultat de la méthode (TRUE si validé, FALSE si refusé)
	// Si la méthode n'existe pas, laisse le couple clé/valeur intact
	// Renvoi le tableau donné en argument avec les modif 
	public function setFull(array $donnees, $fromSQL = FALSE) {
		$this->set_fromSQL($fromSQL);
		foreach ($donnees as $key => $value) {
			$method = 'set_' . $key;
			if (method_exists($this, $method))
			{
				$donnees[$key] = $this->$method($value);
			}
		}
		if ($fromSQL) {$this->set_fromSQL(FALSE); }
		return $this;
	}



	//------------------------------------------------------------
	// Méthodes

	/**
	 * LISTE DES METHODES
	 * ******************
	 * -> display view 		: NIL
	 * -> createFromFiles	: hydrate l'instance image selon les données reçues par $_FILE
	 * -> renameFromId		: modifie le nom de l'image sur le serveur et daans l'instance à partir d'un id (int)
	 * -> hashImgId			: hash un id pour créer un nom d'image unique
	 */

	//==============================
	/**
	 * Affiche la vue demandée à l'intérieur de la vue globale
	 */
	public function displayView($view)
	{

	}


	//==============================
	// créer une image à partir de la variable $_FILE['...']
	public function createFromFiles($file, $categorieImage = null)
	{
		// ajout après soutenance
		if ($file['error'] > 0)
		{ 
			return FALSE;
		}
		// fin ajout après soutenance

		$verif = array(
			'name'	=> $this->set_name($file['name']),		// vérification du nom
			'size'	=> $this->set_size($file['size']),		// vérification de la taille (size) en ko
			'type'	=>	$this->set_type($file['name'])		// vérification du type
			);

		foreach ($verif as $key => $value)  
		{
			if (!$value)
			{
				// on renvoi FALSE si au moins 1 élément est incorrect
				return FALSE;
			}
		}

		// contrôle de la taille de l'image
		switch ($categorieImage)
		{
			case 'AVATAR':
				$sizeLimit = self::AVATAR_MAX_SIZE;
				break;

			case 'BILLET':
				$sizeLimit = self::BILLET_MAX_SIZE;
				break;
				
			default:
				$sizeLimit = self::IMG_SIZE_MAX;
				break;
		}

		if ($this->get_size() > $sizeLimit) return FALSE; // taille trop élevée

		// on copie le fichier dans le répertoire des images
		// et on renvoi FALSE si le fichier ne s'est pas copié
		$filename = self::DIR_SOURCE . $this->get_filename();

		if (!move_uploaded_file($file['tmp_name'], $filename)) { return FALSE; }

		// on récupère la source
		if (!$this->set_source())	{ return FALSE; } // FALSE si une erreur survient

		// on récupère les dimensions de l'image
		if (!$this->set_img_sizes())	{ return FALSE; } // FALSE si une eerreur survient

		// tout est ok, on renvoi TRUE
		return TRUE;
	}


	//==============================
	// créer un nom d'image à partir d'un id
	public function renameFromId(int $id) 
	{
		// on met à jour le nom de l'image dans le dossier
		$fileOldName = $this->get_filename();
		$this->set_name(self::hashImgId($id) . '.' . $this->get_type());
		$this->set_source();
		$fileNewName = $this->get_filename();

		$fichiers = array(
			'source'		=> self::DIR_SOURCE, 
			'billet' 	=>	self::DIR_BILLET, 
			'vignette'	=> self::DIR_VIGNETTE,
			'avatar'		=> self::DIR_AVATAR);

		// pour chaque source possible,
		// si le fichier existe, il est renommé
		// et la source url est mise à jour dans l'objet
		foreach ($fichiers as $key => $value)
		{
			$method = 'set_' . $key;
			if (file_exists($value . $fileOldName))
			{
				rename($value . $fileOldName, $value . $fileNewName);
				$this->$method();
			}
		}
		return TRUE;
	}


	//==============================
	// renvoi un hash pour le nom de l'image
	public static function hashImgId($id)
	{
		return hash('md5', $id);
	}


	//==============================
	// supprime l'image du serveur
	// $image = instance image
	// $type = type image spécifique à supprimer (ex : source)
	public function delete(string $type = null)
	{
		// on récupère les url de tous les types d'images
		$filenames = array(
			'source'	=> $this->get_source(),
			'billet'	=> $this->get_billet(),
			'vignette'	=> $this->get_vignette(),
			'avatar'	=> $this->get_avatar());

		// suppression de tous les fichiers de cette image
		foreach ($filenames as $key => $value)
		{
			if (!is_null($value)) // l'url du fichier ne doit pas être nulle !!
			{
				$filename = str_replace(APP['url-website'], SITE_ROOT, $value);
				// on supprime le fichier seulement si $type est nul ou si $type = la valeur souchaitée
				if (is_null($type) OR $type == $key)
				{
					if (file_exists($filename))
					{
						$method = 'set_' . $key;
						if (unlink($filename) AND method_exists($this, $method))
						{
							$this->$method(''); // on change les attributs à NULL
						}
					}
				}
			}
		}
		return $this;
	}




	//==============================
	// vérifie l'image envoyée par l'utilisateur pour changer son avatar
	// $image = instance image
	// $type = type image spécifique à supprimer (ex : source)
	public function changeAvatar(array $filesImage, Membre $membre)
	{
		if ($filesImage['error'] <> 0)
		{
			return ['error' => 'changeAvatar'];
		}


		if (isset($filesImage) AND $filesImage['error'] == 0)
		{
			// on créer une image à partir de l'image uploadée
			$image = new Image;

			// on vérifie que le fichier envoyé entre dans les critères
			// si c'est ok, le fichier temporaire est copié dans le dossier images
			if ($image->setfrom_FILE($filesImage))
			{
				// on met à jour le nom de l'image dans le dossier
				$image->renameFromId($membre->get_id());

				// on créer un avatar
				if ($image->set_avatar())
				{
					// on peut supprimer l'image source
					$image->delete('source');

					// on créer le manager qui appelera la base donnée de l'image
					$imageMgr = new ImageMgr;

					// on met à jour la description de l'image
					$image->set_description('Avatar de ' . $membre->get_pseudo());

					// si le membre possède déjà un avatar personnel,
					// on ne sauvegarde pas la nouvelle image dans la BDD
					// car la nouvelle a écrasé l'ancienne sur le serveur
					$avatar_id = $membre->get_avatar_id();
					if ($avatar_id > 1)
					{
						// on récupère les données de l'avatar AVANT UPDATE pour supprimer le fichier du serveur si le nom est différent
						$imageOld = $imageMgr->select(array('id' => $avatar_id));
						if ($imageOld->get_avatar() <> $image->get_avatar())
						{
							$imageOld->delete();
						}
						unset($imageOld);

						// on UPDATE le fichier dans la BDD (en cas de changement de type notamment, ex : jpeg devient png)
						$image->set_id($avatar_id);
						if ($imageMgr->update($image))
						{
							$membre->set_avatar($image->get_avatar());
							$_SESSION['membre'] = $membre;
							return TRUE;
						}
						return FALSE;
					}
					// Si le membre n'avait pas d'avatar personnalisé
					// on enregistre l'image dans la BDD
					else
					{
						// on tente une insertion dans la base de données
						if ($imageMgr->insert($image))
						{
							// on recherche immédiatement l'image enregistrée pour récupérer l'id
							// et mettre à jour l'instance membre
							$reqAvatar = $imageMgr->select(array('avatar' => $image->get_avatar()));
							if ($reqAvatar !== FALSE)
							{
								// mise à jour de l'objet membre
								unset($image);
								$membre->set_avatar_id($reqAvatar->get_id());
								$membre->set_avatar($reqAvatar->get_avatar());
								$_SESSION['membre'] = $membre;
								return TRUE;
							}
						}
					}
				}
			}
			$erreur['error'] = 'avatar';
			return $erreur;
		}

		return TRUE;
	}


	public function createForBillet($files, Billet $billet)
	{
		/// 1 : vérifier que c'est une image
		if (!$this->createFromFiles($files, 'BILLET'))
		{
			return "Erreur Image : Mauvais format image";
		}

		/// 2 : renommer l'image selon id du billet
		$imageNameAsId = $billet->get_id();
		if (is_null($imageNameAsId))
		{
			$imageNameAsId = 0;
		}
		if (!$this->renameFromId($imageNameAsId))
		{
			return "Erreur Image : Erreur lors de la création de l'image à la une";
		}

		/// 3 : copier l'image dans le dossier billet
		$imageSource = self::DIR_SOURCE . $this->get_filename();
		$imageBillet = self::DIR_BILLET . $this->get_filename();
		$imageMiniature = self::DIR_VIGNETTE . $this->get_filename();

		//copie de l'image source dans le dossier avatar
		if (!copy($imageSource, $imageBillet)) return "Erreur Image : Echec copie de l'image source"; // échec de la copie
		if (!copy($imageSource, $imageMiniature)) return "Erreur Image : Echec copie de la miniature"; // échec de la copie		

		/// 4 : redimmensionner l'image
		if (!$this->resize($imageBillet, self::BILLET_MAX_WIDTH, self::BILLET_MAX_HEIGHT)) return "Erreur Image : Echec redimensionnement de l'image source"; // échec redim
		if (!$this->resize($imageMiniature, self::VIGNETTE_MAX_WIDTH, self::VIGNETTE_MAX_HEIGHT)) return "Erreur Image : Echec redimensionnement de la miniature"; // échec redim

		/// 5 supprimer l'image source
		$this->delete('source');

		/// 6 : renvoyer l'image
		$this->_billet = self::URL_BILLET . $this->get_filename();
		$this->_vignette = self::URL_VIGNETTE . $this->get_filename();
		return $this;
	}




	protected function resize($imageFile, $maxWidth, $maxHeight)
	{
		// fonctions PHP à appeler
		// on remplace le type jpg par jpeg car les fonctions "jpg" n'existent pas
		$type = $this->get_type();
		if ($type == 'jpg')
		{
			$type = 'jpeg';
		}
		//-- creation des noms de fonction PHP
		$imagecreatefromType = 'imagecreatefrom' . $type; // ex : imagecreatefrompng()
		$imageType = 'image' . $type;	// ex : imagepng()

		// on créer l'image résuite vide
		$imgResized = imagecreatetruecolor($maxWidth, $maxHeight);
		imagealphablending($imgResized, false);
		imagesavealpha($imgResized, true);

		$imgSource = $imagecreatefromType($imageFile);
		imagealphablending($imgSource, true);

		// calcul des nouvelles dimensions
		$widthSource = $this->get_img_width();
		$heightSource = $this->get_img_height();
		$decalageWidthSource = 0;
		$decalageHeightSource = 0;
		if ($widthSource > $maxWidth OR $heightSource > $maxHeight)
		{
			$limiteWidth = $widthSource * $maxHeight / $heightSource;
			$limiteHeight = $heightSource * $maxWidth / $widthSource;
			/*
			if ($limiteWidth >= $maxWidth)
			{
				$widthResized = $maxWidth;
				$heightResized = $limiteHeight;
			}
			elseif ($limiteHeight >= $maxHeight)
			{
				$heightResized = $maxHeight;
				$widthResized = $limiteWidth;	
			}
			*/
			if ($limiteWidth <= $maxWidth AND $widthSource > $heightSource)
			{
				$widthResized = $maxWidth;
				$heightResized = $maxHeight;
				//$decalageHeightSource = ($heightSource - $limiteHeight) / 2;
				$heightSource = $heightSource * $maxHeight / $limiteHeight;
			}
			elseif ($limiteHeight <= $maxHeight AND $heightSource > $widthSource)
			{
				$heightResized = $maxHeight;
				$widthResized = $maxWidth;	
				//$decalageWidthSource = ($widthSource - $limiteWidth) / 2;
				$widthSource = $widthtSource * $maxWidth / $limiteWidth;
			}		
			else
			{
				$widthResized = $maxWidth;
				$heightResized = $maxHeight;
			}
		}

		// calcul de la position de l'image redimensionnée dans l'image recrée
		$decalageWidth = 0;
		$decalageHeight = 0;
		/*
		if ($widthResized < $maxWidth)
		{
			$decalageWidth = ($maxWidth - $widthResized) / 2;
		}
		if ($heightResized < $maxHeight)
		{
			$decalageHeight = ($maxHeight - $heightResized) / 2;
		}
		*/

		// on créer l'image redimensionnée
		if (!imagecopyresampled($imgResized, $imgSource, $decalageWidth, $decalageHeight, $decalageWidthSource, $decalageHeightSource, $widthResized, $heightResized, $widthSource, $heightSource))
		{
			return FALSE;
		}

		// on enregistre la miniature en écrasant le fichier existant
		if (!$imageType($imgResized, $imageFile))
		{
			return FALSE;
		}

		// on détruit les images stockées en ressource PHP
		imagedestroy($imgResized);
		imagedestroy($imgSource);
		return TRUE;
	}

} // Fin classe Image /// /// /// /// /// /// /// /// /// ///