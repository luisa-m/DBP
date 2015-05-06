<?php  
$method = $_SERVER['REQUEST_METHOD'];
$path = explode('/', trim($_SERVER['PATH_INFO'], '/'));


if($path[0] == "gefolgt" && $path[1] == "nachrichten")
{
	//require_once('fach/Benutzer.php');
	//$nachrichten = Benutzer::XXXXX;
	//echo json_encode($nachrichten);
}
elseif($path[0] == "gefolgt" && $path[1] == " benutzer")
{
	//require_once('fach/Benutzer.php');
	//$follower = Benutzer::XXXXX;
	//echo json_encode($follower);	
}
elseif($path[0] == "hashtag")
{
	require_once('fach/Nachricht.php');
	$hashtags = Nachricht::sucheNachHashtag($path[1]);
	echo json_encode($hashtags);
}
?>