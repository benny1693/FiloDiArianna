window.onload = load;
function load() {
	document.getElementById("burger-menu").addEventListener("touchend", click);

	function click(){
		var el = document.getElementById("sidebar-wrapper");
		el.classList.toggle("toggled");
	}
}
