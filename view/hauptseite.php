<?php 
require_once("../fach/Kontext.php");
require_once("../fach/Benutzer.php");
require_once("../fach/Nachricht.php");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="stylesheet.css">
<script type="text/javascript" src="script.js"></script>
<link rel="shortcut icon" type="image/x-icon" href="Icon.png">
<title>Kikeriki</title>
</head>
<body onload='zeigeTimeline("nachrichten_anzeige");zeigeGefolgte("gefolgte_anzeige");'>
	<nav>
	<div id="nav_links">
		<a href="hauptseite.php" id="start_button">Hauptseite</a>
		<input type="text" placeholder="Suchhashtag" id="suchehashtag" onkeyup="sucheingabe(this, event, 'nachrichten_anzeige');">
	</div>
	<div id="nav_rechts">
		<span id="benutzername">
			<?php echo (new Kontext())->getBenutzer()->getNickname() ?>
		</span>
		<a href="Anmelden.php" id="abmelden_button">Abmelden</a>
	</div>
	</nav>
	
	<main>
		
		<div id="aktions_bereich">
			<form>
				<textarea id="nachricht" placeholder="Ihre Nachricht"></textarea> <br>
				<button>Abschicken</button>
			</form>
			<div id="gefolgte_container">
				<div id="gefolgte_anzeige">
				</div>
				<input type="text" placeholder="Neuer Person folgen" onkeyup="folgenEingabe(this, event, 'gefolgte_anzeige');">
			</div>
		</div>
		<div id="nachrichten_anzeige">
			<p>Nachricht 1</p>
			<p>Nachricht 2</p>
			<p>Nachricht 3</p>
		</div>					
				
	</main>
</body>
</html>