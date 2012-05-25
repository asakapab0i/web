function cookie_set(name, value, days) {
	if (days) {
		var date = new Date();
		date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
		var expires = "; expires=" + date.toGMTString();
	} else {
		var expires = "";
	}
	document.cookie = name + "=" + value + expires + "; path=/";
}

function cookie_get(name) {
	var nameEQ = name + "=";
	var ca = document.cookie.split(';');
	for(var i=0;i < ca.length;i++) {
		var c = ca[i];
		while (c.charAt(0)==' ') c = c.substring(1,c.length);
		if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
	}
	return null;
}

function cookie_del(name) {
	cookie_set(name, "", -1);
}

function text_change(closed) {
	if (closed) {
		document.getElementById("text").style.display = 'none';
		document.getElementById("openLink").className = "";
		document.getElementById("closeLink").className = "selected";
		cookie_set("text_closed", "yes", 300);
	} else {
		document.getElementById("text").style.display = 'block';
		document.getElementById("openLink").className = "selected";
		document.getElementById("closeLink").className = "";
		cookie_del("text_closed");
	}
	return false;
}

function roll(what, how) {
	eval("document." + what + ".src = " + what + "_" + how + ".src");
}