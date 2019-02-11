<?php
require_once "utilities.php";
$u = init();
$currentpage = $_GET['page'] = empty($_GET['page']) ? 1 : $_GET['page'];

$articlesNumber = 10;

$list = $u->searchArticle($_GET['substringSearched'], $_GET['category'], $_GET['subcategory']);
$pages = ceil(count($list)/$articlesNumber);
if ($pages == 0)
    $currentpage = 0;

if ($currentpage == 0 && $page != 0) {
	header("Location: notfound.php");
	exit();
}

if ($currentpage > $pages || $currentpage < 0) {
	header("Location: notfound.php");
	exit();
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<meta charset="utf-8" />
	<!-- Questa pagina di ricerca non la si vuole indicizzare -->
	<meta name="robots" content="noindex" />
	<meta name="author" content="Matteo Ranzato" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Risultati ricerca | Filo di Arianna</title>
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js"></script>
</head>

<body>
	<!--HEADER-->
    <?php include_once 'header.php'; ?>
	<div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in: </p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item" lang="en"><a href="../index.php">Home</a></li>
				<li class="breadcrumb-item active" aria-current="page" lang="en">Ricerca</li>
			</ol>
		</nav>
		<section>
			<h1>Risultati di ricerca</h1>
            <?php
            if($_GET['substringSearched'] == null)
                echo '<p id="results">Nessun risultato trovato</p>';
            else {
                echo "<p id=\"results\">Trovati " . count($list) . " risultati</p>";
                echo "<p class='sr-only'>Pagina $currentpage di $pages</p>";

                printNavigation($currentpage,$pages);

                echo '<ul class="query">';
                if ($currentpage < $pages)
                    $u->printArticleList(array_slice($list,($currentpage-1)*$articlesNumber,$articlesNumber));
                else
                    $u->printArticleList(array_slice($list,($currentpage-1)*$articlesNumber));

                printNavigation($currentpage,$pages);
                echo '</ul>';
            }
            ?>
        </section>
	</div>
	<!--FOOTER-->
    <?php include_once '../HTML/footer.html'; ?>
</body>

</html>
