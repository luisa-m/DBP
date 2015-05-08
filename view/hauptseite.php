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
<!-- <link rel="shortcut icon" type="image/x-icon" href="Hahn.jpg"> -->
<title>Kikeriki</title>
</head>
<body>
	<nav>
	<div id="nav_links">
		<a href="hauptseite.html" id="start_button">Hauptseite</a>
		<input type="text" placeholder="Suchhashtag" id="suchehashtag">
	</div>
	<div id="nav_rechts">
		<span id="benutzername">
			<?php echo (new Kontext())->getBenutzer()->getNickname() ?>
		</span>
		<a href="Anmelden.php" id="abmelden_button">Abmelden</a>
	</div>
	</nav>
	
	<main>
		<table id="table">
			<tbody>
				<tr>
					<td id="aktions_bereich">
						<textarea id="nachricht" placeholder="Ihre Nachricht"></textarea> <br>
						<button>Abschicken</button>
						<p>evtl. Wolke</p>
					</td>
					<td id="nachrichten_anzeige">
						<p>Nachricht 1</p>
						<p>Nachricht 2</p>
						<p>Nachricht 3</p>
					</td>					
				</tr>
			</tbody>
		</table>
	</main>
</body>
</html>