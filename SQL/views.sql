CREATE VIEW unpostedPagesInfo AS
	 SELECT ID, insTime, content, img, ext
	 FROM _pages
	 WHERE posted = FALSE
					UNION
	 SELECT ID, modTime, content, img, ext
	 FROM _modifiedPages;
				
/* Vista che seleziona le pagine non postate e le modifiche non ancora approvate */
CREATE VIEW unpostedPages AS
	SELECT U.ID, U.insTime, P.title, P.author, P.visits, U.img, U.content, U.ext
	FROM unpostedPagesInfo 	AS U,
				_pages AS P
	WHERE P.ID = U.ID;

/* Vista che seleziona le pagine postate */
CREATE VIEW postedPages AS
	SELECT ID, insTime ,title, author, visits, img, content, ext
	FROM _pages
	WHERE posted = TRUE;

/* Vista che seleziona tutte le pagine postate e non postate */
CREATE VIEW allPages AS
  SELECT DISTINCT *
  FROM (SELECT * FROM postedPages UNION SELECT * FROM unpostedPages) AS U;

/* Vista che seleziona le pagine correlate */
CREATE VIEW relatedPages AS
	SELECT R.ID1 AS ID1, P1.insTime AS insTime1,P1.title AS title1, P1.author AS author1, P1.visits AS visits1,
         R.ID2 AS ID2, P2.insTime AS insTime2,P2.title AS title2, P2.author AS author2, P2.visits AS visits2
	FROM (_pages AS P1
						JOIN 
				_relations AS R ON P1.ID = R.ID1)
						JOIN
				_pages AS P2 ON P2.ID = R.ID2
	WHERE P1.ID <> P2.ID AND P1.posted = TRUE AND P2.posted = TRUE;

/* Vista che seleziona tutte le pagine non postate in relazione con pagine postate */
CREATE VIEW relatedPendantPages AS
  SELECT U.ID AS ID1, U.title AS title1, U.insTime AS insTime1, U.author AS author1, U.visits as visits1,
         P.ID AS ID2, P.title AS title2, P.insTime AS insTime2,P.author AS author2, P.visits as visits2
  FROM unpostedPages AS U,
       _pendantRelations AS R,
       postedPages AS P
	WHERE U.ID = R.ID1 AND U.insTime = R.modTime AND R.ID2 = P.ID AND U.ID <> P.ID;

/* Vista che seleziona tutte le pagine postate  e non in relazione con pagine postate */
CREATE VIEW allRelatedPages AS
  SELECT * FROM relatedPages
			UNION
	SELECT * FROM relatedPendantPages;


/* Vista che selezione gli admin */
CREATE VIEW admins AS
	SELECT ID,name
	FROM _users
	WHERE is_admin = TRUE;

/* Vista che selezione gli utenti normali */
CREATE VIEW normalUsers AS
	SELECT ID,name
	FROM _users
	WHERE is_admin = FALSE;
	
/* Vista che seleziona tutti i commenti con autore del commento e 
pagina commentata */
CREATE VIEW commentedArticles AS
	SELECT P.ID AS pageID, P.title AS pageTitle, P.author AS pageAuthor,
				C.time_stamp AS commentTime, C.author AS commentAuthor, U.username AS commentAuthorName, C.content AS pageComment
	FROM (Prova._pages AS P JOIN Prova._comments AS C ON P.ID = C.pageID)
				JOIN Prova.`_users` AS U ON C.author = U.ID
	ORDER BY C.time_stamp ASC;