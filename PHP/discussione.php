<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Discussione su TitoloArticolo | Il Filo di Arianna</title>
	<meta name="description" content="Discussione tra gli utenti sull'articolo TitoloArticolo" />
	<meta name="keywords" content="Filo, Arianna, greco, mitologia, TitoloArticolo, discussione" />
	<meta name="author" content="Benedetto Cosentino" />
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js">
	</script>
</head>

<body>
	<!-- HEADER / SIDEBAR -->
    <?php include_once 'header.php';?>

	<div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="scopri.php">Scopri</a></li>
				<li class="breadcrumb-item"><a href="#queryarticoloprecedente.php">TitoloArticolo</a></li>
				<li class="breadcrumb-item" aria-current="page">Discussione</li>
			</ol>
		</nav>

		<section id="discussione">
			<ul id="article-menu">
				<li><a href="articolo.php">Voce</a></li>
				<li class="active">Discussione</li>
			</ul>
			<div id="article-content">
				<div id="article-title">
					<h1>Discussione di "Titolo"</h1>
					<p id="article-id"><? $y->y->getArticleID ?></p>
					<a id="back-to-article" href="articolo.php">Torna all'articolo</a>
				</div>
				<div>
					<div class="comment user">
						<p>Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento</p>
						<a href="profiloautore.html">Autore</a>
					</div>
					<div class="comment others">
						<p>Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento</p>
						<a href="profiloautore.html">Autore</a>
					</div>
					<div class="comment others">
						<p>Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento</p>
						<a href="profiloautore.html">Autore</a>
					</div>
					<div class="comment others">
						<p>Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento</p>
						<a href="profiloautore.html">Autore</a>
					</div>
					<div class="comment user">
						<p>Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento</p>
						<a href="profiloautore.html">Autore</a>
					</div>
					<div class="comment others">
						<p>Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento</p>
						<a href="profiloautore.html">Autore</a>
					</div>
					<div class="comment user">
						<p>Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento Commento</p>
						<a href="profiloautore.html">Autore</a>
					</div>
				</div>
				<form id="comment-form" onsubmit="">
					<div class="form-group row">
						<label for="inputText">Lascia un commento</label>
						<textarea id="inputText" class="form-control"></textarea>
					</div>

					<div class="form-group row">
						<button type="submit" class="btn btn-outline-primary">Invia</button>
					</div>
				</form>
			</div>
		</section>
	</div>
	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>

</body>

</html>
