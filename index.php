<?php
// Weiterleitung auf Hauptseite, falls angemeldet, sonst auf Anmelden-Seite
require_once("fach/Kontext.php");
$kontext = new Kontext();
if ($kontext->isAngemeldet()){
	header("Location: view/hauptseite.php");
} else {
	header("Location: view/Anmelden.php");
}
?>