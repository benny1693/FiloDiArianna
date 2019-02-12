<?php
/**
 * Created by PhpStorm.
 * User: benedetto
 * Date: 11/02/19
 * Time: 20.22
 */

require_once 'Page.php';

class SearchPage extends Page {

	private $index = 1;
	private $limit = 10;
	private $articles = 0;

	/** stabilisce la visualizzazione in versione amministrazione tramite l'uso di tre livelli:
	 * 0 : nessuna amministrazione
	 * 1 : modifica ed eliminazione
	 * 2 : approvazione, modifica ed eliminazione
	*/
	private $administration = 0;

	public function __construct($index, $articles, $limit =10){
		$this->index = $index > 0 ? $index : 0;
		$this->articles = $articles >= 0 ? $articles : 0;
		$this->limit = $limit > 0 ? $limit : 10;

		if ($this->lastPage() == 0)
			$this->index = 0;

		if ($this->index == 0 && $this->lastPage() > 0)
			throw new Exception();

		if ($this->index > $this->lastPage())
			throw new Exception();
	}

	public function getIndex() { return $this->index; }

	public function getLimit() { return $this->limit; }

	public function getArticles() { return $this->articles; }


	public function setAdministration($priority) { $this->administration = $priority; }


	public function lastPage() { return ceil($this->articles / $this->limit); }

	public function noResults() { return $this->articles == 0; }

	public function offset() { return ($this->index - 1) * $this->limit; }


	public function printArticleSublist($articleList, $admin = false) {

		if ($articleList != null) {
			if (!$this->administration) {
				foreach ($articleList as $article){
					echo '
				<li>
					<a href="articolo.php?articleID='.$article['ID'].'">
						<p class="articleTitle">' . stripslashes($article['title']) . '</p>
						<p class="description">' . stripslashes(substr($article['content'], 0, 100)) . '</p>
					</a>
				</li>';
				}
			} else {
				foreach ($articleList as $article){
					echo '
										<li class="page-administration clearfix">
                        <form action="pageaction.php" method="post">
                            <a class="pagina" href="articolo.php?articleID='.$article['ID'].($this->administration ? '&instime='.$article['insTime'] : '').'">
                            	<p>'.$article['title'].'</p>
                            	<p class="time">'.$article['insTime'].'</p>
                            </a>
                            <div class="bottoni">
                            		<input type="hidden" name="pageid" value="'.$article['ID'].'" />
                            		<input type="hidden" name="instime" value="'.$article['insTime'].'" />';

					if ($admin && $this->administration == 2)
						echo '<input type="submit" class="btn  btn-outline-primary" name="action" value="Accetta" />';

					echo '
                                <input type="submit" class="btn btn-outline-primary" name="action" value="Modifica" />
                                <input type="submit" class="btn btn-outline-primary" name="action" value="Elimina" />
                            </div>
                        </form>
                    </li>';
				}
			}
		}
	}

	function printArticleList($list,$admin = false){
		if ($this->index < $this->lastPage())
			$this->printArticleSublist(array_slice($list,$this->offset(),$this->limit), $admin);
		else
			$this->printArticleSublist(array_slice($list,$this->offset()),$admin);
	}

	private function printUserSublist($userList)
	{
		foreach ($userList as $row) {

			echo
				"
				<li class=\"page-administration clearfix\">
					<form action=\"gestioneutenti.php\" method=\"post\">
						<input type=\"hidden\" name=\"userID\" value=\"" . $row['ID'] . "\"/>
						<a class=\"pagina\" href=\"profilopubblico.php?ID=" . $row['ID'] . "\">" . $row['username'] . "</a>";

			if ($row['is_admin'] == 0)
				echo "
						<div class=\"bottoni\">
							<button type=\"submit\" class=\"btn btn-outline-primary\">Elimina</button>
						</div>";

			echo "
					</form>
				</li>";
		}
	}

	public function printUserList($userList) {
			if ($this->index < $this->lastPage())
				$this->printUserSublist(array_slice($userList,$this->offset(),$this->limit));
			else
				$this->printUserSublist(array_slice($userList,$this->offset()));
	}

	function printLinkRicerca($category,$substring,$subcategory,$page,$text) {
		echo '
					<li class="page-item"><a href="ricerca.php?category=' . $category . '&substringSearched=' . $substring . '&subcategory=' . $subcategory . '&page=' . $page . '" class="page-link">' . $text . '</a></li>';
	}

	function printLinkUser($page,$text) {
		echo '
					<li class="page-item"><a href="gestioneutenti.php?page='.$page.'" class="page-link">'.$text.'</a></li>';
	}

	function printLinkManageArticle($page,$text) {
		echo '
					<li class="page-item"><a href="listapagine.php?adm='.$this->administration.'&page='.$page.'" class="page-link">'.$text.'</a></li>';
	}

	function printLink($article,$page,$text) {
		if ($article) {
			if ($this->administration == 0) {
				$this->printLinkRicerca($_GET['category'], $_GET['substringSearched'], $_GET['subcategory'], $page, $text);
			} else {
				$this->printLinkManageArticle($page,$text);
			}
		} else
			$this->printLinkUser($page,$text);
	}

	function printNavigation($article = true){
		echo '<nav aria-label="Paginazione" class="nav-pages">
                <ul class="pagination">';
		if ($this->index == 1)
			echo '
					<li class="page-item disabled"><a href="#">&laquo;</a></li>
					<li class="page-item disabled"><a href="#">&lsaquo;</a></li>';
		else {
			$this->printLink($article,1,'&laquo;');
			$this->printLink($article,$this->index - 1, '&lsaquo;');
		}

		for ($i = 0; $i < 5; $i++) {
			if ($this->index - 2 + $i > 0 && $this->index - 2 + $i <= $this->lastPage()) {
				if ($i == 2)
					echo '<li class="page-item disabled"><a href="#">'.$this->index.'</a></li>';
				else
					$this->printLink($article,$this->index + $i - 2,$this->index + $i - 2);
			}
		}

		if ($this->index == $this->lastPage())
			echo'
					<li class="page-item disabled"><a href="#" >&rsaquo;</a></li>
					<li class="page-item disabled"><a href="#" >&raquo;</a></li>';
		else {
			$this->printLink($article,$this->index + 1,'&rsaquo;');
			$this->printLink($article,$this->lastPage(),'&raquo;');
		}
		echo '</ul>
            </nav>';
	}

}