<?

	// ---- D�finition des constantes du site ------------------------ //
	//echo $_SERVER[ "DOCUMENT_ROOT" ] . "<br>";
	switch( $_SERVER[ "DOCUMENT_ROOT" ] ) {
		
		// ---- Serveur local Franck -------- //
		case "/var/www/sfnettoyagenew" :
			$localhost = "localhost";
			$dbname = "sfnettoyagenew";
			$user = "global";
			$mdp = "global";
			break;
		
		// ---- Serveur PRE-PROD ------------ //
		case "/home/web/sfnettoyagenew" :
			$localhost = "localhost";
			$dbname = "sfnettoyagenew";
			$user = "sfnettoyagenew";
			$mdp = "sfnettoyagenew33";
			break;
		
		// ---- Serveur PROD ---------------- //
		case "/var/www/sfnettoyagenew" :
			$localhost = "localhost";
			$dbname = "sfnettoyagenew";
			$user = "sfnettoyagenew";
			$mdp = "sfnettoyagenew33";
			break;
		default:
		    $localhost = "localhost";
		    $dbname = "sfnettoyagenew";
		    $user = "sfnettoyagenew";
		    $mdp = "sfnettoyagenew33";
		    break;
	}
		
	define( "DBHOST",	$localhost );
	define( "DBNAME",	$dbname );
	define( "DBUSER",	$user );
	define( "DBPASSWD", $mdp );
	
	define( "MAILCUSTOMER", 	"NePasRepondre@sfnettoyage.com" );
	define( "MAILNAMECUSTOMER", "Modul Ouest" );
	define( "URLSITEDEFAULT", 	"http://www.sfnettoyage.com/" );
	define( "FACEBOOK_LINK", 	"https://www.facebook.com/sfnettoyage" );
	define( "DAILYMOTION_LINK", "http://www.dailymotion.com/video/x43ijxj" );
	
	// ---- Mail d'envoi
	define( "MAIL_TEST", 	"" ); // Si rempli alors cette valeur ser utilis�e pour les diff�rents envois de mails
	define( "MAIL_CONTACT", "contact@sfnettoyage.com" );
	define( "MAIL_BCC", 	"xav335@hotmail.com,fjavi.gonzalez@gmail.com,jav_gonz@yahoo.com" );
?>