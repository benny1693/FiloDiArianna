<?php
require_once 'utilities.php';
$user = init();

$currentpage = $_GET['page'] = empty($_GET['page']) ? 1 : $_GET['page'];

$usersNumber = 10;

$list = null;
if ($user->isAdmin()) {
	if (!empty($_POST['userID'])){
		$user->deleteUser($_POST['userID']);
    }

	$list = $user->findUser('');
	$pages = ceil(count($list)/$usersNumber);
	if ($pages == 0)
		$currentpage = 0;

	if ($currentpage == 0 && $page != 0)
		header("Location: notfound.php");

	if ($currentpage > $pages || $currentpage < 0)
		header("Location: notfound.php");
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
                printFeedback('Non sei un amministratore',false);
            else {
                echo '
			<h1>Gestisci gli utenti</h1>';

                printNavigation($currentpage,$pages,false);

                echo '
			<ul class="query">';

                if ($currentpage < $pages) {
                    $user->printUserList(array_slice($list, ($currentpage - 1) * $usersNumber, $usersNumber));
                }else{
                    $user->printUserList(array_slice($list,($currentpage - 1) * $usersNumber));
                }

                echo'
			</ul>';

                printNavigation($currentpage,$pages,false);
            }
			?>
		</section>
	</div>
	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>
</body>

</html>
