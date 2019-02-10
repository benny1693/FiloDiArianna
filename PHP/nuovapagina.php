<?php
include_once 'utilities.php';
$user = init();

$validField = preg_match('/^.*[a-zA-Z].*$/',$_POST['title']) &&
        preg_match('/^(.*[a-zA-Z].*\r*\n*)(.*[a-zA-Z]*.*\r*\n*)*$/',$_POST['content']);

if (!empty($_POST) && $validField){
	$img = file_get_contents($_FILES['image']['tmp_name']);
	$path = $_FILES['image']['name'];
	$ext = pathinfo($path, PATHINFO_EXTENSION);

	$types = findCorrectTypes($_POST['types']);

	$_POST['relatedpages'] = array_unique(array_diff($_POST['relatedpages'],array('none')));

	$user->insertArticle($_POST['title'],$_POST['content'],$img,$ext,$_SESSION['ID'],$types,$_POST['relatedpages']);
}
$refill = !empty($_POST) && (!$validField || $user->getDBError() != 0);
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
		<section id="nuovapagina">';

                if ($user->getDBError() != 0) {
                    if ($user->getDBError() == 1644)
                        printFeedback('Pagina gi&agrave; esistente: potrebbe essere in attesa di approvazione',false);
                    else
                        printFeedback('Pagina non inserita nel database', false);
                }else
		            if (!empty($_POST)) {
                        if ($validField)
                            printFeedback('Pagina inserita e in attesa di approvazione', true);
                        else
                            printFeedback('La pagina deve avere almeno titolo e descrizione', false);
                    }

		        echo '		    
			<h1>Crea una nuova pagina</h1>
			<form method="post" action="nuovapagina.php" enctype="multipart/form-data">
				<div class="form-group">
					<label for="FormControlFile">Carica l\'immagine che vuoi inserire.</label>
					<input type="file" class="form-control-file" id="FormControlFile" name="image" onchange="AlertFilesize();" />
				</div>

				<div class="form-group">
					<label for="inputTitolo">Titolo</label>
					<input type="text" class="form-control" id="inputTitolo" name="title" placeholder="Titolo" required="required" aria-required="true" ' . ($refill ? 'value="'.$_POST['title'].'"' : "") .'/>
				</div>

				<div class="form-group">
					<label for="FormControlTextarea1">Descrizione</label>
					<textarea class="form-control" id="FormControlTextarea1" name="content" rows="10" required="required" aria-required="true">' . ($refill ? $_POST['content'] : "") .'</textarea>
				</div>
				
				<div class="form-group">
					<label for="inputCategorie">Categorie</label>
					<select name="types" id="inputCategorie" class="form-control">
						<optgroup label="Personaggi">
							<option value="p_umani" ' . ($refill ? selectRefill($_POST['types'],'p_umani') : "") .'>Esseri Umani</option>
							<option value="p_eroi" ' . ($refill ? selectRefill($_POST['types'],'p_eroi') : "") .'>Semidivinit&agrave;/Eroi</option>
							<option value="p_dei" ' . ($refill ? selectRefill($_POST['types'],'p_dei') : "") .'>Divinità</option>
							<option value="p_creature" ' . ($refill ? selectRefill($_POST['types'],'p_creature') : "") .'>Creature</option>
						</optgroup>
						<optgroup label="Eventi">
							<option value="era_dei" '.($refill ? selectRefill($_POST['types'],'era_dei') : "").'>Era degli Dei</option>
							<option value="era_dei_uomini" '.($refill ? selectRefill($_POST['types'],'era_dei_uomini') : "").'>Era degli Dei e degli Uomini</option>
							<option value="era_eroi" '.($refill ? selectRefill($_POST['types'],'era_eroi') : "").'>Era degli Eroi</option>
						</optgroup>
						<optgroup label="Luoghi">
							<option value="l_mitologici" '.($refill ? selectRefill($_POST['types'],'l_mitologici') : "").'>Mitologici</option>
							<option value="l_reali" '.($refill ? selectRefill($_POST['types'],'l_reali') : "").'>Reali</option>
						</optgroup>
					</select>
				</div>

				<fieldset id="correlate" class="form-group">
					<legend>Pagine correlate</legend>
                    <p class="row">
                        <label for="1" class="col-xs-1">1</label>
                        <select id="1" name="relatedpages[]" class="form-control col-xs-9">
                            <option value="none" selected="selected">Nessuna</option>';

                printSelect($user->searchArticle(''));

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