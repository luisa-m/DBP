<?php  

require_once('fach/Nachricht.php');
$hashtags = Nachricht::sucheNachHashtag("Hallo");
echo json_encode($hashtags);


hashtagSuche();


?>