/**
 * 
 */
function sucheHashtag(hashtag){
	var req = new XMLHttpRequest();
	req.open("GET", "../json.php/hashtag/"+hashtag, true);
	req.onreadystatechange = function(e){
		if (req.readyState == 4){
			document.getElementById("ausgabe").innerHTML = formatiereNachrichten(JSON.parse(req.responseText));
		}
	};
	req.send();	
}

function formatiereNachrichten(nachrichten){
	var res = "";
	for (var i=0; i<nachrichten.length; i++){
		nachricht = nachrichten[i];
		res += '<div class="nachricht"><div class="nachrichtHeader"><span class="nachrichtName">'+nachricht["benutzer"]["vorname"]+" "+nachricht["benutzer"]["nachname"]+'</span><span class="nachrichtNickname">'+nachricht["benutzer"]["nickname"]+'</span><span class="nachrichtDatum">'+nachricht["datum"]["date"]+'</span></div><div class="nachrichtBody">'+nachricht["inhalt"]+'</div></div>';
	}
	return res;
}