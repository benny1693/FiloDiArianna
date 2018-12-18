<!DOCTYPE html>
<html lang="it">

<head>
	<meta name="title" content="Creature | Filo di Arianna" />
	<title>Creature | Filo di Arianna</title>
	<meta charset="utf-8" />
	<meta name="description" content="Scopri le voci sulle creature narrate nella mitologia greca dell'enciclopedia più ellenica del web" />
	<meta name="author" content="Benedetto Cosentino" />
	<meta name="keywords" content="greco, antico, ellenico, grecia, enciclopedia, mitologia, personaggi" />
	<meta name="language" content="italian it" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" href="../CSS/aiuti_nav.css" />
	<link rel="stylesheet" type="text/css" href="../CSS/style_list.css" />
	<script src="../JS/custom.js"></script>
</head>

<body>
	<!-- HEADER / SIDEBAR -->
	<?php require_once "header.php" ?>
	<div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item" aria-current="page"><a href="index.php">Home</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="scopri.php">Scopri</a></li>
				<li class="breadcrumb-item" aria-current="page"><a href="personaggi.php">Personaggi</a></li>
				<li class="breadcrumb-item active" aria-current="page">Creature</li>
			</ol>
		</nav>
		<section>
			<h1>Creature</h1>
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
				<li>
					<a href="articolo.php">
						<img src="query" alt="imago" class="image" />
						<p>Nome</p>
						<p>Descrizione</p>
					</a>
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
	<!-- FOOTER -->
	<?php require_once "footer.html" ?>
</body>

</html>
