<?php
include_once 'utilities.php';
$user = init();
$page = new FormPage();

print_r($_SESSION);
unset($_SESSION['errorMsg']);
unset($_SESSION['successMsg']);
if (!$user->isRegistered()) {
    $_SESSION['errorMsg'] = "Per modificare una pagina devi effettuare l'accesso";
} else {
    $info = null;
    if (!isset($_SESSION['modification'])) { // se arrivo da una pagina diversa da pageaction, ovvero da modificaèagina stessa

        // bisogna completare la modifica di una pagina
        $info = $user->getArticleInfo($_POST['articleID'],$_POST['instime']);

        $page->setErrors(!preg_match('/^(.*[a-zA-Z].*\r*\n*)(.*[a-zA-Z]*.*\r*\n*)*$/',$_POST['content'])
            || $_POST['content'] == $info['content']);

        if ($page->hasErrors()) {
            $_SESSION['errorMsg'] = "I campi inseriti non sono validi o sono uguali a quelli della pagina da modificare";
        } else {
            if (empty($_POST)) // Sono arrivato da una pagina senza usare un form
                $_SESSION['errorMsg'] = 'Non hai selezionato una pagina da modificare';
            else {
                $imgInfo = $page->adjustFile($_FILES,$info);
                $types = $page->findCorrectTypes($_POST['types']);
                $_POST['relatedpages'] = array_unique(array_diff($_POST['relatedpages'], array('none')));
                $user->modifyArticle($_POST['articleID'], $_POST['content'], $imgInfo['img'], $imgInfo['ext'], $types, $_POST['relatedpages']);
                $page->addError($user->getDBError());
                if ($page->hasErrors())
                    $_SESSION['errorMsg'] = 'Errore di inserimento nel database';
                else
                    $_SESSION['successMsg'] = "Modifica avvenuta con successo e in attesa di approvazione";
            }
        }
    } else { // altrimenti devo effettuare il completamento dei campi
        $modifiedpage = !empty($_SESSION['modification']['instime']);
        $info = $user->getArticleInfo($_SESSION['modification']['pageid'], ($modifiedpage ? $_SESSION['modification']['instime'] : null));
    }
}

if ($_SESSION['errorMsg'] || $_SESSION['successMsg']){
	header('Location: avviso.php');
	exit();
}

unset($_SESSION['modification']);
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Modifica Pagina | Filo di Arianna</title>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Accedi al tuo profilo o registrati." />
    <meta name="author" content="Laura Cameran" />
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

		<section id="modificapagina">

			<h1>Modifica la pagina "<?php echo $info['title']; ?>"</h1>

			<form action="modificapagina.php" method="post" enctype="multipart/form-data">
			    <input type="hidden" name="articleID" value="'<?php echo $info['insTime']; ?>'"/>
			    <input type="hidden" name="instime" value="<?php echo $info['insTime']; ?>">
				<div class="form-group">
                    <?php if ($info['img']): ?>
    			        <img id="oldimage" src="data:image/<?php echo $info['ext']; ?>;base64,<?php echo base64_encode($info['img']); ?>" alt="Vecchia immagine" />
                    <?php endif; ?>
					<label for="FormControlFile">Carica l'immagine per sostituire la precedente.</label>
					<input type="file" class="form-control-file" id="FormControlFile"/>
				</div>

				<div class="form-group">
					<label for="exampleFormControlTextarea1">Descrizione</label>
					<textarea class="form-control" id="exampleFormControlTextarea1" rows="10" name="content" placeholder="Inserisci una descrizione qui"><?php echo $info['content']; ?></textarea>
				</div>

                <div class="form-group">
                    <label for="inputCategorie">Categorie</label>
                    <select name="types" id="inputCategorie" class="form-control">
                        <optgroup label="Personaggi">
                            <option value="p_umani" <?php echo $page->selectRefill($_POST['types'],"p_umani"); ?>>Esseri Umani</option>
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
                        </optgroup>
                    </select>
                </div>

				<fieldset id="correlate" class="form-group">
					<legend>Pagine correlate</legend>
					<p class="row">
						<label for="1" class="col-xs-1">1</label>
						<select id="1" name="relatedpages[]" class="form-control col-xs-9">
                            <option value="none" selected="selected">Nessuna</option>
                            <?php $page->printSelect($user->searchArticle('')); ?>
                        </select>
					</p>
					<button type="button" id="plus" class="btn" onclick="plusClick()" aria-label="Aggiungi correlata">
						<svg>
                            <path d="M 28, 20 h -8 v 8 h -4 v -8 h -8 v -4 h 8 v -8 h 4 v 8 h 8 v 4 z" />
                        </svg>
					</button>
				</fieldset>

                <a href="#correlate" class="sr-only">Torna all'inserimento delle pagine correlate</a>

				<div class="form-group submit-button">
					<button type="submit" class="btn  btn-outline-primary">Fatto</button>
				</div>

			</form>
        </section>
	</div>
	<!-- FOOTER -->
    <?php include_once '../HTML/footer.html'; ?>

</body>

</html>
