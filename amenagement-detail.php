<?
	include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/utils.php" );
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Categorie.php";
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Produit.php";
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Produit_image.php";
	session_start();
	
	$debug = false;
	
	$produit = new Produit();
	$produit_image = new Produit_image();
	$result = $produit->load( $_GET[ "id" ], $debug );
	//print_pre( $result );
	
	// ---- VERIFICATIONS PREALABLES --------------------------------- //
	if ( 1 == 1 ) {
		
		// ---- Le produit DOIT être en ligne pour être affiché ici!
		if ( $result[ 0 ][ "online" ] == "non" ) {
			if ( $debug ) echo "1 - Produit OFFLINE!<br>";
			if ( !$debug ) header( "Location: /amenagements.php" );
			exit();
		}
		
	}
	// --------------------------------------------------------------- //
	
	// ---- Informations à afficher ---------------------------------- //
	if ( 1 == 1 ) {
		
		// ---- Données de l'annonce ------------- //
		$nom = $result[ 0 ][ "nom" ];
		$description = nl2br( $result[ 0 ][ "description" ] );
		$fichier_pdf = $result[ 0 ][ "fichier_pdf" ];
		
		// ---- Image par défaut ----- //
		$image_defaut = $produit_image->getImageDefaut( $result[ 0 ][ "id" ], $debug );
		
		// ---- Liste des images ----- //
		if ( 1 == 1 ) {
			unset( $recherche );
			$recherche["num_produit"] = $result[ 0 ][ "id" ];
			$liste_image = $produit_image->getListe( $recherche, $debug );
		}
		
	}
	// --------------------------------------------------------------- //
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<title>Les différents aménagements de Modul-Ouest</title>
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/header.php" ); ?>
	</head>
	
	<body>
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/top.php" ); ?>
	
		<div class="row contenu">
			
			<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/rappel.php" ); ?>
	
			<div class="large-12 columns">
				<h1><?php echo $nom?></h1>
			</div>
			
			<div class="row">
				<div class="large-6 columns">
					
					<div class="gallery-top">
						<div class="swiper-wrapper">
							
							<?
							// ---- Affichage des vignettes ------------------ //
							if ( !empty( $liste_image ) ) {
								foreach ( $liste_image as $_image ) { 
									echo "<div class='swiper-slide'><a href='/photos/produit/normale" . $_image[ "fichier" ] . "' class='fancybox photo-principale' rel='offre'><img src='/photos/produit/accueil" . $_image[ "fichier" ] . "' alt='' /></a></div>\n";
								}
							}
							// ----------------------------------------------- //
							?>
						
						</div>
						
						<!-- Add Arrows -->
						<div class="swiper-button-next"></div>
						<div class="swiper-button-prev"></div>
					</div>
					<div class="gallery-thumbs">
						<div class="swiper-wrapper">
							
							<?
							// ---- Affichage des vignettes ------------------ //
							if ( !empty( $liste_image ) ) {
								foreach ( $liste_image as $_image ) { 
									echo "<div class='swiper-slide'><img src='/photos/produit/vignette" . $_image[ "fichier" ] . "' alt='' /></div>\n";
								}
							}
							// ----------------------------------------------- //
							?>
							
						</div>
					</div>
				</div>
				
				<div class="large-6 columns">
					<h3>Descriptif</h3>
					<p><?=$description?></p>
					
					<?
					// ---- PDF disponible --------------- //
					if ( $fichier_pdf != '' ) {
						echo "<h3>PDF disponible</h3>\n";
						echo "<p>\n";
						echo "	Télécharger ici notre fichier PDF :\n";
						echo "	<a href='/fichier/pdf" . $fichier_pdf . "' target='_blank' class='pdf'></a>\n";
						echo "</p>\n";
					}
					// ----------------------------------- //
					?>
					
				</div>
			</div>
			
		</div>
	
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/footer.php" ); ?>
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/scripts.php" ); ?>
		
		<script>
			$(document).ready(function(){
				$('.menu li:nth-child(3)').addClass('active');
			});
		</script>
		
	</body>
</html>
