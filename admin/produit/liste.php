<? include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/inc-auth-granted.php" );?>
<? include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/utils.php" );?>
<? 
	require$_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php";
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Categorie.php";
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Produit.php";
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Produit_image.php";
	
	$debug = 			false;
	$categorie = 		new Categorie();
	$produit = 			new Produit();
	$produit_image = 	new Produit_image();
	
	$id_categorie = ( $_POST[ "id_categorie" ] != '' ) ? $_POST[ "id_categorie" ] : $_GET[ "id_categorie" ];
	
	// ---- Liste des catégories de niveau 0 ------- //
	if ( 1 == 1 ) {
		unset( $recherche );
		$recherche[ "id_parent" ] = '0';
		$liste_categorie = $categorie->getListe( $recherche, $debug );
	}
	// -------------------------------------------- //
	
	// ---- Liste des produits -------------------- //
	if ( 1 == 1 ) {
		unset( $recherche );
		if ( $id_categorie != '' ) $recherche[ "id_categorie" ] = $id_categorie;
		$liste_produit = $produit->getListe( $recherche, $debug );
	}
	// -------------------------------------------- //

	if ( empty( $liste_produit ) ) {
		$message = 'Aucun enregistrement';
	} 
	else {
		$message = '';
	}

?>

<!doctype html>
<html class="no-js" lang="en">
	<head>
		<? include_once $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/inc-meta.php";?>
	</head>
	
	<body>	
		<? require_once $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/inc-menu.php";?>
	
		<div class="container">
			
			<div class="row">
				<form name="formulaire" class="form-horizontal" method="GET"  action="liste.php" >
				<div class="col-md-2">	
					<label  >&nbsp;Filtrez par catégorie :</label>
				</div>
				<div class="col-md-4">		
					<select name="id_categorie" id="id_categorie">
						<option value="" selected>-- afficher tout --</option>
						<?
						if ( !empty( $liste_categorie ) ) {
							foreach( $liste_categorie as $_categorie ) {
								$selected = ( $id_categorie == $_categorie[ "id" ] ) ? "selected" : "";
								echo "<option value='" . $_categorie[ "id" ] . "' " . $selected . " >" . $_categorie[ "nom" ] . "</option>\n";
								
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
				<div class="col-md-3">		
					<button class="btn btn-success col-sm-3" type="submit" >Filtrer</button>
				</div>
				<br><br>
			</div>
			
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-12">
	
					<table class="table table-hover table-bordered table-condensed table-striped" >
						<thead>
							<tr>
								<th class="col-md-2" style="">Titre</th>
								<th class="col-md-2" style="">Catégorie</th>
								<th class="col-md-5" style="">Description</th>
								<th class="col-md-1" style="">Photo</th>
								<th class="col-md-1" style="">Accueil</th>
								<th class="col-md-1" style="">Online</th>
								<th class="col-md-1" colspan="2" style="">Actions</th>
							</tr>
						</thead>
						<tbody>
							<? 
							if ( !empty( $liste_produit ) ) {
								$i=0;
								foreach ( $liste_produit as $value ) {
									$i++;
									
									// ---- Chargement de la catégorie associée
									$data = $categorie->load( $value[ "id_categorie" ] );
									
									// ---- Chargement de l'image par défaut
									$image_defaut = $produit_image->getImageDefaut( $value[ "id" ], $debug );
									
									$classe_affichage = ( $i % 2 != 0 ) ? "info" : "";
									$description = couper_correctement( $value[ "description" ], 50 );
									if ( strlen( $value[ "description" ] ) > 50 ) $description .= " ...";
									$image_ok = ( $image_defaut[ "fichier" ] != '' ) ? 'check' : 'vide';
									$accueil = ( $value[ "accueil" ] == '1' ) ? 'check' : 'vide';
									$online = ( $value[ "online" ] == '1' ) ? 'check' : 'vide';
									
									echo "<tr class='" . $classe_affichage . "'>\n";
									echo "	<td>" . $value[ "nom" ] . "</td>\n";
									echo "	<td>" . $data[ 0 ][ "nom" ] . "</td>\n";
									echo "	<td>" . $description . "</td>\n";
									echo "	<td align='center'><img src='../img/" . $image_ok . ".png' width='30' ></td>\n";
									echo "	<td align='center'><img src='../img/" . $accueil . ".png' width='30' ></td>\n";
									echo "	<td align='center'><img src='../img/" . $online . ".png' width='30' ></td>\n";
									echo "	<td><a href='./edition.php?id=" . $value[ "id" ] . "'><img src='../img/modif.png' width='30' alt='Modifier' ></a></td>\n";
									echo "	<td>\n";
									echo "		<div style='display: none;' class='supp" . $value[ "id" ] . " alert alert-warning alert-dismissible fade in' role='alert'>\n";
									echo "			<button type='button' class='close' aria-label='Close' onclick=\"$('.supp" . $value[ "id" ] . "').css('display', 'none');\"><span aria-hidden='true'>×</span></button>\n";
									echo "			<strong>Voulez vous vraiment supprimer ?</strong>\n";
									echo "			<button type='button' class='btn btn-danger' onclick=\"location.href='./traitement.php?reference=news&action=delete&id=" . $value[ "id" ] . "'\">Oui !</button>\n";
									echo "		</div>\n";
									echo "		<img src='../img/del.png' width='20' alt='Supprimer' onclick=\"$('.supp" . $value[ "id" ] . "').css('display', 'block');\">\n";
									echo "	</td>\n";
									echo "</tr>\n";
								}
							}
							?>
						</tbody>
					</table>
	
					<h3><?=$message?></h3>
				</div>
			</div>
		</div>
	</body>
</html>


