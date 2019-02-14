window.onload = load;
window.onscroll = scroll;

function load() {
	document.getElementById("burger-menu").addEventListener("click", click);
	document.querySelector("#sidebar-wrapper > .close").addEventListener("click", click);

	function click(){
		var el = document.getElementById("sidebar-wrapper");
		el.classList.toggle("toggled");
	}
}

function plusClick(){
	var elements = document.getElementById("correlate").children;
	var element = elements[elements.length - 2];
	var newElement = element.cloneNode(true);
	var number = +newElement.querySelector("label").textContent + 1;
	newElement.querySelector("label").setAttribute("for", '_' + number);
	newElement.querySelector("label").textContent = number;
	newElement.querySelector("select").setAttribute("id", '_' + number);
	element.parentNode.insertBefore(newElement, element.nextSibling);
}

function scroll(){
	var back = document.getElementById("scroll-back-button");

	if(window.pageYOffset > 50){
		back.classList.add("scroll-back-button-active");
	}else{
		back.classList.remove("scroll-back-button-active");
	}

	var bta = document.getElementById("back-to-article");
	if (bta) {
		if (window.pageYOffset >= document.body.scrollHeight - window.innerHeight){
			bta.classList.add("active");
		} else {
			bta.classList.remove("active");
		}
	}
}

function showAlert(alert, condition, text, parent){
	if(alert) parent.removeChild(alert);

	if(!condition && text !== ""){
		var div = document.createElement("div");
		div.classList.add("feedback");
		div.classList.add("invalid-feedback");
		var p = document.createElement("p");
		p.appendChild(document.createTextNode(text));
		div.appendChild(p);
		parent.appendChild(div);

		return false;
	}

	return true;
}

function checkText(input, text, regexp){
	var element = document.getElementById(input);
	var test = element.value;
	var parent = element.parentNode;
	var alert = parent.querySelector(".invalid-feedback");

	return showAlert(alert, regexp.test(test) || test === "" , text, parent);
}

function checkEmail() {
	var regex = /^[a-zA-Z0-9.!#$%&'*+/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/;
	var element = document.getElementById('inputEmail');
	var test = element.value;
	var parent = element.parentNode;
	var alert = parent.querySelector(".invalid-feedback");

	return showAlert(alert,regex.test(test) || test === "", 'Email non valida', parent);
}

function isPasswordEqual(){
	var password = document.getElementById('inputPassword');
	var confermaPassword = document.getElementById('inputPasswordConfirm');

	var parent = confermaPassword.parentNode;
	var alert = parent.querySelector(".invalid-feedback");

	return showAlert(alert, password.value === confermaPassword.value, 'Le password non combaciano', parent);
}

function AlertFilesize(){
	var filepath = document.getElementById("FormControlFile").value;

	var fileSize = document.getElementById("FormControlFile").files[0].size;

    var i = 0;
    while(fileSize > 900){
    	fileSize /= 1024;
    	i++;
    }

    var button = document.getElementById("fatto");
    var addImage = document.getElementById("FormControlFile");
	var parent = addImage.parentNode;
	var alert = parent.querySelector(".invalid-feedback");

	var extensions = ['png','jpg','jpeg','svg'];
	var isImage = extensions.includes(filepath.split('.').pop());

    disableElement(button,showAlert(alert, ((Math.round(fileSize*100)/100) < 300) && isImage, "Il file pesa troppo o non è un'immagine!", parent));
}

function disableElement(element,condition) {
	if (!condition){
		element.setAttribute("disabled", "disabled");
	}else{
		if(element.hasAttribute("disabled"))
			element.removeAttribute("disabled");
	}
}

function invalidBirthDay() {
	var element = document.getElementById("inputDate");
	var parent = element.parentNode;
	var alert = parent.querySelector(".invalid-feedback");
	var condition = false;
	var text = 'Data non valida';
	var userBirth = Date.parse(element.value);
	if (Date.now() - userBirth  < Date.UTC(1976))
		if(userBirth <= Date.now())
			text = 'Sei un po\' troppo giovane, non credi?';
		else
			text = 'Vieni dal futuro?';
	else if (userBirth <= Date.UTC(1875,2,21))
		text = 'Sei davvero nato prima della persona più anziana del mondo?';
	else if (element.value === "")
		text = 'Campo obbligatorio';
	else
		condition = true;

	return showAlert(alert, condition, text, parent);
}
