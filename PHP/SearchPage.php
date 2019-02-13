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

	private function printArticle($article){
		echo '
				<li>
					<a href="articolo.php?articleID='.$article['ID'].'">
						<p class="articleTitle">' . stripslashes($article['title']) . '</p>
						<p class="description">' . stripslashes(substr($article['content'], 0, 100)) . '</p>
					</a>
				</li>';
	}

	private function printAdministrationArticle($article,$admin){
		echo '
										<li class="page-administration clearfix">
                        <form action="pageaction.php" method="post">
                            <a class="pagina" href="articolo.php?articleID='.$article['ID'].($this->administration == 2 ? '&instime='.$article['insTime'] : '').'">
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

	public function printArticleSublist($articleList, $admin = false) {

		if ($articleList != null) {
			if (!$this->administration) {
				foreach ($articleList as $article) {
					$this->printArticle($article);
				}
			} else {
				foreach ($articleList as $article)
					$this->printAdministrationArticle($article,$admin);
			}
		}
	}

	function printArticleList($list,$admin = false){
		if ($this->index < $this->lastPage())
			$this->printArticleSublist(array_slice($list,$this->offset(),$this->limit), $admin);
		else
			$this->printArticleSublist(array_slice($list,$this->offset()),$admin);
	}

	private function printAdmin($admin){
			echo
				"
				<li class=\"page-administration clearfix\">
					<a class=\"pagina\" href=\"profilopubblico.php?ID=" . $admin['ID'] . "\">" . $admin['username'] . "</a>
				</li>";

	}

	private function printUser($user) {
		echo
			"
				<li class=\"page-administration clearfix\">
					<form action=\"gestioneutenti.php\" method=\"post\">
						<input type=\"hidden\" name=\"userID\" value=\"" . $user['ID'] . "\"/>
						<a class=\"pagina\" href=\"profilopubblico.php?ID=" . $user['ID'] . "\">" . $user['username'] . "</a>
						<div class=\"bottoni\">
							<button type=\"submit\" class=\"btn btn-outline-primary\">Elimina</button>
						</div>
						</form>
				</li>";
	}

	private function printUserSublist($userList){
		foreach ($userList as $row) {
			if ($row['is_admin'])
				$this->printAdmin($row);
			else
				$this->printUser($row);
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
			echo '<li class="page-item disabled"><a href="#">&laquo;</a></li>';
		else {
			$this->printLink($article,1,'&laquo;');
		}

		for ($i = 0; $i < 3; $i++) {
			if ($this->index - 1 + $i > 0 && $this->index - 1 + $i <= $this->lastPage()) {
				if ($i == 1)
					echo '<li class="page-item disabled"><a href="#">'.$this->index.'</a></li>';
				else
					$this->printLink($article,$this->index + $i - 1,$this->index + $i - 1);
			}
		}

		if ($this->index == $this->lastPage())
			echo'<li class="page-item disabled"><a href="#" >&raquo;</a></li>';
		else
			$this->printLink($article,$this->lastPage(),'&raquo;');

		echo '</ul>
            </nav>';
	}

}