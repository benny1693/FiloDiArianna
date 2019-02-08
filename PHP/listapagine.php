<?php
require_once 'utilities.php';
$user = init();

$pendenti = $_GET['pendenti'] = (empty($_GET['pendenti']) ? false : $_GET['pendenti']);
$pendenti = filter_var($pendenti, FILTER_VALIDATE_BOOLEAN);

$currentpage = $_GET['page'] = empty($_GET['page']) ? 1 : $_GET['page'];

$articlesNumber = 10;

$list = null;
if ($user->isAdmin())
	$list = $user->searchArticle('', null, null,$pendenti);
else {
    if ($user->isRegistered())
    	$list = $user->searchArticle('', null, null, $pendenti, $user->getID());
}
$pages = ceil(count($list)/$articlesNumber);
if ($pages == 0)
	$currentpage = 0;

if (($currentpage > $pages || $currentpage <= 0) && $currentpage != $pages)
	header("Location: notfound.php");

print_r($list);


print_r($_SESSION);
print_r($_GET);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Area personale | Il Filo di Arianna</title>
	<meta name="description" content="Gestisci le pagine create" />
	<meta name="keywords" content="Filo, Arianna, greco, mitologia, pagina, gestisci, pubblicata" />
	<meta name="author" content="Alessandro Spreafico" />
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
    <link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js"></script>
</head>

<body>
	<!-- HEADER / SIDEBAR -->
    <?php include_once 'header.php'; ?>

    <div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="areapersonale.php">Area personale</a></li>
                <?php
				echo '<li class="breadcrumb-item active" aria-current="page">Pagine '.($pendenti ? 'pendenti' : 'pubblicate').'</li>';
				?>
			</ol>
		</nav>

		<section>
            <?php

            if (!$user->isRegistered())
                printFeedback('Devi essere registrato per vedere questa pagina',false);
            else {
                echo '
			<h1>Pagine '.($pendenti ? 'pendenti' : 'pubblicate').'</h1>';
                if (count($list) <= 0)
                    echo '<p id="results">Nessun risultato trovato</p>';
                else {
                    echo "<p id=\"results\">Trovati " . count($list) . " risultati</p>";
                    echo "<p class='sr-only'>Pagina $currentpage di $pages</p>";

                    printNavigation($currentpage, $pages);

                    echo '
                <ul class="query">';

                    if ($currentpage < $pages)
                        $user->printArticleList(array_slice($list, ($currentpage - 1) * $articlesNumber, $articlesNumber), true,$pendenti);
                    else //$currentpage == $pages
                        $user->printArticleList(array_slice($list, ($currentpage - 1) * $articlesNumber, count($list) - ($currentpage - 1) * $articlesNumber), true,$pendenti);

                    echo '
                </ul>';

                    printNavigation($currentpage, $pages);
                }
            }
			?>
		</section>
	</div>
	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>

</body>

</html>
