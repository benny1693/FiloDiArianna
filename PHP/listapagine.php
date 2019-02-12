<?php
require_once 'utilities.php';
$user = init();

$pendenti = empty($_GET['adm']) ? 0 : $_GET['adm'];

$list = null;
if ($user->isAdmin())
	$list = $user->searchArticle('', null, null,$pendenti);
else {
    if ($user->isRegistered())
    	$list = $user->searchArticle('', null, null, $pendenti, $user->getID());
}

$listPage = null;
try {
	$listPage = new SearchPage(empty($_GET['page']) ? 1 : $_GET['page'], count($list));
} catch (Exception $exception) {
    header("Location: notfound.php");
    exit();
}
$listPage->setAdministration($pendenti);
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
				echo '<li class="breadcrumb-item active" aria-current="page">Pagine '.($pendenti == 2 ? 'pendenti' : 'pubblicate').'</li>';
				?>
			</ol>
		</nav>

		<section>
            <?php

            if (!$user->isRegistered())
                $listPage->printFeedback('Devi essere registrato per vedere questa pagina',false);
            else {
                echo '
			<h1>Pagine '.($pendenti == 2 ? 'pendenti' : 'pubblicate').'</h1>';
                if ($listPage->noResults())
                    echo '<p id="results">Nessun risultato trovato</p>';
                else {
                    echo '<p id="results">Trovati ' . $listPage->getArticles() . ' risultati</p>';
                    echo '<p class="sr-only">Pagina '.$listPage->getIndex().' di '.$listPage->lastPage().'</p>';

                    $listPage->printNavigation(true);

                    echo '<ul class="query">';

                    $listPage->printArticleList($list, $user->isAdmin());

                    echo '</ul>';

                    $listPage->printNavigation(true);
                }
            }
			?>
		</section>
	</div>
	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>

</body>

</html>
