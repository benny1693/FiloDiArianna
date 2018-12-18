<!DOCTYPE html>
<html lang="it">

<head>
	<title>Area personale | Il Filo di Arianna</title>
	<meta name="title" content="Area personale | Filo di Arianna" />
	<meta name="description" content="Gestisci le pagine create" />
	<meta name="keyword" content="Filo, Arianna, greco, mitologia, pagina, gestisci, pendenti" />
	<meta name="author" content="Alessandro Spreafico" />
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" href="../CSS/style_list.css" />
	<link rel="stylesheet" type="text/css" href="../CSS/provelaura.css" />
	<link rel="stylesheet" type="text/css" href="../CSS/aiuti_nav.css" />
	<link rel="stylesheet" type="text/css" href="../CSS/paginepubblicatependenti.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js">
	</script>

</head>

<body>
	<!-- HEADER / SIDEBAR -->
	<?php require_once "header.php" ?>
	<div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="areapersonale.php">Area personale</a></li>
				<li class="breadcrumb-item active" aria-current="page">Pagine pendenti</li>
			</ol>
		</nav>
		<section>
			<h1>Pagine pendenti</h1>
			<nav aria-label="Paginazione" class="nav-pages">
				<ul class="pagination">
					<li class="page-item disabled"><a href="#">&laquo;</a></li>
					<li class="page-item disabled"><a href="#">&lsaquo;</a></li>
					<li class="page-item disabled"><a href="#" class="page-link">1</a></li>
					<li class="page-item"><a href="#" class="page-link">2</a></li>
					<li class="page-item"><a href="#" class="page-link">3</a></li>
					<li class="page-item"><a href="#" class="page-link">&rsaquo;</a></li>
					<li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
				</ul>
			</nav>
			<ul class="query">
				<li class="page-administration clearfix">
					<form action="/ROBE.PHP" method="get">
						<a class="pagina" href="articolo.php">Pagina</a>
						<div class="bottoni">
							<button type="submit" class="btn  btn-outline-primary">Accetta</button>
							<button type="submit" class="btn  btn-outline-primary">Modifica</button>
							<button type="submit" class="btn  btn-outline-primary">Elimina</button>
						</div>
					</form>
				</li>
				<li class="page-administration clearfix">
					<form action="/ROBE.PHP" method="get">
						<a class="pagina" href="articolo.php">Pagina</a>
						<div class="bottoni">
							<button type="submit" class="btn  btn-outline-primary">Accetta</button>
							<button type="submit" class="btn  btn-outline-primary">Modifica</button>
							<button type="submit" class="btn  btn-outline-primary">Elimina</button>
						</div>
					</form>
				</li>
				<li class="page-administration clearfix">
					<form action="/ROBE.PHP" method="get">
						<a class="pagina" href="articolo.php">Pagina</a>
						<div class="bottoni">
							<button type="submit" class="btn  btn-outline-primary">Accetta</button>
							<button type="submit" class="btn  btn-outline-primary">Modifica</button>
							<button type="submit" class="btn  btn-outline-primary">Elimina</button>
						</div>
					</form>
				</li>
			</ul>
			<nav aria-label="Paginazione" class="nav-pages">
				<ul class="pagination">
					<li class="page-item disabled"><a href="#">&laquo;</a></li>
					<li class="page-item disabled"><a href="#">&lsaquo;</a></li>
					<li class="page-item disabled"><a href="#" class="page-link">1</a></li>
					<li class="page-item"><a href="#" class="page-link">2</a></li>
					<li class="page-item"><a href="#" class="page-link">3</a></li>
					<li class="page-item"><a href="#" class="page-link">&rsaquo;</a></li>
					<li class="page-item"><a href="#" class="page-link">&raquo;</a></li>
				</ul>
			</nav>
		</section>
	</div>
	<!-- FOOTER di Matteo -->
	<?php require_once "footer.html"?>
</body>

</html>
