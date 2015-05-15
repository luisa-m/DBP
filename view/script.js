var mach_nochmal = null;

/**
 * Verarbeitet eine Eingabe des Elements self, die das Event e ausgelöst hat: Wenn ein Enterzeichen gedrückt wird, wird eine Hashtag-Suche nach dem Wert des Elements self durchgeführt und das formatierte Ergebnis im DOM-Element mit der ID displayElem angezeigt 
 * @param self
 * @param e
 * @param displayElem
 */
function sucheingabe(self, e, displayElem){
	if (e.keyCode == 13){
		sucheHashtag(self.value, displayElem);
		self.value = "";
		self.blur();
	}
}

/**
 * Verarbeitet eine Eingabe des Elements self, die das Event e ausgelöst hat: Wenn ein Enterzeichen gedrückt wird, wird eine Hashtag-Suche nach dem Wert des Elements self durchgeführt. Zeigt in diesem Fall anschließend die neue, formatierte Liste der gefolgten Nutzer im DOM-Element mit der ID folgenElem und die derer Nachrichten im DOM-Element mit der ID nachrichtenElem an. 
 * @param self
 * @param e
 * @param folgenElem
 * @param nachrichtenElem
 */
function folgenEingabe(self, e, folgenElem, nachrichtenElem) {
	if (e.keyCode == 13) {
		folgeBenutzer(self.value, folgenElem, nachrichtenElem);
		self.value = "";
		self.blur();
	}
}

/**
 * Zeigt im DOM-Element mit der ID displayElem die formatierte Liste der Nachrichten an, die von den gefolgten Nutzern verfasst wurden.
 * @param displayElem
 */
function zeigeTimeline(displayElem){
	var req = new XMLHttpRequest();
	req.open("GET", "../json.php/gefolgt/nachrichten", true);
	req.onreadystatechange = function(e){
		if (req.readyState == 4){
			document.getElementById(displayElem).innerHTML = formatiereNachrichten(JSON.parse(req.responseText), displayElem, "");
		}
	};
	req.send();	
	wiederhole(function(){zeigeTimeline(displayElem)});
}

/**
 * Sucht nach einem Hashtag und zeigt das formatierte Ergebnis im DOM-Element mit der ID displayElem an
 */
function sucheHashtag(hashtag, displayElem){
	if (hashtag.substring(0,1) == "#"){
		hashtag = hashtag.substring(1);
	}
	var req = new XMLHttpRequest();
	req.open("GET", "../json.php/hashtag/"+hashtag, true);
	req.onreadystatechange = function(e){
		if (req.readyState == 4){
			document.getElementById(displayElem).innerHTML = formatiereNachrichten(JSON.parse(req.responseText), displayElem, hashtag);
		}
	};
	req.send();	
	wiederhole(function(){sucheHashtag(hashtag, displayElem)});
}

/**
 * Folgt einem neuen Benutzer. Zeigt anschließend die neue, formatierte Liste der gefolgten Nutzer im DOM-Element mit der ID folgenElem und die derer Nachrichten im DOM-Element mit der ID nachrichtenElem an.
 * @param benutzername
 * @param folgenElem
 * @param nachrichtenElem
 */
function folgeBenutzer(benutzername, folgenElem, nachrichtenElem) {
	console.log("folge benutzer " + benutzername);
	var req = new XMLHttpRequest();
	req.open("GET", "../json.php/folgen/"+benutzername, true);
	req.onreadystatechange = function(e){
		if (req.readyState == 4){
			console.log(req.responseText);
			if (req.responseText == "+ok") {
				zeigeGefolgte(folgenElem);
				zeigeTimeline(nachrichtenElem);
			}
		}
	};
	req.send();			
}

/**
 * Zeigt im DOM-Element mit der ID anzeigeElem die formatierte Liste der Nutzer an, denen der aktueller Nutzer folgt.
 * @param anzeigeElem
 */
