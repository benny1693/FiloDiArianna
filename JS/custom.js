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