<?php
require_once("StorageManager.php");
class Categorie extends StorageManager {

	public function __construct( $id='', $debug=false ){
		if ( $id != '' ) return $this->load( $id, $debug );
	}
	
	public function load( $id, $debug=false ){
		$this->dbConnect();
		
		if ( intval( $id ) <= 0 ) return array();
		$new_array = null;
		
		$requete = "SELECT * FROM `catproduct` WHERE id = " . $id ;
		if ( $debug ) echo $requete . "<br>";
		$result = mysqli_query( $this->mysqli, $requete );
		
		while( $row = mysqli_fetch_assoc( $result ) ) {
			$new_array[] = $row;
		}
		$this->dbDisConnect();
		return $new_array;
	}
	
	public function gererDonnees( $post, $debug=false ) {
		$datas = $this->load( $post[ "id" ], $debug );
		$modification = ( !empty( $datas ) ) ? true : false;
		
		$val[ "id" ] = intval( $post[ "id" ] );
		$val[ "id_parent" ] = intval( $post[ "id_parent" ] );
		$val[ "nom" ] = addslashes( $post[ "nom" ] );
		$val[ "image" ] = addslashes( $post[ "image" ] );
		
		// ---- Modification -------- //
		if ( $modification ) {
			$id = $this->modifier( $val, $debug );
		}
		
		// ---- Ajout --------------- //
		else {
			$val[ "ordre_affichage" ] = $this->getOrdreMaxi( $post[ "id_parent" ], $debug ) + 1;
			$id = $this->ajouter( $val, $debug );
		}
		
		return $id;
	}
	
	private function getOrdreMaxi( $id_parent=0, $debug=false ) {
		$this->dbConnect();
		
		$id_parent = intval( $id_parent );
		
		$requete = "SELECT * FROM `catproduct` WHERE id_parent = " . $id_parent ;
		$requete .= " ORDER BY ordre_affichage DESC";
		if ( $debug ) echo $requete . "<br>";
		
		$result = mysqli_query( $this->mysqli, $requete );
		$data = mysqli_fetch_assoc( $result );
		$this->dbDisConnect();
		
		return $data[ "ordre_affichage" ];
	}
	
	public function ajouter( $value, $debug=false ) {
		$this->dbConnect();
		$this->begin();
		
		try {
			$sql = "INSERT INTO  `catproduct`
				( `id_parent`, `nom`, `image`, `ordre_affichage` )
				VALUES (
				'" . $value[ "id_parent" ] . "',
				'" . $value[ "nom" ] ."',
				'" . $value[ "image" ] ."',
				'" . $value[ "ordre_affichage" ] . "'
			);";
			
			if ( $debug ) echo $sql . "<br>";
			else {
				$result = mysqli_query( $this->mysqli, $sql );
				
				if ( !$result ) {
					throw new Exception( $sql );
				}
				
				$id_record = mysqli_insert_id( $this->mysqli );
				$this->commit();
			}
		
		} 
		catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
		$this->dbDisConnect();
		return $id_record;
	}
	
	public function modifier( $value, $debug=false ) {
		$this->dbConnect();
		$this->begin();
		
		try {
			$sql = "UPDATE  .`catproduct` SET";
			$sql .= " `id_parent` = '" . $value[ "id_parent" ] ."',";
			$sql .= " `nom` = '" . $value[ "nom" ] . "'";
			if ( $value[ "image" ] != '' ) $sql .= ", `image` = '" . $value[ "image" ] . "'";
			$sql .= " WHERE `id` = " . $value[ "id" ] . ";";
			
			if ( $debug ) echo $sql . "<br>";
			else {
				$result = mysqli_query( $this->mysqli, $sql );
				
				if ( !$result ) {
					throw new Exception( $sql );
				}
			
				$this->commit();
			}
		
		} catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
		
		$this->dbDisConnect();
		return $value[ "id" ];
	}
	
	public function supprimer( $id, $debug=false ) {
		$this->dbConnect();
		$this->begin();
	
		try {
			
			// ---- Chargement de la catégorie ----- //
			$data = $this->load( $id, $debug );
			//print_pre( $data );
			
			// ---- Diminution automatique de l'ordre d'affichage des catégories suivantes
			$this->dbConnect();
			$sql = "UPDATE `catproduct` SET";
			$sql .= " ordre_affichage = ordre_affichage - 1";
			$sql .= " WHERE id_parent = " . $data[ 0 ][ "id_parent" ];
			$sql .= " AND ordre_affichage > " . $data[ 0 ][ "ordre_affichage" ];
			if ( $debug ) echo $sql . "<br>";
			else $result = mysqli_query( $this->mysqli, $sql );
			
			// ---- Suppression de la catégorie ---- //
			$sql = "DELETE FROM `catproduct`";
			$sql .= " WHERE `id`=" . $id . ";";
			
			if ( $debug ) echo $sql . "<br>";
			else {
				$result = mysqli_query( $this->mysqli, $sql );
				if (!$result) {
					throw new Exception($sql);
				}
				
				$this->commit();
			}
	
		} catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
	
	
		$this->dbDisConnect();
	}
	
	function setChamp( $id=0, $champ, $valeur=0, $debug=false ) {
		$this->dbConnect();
		$this->begin();
		
		$requete = "UPDATE `catproduct` SET";
		$requete .= " " . $champ . " = '" . $this->traiter_champ( $valeur ) . "'";
		$requete .= " WHERE id = " . $id;
		if ( $debug ) echo $requete . "<br>";
		else {
			$result = mysqli_query( $this->mysqli, $requete );
		
			if ( !$result ) {
				$this->rollback();
				throw new Exception( 'Erreur Mysql valideCommande sql = : ' . $requete );
			}
			
			$this->commit();
			$this->dbDisConnect();
		}
	}
	
