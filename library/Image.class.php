<?php
namespace library;

class Image {
	
	/**
	 * Image::copyIndex()
	 *
	 * @param string $folder
	 * @return void
	 */
	private function copyIndex($folder){
	    if(!file_exists($folder.'/index.html'))
	        copy('img/index.html', $folder.'/index.html');  
	}

	/**
	 * Image::folder()
	 *
	 * @param int $ficheid
	 * @return void
	 */
	private function folder($ficheid){
	    return intval($ficheid / 100);
	}

	/**
	 * Image::createFolder()
	 *
	 * @param string $fichetype
	 * @param int $ficheid
	 * @return void
	 */
	public function createFolder($fichetype, $ficheid) {	    
	    // Création du dossier parent
	    $folder = intval($ficheid / 100);
	    
		// On regarde si le dossier de la fiche existe
		if(!file_exists(FOLDER_IMAGES.'/'.$fichetype.'/'.$folder.'/index.html'))
		{
		    // Création du dossier de la fiche, avec les parents, s'il n'existe pas encore
		    mkdir(FOLDER_IMAGES.'/'.$fichetype.'/'.$folder, '0777', true);

		    // Ajout des fichiers index.htm
		    $this->copyIndex(FOLDER_IMAGES.'/'.$fichetype);
		    $this->copyIndex(FOLDER_IMAGES.'/'.$fichetype.'/'.$folder);
		}
	}

	/**
	 * Image::download()
	 *
	 * @param string $url
	 * @param string $fichetype
	 * @param int $ficheid
	 * @return void
	 */
	public function download($url, $fichetype, $ficheid) {	    
	    $ficheid = intval($ficheid);

	    // Création des dossiers
	    $this->createFolder($fichetype, $ficheid);
	    
	    if(file_exists(FOLDER_IMAGES.'/temp/'.$ficheid.'.jpg'))
	    	unlink(FOLDER_IMAGES.'/temp/'.$ficheid.'.jpg');
	    // Téléchargement de l'image dans le dossier temp
	    copy($url, FOLDER_IMAGES.'/temp/'.$ficheid.'.jpg');

	    // On redimensionne l'image pour qu'elle respecte les bonnes proportions
	    $this->imageResize(FOLDER_IMAGES.'/temp/'.$ficheid.'.jpg', FOLDER_IMAGES.'/'.$fichetype.'/'.$this->folder($ficheid), $ficheid, 350, 480);
	}

	 /**
	  * Image::imageResize()
	  * 
	  * @param string $source
	  * @param string $folder_destination
	  * @param string $nom
	  * @param int $largeur
	  * @param int $hauteur
	  * @return void
	  */
	 public function imageResize($source, $folder, $nom, $largeur, $hauteur) {
		$source = imagecreatefromjpeg($source); // La photo est la source
		$largeur_source = imagesx($source);
		$hauteur_source = imagesy($source);

		$image = imagecreatetruecolor($largeur, $hauteur);
		imagecopyresampled($image, $source, 0, 0, 0, 0, $largeur, $hauteur, $largeur_source, $hauteur_source);

		// On supprime l'image de destination si elle existe
		if(file_exists($folder.'/'.$nom.'.jpg'))
		  unlink($folder.'/'.$nom.'.jpg');

		// On enregistre l'image redimensionnée
		imagejpeg($image, $folder.'/'.$nom.'.jpg', 100);
	}
}