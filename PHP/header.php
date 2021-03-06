<?php
require_once "utilities.php";
$header = new Page();
?>

<header>
    <div class="container-fluid">
        <a href="#sidebar-wrapper" class="sr-only">Vai al men&ugrave; di navigazione</a>
        <div class="row navbar">
            <div class="col-sm-2 col-xs-3">
                <img class="navbar-brand" src="<?php echo Page::adjustPath() . 'img/logo.png'; ?>" alt="Logo Filo di Arianna" />
            </div>
            <div class="col-sm-3 col-sm-push-7 col-xs-9">
                <button id="burger-menu" type="button" class="navbar-toggler" aria-hidden="true">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <?php $header->printLogButtons(); ?>
            </div>
            <div class="col-sm-7 col-sm-pull-2 col-xs-12">
                <form class="row navbar-form clearfix" action="<?php echo Page::adjustPath().'PHP/ricerca.php'; ?>" method="get">
                    <div id="categoria" class="navbar-select">
                        <label id="selectCategory" for="inputState" class="sr-only">Seleziona la categoria in cui desideri effettuare la ricerca</label>
                        <select id="inputState" name="category" class="form-control">
                            <option value="not_selected" selected="selected">Categorie</option>
                            <option value="personaggi">Personaggi</option>
                            <option value="eventi">Eventi</option>
                            <option value="luoghi">Luoghi</option>
                        </select>
                    </div>
                    <input title="Search" class="navbar-input col-xs-11" type="text" name="substringSearched" placeholder="Ricerca" />
                    <button class="navbar-button col-xs-1" aria-label="Cerca">
                        <svg id="icon-search">
                            <path d="M11.618 9.897l4.224 4.212c.092.09.1.23.02.312l-1.464 1.46c-.08.08-.222.072-.314-.02L9.868 11.66M6.486 10.9c-2.42 0-4.38-1.955-4.38-4.367 0-2.413 1.96-4.37 4.38-4.37s4.38 1.957 4.38 4.37c0 2.412-1.96 4.368-4.38 4.368m0-10.834C2.904.066 0 2.96 0 6.533 0 10.105 2.904 13 6.486 13s6.487-2.895 6.487-6.467c0-3.572-2.905-6.467-6.487-6.467 "></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
        <nav id="sidebar-wrapper">
            <button type="button" class="close" aria-label="Chiudi il menu">
                <span aria-hidden="true">&times;</span>
            </button>
            <a href="#page-content-wrapper" class="sr-only">Vai al contenuto</a>
            <ul class="sidebar-nav">
                <?php $header->printMenu(); ?>
            </ul>
        </nav>
    </div>
</header>