function zeigeGefolgte(anzeigeElem){
	var req = new XMLHttpRequest();
	req.open("GET", "../json.php/gefolgt/benutzer", true);
	req.onreadystatechange = function(e){
		if (req.readyState == 4){
			document.getElementById(anzeigeElem).innerHTML = formatiereBenutzer(JSON.parse(req.responseText));
		}
	};
	req.send();		
}

/**
 * Wiederholt die angegebene Funktion im Abstand von einer Minute. Andere Wiederholungen werden abgebrochen.
 * @param funktion
 */
function wiederhole(funktion){
	if (mach_nochmal != null){
		clearInterval(mach_nochmal);
	}
	mach_nochmal = setInterval(funktion, 60000);
}

/**
 * Formatiert die angegebenen Nachrichten für die Anzeige. Hashtag-Links lassen die Ergebnisse im DOM-Element mit der ID displayElem anzeigen. Der Hashtag highlightedHashtag wird hervorgehoben.
 * @param nachrichten
 * @param displayElem
 * @param highlightedHashtag
 * @returns {String}
 */
function formatiereNachrichten(nachrichten, displayElem, highlightedHashtag){
	/**
	 * Formatiert eine Zahl so, dass sie mindestens aus zwei Ziffern besteht
	 */
	function zwst(x){
		if (x < 10){
			return "0" + x;
		} else {
			return x;
		}
	}
	var res = "";
	for (var i=0; i<nachrichten.length; i++){
		nachricht = nachrichten[i];
		
		// Datum für die Anzeige aufbereiten
		var datum = new Date(nachricht["datum"]*1000);
		var monate = new Array("Januar", "Februar", "März", "April", "Mai", "Juni", "Juli", "August", "Septemer", "Oktober", "November", "Dezember");
		var datumStr = zwst(datum.getDate()) + ".&nbsp;" + monate[datum.getMonth()] + "&nbsp;" + datum.getFullYear() + " " + zwst(datum.getHours()) + ":" + zwst(datum.getMinutes());
		
		// Nachrichten-Inhalt für die Anzeige aufbereiten
		var len = nachricht["inhalt"].length;
		var regEx = /\#([^\s\.\,\:\;\-\+\#\?\!]*)/g;
		var find;
		var inhalt = "";
		var lastFindEnd = 0;
		while (find = regEx.exec(nachricht["inhalt"])){
			inhalt += nachricht["inhalt"].substr(lastFindEnd, find.index - lastFindEnd); // Inhalt zwischen den Hashtags anzeigen (beim ersten Hashtag: Inhalt vor dem ersten Hashtag)
			inhalt += '<a class="hashtag' + (find[1] == highlightedHashtag ? " highlighted" : "") + '" href="javascript:sucheHashtag(\''+find[0]+'\', \''+displayElem+'\');\">'+find[0]+'</a>'; // Hashtag verlinkt anzeigen
			lastFindEnd = find.index + find[0].length;
		}
		inhalt += nachricht["inhalt"].substr(lastFindEnd); // Inhalt nach dem letzten Hashtag anzeigen
		
		// Nachricht zusammenfügen
		res += '<div class="nachricht"><div class="nachrichtHeader"><span class="nachrichtName">'+nachricht["benutzer"]["vorname"]+" "+nachricht["benutzer"]["nachname"]+'</span><span class="nachrichtNickname">'+nachricht["benutzer"]["nickname"]+'</span><span class="nachrichtDatum">'+datumStr+'</span></div><div class="nachrichtBody">'+inhalt+'</div></div>';
	}
	return res;
}

/**
 * Formatiert die angegebenen Benutzer für die Anzeige
 * @param benutzers
 * @returns {String}
 */
function formatiereBenutzer(benutzers){
	var res = "";
	for (var i=0; i<benutzers.length; i++){
		benutzer = benutzers[i];
		res += '<div class="benutzer"><span class="benutzerName">'+benutzer["vorname"]+" "+benutzer["nachname"]+'</span><span class="benutzerNickname">'+benutzer["nickname"]+'</span>';
	}
	return res;
}