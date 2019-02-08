<?php
include_once 'utilities.php';
$user = init();
if (!empty($_POST)){
	$img = file_get_contents($_FILES['image']['tmp_name']);
	$path = $_FILES['image']['name'];
	$type = pathinfo($path, PATHINFO_EXTENSION);

	$types = array();
    switch (substr($_POST['types'],0,1)):
      case 'p':
          $types[0] = 'personaggi';
          break;
      case 'e':
          $types[0] = 'eventi';
          break;
      case 'l':
          $types[0] = 'luoghi';
          break;
    endswitch;

    if ($types[0] == 'eventi'){
        $types[1] = str_replace('_','',$_POST['types']);
    } else {
        $types[1] = substr($_POST['types'],2);
    }

    $_POST['relatedpages'] = array_diff($_POST['relatedpages'],array('none'));

    $user->insertArticle($_POST['title'],$_POST['content'],$img,$_SESSION['ID'],$_POST['types'],$_POST['relatedpages']);
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
		<section id="nuovapagina">';

                if ($user->getDBConnection()->getError() != 0)
                    printFeedback('Pagina non inserita',false);
		        else
		            if (!empty($_POST))
		                printFeedback('Pagina inserita e in attesa di approvazione',true);

		        echo '		    
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
					<select name="types" id="inputCategorie" class="form-control">
						<optgroup label="Personaggi">
							<option value="p_umani">Esseri Umani</option>
							<option value="p_eroi">Semidivinit&agrave;/Eroi</option>
							<option value="p_dei">Divinità</option>
							<option value="p_creature">Creature</option>
						</optgroup>
						<optgroup label="Eventi">
							<option value="era_dei">Era degli Dei</option>
							<option value="era_dei_uomini">Era degli Dei e degli Uomini</option>
							<option value="era_eroi">Era degli Eroi</option>
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