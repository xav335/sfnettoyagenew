<?
	include_once ( $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/utils.php" );
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Goldbook.php";
	require $_SERVER[ "DOCUMENT_ROOT" ] . "/admin/classes/Contact.php";
	
	$debug = false;
	$goldbook = new Goldbook();
	$contact = new Contact();
	
	$mon_action = $_POST[ "mon_action" ];
	$anti_spam = $_POST[ "as" ];
	//print_pre( $_POST );
	
	// ---- Post du commentaire ---------------------------- //
	if ( $mon_action == "poster" && $anti_spam == '' ) {
		if ( $debug ) echo "On poste...<br>";
		
		// ---- Enregistrement dans "goldbook" ------- //
		if ( 1 == 1 ) {
			unset( $val );
			$val[ "datepicker"] = date( "d/m/Y" );
			$val[ "name"] = $_POST[ "nom" ];
			$val[ "email"] = $_POST[ "email" ];
			$val[ "message"] = $_POST[ "message" ];
			$goldbook->goldbookAdd( $val, $debug );
		}
		// ------------------------------------------- //
		
		// ---- Enregistrement dans "contact" -------- //
		if ( 1 == 1 ) {
			$num_contact = $contact->isContact( $_POST[ "email" ], $debug );
			
			unset( $val );
			$val[ "id"] = $num_contact;
			$val[ "name"] = $_POST[ "nom" ];
			$val[ "email"] = $_POST[ "email" ];
			$val[ "message"] = $_POST[ "message" ];
			$val[ "newsletter"] = $_POST[ "newsletter" ];
			$val[ "fromgoldbook"] = "on";
			if ( $num_contact <= 0 ) $contact->contactAdd( $val, $debug );
			else $contact->contactModify( $val, $debug );
		}
		// ------------------------------------------- //
		
		// ---- Envoi du mail à l'admin -------------- //
		if ( 1 == 1 ) {
			$entete = "From:" . MAILNAMECUSTOMER . " <" . MAILCUSTOMER . ">\n";
			$entete .= "MIME-version: 1.0\n";
			$entete .= "Content-type: text/html; charset= iso-8859-1\n";
			$entete .= "Bcc:" . MAIL_BCC . "\n";
			//echo "Entete :<br>" . $entete . "<br><br>";
			
			$sujet = utf8_decode( "Nouveau commentaire" );
			
			//$_to = "franck_langleron@hotmail.com";
			$_to = ( MAIL_TEST != '' )
		    	? MAIL_TEST
		    	: MAIL_CONTACT;
			//echo "Envoi du message à : " . $_to . "<br><br>";
			
			$message = "Bonjour,<br><br>";
			$message .= "La personne suivante a laissé un commentaire de votre site :<br>";
			$message .= "Nom : <b>" . $_POST[ "nom" ] . "</b><br>";
			$message .= "E-mail : <b>" . $_POST[ "email" ] . "</b><br>";
			$message .= "Message : <br><i>" . nl2br( $_POST[ "message" ] ) . "</i><br><br>";
			$message .= "Cordialement.";
			$message = utf8_decode( $message );
			if ( $debug ) echo $message;
			
			if ( !$debug ) mail( $_to, $sujet, stripslashes( $message ), $entete );
			//exit();
		}
		// ------------------------------------------- //
		
	}
	// ----------------------------------------------------- //
	
	// ---- Liste des commentaires en ligne ---- //
	$liste_commentaire = $goldbook->goldbookValidGet( $debug );
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<title>Livre d'or de SFnettoyage.com</title>
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/header.php" ); ?>
	</head>
<body class="page">

	<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/top.php" ); ?>
	
	<div class="row contenu">
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/rappel.php" ); ?>

		<div class="large-12 columns">
			<h1>Notre livre d'or</h1>
		</div>
		
		<?
		// ---- Affichage des commentaires validés ------ //
		if ( !empty( $liste_commentaire ) ) {
			$cpt = 1;
			foreach( $liste_commentaire as $_commentaire ) {
				echo "<div class='row temoignage'>\n";
				echo "	<div class='large-12 columns'>\n";
				echo "		<h3>Témoignage de " . $_commentaire[ "nom" ] . "</h3>\n";
				echo "		<p>" . nl2br( $_commentaire[ "message" ] ) . "</p>\n";
				echo "	</div>\n";
				echo "</div>\n";
				
				$cpt++;
			}
		}
		// ---------------------------------------------- //
		?>
		
		<!-- Inscription Témoignage -->
		<div class="row inscription">
			<form id="formulaire" method="post" action="livre-dor.php">
				<input type="hidden" name="mon_action" id="mon_action" value="" />
				<input type="hidden" name="as" value="" />
				
				<h3>Ajouter un témoignage</h3>
				<div class="large-6 medium-6 small-12 columns">
					<input type="text" name="nom" id="nom" placeholder="Votre nom" />
					<input type="text" name="prenom" id="prenom" placeholder="Votre prénom" />
					<input type="email" name="email" id="email" placeholder="Votre e-mail" />
				</div>
				<div class="large-6 medium-6 small-12 columns">
					<textarea name="message" id="message" placeholder="Votre témoignage ici"></textarea>
				</div>
				<div class="large-12 columns">
					<input type="submit" value="Témoigner" />
				</div>
			</form>
		</div>
		
	</div>
	
	<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/footer.php" ); ?>
	<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/scripts.php" ); ?>
	
	<script>
		
		$(document).ready(function(){
			$('.menu li:nth-child(4)').addClass('active');
			
			// ---- Validation du formulaire ---------------------------- //
			if ( 1 == 1 ) {
				
				function initialiser() {
					$( "#nom" ).removeClass( "erreur" );
					$( "#email" ).removeClass( "erreur" );
					$( "#message" ).removeClass( "erreur" );
				}
				
				function checkEmail( adr ) {
					if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(adr)) {
							return (true);
					}
					return (false);
				}
				
				$( "#formulaire" ).submit(function() {
					//alert( "validation..." );
					var erreur = 0;
					initialiser();
					
					if ( $.trim( $( "#nom" ).val() ) == '' ) {
						erreur = 1;
						$( "#nom" ).addClass( "erreur" );
					}
					
					if ( $.trim( $( "#email" ).val() ) == '' ) {
						erreur = 1;
						$( "#email" ).addClass( "erreur" );
					}
					else if ( !checkEmail( $.trim( $( "#email" ).val() ) ) ) {
						erreur = 1;
						$( "#email" ).addClass( "erreur" );
					}
					
					if ( $.trim( $( "#message" ).val() ) == '' ) {
						erreur = 1;
						$( "#message" ).addClass( "erreur" );
					}
					
					if ( erreur == 0 ) $( "#mon_action" ).val( "poster" );
					return ( erreur == 0 ) ? true : false;
				});
			}
			// ---------------------------------------------------------- //
		});
		
	</script>
	
</body>
</html>
