<? include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/inc-auth-granted.php" );?>
<? include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/utils.php" );?>
<? 
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Categorie.php";
	
	$debug = false;
	$categorie = new Categorie();
	
	$id = $_GET[ "id" ];
	
	$btn_creation_categorie = "Créer la catégorie";
	
	// ---- Liste des catégories de niveau 0 ------ //
	if ( 1 == 1 ) {
		unset( $recherche );
		$recherche[ "id_parent" ] = 0;
		$liste_categorie = $categorie->getListe( $recherche, $debug );
	}
	// -------------------------------------------- //
	
	// ---- Chargement d'une catégorie ------------ //
	if ( $_GET[ "id" ] != '' ) {
		$datas = $categorie->load( $id );
		
		if ( !empty( $datas[ 0 ] ) ) {
			$id_parent = $datas[ 0 ][ "id_parent" ];
			$nom = $datas[ 0 ][ "nom" ];
			$btn_creation_categorie = "Modifier la catégorie";
		}
	}
	// -------------------------------------------- //

	if ( empty( $liste_categorie ) ) {
		$message = 'Aucun enregistrement';
	} 
	else {
		$message = '';
	}

?>

<!doctype html>
<html class="no-js" lang="en">
	<head>
		<? include_once $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/inc-meta.php"; ?>
	</head>
	
	<body>	
		<? include_once $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/inc-menu.php"; ?>
		
		<div class="container">
			
			<div class="row">
				
				<!-- Nouvelle catégorie -->
				<div class="col-md-8">
					<div class="panel panel-default">
						<div class="panel-heading">
							<h3 class="panel-title">Choisissez la catégorie parent puis indiquez le nom de la catégorie fille</h3>
						</div>
						<div class="panel-body">
							<form name="formulaire" class="form-horizontal" method="POST" action="/admin/categorie/traitement.php" >
								<input type="hidden" name="mon_action" id="mon_action" value="gerer">
								<input type="hidden" name="id" value="<?=$id?>">
								
								<div class="row">
									<div class="row">
										<label class="col-md-3" >Catégorie Parent :</label>
										<select name="id_parent" id="id_parent" class="col-md-5">
											<option value="0" selected>-- racine --</option>
											<?
											if ( !empty( $liste_categorie ) ) {
												foreach ( $liste_categorie as $_categorie ) { 
													$selected = ( $id_parent == $_categorie[ "id" ] ) ? "selected" : "";
													echo "<option value='" . $_categorie[ "id" ] . "' " . $selected . ">" . $_categorie[ "nom" ] . "</option>\n";
												}
											}
											?>
										</select>	
									</div>	
									<div class="row">
										<label class="col-md-3">&nbsp;Nom catégorie :</label>
					      				<input type="text" class="col-md-5" name="nom" id="nom" value="<?=$nom?>" required>
					      			</div>
								</div>	
								
						      	<div class="row ">	
						      		<div class="col-md-3">&nbsp;</div>	
									<div class="col-md-8"><br>
										<button class="btn btn-success col-sm-10" type="submit" > <?=$btn_creation_categorie?> </button>
									</div>		
								</div>	
							</form>
						</div>
					</div>
				</div>
				
				<div class="col-md-6"><br><?=$message?></div>
				
				<form name="form_liste" id="form_liste" class="form-horizontal" method="POST" action="/admin/categorie/traitement.php" >
					<input type="hidden" name="mon_action" id="mon_action" value="">
					<input type="hidden" name="id_categorie" id="id_categorie" value="">
					<input type="hidden" name="ordre_affichage" id="ordre_affichage" value="">
				</form>
				
				<table class="table table-hover table-bordered table-condensed table-striped" >
				<thead>
					<tr>
						<th class="col-md-10" style="">Liste des catégories</th>
						<th class="col-md-1" style="">Produits</th>
						<th class="col-md-1" colspan="2" style="">Actions</th>
					</tr>
				</thead>
				<tbody>
					<? 
					if ( !empty( $liste_categorie ) ) {
						foreach ( $liste_categorie as $_categorie ) {
							
							// ---- Affichage de la categorie principale -------------------- //
							$categorie->afficherLigneAdmin( $_categorie[ "id" ], $debug );
							// -------------------------------------------------------------- //
							
							// ---- Recherche & affichage des sous-catégories --------------- //
							if ( 1 == 1 ) {
								unset( $recherche );
								$recherche[ "id_parent" ] = $_categorie[ "id" ];
								$liste_sous_categorie = $categorie->getListe( $recherche, $debug);
								
								if ( !empty( $liste_sous_categorie ) ) {
									foreach ( $liste_sous_categorie as $_categorie ) {
										
										// ---- Affichage de la categorie principale -------------------- //
										$categorie->afficherLigneAdmin( $_categorie[ "id" ], $debug );
									}
								}
							}
							// -------------------------------------------------------------- //
							
						}
					}
					?>
				</tbody>
				</table>
					
			</div>
		</div>
		
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8/jquery.min.js"></script>
		<script>window.jQuery || document.write('<script src="/js/jquery.min.js"><\/script>')</script>
		
		<script>
			
			// DOM Ready
			$(function() {
				
				$( ".select_categorie" ).change(function() {
					//alert( "changement..." );
					var id_cat = $(this).attr( "id" );
					var ordre_affichage = $(this).val();
					
					$( "#form_liste #mon_action" ).val( "changer-ordre-categorie" );
					$( "#form_liste #id_categorie" ).val( id_cat );
					$( "#form_liste #ordre_affichage" ).val( ordre_affichage );
					$( "#form_liste" ).submit();
					
					return false;
				});
				
			});
			
		</script>
		
	</body>
</html>


