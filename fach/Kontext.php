<?php

class Kontext {
	
	private $benutzer;
	
	/**
	 * Erzeugt ein neues Objekt vom Typ Kontext.
	 */
	public function __construct(){
		require_once("Benutzer.php");
		session_start();
		if (isset($_SESSION["benutzer"])){
			$this->benutzer = Benutzer::getBenutzer($_SESSION["benutzer"]);
		} else {
			$this->benutzer = null;
		}		
	}
	
	/**
	 * Überprüft, ob der Benutzer bereits angemeldet ist.
	 * @return boolean
	 */
	public function isAngemeldet(){
		return ($this->benutzer !== null);
	}
	
	/**
	 * Liefert den aktuellen Benutzer.
	 */
	public function getBenutzer(){
		return $this->benutzer;
	}
	
	/**
	 * Loggt sich mit den angegeben Daten auf der Seite ein.
	 * @param String $nickname
	 * @param String $passwort
	 * @throws Exception
	 */
	public function einloggen($nickname, $passwort){
		$benutzer = Benutzer::getBenutzer($nickname);
		if ($benutzer->pruefePasswort($passwort)){
			session_regenerate_id();
			$_SESSION["benutzer"] = $benutzer->getNickname();
			$this->benutzer = $benutzer;
		} else {
			throw new Exception("UngueltigesPasswort");
		}
	}
	
	/**
	 * Loggt sich auf der Seite aus und löst die aktuelle Session auf.
	 */
	public function ausloggen(){
		$_SESSION = array();
		session_destroy();
		$this->benutzer = null;
	}
	
}
?>