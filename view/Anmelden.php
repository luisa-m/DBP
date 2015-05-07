 <!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Bitte loggen Sie sich ein</title>
	<link rel="stylesheet" type="text/css" href="Style.css">
</head>
<body>
<div align=center>
	<h1>Willkommen bei Twitter 2.0 <Br> Die neusten Updates für dich auf einem Blick</h1>
	<table class="t1">
		<tr">
				<td>Nickname</td>
				<td><input required type="text" name="nickname" placeholder="Nickname" value="<?php if(!empty($_POST["nickname"])){echo $_POST["nickname"];}?>"/></td>
		</tr>
		<tr>
				<td>Passwort</td>
				<td><input required type="password" name="password" placeholder="Passwort"/></td>
		</tr>
	</table>
	<br>
	<input type="submit" name="submit" value="Einloggen">
	<br>
	<p><font color="white">Noch nicht Mitglied der Community? <br><a href="Registrieren.php" style="color: white">Jetzt registrieren</a></font></p>
</div>
</body>
</html>