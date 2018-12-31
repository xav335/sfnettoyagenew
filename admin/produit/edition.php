<?
	include_once '../../inc/inc.config.php';
	include_once '../inc-auth-granted.php';
	include_once '../classes/utils.php';
	require '../classes/Categorie.php';
	require '../classes/Produit.php';
	require '../classes/Produit_image.php';
	
	$debug = 			false;
	$categorie = 		new Categorie();
	$produit = 			new Produit();
	$produit_image = 	new Produit_image();
	
	//print_pre( $_GET );
	
	// ---- Modification ---------------------------- //
	if ( !empty( $_GET ) ) {
		$action = 'modif';
		$result = $produit->load( $_GET[ "id" ], $debug );

		if ( !empty( $result ) ) {
			$titre_page = 	'Produit "'. $result[ 0 ][ "nom" ] . '"';
			$id =			$_GET[ "id" ];
			$id_categorie = $result[ 0 ][ "id_categorie" ];
			$nom = 			$result[ 0 ][ "nom" ];
			$description = 	$result[ 0 ][ "description" ];
			$image[ 1 ] = 	$result[ 0 ][ "image" ];
			$fichier_pdf = 	$result[ 0 ][ "fichier_pdf" ];
			$accueil = 		( $result[ 0 ][ "accueil" ]=='1' ) ? "checked" : "";
			$online = 		( $result[ 0 ][ "online" ]=='1' ) ? "checked" : "";
			
			$display_pdf = ( $fichier_pdf != '' ) ? "block" : "none";
			$display_pdf_img = ( $fichier_pdf != '' ) ? "none" : "block";
			
			// ---- Liste des photos associées à cette offre ---- //
			if ( 1 == 1 ) {
				unset( $recherche );
				$recherche[ "num_produit" ] = $_GET[ "id" ];
				$liste_image = $produit_image->getListe( $recherche, $debug );
			}
			// -------------------------------------------------- //
			
		}
		else $message = 'Aucun enregistrement';
	} 

	// ---- Ajout d'une rubrique -------------------- //
	else {
		$action = 'add';
		$titre_page = 	'Nouveau produit';
		$id	=			null;
		$nom = 			null;
		$description =	null;
		$img[ 1 ] = 	"/img/favicon.png";
		$imgval[ 1 ] = 	"/img/favicon.png";
		$fichier_pdf = 	'';
		$accueil = 		'0';
		$online = 		'0';
		
		$display_pdf = "none";
		$display_pdf_img = "block";
		
	}
	
	// ---- Liste des catégories de niveau 0 -------- //
	if ( 1 == 1 ) {
		unset( $recherche );
		$recherche[ "id_parent" ] = '0';
		$liste_categorie = $categorie->getListe( $recherche, $debug );
	}
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<? include_once "../inc-meta.php" ; ?>
	</head>
	
	<body>	
		<? require_once "../inc-menu.php" ; ?>
	
		<div class="container">
	
			<div class="row">
				<h3><?=$titre_page?></h3><br>
				<div class="col-xs-12 col-sm-12 col-md-12">
					
					<form name="formulaire" id="formulaire" class="form-horizontal" method="POST" action="traitement.php">
						<input type="hidden" name="mon_action" id="mon_action" value="gerer">
						<input type="hidden" name="id" id="id" value="<?=$id?>">
						<input type="hidden" name="num_image" id="num_image" value="">
						
						<div class="form-group" >
							<label class="col-sm-2" for="titre">Catégorie :</label>
							<select name="id_categorie" required>
								<option value="" selected >-- Aucune --</option>
								<?
								if ( !empty( $liste_categorie ) ) {
									foreach( $liste_categorie as $_categorie ) {
										$selected = ( $id_categorie == $_categorie[ "id" ] ) ? "selected" : "";
										//echo "<option value='' disabled >" . $_categorie[ "nom" ] . "</option>\n";
										echo "<option value='" . $_categorie[ "id" ] . "' " . $selected . ">" . $_categorie[ "nom" ] . "</option>\n";
										
										// ---- Liste des sous catégories disponibles ----- //
										if ( 1 == 1 ) {
											unset( $recherche );
											$recherche[ "id_parent" ] = $_categorie[ "id" ];
											$liste_sous_categorie = $categorie->getListe( $recherche, $debug );
											
											if ( !empty( $liste_sous_categorie ) ) {
												foreach( $liste_sous_categorie as $_categorie ) {
													$decalage = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
													$selected = ( $id_categorie == $_categorie[ "id" ] ) ? "selected" : "";
													
													echo "<option value='" . $_categorie[ "id" ] . "' " . $selected . " >" . $decalage . $_categorie[ "nom" ] . "</option>\n";
												}
											}
										}
										// ------------------------------------------------ //
									}
								}
								?>
							</select>
						</div>
						
						<div class="form-group" >
							<label class="col-sm-2" for="titre">Titre :</label>
							<input type="text" class="col-sm-10" name="nom" required value="<?=$nom?>">
						</div>
						
						<div class="form-group">
							<label class="col-sm-2" for="description">Description :</label><br>
							<textarea class="col-sm-12" name="description" id="description" required rows="5" ><?=$description?></textarea>
						</div>
						
						<div class="form-group" >
							<label class="col-sm-2" for="titre">En page d'accueil :</label>
							<input type="checkbox" name="accueil" value="1" <?=$accueil?>>
						</div>
						
						<div class="form-group" >
							<label class="col-sm-2" for="titre">En ligne :</label>
							<input type="checkbox" name="online" value="1" <?=$online?>>
						</div>
						
						<div class="col-md-6" style="margin-bottom:20px;">
							<label for="titre">Choix des photos </label><br>
							<input type="hidden" name="url0" id="url0" value=""><br>
							<input type="hidden"  name="idImage"  id="idImage" value="">
	            			<a href="javascript:openCustomRoxy('0')"><img id="" src="http://www.placehold.it/400x150/EFEFEF/171717&text=Choisir les images ici" id="customRoxyImage0" style="max-width:400px;"></a>
						</div>
						
						<div class="col-md-6" style="margin-bottom:20px;">
							<label for="titre">Choix du PDF</label><br>
							<input type="hidden" name="url1_changement" id="url1_changement" value="">
							<input type="hidden" name="url1" id="url1" value="<?=$fichier_pdf?>">
							
							<div id="div_pdf" style="display:<?=$display_pdf?>;">
								<img src="/admin/img/pdf.png" />&nbsp;
								<span id="span_pdf"><?=$fichier_pdf?></span>&nbsp;&nbsp;
						  		<input type="button" value="Changer" onclick="javascript:openCustomRoxy('1');" />&nbsp;
						  		<input type="button" value="Annuler" onclick="javascript:annuler_pdf();" />
							</div>
							<div id="div_pdf_img" style="display:<?=$display_pdf_img?>;">
	            				<a href="javascript:openCustomRoxy('1')"><img id="img_pdf" src="http://www.placehold.it/400x150/EFEFEF/171717&text=Choisir le PDF ici" id="customRoxyImage1" style="max-width:400px;"></a>
	            			</div>
						</div>
						<div style="clear:both;"></div>
						
						<div id="div_liste_image">
							<?
							// ---- Affichage de la liste des images déjà associées à cette offre ---- //
							if ( !empty( $liste_image ) ) {
								$cpt = 0;
								foreach( $liste_image as $_image ) {
									
									echo "<div class='col-md-3' style='text-align:center; margin-bottom:20px; border:0px solid red;'>\n";
				            		echo "	<img src='/photos/produit/accueil" . $_image[ "fichier" ] . "' width='230' style='max-width:230px;'></a><br>\n";
				            		if ( $_image[ "defaut" ] == 'non' ) echo "	<input type='button' id='" . $_image[ "num_image" ] . "' value='Par défaut' class='par_defaut' />\n";
				            		echo "	<input type='button' id='" . $_image[ "num_image" ] . "' value='Supprimer' class='supprimer_image_precise' />\n";
									echo "</div>\n";
									
									if ( $cpt % 4 == 4 )echo "<div style='clear:both;'></div>\n";
									$cpt++;
								}
							}
							// ----------------------------------------------------------------------- //
							?>
						</div>
						
			            <div id="roxyCustomPanel" style="display:none;">
							<iframe src="/admin/fileman2/index.html?integration=custom" style="width:100%;height:100%" frameborder="0"></iframe>
						</div>
						
						<div style="clear:both;"></div>
						<a href="./liste.php" class="btn btn-success col-sm-6" class="btn btn-default annuler"> Annuler </a>	
						<button type="submit" class="btn btn-success col-sm-6" class="btn btn-default"> Valider </button>
				  </form>
				  
				</div>
			</div>
		</div>
		
		
		<script type="text/javascript">
			var cpt = 0;
			
			function openCustomRoxy(idImage){
				$( "#url0" ).val( '' );
				$( "#url1" ).val( '' );
				
				$('#idImage').val(idImage);
			 	$('#roxyCustomPanel').dialog({modal:true, width:875,height:600});
			}
			
			function closeCustomRoxy(){
			  	$('#roxyCustomPanel').dialog('close');
			  	
			  	// ---- Contenu photo --------------------- //
			  	if ( $( "#url0" ).val() != '' ) {
			  		//alert( "Photos..." );
			  		
			  		var fichier_image = $( "#url0" ).val();
			  		var contenu = "<div id='div_image_" + cpt + "' class='col-md-3' style='text-align:center; margin-bottom:20px; border:0px solid red;'>\n";
					contenu += "	<input type='hidden' name='mes_images[]' value='" + fichier_image + "' />\n";
            		contenu += "	<img src='" + fichier_image + "' width='230' style='max-width:230px;'></a><br>\n";
            		//contenu += "	<input type='button' value='Par défaut' />\n";
            		contenu += "	<input type='button' id='" + cpt + "' value='Supprimer' class='supprimer_image' />\n";
					contenu += "</div>";
					
					if ( ( cpt % 4 ) == 4 ) contenu += "<div style='clear:both;'></div>\n";
					
					$( "#div_liste_image" ).append( contenu );
					cpt++;
			  	}
			  	// ---------------------------------------- //
			  	
			  	
			  	// ---- Contenu du PDF -------------------- //
			  	else if ( $( "#url1" ).val() != '' ) {
			  		$( "#div_pdf_img" ).hide();
			  		
			  		$( "#url1_changement" ).val( "changer pdf" );
			  		$( "#span_pdf" ).html( $( "#url1" ).val() );
			  		$( "#div_pdf" ).show();
			  	}
			  	// ---------------------------------------- //
			  	
			}
			
			function clearImage(idImage){
				$('#customRoxyImage'+idImage).attr('src', '/img/favicon.png');
				$('#url'+idImage).val('');
			}
			
			function annuler_pdf() {
				$( "#url1_changement" ).val( "changer pdf" );
				$( "#url1" ).val( '' );
				
				$( "#div_pdf" ).hide();
				$( "#div_pdf_img" ).show();
			}
			
			$( document ).on( "click", ".supprimer_image", function() {
				var val = $(this).attr( "id" );
				//alert( "Suppression de l'image " + val );
				$( "#div_image_" + val ).remove();
			});
			
			$( ".par_defaut" ).click(function() {
				var val = $(this).attr( "id" );
				//alert( "Image #" + val + " par defaut" );
				
				$( "#num_image" ).val( val );
				$( "#mon_action" ).val( "par defaut" );
				$( "#formulaire" ).submit();
			});
			
			$( ".supprimer_image_precise" ).click(function() {
				var val = $(this).attr( "id" );
				//alert( "Suppression de l'image #" + val );
				
				$( "#num_image" ).val( val );
				$( "#mon_action" ).val( "supprimer image" );
				$( "#formulaire" ).submit();
			});
			
			$( ".annuler" ).click(function() {
				window.location.href = "./liste.php";
			});
			
			$( ".valider" ).click(function() {
				//alert( "On poste..." );
				var is_coche = false;
				
				// ---- Il faut a moins un type de bien sélectionné ---- //
				if ( 1 == 1 ) {
					$( ".type_bien" ).each( function( index ) {
						//console.log( index + ": " + $( this ).text() );
						if (  $(this).is( ":checked" ) ) {
							//alert( "coché!!!" );
							is_coche = true;
							return false;
						}
					});
				}
				
				// ---- Tout va bien --> On poste ---------------------- //
				if ( is_coche ) {
					$( "#formulaire" ).submit();
					//alert( "On poste..." );
				}
				else alert( "Veuillez cocher au moins un type de bien." );
				
				return false;
			});
			
		</script>
		
	</body>
</html>


