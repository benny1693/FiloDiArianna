<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 07/02/19
 * Time: 0.30
 */
include_once 'utilities.php';
$user = init();
if ($user->isRegistered()){
	if ($_SERVER['HTTP_REFERER'] != "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'])
		$_SESSION['errorMsg'] = 'Sei gi&agrave; registrato!';
	else
		$_SESSION['errorMsg'] = 'Registrazione effettuata con successo';

	header('Location: avviso.php');
}

$page = new FormPage();
if (!empty($_POST)) {

    $page->inferRegistrationErrors($_POST,$user);

    if (!$page->hasErrors()){
    	session_destroy();
	    $user = init();
	    $user = login($_POST['username'], $_POST['password']);
    }
}

print_r($page->errors);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it-IT" lang="it-IT">

<head>
	<title>Pagina di registrazione | Filo di Arianna</title>
	<meta charset="utf-8" />
    <meta name="author" content="Laura Cameran" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Accedi al tuo profilo o registrati." />
	<meta name="keywords" content="greco, antico, ellenico, grecia, enciclopedia, mitologia, registrazione, registrati" />
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
				<li class="breadcrumb-item active" aria-current="page">Registrazione</li>
			</ol>
		</nav>

        <section id="registrazione">
            <h1>Registrati</h1>
            <form data-toggle="validator" action="registrazione.php" method="post">

                <div class="form-group row">
                    <label for="inputName" class="col-sm-3 col-form-label">Nome</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputName" name="name" placeholder="Nome" required="required" aria-required="true" <?php echo ($page->hasErrors() ? 'value="'.$_POST['name'].'"' : ""); ?> onblur="return checkText('inputName','Nome non valido',/^[a-zA-Z]{1,20}$/);"/>
                        <?php
                        if ($page->errors['name'])
                            $page->printFeedback('Nome non valido',false);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputSurname" class="col-sm-3 col-form-label" >Cognome</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputSurname" name="surname" placeholder="Cognome" required="required" aria-required="true" <?php echo ($page->hasErrors() ? 'value="'.$_POST['surname'].'"' : ""); ?> onblur="return checkText('inputSurname','Cognome non valido',/^[a-zA-Z' ]{1,20}$/);"/>
                        <?php
                        if ($page->errors['surname'])
                            $page->printFeedback('Cognome non valido',false);
                        ?>
                    </div>
                </div>

                 <fieldset class="form-group row">
                     <legend class="col-sm-3 col-form-label">Sesso</legend>
                     <div class="col-sm-9" role="radiogroup">
                         <div class="form-check">
                             <input class="form-check-input" type="radio" name="gender" id="male" value="M" checked="checked" />
                             <label class="form-check-label" for="male">
                                 Maschio
                             </label>
                         </div>
                         <div class="form-check">
                             <input class="form-check-input" type="radio" name="gender" id="female" value="F"/>
                             <label class="form-check-label" for="female">
                                 Femmina
                             </label>
                         </div>
                     </div>
                 </fieldset>

                <div class="form-group row">
                    <label for="inputDate" class="col-sm-3 col-form-label">Data di nascita</label>
                    <div class="col-sm-9">
                        <input type="date" class="form-control" id="inputDate" name="birthdate" required="required" aria-required="true" <?php echo ($page->hasErrors() ? 'value="'.$_POST['birthdate'].'"' : ""); ?> onblur="return invalidBirthDay();" />
                        <?php
                        if ($page->errors['birthdate'])
                            $page->printFeedback($page->errors['birthdate'],false);
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputEmail" class="col-sm-3 col-form-label" lang="en">Email</label>
                    <div class="col-sm-9">
                        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email" required="required" aria-required="true" <?php echo ($page->hasErrors() ? 'value="'.$_POST['email'].'"' : ""); ?> onblur="return checkEmail();"/>
                        <?php
                        if ($page->errors['email'])
                            $page->printFeedback('Email non valida',false);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputUsername" class="col-sm-3 col-form-label" lang="en">Username</label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="inputUsername" name="username" placeholder="Username" required="required" <?php echo ($page->hasErrors() ? 'value="'.$_POST['username'].'"' : "")?> onblur="return checkText('inputUsername','Username non valido',/^[a-zA-Z0-9]+$/)"/>
                        <p class="help-block">Lo username pu&ograve contenere solo lettere e numeri.</p>
                        <?php
                        if ($page->errors['username'])
                            $page->printFeedback($page->errors['username'],false);
                        ?>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-3 col-form-label" lang="en">Password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" name="password" id="inputPassword" placeholder="Password" required="required" onblur="return checkText('inputPassword','Password errata',/^([a-zA-Z0-9!@#$%^&*]){6,12}$/);"/>
                        <p class="help-block">La password deve contenere tra 6-12 caratteri.</p>
                        <?php
                        if ($page->errors['password'])
                            $page->printFeedback('Password non valida',false);
                        ?>
                    </div>
                    <label for="inputPasswordConfirm" class="col-sm-3 col-form-label">Conferma password</label>
                    <div class="col-sm-9">
                        <input type="password" class="form-control" id="inputPasswordConfirm" name="confirmpass" placeholder="Conferma password" required="required" onblur="return isPasswordEqual();"/>
                        <?php
                        if ($page->errors['confirmpass'])
                            $page->printFeedback('Le password non corrispondono',false);
                        ?>
                    </div>
                </div>

                <div class="col-sm-10 col-sm-offset-3">
                    <button type="submit" id="fatto" class="btn  btn-outline-primary" >Fatto</button>
                </div>
            </form>
        </section>
	</div>
	<?php include_once '../HTML/footer.html'; ?>
</body>

</html>