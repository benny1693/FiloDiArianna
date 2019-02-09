<?php
include_once 'utilities.php';
$user = init();
$modifiedpage = !empty($_SESSION['modification']['instime']);

print_r($_SESSION);
$info = null;
if (!empty($_SESSION['modification'])) {
	$info = $user->getArticleInfo($_SESSION['modification']['pageid'], ($modifiedpage ? $_SESSION['modification']['instime'] : null));
}
print_r($info);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Modifica Pagina | Filo di Arianna</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Accedi al tuo profilo o registrati." />
	<meta name="keywords" content="greco, antico, ellenico, grecia, enciclopedia, mitologia, modifica, pagina" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js"></script>
</head>

<body>
	<!-- HEADER / SIDEBAR -->
    <?php include_once 'header.php';?>

	<!-- INIZIO PAGINA -->
	<div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="areapersonale.php">Area Personale</a></li>
				<li class="breadcrumb-item active" aria-current="page">Modifica Pagina</li>
			</ol>
		</nav>

        <?php
            if ($_SESSION['ID'] == -1) {
                echo '
        <section>';
                printFeedback("Per modificare una pagina devi effettuare l'accesso", false);
            } else {
                if (empty($_SESSION['modification']))
                    printFeedback("Non hai selezionato la pagina da modificare",false);
                else {
                    echo '
		<section id="modificapagina">
			<h1>Modifica la pagina "'.$info['title'].'"</h1>

			<form method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label for="FormControlFile">Carica l\'immagine che vuoi sostituire.</label>
					<input type="file" class="form-control-file" id="FormControlFile"';
                    if (!empty($info['img']))
                        echo 'value="data:image/' . $info['ext'] . ';base64,' . base64_encode($info['img']).'"';

                    // TODO: effettuare il filling dei campi delle pagine correlate
					echo '/>
				</div>

				<div class="form-group">
					<label for="exampleFormControlTextarea1">Descrizione</label>
					<textarea class="form-control" id="exampleFormControlTextarea1" rows="10" placeholder="Inserisci una descrizione qui">'.$info['content'].'</textarea>
				</div>

				<fieldset id="correlate" class="form-group">
					<legend>Pagine correlate</legend>
					<p class="row">
						<label for="1" class="col-xs-1">1</label>
						<select id="1" name="correlati[]" class="form-control col-xs-9"></select>
					</p>
					<button type="button" id="plus" class="btn" onclick="plusClick()">
						<svg>
							<path d="M 28, 20 h -8 v 8 h -4 v -8 h -8 v -4 h 8 v -8 h 4 v 8 h 8 v 4 z" /></svg>
					</button>
				</fieldset>

				<div class="form-group submit-button">
					<button type="submit" class="btn  btn-outline-primary">Fatto</button>
				</div>

			</form>';
                }
            }
            unset($_SESSION['modification']);
            ?>
		</section>

	</div>

	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>

</body>

</html>