<?php
require_once 'utilities.php';
$user = init();

$list = null;
if ($user->isAdmin()) {
	if (!empty($_POST['userID'])){
		$user->deleteUser($_POST['userID']);
    }

	$list = $user->findUser('');

	try {
	    $listPage = new SearchPage(empty($_GET['page']) ? 1 : $_GET['page'], count($list));
	} catch (Exception $exception) {
	    header("Location: notfound.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Gestione utenti | Il Filo di Arianna</title>
	<meta name="description" content="Gestisci gli utenti" />
	<meta name="keywords" content="Filo, Arianna, greco, mitologia, utenti, gestisci" />
	<meta name="author" content="Matteo Ranzato" />
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
				<li class="breadcrumb-item active" aria-current="page">Gestione utenti</li>
			</ol>
		</nav>
		<section>
            <?php
            if (!$user->isAdmin())
                $page->printFeedback('Non sei un amministratore',false);
            else {
                echo '
			<h1>Gestisci gli utenti</h1>';

                $listPage->printNavigation(false);

                echo '<ul class="query">';

                $listPage->printUserList($list);

                echo'</ul>';

                $listPage->printNavigation(false);
            }
			?>
		</section>
	</div>
	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>
</body>

</html>
