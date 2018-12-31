<? 
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require 'admin/classes/Contact.php';
	require 'admin/classes/utils.php';
	session_start();
	
	$debug = false;
	
	$contact = new Contact();
	
	$mon_action = $_POST[ "mon_action" ];
	$anti_spam = $_POST[ "as" ];
	//print_pre( $_POST );
	
	$affichage_success = "wait";
	$affichage_erreur = "wait";
	
	// ---- Post du formulaire ------------------------------- //
	if ( $mon_action == "poster" && $anti_spam == '' ) {
		if ( $debug ) echo "On poste...<br>";
		
		// ---- Enregistrement dans "contact" -------- //
		if ( 1 == 1 ) {
			$num_contact = $contact->isContact( $_POST[ "email" ], $debug );
			
			unset( $val );
			$val[ "id"] = $num_contact;
			$val[ "firstname"] = $_POST[ "prenom" ];
			$val[ "name"] = $_POST[ "nom" ];
			$val[ "adresse"] = $_POST[ "adresse" ];
			$val[ "cp"] = $_POST[ "cp" ];
			$val[ "ville"] = $_POST[ "ville" ];
			$val[ "email"] = $_POST[ "email" ];
			$val[ "tel"] = $_POST[ "tel" ];
			$val[ "message"] = $_POST[ "message" ];
			$val[ "newsletter"] = $_POST[ "newsletter" ];
			$val[ "fromcontact"] = "on";
			if ( $num_contact <= 0 ) $contact->contactAdd( $val, $debug );
			else $contact->contactModify( $val, $debug );
		}
		// ------------------------------------------- //
		
		// ---- Envoi du mail à l'admin -------------- //
		if ( 1 == 1 ) {
			$entete = "From:" . $_POST[ "nom" ] . " <" .  $_POST[ "email" ] . ">\n";
			$entete .= "MIME-version: 1.0\n";
			$entete .= "Content-type: text/html; charset= iso-8859-1\n";
			$entete .= "Bcc:" . MAIL_BCC . "\n";
			//echo "Entete :<br>" . $entete . "<br><br>";
			
			$sujet = utf8_decode( "Prise de contact" );
			
			//$_to = "franck_langleron@hotmail.com";
			$_to = ( MAIL_TEST != '' )
		    	? MAIL_TEST
		    	: MAIL_CONTACT;
			//echo "Envoi du message à : " . $_to . "<br><br>";
			
			$message = "Bonjour,<br><br>";
			$message .= "La personne suivante a rempli le formulaire de contact de votre site :<br>";
			$message .= "Nom : <b>" . $_POST[ "nom" ] . " " . $_POST[ "prenom" ] . "</b><br>";
			$message .= "E-mail / Téléphone : <b>" . $_POST[ "email" ] . " / " . $_POST[ "tel" ] . "</b><br>";
			$message .= "Adresse postale : <b>" . $_POST[ "adresse" ] . ", " . $_POST[ "cp" ] . " " . $_POST[ "ville" ] . "</b><br>";
			$message .= "Message : <br><i>" . nl2br( $_POST[ "message" ] ) . "</i><br><br>";
			$message .= "Cordialement.";
			$message = utf8_decode( $message );
			if ( $debug ) echo $message;
			
			if ( !$debug ) $retour = mail( $_to, $sujet, stripslashes( $message ), $entete );
			//exit();
			
			$affichage_success = ( $retour ) ? "" : "wait";
			$affichage_erreur = ( $retour ) ? "wait" : "";
		}
		// ------------------------------------------- //
		//exit();
		
	}
	// ------------------------------------------------------- //
?>

