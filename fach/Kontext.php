<?php

class Kontext {
	
	private $benutzer;
	
	public function __construct(){
		session_start();
		if (isset($_SESSION["benutzer"])){
			$this->benutzer = Benutzer::getBenutzer($_SESSION["benutzer"]);
		} else {
			$this->benutzer = null;
		}		
	}
	
	public function isAngemeldet(){
		return ($this->benutzer !== null);
	}
	
	public function getBenutzer(){
		return $this->benutzer;
	}
	
	public function einloggen($nickname, $passwort){
		$benutzer = Benutzer::getBenutzer($nickname);
		if ($benutzer->pruefePasswort($passwort)){
			session_regenerate_id();
			$_SESSION["benutzer"] = $benutzer;
			$this->benutzer = $benutzer;
		} else {
			throw new Exception("UngueltigesPasswort");
		}
	}
	
	public function ausloggen(){
		$_SESSION = array();
		session_destroy();
		$this->benutzer = null;
	}
	
}
?>