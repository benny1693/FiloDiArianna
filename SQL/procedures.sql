/* 	Inserisce nel database la pagina con i dati indicati.
		@param _title indica il titolo da assegnare alla pagina
		@param _htmlCode indica il codice HTML relativo alla pagina inserita
		@param _img indica l'immagine che correda l'articolo
		@param type1 indica la categoria principale dell'articolo (eventi,luoghi o personaggi)
		@param type2 indica la sottocategoria dell'articolo
					 Per eventi:
							- Dei
							- Eroi
							- Dei e Uomini
					 Per luoghi:
					 		- Reale
							- Mitologico
					 Per personaggi:
					 		- Essere Umano
							- Semidivinità o Eroe
							- Divinità
							- Creatura
*/
DELIMITER |
CREATE PROCEDURE insertPage(_title VARCHAR(30), _htmlCode TEXT, _img BLOB, _author INTEGER,
														 	_type1 VARCHAR(18), _type2 VARCHAR(18))
BEGIN
	DECLARE _ID INTEGER;
	
	IF (EXISTS (SELECT * FROM _pages WHERE title = _title))
	THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pagina esistente';
	END IF;
	
	INSERT INTO _pages (title,htmlCode,img,author)
	VALUES (_title, LOAD_FILE(_htmlCode), LOAD_FILE(_img),_author);
	
	SELECT ID INTO _ID 
	FROM _pages 
	WHERE title = _title
	LIMIT 1;
	
	IF _type1 = 'eventi' THEN
		INSERT INTO _events(ID,era) VALUES(_ID,_type2);
	ELSEIF _type1 = 'luoghi' THEN
		INSERT INTO _places(ID,mythological) VALUES(_ID,(_type2 = 'mitologico'));
	ELSE
		INSERT INTO _characters(ID,type) VALUES(_ID,_type2);
	END IF;
END|
DELIMITER ;

/*	Permette l'inserimento di una modifica di una pagina. La nuova versione della pagina
		viene inserita tra quelle pendenti.
		@param _ID indica il codice della pagina da modificare
		@param _htmlCode rappresenta il codice HTML modificato
		@param _img rappresenta l'immagine che correda la voce
		@param _type1 indica la categoria principale 
		@param type2 indica la sottocategoria dell'articolo
					 Per eventi:
							- Dei
							- Eroi
							- Dei e Uomini
					 Per luoghi:
					 		- Reale
							- Mitologico
					 Per personaggi:
					 		- Essere Umano
							- Semidivinità o Eroe
							- Divinità
							- Creatura
*/
DELIMITER |
CREATE PROCEDURE insertModification(_ID INTEGER, _htmlCode TEXT, _img BLOB, 
														_type1 VARCHAR(18), _type2 VARCHAR(18))
BEGIN
		INSERT INTO _modifiedPages (ID,htmlCode,img,type1,type2)
		VALUES (_ID,_htmlCode,_img,_type1,_type2);
END|
DELIMITER ;

/* 	Approva la modifica della pagina con i dati indicati e la elimina tra quelle pendenti.
		@param _ID indica il codice identificativo della pagina da postare
		@param _modTime indica il timestamp della pagina voluta
*/
DELIMITER |
CREATE PROCEDURE approveModification(_ID INTEGER, _modTime TIMESTAMP(6))
BEGIN
	DECLARE _htmlCode TEXT;
	DECLARE _img BLOB;
	DECLARE _type1 VARCHAR(18);
	DECLARE _type2 VARCHAR(18);
	
	SELECT htmlCode,img,type1,type2 INTO _htmlCode,_img,_type1,_type2
	FROM _modifiedPages
	WHERE ID=_ID AND modTime=_modTime;

	UPDATE _pages
	SET insTime=_modTime,htmlCode=_htmlCode,img=_img, posted = FALSE
	WHERE ID = _ID;
	
	DELETE FROM _events WHERE ID = _ID;
	DELETE FROM _characters WHERE ID = _ID;
	DELETE FROM _places WHERE ID = _ID;
	DELETE FROM _modifiedPages WHERE ID = _ID AND modTime = _modTime;
	
	IF _type1 = 'eventi' THEN
		INSERT INTO _events VALUES(_ID,_type2);
	ELSEIF _type1 = 'luoghi' THEN
		INSERT INTO _places VALUES(_ID,(_type2 = 'mitologico'));
	ELSE
		INSERT INTO _characters VALUES(_ID,_type2);
	END IF;
	
	call setPostStatus(_ID,TRUE);	
END|
DELIMITER ;

