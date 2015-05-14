<?php 
require_once("../fach/Kontext.php");
require_once("../fach/Benutzer.php");
require_once("../fach/Nachricht.php");
$kontext = new Kontext();
if (!$kontext->isAngemeldet()){
	header("Location:Anmelden.php");
}
if(isset($_REQUEST["abschicken"]))
{
	$benutzer = $kontext->getBenutzer();
		try
		{
			$benutzer->schreibeNachricht($_REQUEST["nachricht"]);
		}
		catch(Exception $e)
		{
			$Fehlermeldung = "Es ist ein unerwarteter Fehler aufgetreten (" . $e.getMessage() . ")";
		}
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<link rel="stylesheet" type="text/css" href="stylesheet.css">
<script type="text/javascript" src="script.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="Icon.png">
<title>Kikeriki!</title>
</head>
<body onload='zeigeTimeline("nachrichten_anzeige");zeigeGefolgte("gefolgte_anzeige");'>
	<nav>
	<div id="nav_links">
		<a href='javascript:zeigeTimeline("nachrichten_anzeige");' id="start_button"></a>
		<input type="search" placeholder="Suche nach Hashtag" id="suchehashtag" onkeyup="sucheingabe(this, event, 'nachrichten_anzeige');">
	</div>
	<div id="nav_rechts">
		<span id="benutzername">
			<?php echo $kontext->getBenutzer()->getNickname() ?>
		</span>
		<a href="Anmelden.php?abmelden=1" id="abmelden_button">Abmelden</a>
	</div>
	</nav>
	
	<main>		
		<div id="aktions_bereich">
			<form  action="" method="post" id="nachricht_container">
				<textarea id="nachrichtenEingabe" name="nachricht" placeholder="Deine Nachricht"></textarea> <br>
				<input type="submit" name="abschicken" value="Abschicken">
			</form>
			<div id="gefolgte_container">
				<div id="gefolgte_header">Du folgst:</div>
				<div id="gefolgte_anzeige">
				</div>
				<input type="text" placeholder="Neuer Person folgen" onkeyup="folgenEingabe(this, event, 'gefolgte_anzeige');">
			</div>
		</div>
		<div id="haupt_bereich">
			<?php 
			if(isset($Fehlermeldung)){
			echo '<div class="fehlermeldung">' . $Fehlermeldung . '</div>';}
			?>
			<div id="nachrichten_anzeige">
			</div>
		</div>					
	</main>
</body>
</html>
