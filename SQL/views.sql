/* Vista che seleziona le pagine non postate e le modifiche non ancora approvate */
CREATE VIEW unpostedPages AS
	SELECT P.ID, U.insTime, P.title, P.visits, P.author
	FROM (SELECT ID, insTime 
				FROM _pages 
				WHERE posted = FALSE
					UNION 
				SELECT ID, modTime 
				FROM _modifiedPages) AS U,
				_pages AS P
	WHERE P.ID = U.ID;

/* Vista che seleziona le pagine postate*/
CREATE VIEW postedPages AS
	SELECT ID, title, author, visits
	FROM _pages
	WHERE posted = TRUE;
	
/* Vista che seleziona le pagine correlate */
CREATE VIEW relatedPages AS
	SELECT R.ID1 AS ID1, P1.title AS title1, P1.author AS author1, P1.visits AS visits1, 
         R.ID2 AS ID2, P2.title AS title2, P2.author AS author2, P2.visits AS visits2
	FROM (_pages AS P1 
						JOIN 
				_relations AS R ON P1.ID = R.ID1)
						JOIN
				_pages AS P2 ON P2.ID = R.ID2
	WHERE P1.ID <> P2.ID AND P1.posted = TRUE AND P2.posted = TRUE;
	
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