/*	Imposta il valore posted della pagina indicata
		@param _ID indica il codice della pagina da postare
		@param _posted indica il nuovo valore a cui bisogna impostare posted
*/
DELIMITER |
CREATE PROCEDURE setPostStatus(_ID INTEGER, _posted BOOLEAN)
BEGIN
	DECLARE isPosted BOOLEAN;
	
	SELECT posted INTO isPosted FROM _pages WHERE ID = _ID;

	UPDATE _pages SET posted=_posted WHERE ID = _ID;
	
	IF (isPosted <> _posted)
	THEN
		IF (_posted = FALSE) 
		THEN
			INSERT INTO _pendantRelations SELECT ID1, ID2, insTime
																		FROM _relations JOIN _pages ON ID1 = ID
																		WHERE ID1 = _ID OR ID2 =_ID;
																	
			DELETE FROM _relations WHERE ID1 = _ID OR ID2 = _ID;
		ELSE
			INSERT INTO _relations SELECT DISTINCT ID1, ID2
														 FROM _pendantRelations
														 WHERE (ID1 = _ID AND ID2 IN (SELECT ID 
																													FROM _pages 
																												 	WHERE posted = TRUE)) 
																		OR (ID2 = _ID AND ID1 IN (SELECT ID 
																														 	FROM _pages 
																														 	WHERE posted = TRUE));
														 
			DELETE FROM _pendantRelations WHERE ((ID1 = _ID AND ID2 IN (SELECT ID 
																													FROM _pages 
																												 	WHERE posted = TRUE)) 
																					 	OR (ID2 = _ID AND ID1 IN (SELECT ID 
																																			FROM _pages 
																														 					WHERE posted = TRUE)));
		END IF;
	END IF;
			
END|
DELIMITER ;

/*	Rifiuta la modifica inserita 
		@param _ID indica il codice della pagina modificata
		@param _modTime indica il timestamp della modifica
*/
DELIMITER |
CREATE PROCEDURE declineModification(_ID INTEGER, _modTime TIMESTAMP(6))
BEGIN
	DELETE FROM _modifiedPages WHERE ID = _ID AND modTime = _modTime;
END|
DELIMITER ;

/*	Se non esiste, crea una relazione da una pagina verso un'altra
		@param _ID1 indica il codice identificativo della pagina
		@param _ID2 indica il codice della pagina correlata
*/
DELIMITER |
CREATE PROCEDURE insertRelationship(_ID1 INTEGER, _ID2 INTEGER)
BEGIN
	IF (EXISTS(SELECT * 
							FROM _relations 
							WHERE ID1 = _ID1 AND ID2 = _ID2))
	THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Relazione esistente';
	END IF;
	
	INSERT INTO _relations VALUES (_ID1,_ID2);
END|
DELIMITER ;


/* Se non esiste, crea una relazione da una pagina pendente verso un'altra
		@param _ID1 indica il codice identificativo della pagina
		@param _ID2 indica il codice della pagina correlata
		@param _modTime è il timestamp della modifica della pagina scelta
*/
DELIMITER |
CREATE PROCEDURE insertPendantRelationship(_ID1 INTEGER, _ID2 INTEGER, _modTime TIMESTAMP(6))
BEGIN
	IF (EXISTS (SELECT * 
						  FROM _pendantRelations 
						  WHERE ID1 = _ID1 AND ID2 = _ID2 AND modTime = _modTime))
	THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Relazione esistente';
	END IF;
	
	INSERT INTO _pendantRelations(ID1,ID2,modTime) VALUES (_ID1,_ID2,_modTime);
END |
DELIMITER ;

/*	Elimina la pagina indicata */
DELIMITER |
CREATE PROCEDURE deletePage(_ID INTEGER)
BEGIN
	IF (_ID NOT IN (SELECT _ID FROM _pages))
	THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pagina non trovata';
	END IF;
	
	DELETE FROM _pages WHERE ID = _ID;
END|
DELIMITER ;

/* Inserisce un nuovo utente se non è già presente 
	 @param _name : nome utente
	 @param _passw : password indicata
	 @param _admin : parametro che è true se l'utente inserito è un amministratore
*/
DELIMITER |
CREATE PROCEDURE insertUser(_name VARCHAR(25),_passw VARCHAR(40), _admin BOOLEAN)
BEGIN
	IF (_name IN (SELECT name FROM _users))
	THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Utente esistente';
	END IF;
	
	INSERT INTO _users(name,pass_word,is_admin) VALUES (_name,SHA1(_passw),_admin);
END|
DELIMITER ;