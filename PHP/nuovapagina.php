<?php
include_once 'utilities.php';
$user = init();
if (!$user->isRegistered()){
    $_SESSION['errorMsg'] = 'Devi effettuare l\'accesso per inserire una pagina';
    header("Location: avviso.php");
    exit();
}

$page = new FormPage(!preg_match('/^.*[a-zA-Z].*$/',$_POST['title']) ||
                        !preg_match('/^(.*[a-zA-Z].*\r*\n*)(.*[a-zA-Z]*.*\r*\n*)*$/',$_POST['content']));

unset($_SESSION['errorMsg']);
unset($_SESSION['successMsg']);

if (!$page->hasErrors()){
	$imgInfo = $page->adjustFile($_FILES);
	$types = $page->findCorrectTypes($_POST['types']);
	$_POST['relatedpages'] = array_unique(array_diff($_POST['relatedpages'], array('none')));
	$user->insertArticle($_POST['title'],$_POST['content'],$imgInfo['img'],$imgInfo['ext'],$user->getID(),$types,$_POST['relatedpages']);
	$page->addError($user->getDBError());
	if ($page->hasErrors()) {
	    if ($user->getDBError() == 1644)
	        $_SESSION['errorMsg'] = 'Pagina gi&agrave; esistente: potrebbe essere in attesa di approvazione';
		else
	        $_SESSION['errorMsg'] = 'Errore di inserimento nel database';
	} else
		$_SESSION['successMsg'] = "Inserimento avvenuto con successo e in attesa di approvazione";
} else {
    $_SESSION['errorMsg'] = 'Titolo e descrizione devono avere almeno un carattere alfabetico';
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

		<section id="nuovapagina">

            <?php
            if (!empty($_POST)) {
                if ($page->hasErrors())
                    $page->printFeedback($_SESSION['errorMsg'], false);
                else
                    $page->printFeedback($_SESSION['successMsg'], true);

                unset($_SESSION['errorMsg']);
                unset($_SESSION['successMsg']);
            }
            ?>

			<h1>Crea una nuova pagina</h1>
			<form method="post" action="nuovapagina.php" enctype="multipart/form-data">
				<div class="form-group">
					<label for="FormControlFile">Carica l'immagine che vuoi inserire.</label>
					<input type="file" class="form-control-file" id="FormControlFile" name="image" onchange="AlertFilesize();" />
				</div>

				<div class="form-group">
					<label for="inputTitolo">Titolo</label>
					<input type="text" class="form-control" id="inputTitolo" name="title" placeholder="Titolo" required="required" aria-required="true" <?php echo $page->hasErrors() ? 'value="'.$_POST['title'].'"' : ''; ?> />
				</div>

				<div class="form-group">
					<label for="FormControlTextarea1">Descrizione</label>
					<textarea class="form-control" id="FormControlTextarea1" name="content" rows="10" required="required" aria-required="true"><?php echo $page->hasErrors() ? $_POST['title']."" : ""?></textarea>
				</div>
				
				<div class="form-group">
					<label for="inputCategorie">Categorie</label>
					<select name="types" id="inputCategorie" class="form-control">
                        <optgroup label="Personaggi">
                            <option value="p_umani" <?php $page->selectRefill($_POST['types'],"p_umani"); ?>>Esseri Umani</option>
                            <option value="p_eroi" <?php echo $page->selectRefill($_POST['types'],"p_eroi"); ?>>Semidivinit&agrave;/Eroi</option>
                            <option value="p_dei" <?php echo $page->selectRefill($_POST['types'],"p_dei"); ?>>Divinità</option>
                            <option value="p_creature" <?php echo $page->selectRefill($_POST['types'],"p_creature"); ?>>Creature</option>
                        </optgroup>
                        <optgroup label="Eventi">
                            <option value="era_dei" <?php echo $page->selectRefill($_POST['types'],"era_dei"); ?>>Era degli Dei</option>
                            <option value="era_dei_uomini" <?php echo $page->selectRefill($_POST['types'],"era_dei_uomini"); ?>>Era degli Dei e degli Uomini</option>
                            <option value="era_eroi" <?php $page->selectRefill($_POST['types'],"era_eroi"); ?>>Era degli Eroi</option>
                        </optgroup>
                        <optgroup label="Luoghi">
                            <option value="l_mitologici" <?php echo $page->selectRefill($_POST['types'],"l_mitologici"); ?>>Mitologici</option>
                            <option value="l_reali" <?php echo $page->selectRefill($_POST['types'],"l_reali"); ?>>Reali</option>
					</select>
				</div>

				<fieldset id="correlate" class="form-group">
					<legend>Pagine correlate</legend>
                    <p class="row">
                        <label for="1" class="col-xs-1">1</label>
                        <select id="1" name="relatedpages[]" class="form-control col-xs-9">
                            <option value="none" selected="selected">Nessuna</option>
                                <?php
                                $page->printSelect($user->searchArticle(''));
                                ?>
                        </select>
                    </p>
                    <button type="button" id="plus" class="btn" onclick="plusClick()">
                        <svg><path d="M 28, 20 h -8 v 8 h -4 v -8 h -8 v -4 h 8 v -8 h 4 v 8 h 8 v 4 z"/></svg>
                    </button>
				</fieldset>

				<div class="form-group submit-button">
					<button type="submit" id="fatto" class="btn btn-outline-primary">Fatto</button>
				</div>
			</form>
		</section>
	</div>

	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>

</body>

</html>