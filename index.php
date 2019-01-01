<?
	include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/utils.php" );
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php";
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/News.php";
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Produit.php";
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Produit_image.php";
	
	$debug = false;
	$news = new News();
	$produit = new Produit();
	$produit_image = new Produit_image();
	
	// ---- Liste des actualités en ligne ---- //
	if ( 1 == 1 ) {
		$liste_actualite = $news->newsValidGet( $debug );
		$contenu_actualite = '';
		$classe_texte = "large-12 medium-12 small-12 columns";
		
		if ( !empty( $liste_actualite ) ) {
			$contenu_actualite = "<div class='large-4 medium-4 small-12 columns'>\n";
			$contenu_actualite .= "	<div class='actualite'>\n";
			$contenu_actualite .= "		<h2>Actualité</h2>\n";
			$contenu_actualite .= "		<div class='swiper-wrapper'>\n";
			
			foreach( $liste_actualite as $_actualite ) {
				$id_news = $_actualite[ "id_news" ];
				$titre = ( $_actualite[ "titre" ] );
				$accroche = couper_correctement( $_actualite[ "contenu" ], 100, ' ', false );
				if ( strlen( $_actualite[ "contenu" ] ) > 100 ) $accroche .= " ...";
				$image = ( $_actualite[ "image1" ] != '' )
					? "/photos/news/thumbs" . $_actualite[ "image1" ]
					: "/img/marker.png";
				
				$contenu_actualite .= "			<div class='swiper-slide'>\n";
				$contenu_actualite .= "				<div class='contenu-actu'>\n";
				$contenu_actualite .= "					<p class='center'><img src='" . $image . "' alt='' /></p>\n";
				$contenu_actualite .= "					<h3>" . $titre . "</h3>\n";
				$contenu_actualite .= "					<p>" . $accroche . "</p>\n";
				$contenu_actualite .= "					<p text-align='right'><a href='/actualites.php#" . $id_news . "'>Lire la suite.</a></p>\n";
				$contenu_actualite .= "				</div>\n";
				$contenu_actualite .= "			</div>\n";
				
				$classe_texte = "large-8 medium-8 small-12 columns";
				break;
			}
			
			$contenu_actualite .= "		</div>\n";
			$contenu_actualite .= "	</div>\n";
			$contenu_actualite .= "</div>\n";
		}
	}
	// --------------------------------------- //
	
	// ---- Liste des produits "à la Une" ---- //
	if ( 1 == 1 ) {
		unset( $recherche );
		$recherche[ "online" ] = '1';
		$recherche[ "accueil" ] = '1';
		$liste_produit = $produit->getListe( $recherche, $debug );
		//print_pre( $liste_produit );
		
		$contenu_produit = '';
		
		if ( !empty( $liste_produit ) ) {
			$contenu_produit = "<div class='row amenagements'>\n";
			$contenu_produit .= "	<div class='large-12 columns'>\n";
			$contenu_produit .= "		<h1>Nos prestations</h1>\n";
			$contenu_produit .= "	</div>\n";
			$contenu_produit .= "	<div class='swiper-wrapper'>\n";
			
			foreach( $liste_produit as $_produit ) {
				$id_produit = $_produit[ "id" ];
				$nom = ( $_produit[ "nom" ] );
				$image_defaut = $produit_image->getImageDefaut( $id_produit, $debug );
				
				$contenu_produit .= "	<div class='large-4 medium-4 small-12 columns swiper-slide'>\n";
				$contenu_produit .= "		<a href='/amenagement-detail.php?id=" . $id_produit . "'>\n";
				$contenu_produit .= "			<span>" . $nom . "</span>\n";
				$contenu_produit .= "			<img src='/photos/produit/accueil" . $image_defaut[ "fichier" ] . "' alt='" . $nom . "' />\n";
				$contenu_produit .= "		</a>\n";
				$contenu_produit .= "	</div>\n";
			}
			
			$contenu_produit .= "	</div>\n";
			$contenu_produit .= "	<div style='clear:both;'></div>\n";
			$contenu_produit .= "</div>\n";
			//echo $contenu_produit . "<br>";
		}
	}
	// --------------------------------------- //
	
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<title>SFnettoyage.com - aménagement, transformation de véhicules utilitaires</title>
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/header.php" ); ?>
	</head>
<body>

	<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/top.php" ); ?>
	<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/slider.php" ); ?>
	
	<div class="row contenu">
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/rappel.php" ); ?>

		<div class="<?=$classe_texte?>">
			
			<h1>Présentation</h1>
			
			
			<p><strong>Je  vous propose  mes services  pour  des  prestations  occasionnelles ou régulières:</strong></p>
			<p><strong>Tous les travaux de:</strong></p>
			
			<div class="large-6 medium-6 small-12 columns">
			
    			<h3>Nettoyage vitrine</h3>
    			  <ul>
                        <li>Particuliers</li>
                        <li>Professionnels</li>
                    </ul>
    			<h3>Remise en état</h3>
                    <ul>
                        <li>fin de chantier</li>
                        <li>fin de location</li>
                        <li>vitres, sols, cuisines, salles de bains</li>
                    </ul>
            </div>
            <div class="large-6 medium-6 small-12 columns">
                <h3>Nettoyage à l'eau pure</h3>
                    <ul>
                        <li>panneaux photovoltaïques</li>
                        <li>verandas</li>
                    </ul>
                    
                <h3>Entretien de locaux professionnels</h3>
            </div>   
            
            <div class="large-12 medium-12 small-12 columns"> 
                 <p><strong><a href="contact.php">DEVIS GRATUIT</a> - TRAVAIL AUX FORFAITS</strong></p>
                <p><strong>Règlement en chèque, CESU, ou autre</strong></p>
           </div>
           
		</div>
		
		<?
		// ---- Affichage des actualités ------ //
		if ( $contenu_actualite != '' ) {
			echo $contenu_actualite;
		}
		?>
		
	</div>
	
	<?
	// ---- Affichage des produits "à la Une" ------ //
	echo $contenu_produit;
	?>
	
	<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/footer.php" ); ?>
	<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/scripts.php" ); ?>
	
	<script>
		$(document).ready(function() {
			
			$('.menu li:first-child').addClass('active');
			
			// ---- Ouverture de l'iframe pour jouer la vidéo Youtube ------ //
			$( ".play" )
				.attr( 'rel', 'media-gallery' )
				.fancybox({
					openEffect : 'none',
					closeEffect : 'none',
					prevEffect : 'none',
					nextEffect : 'none',

					arrows : false,
					helpers : {
						media : {},
						buttons : {}
					}
				});
			// ------------------------------------------------------------- //
			
		});
	</script>
	
</body>
</html>