<!doctype html>
<html class="no-js" lang="fr">
	<head>
		<title>Contactez Modul-Ouest</title>
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/header.php" ); ?>
	</head>
	<body class="page">
	
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/top.php" ); ?>
		
		<div class="row contenu">
			
			<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/rappel.php" ); ?>
			
			<div class="large-12 columns">
				
				<h1>Contactez Modul-Ouest</h1>
				
			</div>
			
			<div id="div_success" class="large-12 medium-12 small-12 columns <?=$affichage_success?>">
				<h3>Félicitations!</h3>
				<p>Votre message a été envoyé avec succès!</p>
			</div>
			
			<div id="div_erreur" class="large-12 medium-12 small-12 columns <?=$affichage_erreur?>">
				<h3>Erreur!</h3>
				<p>
					Une erreur s'est produite lors de l'envoi de votre message.<br>
					Veuillez essayer ultérieurement.
				</p>
			</div>
			
			<div class="large-4 medium-6 small-12 columns">
				<h3>MODUL-OUEST</h3>
				<p>SARL 40141433900036</p>
				<p>
					Za Tabernotte Sud<br/>
					33370 YVRAC
				</p>
				<p>
					Tél. 05 56 74 25 25<br/>
					Fax 05 56 74 28 28
				</p>
				<p>Email : commercial(at)modul-ouest.com</p>
			</div>
			<div class="large-8 medium-6 small-12 columns">
				<form id="formulaire" class="row contact" method="post" action="contact.php">
					<input type="hidden" name="mon_action" id="mon_action" value="" />
					<input type="hidden" name="as" value="" />
					
					<div class="large-6 medium-12 columns">
						<input type="text" name="prenom" id="prenom" placeholder="Votre prénom" />						
					</div>
					<div class="large-6 medium-12 columns">
						<input type="text" name="nom" id="nom" placeholder="Votre nom" />
					</div>
					<div class="large-12 columns">
						<input type="text" name="adresse" id="adresse" placeholder="Votre adresse">
					</div>
					<div class="large-4 medium-5 small-12 columns">
						<input type="text" name="cp" id="cp" placeholder="Code postal" />						
					</div>
					<div class="large-8 medium-7 small-12 columns">
						<input type="text" name="ville" id="ville" placeholder="Ville" />
					</div>
					<div class="large-6 medium-12 columns">
						<input type="tel" name="tel" id="tel" placeholder="Votre n° de téléphone" />						
					</div>
					<div class="large-6 medium-12 columns">
						<input type="email" name="email" id="email" placeholder="Votre e-mail" />
					</div>
					<div class="large-12 columns">
						<textarea name="message" id="message" placeholder="Votre message"></textarea>
					</div>
					<div class="large-12 columns">
						<input type="submit" value="Envoyer" />
					</div>
					<div class="large-12 columns">
						<p class="grey">
							Conformément à la loi Informatique et Libertés en date du 6 janvier 1978, vous disposez d'un droit d'accès, de rectification, de modification et de suppression des données qui vous concernent. Vous pouvez exercer ce droit en nous envoyant un courrier électronique ou postal.
						</p>
					</div>
				</form>
			</div>
			
		</div>
		
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/footer.php" ); ?>
		<? include( $_SERVER[ "DOCUMENT_ROOT" ] . "/scripts.php" ); ?>
		
		<script>
			$(document).ready(function(){
				
				$('.menu li:last-child').addClass('active');
				
				// ---- Validation du formulaire ---------------------------- //
				if ( 1 == 1 ) {
					
					function initialiser() {
						$( "#nom" ).removeClass( "erreur" );
						$( "#prenom" ).removeClass( "erreur" );
						$( "#email" ).removeClass( "erreur" );
						$( "#tel" ).removeClass( "erreur" );
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
						
						if ( $.trim( $( "#prenom" ).val() ) == '' ) {
							erreur = 1;
							$( "#prenom" ).addClass( "erreur" );
						}
						
						if ( $.trim( $( "#email" ).val() ) == '' ) {
							erreur = 1;
							$( "#email" ).addClass( "erreur" );
						}
						else if ( !checkEmail( $.trim( $( "#email" ).val() ) ) ) {
							erreur = 1;
							$( "#email" ).addClass( "erreur" );
						}
						
						if ( $.trim( $( "#tel" ).val() ) == '' ) {
							erreur = 1;
							$( "#tel" ).addClass( "erreur" );
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
