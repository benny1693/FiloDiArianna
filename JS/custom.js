window.onload = load;
function load() {
	document.getElementById("burger-menu").addEventListener("touchend", click);
	var overlay = document.querySelector("#content .overlay");

	function click(){
		var el = document.getElementById("sidebar-wrapper");
		el.classList.toggle("toggled");
		overlay.style.display = overlay.style.display == "block" ? "none" : "block";
	}
}