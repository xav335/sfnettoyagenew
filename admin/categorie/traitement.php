<? 
	include_once '../../inc/inc.config.php';
	include_once '../classes/utils.php';
	require '../classes/ImageManager.php';
	require '../classes/Categorie.php';
	session_start();
	
	$debug = false;
	if ( $debug ) print_pre( $_POST );
	
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
	if ( !empty( $_POST ) ) {
		
		 // ---- Gestion des catégories --------------------------------------- //
		if ( $_POST[ "mon_action" ] == "gerer" ) {
			$categorie = new Categorie();
			
			// ---- Traitement des données ------------------ //
			if ( 1 == 1 ) {
				$id = $categorie->gererDonnees( $_POST, $debug );
			}
			// ---------------------------------------------- //
			
			// ---- Redirection après traitement ------------ //
			if ( 1 == 1 ) {
				$page_redirection = "/admin/categorie/liste.php";
				
				if ( $debug ) echo "Redirection vers " . $page_redirection;
				else header( "Location: " . $page_redirection );
				exit();
			}
			// ---------------------------------------------- //
			
		} 
		// -------------------------------------------------------------------- //
		
		// ---- Changement de l'ordre d'affichage des catégories -------------- //
		else if ( $_POST[ "mon_action" ] == "changer-ordre-categorie" ) {
			$categorie = new Categorie();
			try {
				$categorie->setChamp( 
					$_POST[ "id_categorie" ], 
					"ordre_affichage", 
					$_POST[ "ordre_affichage" ], 
					$debug 
				);
				
				if ( !$debug ) header( "Location: /admin/categorie/liste.php" );
			} 
			catch ( Exception $e ) {
				echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
				$catproduct = null;
				exit();
			}
		}
		//--------------------------------------------------------------------- //
		
	}
	// ------------------------------------------------------------------------- //
	
	
	// ---- GET GET GET -------------------------------------------------------- //
	elseif ( $_GET[ "action" ] == 'delete' ) {
		try {
			$categorie = new Categorie();
			$result = $categorie->supprimer( $_GET[ "id" ], $debug );
			
			if ( !$debug ) header( "Location: /admin/categorie/liste.php" );
		} 
		catch (Exception $e) {
			echo 'Erreur contactez votre administrateur <br> :',  $e->getMessage(), "\n";
			$goldbook = null;
			exit();
		}
	}
	// ------------------------------------------------------------------------- //
	
	
	// ---- ERREUR!!! ---------------------------------------------------------- //
	else {
		if ( $debug ) echo "ERREUR!!!";
		else header('Location: /admin/');
	}
	// ------------------------------------------------------------------------- //
?>