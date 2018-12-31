<? 
	include_once '../../inc/inc.config.php';
	include_once '../classes/utils.php';
	require '../classes/ImageManager.php';
	require '../classes/Produit.php';
	require '../classes/Produit_image.php';
	session_start();
	
	$debug = false;
	if ( $debug ) print_pre( $_POST );
	
	$produit = new Produit();
	$produit_image = new Produit_image();
	$imageManager = New ImageManager();
	
	// ---- Security ---------------------------------------------------------- //
	if ( !isset( $_SESSION[ "accessGranted" ] ) || !$_SESSION[ "accessGranted" ] ) {
		$result = $storageManager->grantAccess($_POST[ "login" ], $_POST[ "mdp" ]);
		if (!$result){
			header('Location: /admin/?action=error');
		} else {
			$_SESSION[ "accessGranted" ] = true;
		}
	}
	// ------------------------------------------------------------------------ //
	
	
	// ---- Forms processing -------------------------------------------------- //
	if ( $_POST[ "mon_action" ] != '' ) {
		
		// ---- Gestion des produits --------------------------------------------- //
		if ( $_POST[ "mon_action" ] == "gerer" ) {
			
			// ---- Traitement de l'image ------------------- //
			/*if ( $_POST[ "url1" ] != '' ) {
				$source = $_SERVER[ "DOCUMENT_ROOT" ] . $_POST[ "url1" ];
				if ( $debug ) echo "Source : " . $source . "<br>";
				
				if( strstr( $source, 'uploads' ) ) {
					$source = $_SERVER[ "DOCUMENT_ROOT" ] . $_POST[ "url1" ];
					$filenameDest = $imageManager->fileDestManagement( $source, $_POST[ "id" ] );
					
					// ---- Image -------- //
					$destination = $_SERVER[ "DOCUMENT_ROOT" ] . '/photos/produit' . $filenameDest;
					if ( $debug ) echo "Destination : " . $destination . "<br>";
					$imageManager->imageResize( $source, $destination, 637, null, ZEBRA_IMAGE_CROP_CENTER );
					
					$_POST[ "image" ] = $filenameDest;
				}
			}*/
			// ---------------------------------------------- //
			
			// ---- Traitement des données ------------------ //
			if ( 1 == 1 ) {
				$id = $produit->gererDonnees( $_POST, $debug );
			}
			// ---------------------------------------------- //
			
			// ---- Gestion des images du produit -------------------------------- //
			if ( !empty( $_POST[ "mes_images" ] ) ) {
				//print_pre( $_POST[ "mes_images" ] );
				
				$cpt = 1;
				foreach( $_POST[ "mes_images" ] as $_image ) {
					$source = $_SERVER['DOCUMENT_ROOT'] . $_image;
					if ( $debug ) echo "<br>--- source : " . $source . "<br>";
					
					$filenameDest = $imageManager->fileDestManagement( $source, $id );
					if ( $debug ) echo "--- filenameDest : " . $filenameDest . "<br>";
					
					// ---- Création des différentes images ------------ //
					if ( 1 == 1 ) {
						
						// ---- Image de taille "normale" ---- //
						$destination = $_SERVER['DOCUMENT_ROOT'] . '/photos/produit/normale' . $filenameDest;
						if ( $debug ) echo "--- destination : " . $destination . "<br>";
						$imageManager->imageResize( $source, $destination, 800, 600, null );
						
						// ---- Image de taille "grande" ----- //
						$destination = $_SERVER['DOCUMENT_ROOT'] . '/photos/produit/accueil' . $filenameDest;
						if ( $debug ) echo "--- destination : " . $destination . "<br>";
						$imageManager->imageResize( $source, $destination, 319, 327, ZEBRA_IMAGE_CROP_CENTER );
						
						// ---- Image de taille "vignette" --- //
						$destination = $_SERVER['DOCUMENT_ROOT'] . '/photos/produit/vignette' . $filenameDest;
						if ( $debug ) echo "--- destination : " . $destination . "<br>";
						$imageManager->imageResize( $source, $destination, 97, 99, ZEBRA_IMAGE_CROP_CENTER );
					}
					// ------------------------------------------------- //
					
					// ---- Ce produit a-t-il une image par défaut? ---- //
					if ( 1 == 1 ) {
						$image_defaut = $produit_image->getImageDefaut( $id, $debug );
						$has_imageDefaut = ( $image_defaut[ "fichier" ] != '' ) ? true : false;
					}
					// ------------------------------------------------- //
					
					// ---- Enregistrement de l'image ------------------ //
					unset( $val );
					$val[ "num_produit" ] = $id;
					$val[ "fichier" ] = $filenameDest;
					$val[ "defaut" ] = ( $cpt == 1 && !$has_imageDefaut ) ? 'oui' : 'non';
					$produit_image->ajouter( $val, $debug );
					// ------------------------------------------------- //
					
					$cpt++;
				}
			}
			// ------------------------------------------------------------------- //
			
			// ---- Gestion du PDF ----------------------------------------------- //
			if ( $_POST[ "url1_changement" ] != '' ) {
				if ( $_POST[ "url1" ] != '' ) {
					if ( $debug ) echo "<br>Gestion du PDF!<br>";
					$source = $_SERVER['DOCUMENT_ROOT'] . $_POST[ "url1" ];
					$filenameDest = $imageManager->fileDestManagement( $source, $id );
					if ( $debug ) echo "--- filenameDest : " . $filenameDest . "<br>";
					
					$destination = $_SERVER['DOCUMENT_ROOT'] . '/fichier/pdf' . $filenameDest;
					if ( $debug ) echo "--- destination : " . $destination . "<br>";
					
					// ---- Copie du fichier ----------- //
					copy( $source, $destination );
				}
				
				// ---- MAJ de l'enregistrement ---- //
				$produit->setChamp( "fichier_pdf", $filenameDest, $id, $debug );
			}
			// ------------------------------------------------------------------- //
				
			// ---- Redirection après traitement ------------ //
			if ( 1 == 1 ) {
				
				// ---- Modification... ---- //
				if ( $_POST[ "id" ] != '' ) $page_redirection = "/admin/produit/edition.php?id=" . $id;
				
				// ---- Ajout... ----------- //
				else $page_redirection = "/admin/produit/liste.php";
				
				if ( $debug ) echo "Redirection vers " . $page_redirection;
				else header( "Location: " . $page_redirection );
				exit();
			}
			// ---------------------------------------------- //
			
		} 
		// ------------------------------------------------------------------------ //
		
		// ---- Définition d'une image par défaut --------------------------------- //
		if ( $_POST[ "mon_action" ] == "par defaut" ) {
			
			// ---- Liste des autres images de l'offre ---- //
			unset( $recherche );
			$recherche[ "num_produit" ] = $_POST[ "id" ];
			$liste_image = $produit_image->getListe( $recherche, $debug );
			
			// ---- On passe toutes les autres à "non" ---- //
			if ( !empty( $liste_image ) ) {
				foreach( $liste_image as $_image ) {
					$produit_image->setChamp( "defaut", 'non', $_image[ "num_image" ], $debug );
				}
			}
			
			$produit_image->setChamp( "defaut", 'oui', $_POST[ "num_image" ], $debug );
			if ( !$debug ) header( "Location: /admin/produit/edition.php?id=" . $_POST[ "id" ] );
		}
		// ------------------------------------------------------------------------ //
		
		// ---- Suppression d'une image ------------------------------------------- //
		if ( $_POST[ "mon_action" ] == "supprimer image" ) {
			$produit_image->supprimer( $_POST[ "num_image" ], $debug );
			if ( !$debug ) header( "Location: /admin/produit/edition.php?id=" . $_POST[ "id" ] );
		}
		// ------------------------------------------------------------------------ //
	
	}
	// ------------------------------------------------------------------------ //
	
	
	// ---- GET GET GET ------------------------------------------------------- //
	elseif ( $_GET[ "action" ] == 'delete' ) {
		try {
			$produit = new Produit();
			$result = $produit->supprimer( $_GET[ "id" ], $debug );
			
			if ( !$debug ) header( "Location: /admin/produit/liste.php" );
		} 
		catch (Exception $e) {
			echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
			$goldbook = null;
			exit();
		}
	}
	// ------------------------------------------------------------------------ //
	
	
	// ---- ERREUR!!! --------------------------------------------------------- //
	else {
		header('Location: /admin/');
	}
	// ------------------------------------------------------------------------ //
?>