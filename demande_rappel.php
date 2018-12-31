<? 
	require( $_SERVER[ "DOCUMENT_ROOT" ] . "/inc/inc.config.php" );
	require 'admin/classes/utils.php';
	session_start();
	
	$debug = false;
	
	$mon_action = $_POST[ "mon_action" ];
	$anti_spam = $_POST[ "as" ];
	//print_pre( $_POST );
	
	// ---- Post du formulaire ------------------------------- //
	if ( $mon_action == "poster" && $anti_spam == '' ) {
		if ( $debug ) echo "On poste...<br>";
		
		// ---- Envoi du mail à l'admin -------------- //
		if ( 1 == 1 ) {
			$entete = "From:" . MAILNAMECUSTOMER . " <" . MAILCUSTOMER . ">\n";
			$entete .= "MIME-version: 1.0\n";
			$entete .= "Content-type: text/html; charset= iso-8859-1\n";
			$entete .= "Bcc:" . MAIL_BCC . "\n";
			//echo "Entete :<br>" . $entete . "<br><br>";
			
			$sujet = utf8_decode( "Demande de rappel" );
			
			//$_to = "franck_langleron@hotmail.com";
			$_to = ( MAIL_TEST != '' )
		    	? MAIL_TEST
		    	: MAIL_CONTACT;
			//echo "Envoi du message à : " . $_to . "<br><br>";
			
			$message = "Bonjour,<br><br>";
			$message .= "La personne suivante souhaite être rappelée au :<br>";
			$message .= "<b>" .$_POST[ "tel" ] . "</b><br><br>";
			$message .= "Cordialement.";
			$message = utf8_decode( $message );
			if ( $debug ) echo $message;
			
			if ( !$debug ) mail( $_to, $sujet, stripslashes( $message ), $entete );
			//exit();
		}
		// ------------------------------------------- //
		
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
				<h1>Demande de rappel</h1>
			</div>
				
			<div class="large-12 medium-12 small-12 columns">
				<h3>MODUL-OUEST</h3>
				<p>
					Pour une mise en relation immédiate et gratuite, veuillez saisir le numéro de téléphone où vous pouvez être joint immédiatement.
				</p>
				<form id="formulaire" class="row contact" method="post" action="demande_rappel.php">
					<input type="hidden" name="mon_action" id="mon_action" value="" />
					<input type="hidden" name="as" value="" />
					
					<div class="large-2 medium-12 columns">
						Téléphone :
					</div>
					<div class="large-3 medium-12 columns">
						<input type="tel" name="tel" id="tel" placeholder="Votre n° de téléphone" />						
					</div>
					<div class="large-7 medium-12 columns">
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
						$( "#tel" ).removeClass( "erreur" );
					}
					
					$( "#formulaire" ).submit(function() {
						//alert( "validation..." );
						var erreur = 0;
						initialiser();
						
						if ( $.trim( $( "#tel" ).val() ) == '' ) {
							erreur = 1;
							$( "#tel" ).addClass( "erreur" );
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
