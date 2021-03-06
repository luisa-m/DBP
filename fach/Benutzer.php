<?php
class Benutzer implements JsonSerializable {
	
	private $id;
	
	/**
	 * Erzeugt ein neues Objekt vom Typ Benutzer.
	 * @param String $id
	 */
	public function __construct($id){
		$this->id = $id;
		
		require_once("/../hilf/db_helper.php");
		$dbh = db_connect();
		$stmt = $dbh->prepare("SELECT Nickname, Vorname, Nachname, Passwort FROM Benutzer WHERE nickname = :ID");
		$stmt->bindParam(':ID', htmlentities($id));
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->nickname = $res["Nickname"];
		$this->vorname = $res["Vorname"];
		$this->nachname = $res["Nachname"];
		$this->passwort = $res["Passwort"];
	}
	
	/**
	 * Gibt den Nicknamen des Benutzers zurück.
	 * @return String Nickname
	 */
	public function getNickname(){
		return $this->nickname;
	}
	
	/**
	 * Gibt den Vornamen des Benutzers zurück.
	 * @return String Vorname
	 */
	public function getVorname(){
		return $this->vorname;
	}
	
	/**
	 * Gibt den Nachnamen des Benutzers zurück.
	 * @return String Nachname
	 */
	public function getNachname(){
		return $this->nachname;
	}
	
	/**
	 * Prüft, ob das eingegebene Passwort korrekt ist.
	 * @param String $pw Passwort des Benutzers 
	 * @return boolean True = Passwort ist korrekt; False = Passwort ist nicht korrekt.
	 */
	public function pruefePasswort($pw){
		 
		return (hash("sha256", $pw) == $this->passwort);
	}
	
	/**
	 * Gibt die ID's der Benutzer, denen ein Benutzer folgt, zurück.
	 * @return Array von Benutzer
	 */
	public function getGefolgte(){
		require_once("/../hilf/db_helper.php");
		$dbh = db_connect();
		$stmt = $dbh->prepare("SELECT Gefolgter FROM Folgen WHERE Folgender = :ID");
		$stmt->bindParam(':ID', htmlspecialchars($this->id));
		$stmt->execute();
		$res = $stmt->fetchAll();
		$gefolgteBenutzer = array();
		foreach ($res as $gefolgter){
			$gefolgteBenutzer[]= new Benutzer($gefolgter["Gefolgter"]);
		}
		
		return $gefolgteBenutzer;
	}
	
	/**
	 * Gibt alle Nachrichten der Benutzer, denen ein Benutzer folgt, aus.
	 * @return String Nachricht
	 */	
	public function getGefolgteNachrichten(){
		require_once("Nachricht.php");
		require_once("/../hilf/db_helper.php");
		$dbh = db_connect();
		$stmt = $dbh->prepare("SELECT ID FROM nachricht n, folgen f WHERE f.Folgender = :ID AND f.Gefolgter = n.Benutzer ORDER BY Datum DESC");
		$stmt->bindParam(':ID', htmlspecialchars($this->id));
		$stmt->execute();
		$res = $stmt->fetchAll();
		$gefolgteNachrichten = array();
		foreach ($res as $nachricht){
			$gefolgteNachrichten[]= new Nachricht($nachricht["ID"]);
		}
		
		return $gefolgteNachrichten;
	}
	
	/**
	 * Der aktuelle Benutzer schreibt eine neue Nachricht.
	 * @param String $inhalt
	 */
	public function schreibeNachricht($inhalt){
		require_once("/../hilf/db_helper.php");
		$dbh = db_connect();
		$stmt = $dbh->prepare("INSERT INTO nachricht(Benutzer, Inhalt) VALUES(:ID,:Inhalt)");
		$stmt->bindParam(':ID', htmlspecialchars($this->id));
		$stmt->bindParam(':Inhalt', htmlspecialchars($inhalt));
		$stmt->execute();
	}
	
	/**
	 * Der aktuelle Benutzer wird zurückgegeben.
	 * @param String $nickname
	 * @return Benutzer aktueller Benutzer
	 */
	public static function getBenutzer($nickname){
		return new Benutzer($nickname);
	}
	
	/**
	 * Ein neuer Benutzer wird angelegt.
	 * @param String $nickname Nickname des neuen Benutzers
	 * @param String $vorname Vorname des neuen Benutzers
	 * @param String $nachname Nachname des neuen Benutzers
	 * @param String $passwort Passwort des neuen Benutzers
	 */
	public static function registrieren($nickname,$vorname,$nachname,$passwort){
		require_once("/../hilf/db_helper.php");
		$dbh = db_connect();
		$stmt = $dbh->prepare("SELECT Nickname, Vorname, Nachname, Passwort FROM Benutzer WHERE nickname = :ID");
		$stmt = $dbh->prepare("INSERT INTO benutzer(Nickname ,Vorname, Nachname, Passwort) VALUES(:Nickname,:Vorname,:Nachname,:Passwort)");
		$stmt->bindParam(':Nickname', htmlspecialchars($nickname));
		$stmt->bindParam(':Vorname', htmlspecialchars($vorname));
		$stmt->bindParam(':Nachname', htmlspecialchars($nachname));
		$stmt->bindParam(':Passwort', (hash("sha256", $passwort)));		
		
		if($stmt->execute() == false)
		{
			throw new Exception("NicknameBereitsVorhanden");
		}
	}
	
	/**
	 * Der aktuelle Benutzer folgt einem anderen Benutzer.
	 * @param String $nickname
	 */
	public function folgen($nickname){
		require_once("/../hilf/db_helper.php");
		$dbh = db_connect();
		$stmt = $dbh->prepare("SELECT COUNT(*) AS Anzahl FROM benutzer WHERE nickname = :Gefolgter");
		$stmt->bindParam(':Gefolgter', htmlspecialchars($nickname));
		$stmt->execute();
		$res = $stmt->fetch();
		// Eine Exception werfen, wenn es den Benutzer nicht gibt
		if ($res["Anzahl"] == 0){
			throw new Exception("userNichtVorhanden");
		} else {
			$stmt = $dbh->prepare("INSERT INTO folgen(Folgender, Gefolgter) VALUES(:Folgender,:Gefolgter)");
			$stmt->bindParam(':Folgender', htmlspecialchars($this->id));
			$stmt->bindParam(':Gefolgter', htmlspecialchars($nickname));
			$stmt->execute();
		}
	}
	
	/**
	 * Daten, die in JSON serialisiert werden sollen.
	 * @return Array von Strings
	 */
	public function jsonSerialize(){
		return [
			'nickname' => $this->getNickname(),
			'vorname' => $this->getVorname(),
			'nachname' => $this->getNachname()		
		];
	}
	
}
?>