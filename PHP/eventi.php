<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Eventi | Filo di Arianna</title>
	<meta charset="utf-8" />
	<meta name="description" content="Scopri le voci sugli eventi della mitologia greca dell'enciclopedia più ellenica del web" />
	<meta name="author" content="Benedetto Cosentino" />
	<meta name="keywords" content="greco, antico, ellenico, grecia, enciclopedia, mitologia, eventi" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js"></script>
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
				<li class="breadcrumb-item active" aria-current="page">Eventi</li>
			</ol>
		</nav>
		<section>
			<h1>Eventi</h1>
			<a href="#macrocategories" class="sr-only">Salta introduzione</a>
			<p>Ricostruire un'esatta cronologia degli eventi della mitologia greca è praticamente impossibile. Spesso, infatti, è facile incontrare delle contraddizioni tra un mito e l'altro. Tuttavia, gli eventi della mitologia greca sono suddivisibili in 3 grandi categorie in base a come le divinità e gli esseri umani interagiscono.</p>
			<dl>
				<dt><em>"I miti delle origini"</em> ovvero <em>"L'epoca degli dei"</em></dt>
				<dd>Sono i miti sulle origini del mondo e degli dei. Son anche detti <em>Teogonie</em>.</dd>
				<dt><em>"L'epoca in cui gli dei e gli uomini vivevano insieme liberamente"</em></dt>
				<dd>Sono i miti sui primi incontri tra dei, semidei e mortali.</dd>
				<dt><em>"L'epoca degli eroi"</em> ovvero <em>"L'et&agrave; eroica"</em></dt>
				<dd>Sono miti che riguardano soprattutto le vicende degli esseri umani, come quella della guerra di Troia.</dd>
			</dl>
			<ul id="macrocategories">
				<li id="dei">
					<a href="#uomini" class="sr-only">Salta lista</a>
					<h2><a href="epocadei.html">Epoca degli Dei</a></h2>
					<ul class="categories">
						<li><a href="#">asdf</a></li>
					</ul>
				</li>

				<li id="uomini">
					<a href="#eroi" class="sr-only">Salta lista</a>
					<h2><a href="epocauomini.html">Epoca degli Dei e degli Uomini</a></h2>
					<ul class="categories">
						<li><a href="#">asdf</a></li>
					</ul>
				</li>

				<li id="eroi">
					<a href="#scroll-back-button" class="sr-only">Salta lista</a>
					<h2><a href="epocaeroi.html">Epoca degli Eroi</a></h2>
					<ul class="categories">
						<li><a href="#">asdf</a></li>
					</ul>
				</li>
			</ul>
		</section>
	</div>
	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>

</body>

</html>
