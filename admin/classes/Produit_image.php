<?php
require_once("StorageManager.php");
class Produit_image extends StorageManager {

	public function __construct(){

	}
	
	public function getListe( $tab=array(), $debug=false ){
		$this->dbConnect();
		$requete = "SELECT * FROM `product_image`" ;
		
		if ( $tab[ "where" ] == '' ) {
			$requete .= " WHERE num_image > 0";
			
			if ( !empty( $tab ) ) {
				foreach( $tab as $champ => $val ) {
					if ( $champ != "champ" && $champ != "order_by" && $champ != "sens" )
						$requete .= " AND " . $champ . " = '" . addslashes( $val ) . "'";
				}
			}
			
			$order_by = ( $tab[ "order_by" ] != "" ) ? $tab[ "order_by" ] : "num_image";
			$sens = ( $tab[ "sens" ] != "" ) ? $tab[ "sens" ] : "ASC";
			$requete .= " ORDER BY " . $order_by . " " . $sens;
		}
		else $requete .= $tab[ "where" ];
		
		if ( $debug ) print_r( $requete );
		
		$new_array = null;
		$result = mysqli_query( $this->mysqli, $requete );
		while( $row = mysqli_fetch_assoc( $result ) ) {
			$new_array[] = $row;
		}
		$this->dbDisConnect();
		return $new_array;
	}
	
	public function load( $num_image=0, $debug=false ) {
		//if ( $debug ) echo "num_image : " . $num_image . "<br>";
		
		$this->dbConnect();
		$requete = "SELECT * FROM `product_image` 
			WHERE num_image = " . intval( $num_image );
		if ( $debug ) echo $requete . "<br>";
		$result = mysqli_query( $this->mysqli, $requete );
		
		$new_array = null;
		while( $row = mysqli_fetch_assoc( $result ) ){
			$new_array[] = $row;
		}
		$this->dbDisConnect();
		return $new_array;
	}
	
	public function getImageDefaut( $num_produit=0, $debug=false ) {
		//if ( $debug ) echo "num_image : " . $num_image . "<br>";
		
		$this->dbConnect();
		$requete = "SELECT * FROM `product_image` 
			WHERE num_produit = " . intval( $num_produit ) . "
			AND defaut = 'oui'";
		if ( $debug ) echo $requete . "<br>";
		$result = mysqli_query( $this->mysqli, $requete );
		
		$row = mysqli_fetch_assoc( $result );
		$this->dbDisConnect();
		return $row;
	}
	
	public function ajouter( $value, $debug=false ) {
		$this->dbConnect();
		$this->begin();
		
		try {
			( $value[ 'defaut' ] == 'oui' ) ? $defaut = "oui" : $defaut = "non";
			
			$sql = "INSERT INTO `product_image`
				( `num_produit`, `fichier`, `defaut` )
				VALUES (
				". intval( $value[ "num_produit" ] ) .",
				'". addslashes( $value[ "fichier" ] ) ."',
				'". $defaut ."'
			);";
			if ( $debug ) echo $sql . "<br>";
			else {
				$result = mysqli_query( $this->mysqli, $sql );
				
				if ( !$result ) {
					throw new Exception( $sql );
				}
				$id_record = mysqli_insert_id( $this->mysqli );
			}
			
			$this->commit();
		
		} catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
		$this->dbDisConnect();
		return $id_record;
	}
	
	public function supprimer( $num_image=0, $debug=false ) {
		if ( intval( $num_image ) <= 0 ) return false;
	
		// ---- Chargement de l'image ---------------- //
		$data = $this->load( $num_image, $debug );
		//print_pre( $data );
		
		// ---- Suppression physique des fichiers ---- //
		if ( 1 == 1 ) {
			
			$fichier_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . "/photos/produit/accueil" . $data[ 0 ][ "fichier" ];
			if ( file_exists( $fichier_a_supprimer ) ) {
				if ( $debug ) echo "On supprime " . $fichier_a_supprimer . "<br>\n";
				if ( !$debug ) unlink( $fichier_a_supprimer );
			}
			$fichier_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . "/photos/produit/vignette" . $data[ 0 ][ "fichier" ];
			if ( file_exists( $fichier_a_supprimer ) ) {
				if ( $debug ) echo "On supprime " . $fichier_a_supprimer . "<br>\n";
				if ( !$debug ) unlink( $fichier_a_supprimer );
			}
			$fichier_a_supprimer = $_SERVER['DOCUMENT_ROOT'] . "/photos/produit/normale" . $data[ 0 ][ "fichier" ];
			if ( file_exists( $fichier_a_supprimer ) ) {
				if ( $debug ) echo "On supprime " . $fichier_a_supprimer . "<br>\n";
				if ( !$debug ) unlink( $fichier_a_supprimer );
			}
			
		}
		// ------------------------------------------- //
		
		$this->dbConnect();
		$this->begin();
		try {
			$sql = "DELETE FROM `product_image` WHERE `num_image` = " . intval( $num_image );
			if ( $debug ) echo $sql . "<br>";
			else {
				$result = mysqli_query( $this->mysqli, $sql );
					
				if ( !$result ) {
					throw new Exception($sql);
				}
			}
	
			$this->commit();
	
		}
		catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
	
		$this->dbDisConnect();
	}
	
	public function setChamp( $champ, $valeur=0, $num_image=0, $debug=false ) {
		if ( intval( $num_image ) <= 0 )  return false;
		
		$this->dbConnect();
		$this->begin();
		try {
			$requete = "UPDATE `product_image` SET";
			$requete .= " " . $champ . " = '" . $this->traiter_champ( $valeur ) . "'";
			$requete .= " WHERE `num_image`=" . $num_image . ";";
			$result = mysqli_query( $this->mysqli, $requete );
			
			if ( $debug ) echo $requete . "<br>";
			else {
				if ( !$result ) {
					throw new Exception( $requete );
				}
		
				$this->commit();
				return false;
			}
			
			return $num_image;
	
		} catch (Exception $e) {
			$this->rollback();
			throw new Exception("Erreur Mysql ". $e->getMessage());
			return "errrrrrrooooOOor";
		}
	
	
		$this->dbDisConnect();
	}
	
	private function traiter_champ( $texte='' ) {
		$texte = trim( $texte );
		$texte = addslashes( $texte );
		$texte = utf8_decode( $texte );
		
		return $texte;
	}
}