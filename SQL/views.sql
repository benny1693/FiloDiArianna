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