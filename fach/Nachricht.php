<?php

class Nachricht implements JsonSerializable {
	
	private $benutzer;
	private $inhalt;
	private $datum;
	
	/**
	 * Erzeugt ein neues Objekt vom Typ Nachricht.
	 * @param String $id
	 * @param Benutzer $benutzer Wenn kein Benutzer-Objekt angegeben wird, wird ein passendes Benutzer-Objekt erzeugt
	 */
	public function __construct($id, $benutzer = null){
		require_once("/../hilf/db_helper.php");
		require_once("Benutzer.php");
		$dbh = db_connect();
		$stmt = $dbh->prepare("SELECT Benutzer, Inhalt, Datum FROM Nachricht WHERE ID = :ID");
		$stmt->bindParam(':ID', htmlspecialchars($id));
		$stmt->execute();
		$res = $stmt->fetch(PDO::FETCH_ASSOC);
		$this->inhalt = $res["Inhalt"];
		// Passenden Benutzer setzen
		if ($benutzer == null){
			$this->benutzer = Benutzer::getBenutzer($res["Benutzer"]);
		} else {
			$this->benutzer = $benutzer;
		}		
		$this->datum = new DateTime($res["Datum"]);
	} 
	
	/**
	 * Liefert den Inhalt einer Nachricht.
	 * @return String inhalt
	 */
	public function getInhalt(){
		return $this->inhalt;
	}
	
	/**
	 * Liefert den jeweiligen Benutzer zu einer Nachricht.
	 * @return Benutzer benutzer
	 */
	public function getBenutzer(){
		return $this->benutzer;
	}
	
	/**
	 * Liefert Datum und Zeit zu einer jeweiligen Nachricht.
	 * @return DateTime
	 */
	public function getDatum(){
		return $this->datum;
	}
	
	/**
	 * Liefert alle Nachrichten zu einem eingegebenen Hashtag.
	 * @param String $hashtag
	 * @return Array von Strings
	 */
	public static function sucheNachHashtag($hashtag){
		require_once(dirname($_SERVER['SCRIPT_FILENAME']).'/hilf/db_helper.php');
		$dbh = db_connect();
		$stmt = $dbh->prepare("SELECT nh.Nachricht FROM Nachricht n, nachricht_hashtag nh, Hashtag h WHERE n.ID = nh.Nachricht AND nh.Hashtag = h.ID AND h.Tag = :Tag ORDER BY Datum DESC");
		$stmt->bindParam(':Tag', htmlspecialchars($hashtag));
		if (!$stmt->execute()){
			print_r($stmt->errorInfo());
		}
		$result = Array();
		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
			$result[] = new Nachricht($row["Nachricht"]);
		}
		return $result;
	}
	
	/**
	 * Daten, die in JSON serialisiert werden sollen.
	 * @return Array 
	 */
	public function jsonSerialize() {
		return [
				'benutzer' => $this->getBenutzer(),
				'inhalt' => $this->getInhalt(),
				'datum' => $this->getDatum()->getTimestamp()
		];
	}
	
}

?>