	function traiter_champ( $texte='' ) {
		$texte = trim( $texte );
		$texte = addslashes( $texte );
		//$texte = utf8_decode( $texte );
		
		return $texte;
	}
	
	public function getListe( $tab=array(), $debug=false ) {
		$this->dbConnect();
		
		$champ_souhaite = ( $tab[ "champ" ] != '' ) ? $tab[ "champ" ] : "*";
		$requete = "SELECT " . $champ_souhaite . " FROM `catproduct`";
		
		if ( $tab[ "where" ] == '' ) {
			$requete .= " WHERE id > 0";
			
			if ( !empty( $tab ) ) {
				foreach( $tab as $champ => $val ) {
					if ( $champ != "champ" && $champ != "order_by" && $champ != "sens" )
						$requete .= " AND " . $champ . " = '" . addslashes( $val ) . "'";
				}
			}
			
			$order_by = ( $tab[ "order_by" ] != "" ) ? $tab[ "order_by" ] : "ordre_affichage";
			$sens = ( $tab[ "sens" ] != "" ) ? $tab[ "sens" ] : "ASC";
			$requete .= " ORDER BY " . $order_by . " " . $sens;
		}
		else $requete .= $tab[ "where" ];
		
		if ( $debug ) echo $requete . "<br>";
		$result = mysqli_query( $this->mysqli, $requete );
		
		while( $row = mysqli_fetch_assoc( $result ) ) {
			$new_array[] = $row;
		}
		$this->dbDisConnect();
		return $new_array;
	}
	
	public function getNbCatByLevel( $id_parent=0, $debug=false ) {
		//echo "--- level : " . $level . "<br>";
		$this->dbConnect();
		
		$sql = "SELECT COUNT(id) AS nb FROM `catproduct`
			WHERE `id_parent`=" . $id_parent . ";";
		
		if ( $debug ) echo $sql . "<br>";
		$result = mysqli_query( $this->mysqli, $sql );
		
		$row = mysqli_fetch_assoc( $result );
		
		$this->dbDisConnect();
		return $row[ "nb" ];
	}
	
	public function afficherLigneAdmin( $id=0, $debug=false ) {
		$datas = $this->load( $id, $debug );
		$_categorie = $datas[ 0 ];
		//print_pre( $_categorie );
		
		if ( !empty( $_categorie ) ) {
			$decalage = ( $_categorie[ "id_parent" ] == 0 ) ? "" : "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
			$classe_affichage = ( $_categorie[ "id_parent" ] == 0 ) ? 'info' : 'success';
			$btn_visualisation = ( $_categorie[ "id_parent" ] == 0 ) 
				? "&nbsp;" 
				: "<a href='/admin/produit/liste.php?id_categorie=" . $_categorie[ "id" ] . "'><img src='/admin/img/eye.png' width='30' title='Voir tous les produits de cette catégorie' ></a>";
			
			echo "<tr class='" . $classe_affichage . "'>\n";
			echo "	<td>\n";
			
			// ---- Positionnement des catégories sur celles de niveau 0 ---- //
			if ( $_categorie[ "id_parent" ] == 0 ) {
				//echo "--- " . $value[ "ordre" ] . "<br>";
				
				$nb_cat = $this->getNbCatByLevel( $_categorie[ "id_parent" ], false );
				echo "		<select id='" . $_categorie[ "id" ] . "' class='select_categorie'>\n";
				
				for( $cpt = 1; $cpt <= $nb_cat; $cpt++ ) {
					$selected = ( $cpt == $_categorie[ "ordre_affichage" ] ) ? "selected" : "";
					echo "		<option value='" . $cpt . "' " . $selected . ">" . $cpt . "</option>\n";
				}
				
				echo "		</select>&nbsp;&nbsp;\n";
			}
			// -------------------------------------------------------------- //
			
			echo "		" . $decalage . "<a href='/admin/categorie/liste.php?id=" . $_categorie[ "id" ] . "'>" . $_categorie[ "nom" ] . "</a>\n";
			echo "	</td>\n";
			echo "	<td align='center'>" . $btn_visualisation . "</td>\n";
			echo "	<td><a href='/admin/categorie/liste.php?id=" . $_categorie[ "id" ] . "'><img src='/admin/img/modif.png' width='30' alt='Modifier' ></a></td>\n";
				
			echo "	<td>\n";
			echo "		<div style='display: none;' class='supp" . $_categorie[ "id" ] . " alert alert-warning alert-dismissible fade in' role='alert'>\n";
			echo "			<button type='button' class='close' aria-label='Close' onclick=\"$('.supp" . $_categorie[ "id" ] . "').css('display', 'none');\"><span aria-hidden='true'>×</span></button>\n";
			echo "			<strong>Voulez vous vraiment supprimer ?</strong>\n";
			echo "			<button type='button' class='btn btn-danger' onclick=\"location.href='/admin/categorie/traitement.php?action=delete&id=" . $_categorie[ "id" ] . "'\">Oui !</button>\n";
			echo "	 	</div>\n";
			echo "		<img src='/admin/img/del.png' width='20' alt='Supprimer' onclick=\"$('.supp" . $_categorie[ "id" ] . "').css('display', 'block');\"> \n";
			echo "	</td>\n";
			echo "</tr>\n";
		}
	}
	
}