//window.onload = load;
//window.onscroll = scroll;
//window.onload = validateForm;

function load() {
	document.getElementById("burger-menu").addEventListener("click", click);
	document.querySelector("#sidebar-wrapper > .close").addEventListener("click", click);

	function click(){
		var el = document.getElementById("sidebar-wrapper");
		el.classList.toggle("toggled");
	}
}

function scroll(){
	var sent = true;
	var scroll = document.getElementById("scroll-back-button");
	if(window.pageYOffset > 50 && sent){
		scroll.classList.add("scroll-back-button-active");
		sent = false;
	}else{
		scroll.classList.remove("scroll-back-button-active");
		sent = true;
	}
}

function showAlert(alert, condition, text, parent){
	if(condition){
		if(alert) parent.removeChild(alert);
		return true;
	}else{
		if(alert) parent.removeChild(alert);
		var div = document.createElement("div");
		div.classList.add("invalid-feedback");
		var p = document.createElement("p");
		p.appendChild(document.createTextNode(text));
		div.appendChild(p);
		parent.appendChild(div);

		return false;
	}
}

function checkText(input, text, regexp){
	var test = input.value;
	var parent = input.parentNode;
	var alert = parent.querySelector(".invalid-feedback");

	return showAlert(alert, regexp.test(test), text, parent);
}

function isPasswordEqual(password, confermaPassword, text, parent){
	var parent = confermaPassword.parentNode;
	var alert = parent.querySelector(".invalid-feedback");

	return showAlert(alert, password.value == confermaPassword.value, text, parent);
}

function validateForm(){
	var name = document.getElementById("inputName");
	var surname = document.getElementById("inputSurename");
	var email = document.getElementById("inputEmail");
	var username = document.getElementById("inputUsername");
	var password = document.getElementById("inputPassword");
	var confermaPassword = document.getElementById("inputPasswordConfirm");

	var regExp = /^[a-zA-Z]{1,20}$/;
	var regexpUsername = /^[a-zA-Z0-9]+$/;
	var regExpPassword = /^(?=.*[\d])(?=.*[A-Z])(?=.*[a-z])(?=.*[!@#$%^&*])[\w!@#$%^&*]{6,12}$/;
	// espressione regolare in accordo con lo standard RFC 822
	var regExpEmail = /^([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x22([^\x0d\x22\x5c\x80-\xff]|\x5c[\x00-\x7f])*\x22))*\x40([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d)(\x2e([^\x00-\x20\x22\x28\x29\x2c\x2e\x3a-\x3c\x3e\x40\x5b-\x5d\x7f-\xff]+|\x5b([^\x0d\x5b-\x5d\x80-\xff]|\x5c[\x00-\x7f])*\x5d))*$/;

	var boolName = checkText(name, "Nome non valido", regExp);
	var boolSurname = checkText(surname, "Cognome non valido", regExp);
	var boolEmail = checkText(email, "Email non valida", regExpEmail);
	var boolUsername = checkText(username, "Username non valida", regexpUsername);
	var boolPassword = checkText(password, "Password non corretta", regExpPassword);
	var boolConfermaPassword = isPasswordEqual(password, confermaPassword, "Le password non combaciano");

	return boolName && boolSurname && boolEmail && boolUsername && boolPassword && boolConfermaPassword;
}