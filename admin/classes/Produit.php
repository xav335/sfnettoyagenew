<?php
require_once("StorageManager.php");
require_once("Categorie.php");

class Produit extends StorageManager {

	public function __construct( $id='', $debug=false ){
		if ( $id != '' ) return $this->load( $id, $debug );
	}
	
	public function load( $id, $debug=false ){
		$this->dbConnect();
		
		if ( intval( $id ) <= 0 ) return array();
		$new_array = null;
		
		$requete = "SELECT * FROM `product` WHERE id = " . $id ;
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
		$val[ "id_categorie" ] = intval( $post[ "id_categorie" ] );
		$val[ "nom" ] = addslashes( $post[ "nom" ] );
		$val[ "description" ] = addslashes( $post[ "description" ] );
		$val[ "fichier_pdf" ] = addslashes( $post[ "fichier_pdf" ] );
		$val[ "accueil" ] = ( $post[ "accueil" ] == '1' ) ? '1' : '0';
		$val[ "online" ] = ( $post[ "online" ] == '1' ) ? '1' : '0';
		
		// ---- Modification -------- //
		if ( $modification ) {
			$id = $this->modifier( $val, $debug );
		}
		
		// ---- Ajout --------------- //
		else {
			$id = $this->ajouter( $val, $debug );
		}
		
		return $id;
	}
	
	public function ajouter( $value, $debug=false ) {
		$this->dbConnect();
		$this->begin();
		
		try {
			$sql = "INSERT INTO  `product`
				( `id_categorie`, `nom`, `description`, `fichier_pdf`, `accueil`, `online` )
				VALUES (
				'" . $value[ "id_categorie" ] . "',
				'" . $value[ "nom" ] . "',
				'" . $value[ "description" ] ."',
				'" . $value[ "fichier_pdf" ] ."',
				'" . $value[ "accueil" ] . "',
				'" . $value[ "online" ] . "'
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
			$sql = "UPDATE  .`product` SET";
			$sql .= " `id_categorie` = '" . $value[ "id_categorie" ] . "',";
			$sql .= " `nom` = '" . $value[ "nom" ] . "',";
			$sql .= " `description` = '" . $value[ "description" ] . "',";
			if ( $value[ "fichier_pdf" ] != '' ) $sql .= " `fichier_pdf` = '" . $value[ "fichier_pdf" ] . "',";
			$sql .= " `accueil` = '" . $value[ "accueil" ] . "',";
			$sql .= " `online` = '" . $value[ "online" ] . "'";
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
			
			// ---- Chargement du produit ---------- //
			//$data = $this->load( $id, $debug );
			//print_pre( $data );
			
			// ---- Suppression de la cat�gorie ---- //
			$sql = "DELETE FROM `product`";
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
	
	public function setChamp( $champ, $valeur=0, $id=0, $debug=false ) {
		if ( intval( $id ) <= 0 )  return false;
		
		$this->dbConnect();
		$this->begin();
		try {
			$requete = "UPDATE `product` SET";
			$requete .= " " . $champ . " = '" . $this->traiter_champ( $valeur ) . "'";
			$requete .= " WHERE `id`=" . $id . ";";
			$result = mysqli_query( $this->mysqli, $requete );
			
			if ( $debug ) echo $requete . "<br>";
			else {
				if ( !$result ) {
					throw new Exception( $requete );
				}
		
				$this->commit();
				return false;
			}
			
			return $num_offre;
	
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
	
	public function getListe( $tab=array(), $debug=false ) {
		$this->dbConnect();
		
		$champ_souhaite = ( $tab[ "champ" ] != '' ) ? $tab[ "champ" ] : "*";
		$requete = "SELECT " . $champ_souhaite . " FROM `product`";
		
		if ( $tab[ "where" ] == '' ) {
			$requete .= " WHERE id > 0";
			
			if ( !empty( $tab ) ) {
				foreach( $tab as $champ => $val ) {
					if ( $champ != "champ" && $champ != "order_by" && $champ != "sens" )
						$requete .= " AND " . $champ . " = '" . addslashes( $val ) . "'";
				}
			}
			
			$order_by = ( $tab[ "order_by" ] != "" ) ? $tab[ "order_by" ] : "nom";
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
	
	public function getInfoProduit( $id_categorie=0, $id_produit=0, $debug=false ) {
		if ( $debug ) echo "--- id_categorie : " . $id_categorie . "<br>";
		if ( $debug ) echo "--- id_produit : " . $id_produit . "<br>";
		
		// ---- On recherche le 1ier produit � afficher ------- //
		if ( $id_produit == '' ) {
			$categorie = new Categorie();
			$produit_charge = false;
			
			// ---- Liste des cat�gories enfants ---------- //
			if ( 1 == 1 ) {
				unset( $recherche );
				$recherche[ "id_parent" ] = $id_categorie;
				$liste_categorie = $categorie->getListe( $recherche, $debug );
			}
			// -------------------------------------------- //
			
			// ---- On prend le 1ier produit dans la liste  //
			if ( !empty( $liste_categorie ) ) {
				foreach( $liste_categorie as $_categorie ) {
					
					// ---- Recherche des produits associ�s � cette sous cat�gorie ---- //
					unset( $recherche );
					$recherche[ "id_categorie" ] = $_categorie[ "id" ];
					$recherche[ "online" ] = '1';
					$liste_produit = $this->getListe( $recherche, $debug );
					// ---------------------------------------------------------------- //
					
					// ---- Affichage des produits ------------------------------------ //
					if ( !empty( $liste_produit ) ) {
						$id_produit = $liste_produit[ 0 ][ "id" ];
					}
					// ---------------------------------------------------------------- //
					
				}
			}
			// -------------------------------------------- //
			
		}
		// ---------------------------------------------------- //
		
		// ---- Produit renseign� --> On le charge ------------ //
		$data = $this->load( intval( $id_produit ), $debug );
		// ---------------------------------------------------- //
		
		return $data;
	}
	
}