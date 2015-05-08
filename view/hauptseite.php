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
	<nav>
		<a href="hauptseite.html" id="start_button">Hauptseite</a>
		<input type="text" placeholder="Suchhashtag" id="suchehashtag">
		<span id="benutzername">
			<?php //echo (new Kontext())->getBenutzer()->getNickname() ?>
			Nickname
		</span>
		<a href="abgemeldet.html" id="abmelden_button">Abmelden</a>
	</nav>
	
	<main>
		<table>
			<tbody>
				<tr>
					<td>
						<textarea>Ihre Nachricht</textarea>
						<button>Abschicken</button>
						<p>evtl. Wolke</p>
					</td>
					<td>
						<p>Nachricht 1</p>
						<p>Nachricht 2</p>
						<p>Nachricht 3</p>
					</td>					
				</tr>
			</tbody>
		</table>
	</main>
<body>
	
</body>
</html>