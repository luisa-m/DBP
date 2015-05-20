<?php  
require_once('fach/Kontext.php');
$method = $_SERVER['REQUEST_METHOD'];
$path = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$kontext = new Kontext();
$benutzer = $kontext->getBenutzer();

// gefolgt/nachrichten
if($path[0] == "gefolgt" && $path[1] == "nachrichten")
{
	require_once('fach/Benutzer.php');
	$nachrichten = $benutzer->getGefolgteNachrichten();
	echo json_encode($nachrichten);
}

// gefolgt/benutzer
elseif($path[0] == "gefolgt" && $path[1] == "benutzer")
{
	require_once('fach/Benutzer.php');
	$follower = $benutzer->getGefolgte();
	echo json_encode($follower);	
}

// hashtag/...
elseif($path[0] == "hashtag")
{
	require_once('fach/Nachricht.php');
	$hashtags = Nachricht::sucheNachHashtag($path[1]);
	echo json_encode($hashtags);
}

// folgen/...
elseif($path[0] == "folgen")
{
	require_once('fach/Benutzer.php');
	try {
		$benutzer->folgen($path[1]);
		echo "+ok";
	} catch (Exception $e) {
		echo "-err ".$e->getMessage();
	}
}
?>