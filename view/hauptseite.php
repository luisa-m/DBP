<?php 
require_once("../fach/Kontext.php");
require_once("../fach/Benutzer.php");
require_once("../fach/Nachricht.php");

if(isset($_REQUEST["abschicken"]))
{
	$benutzer = (new Kontext())->getBenutzer();
		try
		{
			$benutzer->schreibeNachricht($_REQUEST["nachricht"]);
			header("location:Hauptseite.php");
		}
		catch(Exception $e)
		{
			$Fehlermeldung = "Es ist ein unerwarteter Fehler aufgetreten (" . $e.getMessage() . ")";
		}
}

if(!isset($_REQUEST["abschicken"]) || isset($Fehlermeldung))
{
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
<body onload='zeigeTimeline("nachrichten_anzeige")';>
	<nav>
	<div id="nav_links">
		<a href="hauptseite.html" id="start_button">Hauptseite</a>
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
		<table id="table">
			<tbody>
				<tr>
				 <form  action="" method="post">
					<td id="aktions_bereich">
						<textarea id="nachrichtenEingabe" name="nachricht" placeholder="Ihre Nachricht"></textarea> <br>
						<input type="submit" name="abschicken" value="Abschicken">
						<p>evtl. Wolke</p>
					</td>
					</form>
					<?php 
					if(isset($Fehlermeldung)){
					echo '<div class="fehlermeldung">' . $Fehlermeldung . '</div>';}
					?>
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
<?php }?>