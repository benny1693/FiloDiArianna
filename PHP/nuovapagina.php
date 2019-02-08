<?php
include_once 'utilities.php';
$user = init();

if (!empty($_POST)){
	$img = file_get_contents($_FILES['image']['tmp_name']);
	$path = $_FILES['image']['name'];
	$type = pathinfo($path, PATHINFO_EXTENSION);
	print_r($_POST);
	print_r($path);
    //$user->insertArticle($_GET['ID'],$_GET['content'],$img,$_SESSION['ID'],$_GET['types'],$_GET['relatedpages']);
}
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<meta name="title" content="Nuova Pagina | Filo di Arianna" />
	<meta charset="utf-8" />
	<title>Nuova Pagina | Filo di Arianna</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Accedi al tuo profilo o registrati." />
	<meta name="author" content="Laura Cameran" />
	<meta name="keywords" content="greco, antico, ellenico, grecia, enciclopedia, mitologia, pagina, creazione, nuova" />
	<link rel="stylesheet" type="text/css" href="../CSS/style.css" />
	<link rel="stylesheet" type="text/css" media="print" href="../CSS/print.css" />
	<script src="../JS/custom.js"></script>
</head>

<body>
	<!-- HEADER / SIDEBAR -->
    <?php include_once 'header.php'; ?>

	<!-- INIZIO PAGINA -->
	<div id="page-content-wrapper" class="container-fluid">
		<nav aria-label="breadcrumb">
			<p class="sr-only">Ti trovi in:</p>
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="../index.php">Home</a></li>
				<li class="breadcrumb-item"><a href="areapersonale.php">Area Personale</a></li>
				<li class="breadcrumb-item active" aria-current="page">Nuova Pagina</li>
			</ol>
		</nav>

        <?php
            if ($_SESSION['ID'] == -1) {
                echo '
        <section>';
                printFeedback("Per creare una nuova pagina devi effettuare l'accesso", false);
            }else {
                echo '
		<section id="nuovapagina">
			<h1>Crea una nuova pagina</h1>
			<form method="post" action="nuovapagina.php" enctype="multipart/form-data">
				<div class="form-group">
					<label for="FormControlFile">Carica l\'immagine che vuoi inserire.</label>
					<input type="file" class="form-control-file" id="FormControlFile" name="image" onchange="AlertFilesize();" />
				</div>

				<div class="form-group">
					<label for="inputTitolo">Titolo</label>
					<input type="text" class="form-control" id="inputTitolo" name="title" placeholder="Titolo" />
				</div>

				<div class="form-group">
					<label for="FormControlTextarea1">Descrizione</label>
					<textarea class="form-control" id="FormControlTextarea1" name="content" rows="10"></textarea>
				</div>
				
				<div class="form-group">
					<label for="inputCategorie">Categorie</label>
					<select name="type" id="inputCategorie" class="form-control">
						<optgroup label="Personaggi">
							<option value="p_umani">Esseri Umani</option>
							<option value="p_eroi">Semidivinità/Eroi</option>
							<option value="p_divinita">Divinità</option>
							<option value="p_creature">Creature</option>
						</optgroup>
						<optgroup label="Eventi">
							<option value="ep_dei">Epoca degli Dei</option>
							<option value="ep_dei_uomini">Epoca degli Dei e degli Uomini</option>
							<option value="ep_eroi">Epoca degli Eroi</option>
						</optgroup>
						<optgroup label="Luoghi">
							<option value="l_mitologici">Mitologici</option>
							<option value="l_reali">Reali</option>
						</optgroup>
					</select>
				</div>

				<fieldset id="correlate" class="form-group">
					<legend>Pagine correlate</legend>
                    <p class="row">
                        <label for="1" class="col-xs-1">1</label>
                        <select id="1" name="relatedpages[]" class="form-control col-xs-9">
                            <option value="none" selected="selected">Nessuna</option>';
                $list = $user->searchArticle('');
                foreach ($list as $article){
                    echo '
                            <option value="'.$article['ID'].'">'.$article['title'].'</option>';
                }
                echo '
                        </select>
                    </p>
                    <button type="button" id="plus" class="btn" onclick="plusClick()">
                        <svg><path d="M 28, 20 h -8 v 8 h -4 v -8 h -8 v -4 h 8 v -8 h 4 v 8 h 8 v 4 z"/></svg>
                    </button>
				</fieldset>

				<div class="form-group submit-button">
					<button type="submit" id="fatto" class="btn btn-outline-primary">Fatto</button>
				</div>
			</form>';
            }
			?>
		</section>
	</div>

	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>

</body>

</html>