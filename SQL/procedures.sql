/* 	Inserisce nel database la pagina con i dati indicati.
		@param _title: 		indica il titolo da assegnare alla pagina
		@param _content: 	indica il contenuto relativo alla pagina inserita
		@param _img: 			indica la stringa in base64 dell'immagine che correda l'articolo
		@param _ext:			indica l'estensione originaria dell'immagine
		@param type1: 		indica la categoria principale dell'articolo (eventi,luoghi o personaggi)
		@param type2: 		indica la sottocategoria dell'articolo
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
		@throws: 					segnala un errore se la pagina già esiste
*/
DELIMITER |
CREATE PROCEDURE insertPage(_title VARCHAR(150), _content TEXT, _img LONGBLOB, _ext VARCHAR(5),_author INTEGER,
														 	_type1 VARCHAR(18), _type2 VARCHAR(18))
BEGIN
	DECLARE _ID INTEGER;
	
	/* Se la pagina già esiste, segnalo un errore */
	IF (EXISTS (SELECT * FROM _pages WHERE title = _title))
	THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Pagina esistente';
	END IF;
	
	/* Inserisco la pagina tra la lista totale delle pagine*/
	INSERT INTO _pages (title,content,img,ext,author)
	VALUES (_title, _content, _img,_ext,_author);
	
	/* Ne seleziono l'ID */
	SELECT ID INTO _ID 
	FROM _pages 
	WHERE title = _title
	LIMIT 1;
	
	/* La inserisco nella giusta categoria */
	call insertInCategories(_ID,_type1,_type2);
END|
DELIMITER ;

/*	Permette l'inserimento di una modifica di una pagina. La nuova versione della pagina
		viene inserita tra quelle pendenti.
		@param _ID: 			indica il codice della pagina da modificare
		@param _content: rappresenta il codice HTML modificato
		@param _img: 			rappresenta l'immagine che correda la voce
		@param _ext:			indica l'estensione originaria dell'immagine
		@param _type1: 		indica la categoria principale 
		@param type2: 		indica la sottocategoria dell'articolo
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
CREATE PROCEDURE insertModification(_ID INTEGER, _content LONGTEXT, _img LONGBLOB, _ext VARCHAR(5),
														_type1 VARCHAR(18), _type2 VARCHAR(18))
BEGIN
		INSERT INTO _modifiedPages (ID,content,img,ext,type1,type2)
		VALUES (_ID,_content,_img,_ext,_type1,_type2);
END|
DELIMITER ;

/* 	Approva la modifica della pagina con i dati indicati e la elimina tra quelle pendenti.
		@param _ID indica il codice identificativo della pagina da postare
		@param _modTime indica il timestamp della pagina voluta
*/
DELIMITER |
CREATE PROCEDURE approveModification(_ID INTEGER, _modTime TIMESTAMP(6))
BEGIN
	DECLARE _content LONGTEXT;
	DECLARE _img LONGBLOB;
	DECLARE _ext VARCHAR(5);
	DECLARE _type1 VARCHAR(18);
	DECLARE _type2 VARCHAR(18);

	IF EXISTS(SELECT * FROM _modifiedPages WHERE ID=_ID AND modTime=_modTime)
	THEN
		/* Seleziono i valori della pagina modificata */
		SELECT content,img,ext,type1,type2 INTO _content,_img,_ext,_type1,_type2
		FROM _modifiedPages
		WHERE ID=_ID AND modTime=_modTime;

		/* Eseguo l'update */
		UPDATE _pages
		SET insTime=_modTime,content=_content,img=_img,ext=_ext, posted = FALSE
		WHERE ID = _ID;

		/* Elimino la pagina dalle sotto-categorie */
		DELETE FROM _events WHERE ID = _ID;
		DELETE FROM _characters WHERE ID = _ID;
		DELETE FROM _places WHERE ID = _ID;
		DELETE FROM _modifiedPages WHERE ID = _ID AND modTime = _modTime;

		/* Inserisco la pagina nella sotto-categoria corretta */
		call insertInCategories(_ID,_type1,_type2);

		call setPostStatus(_ID,TRUE);
	END IF;
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
	
	/* Trovo il valore di posted della pagina */
	SELECT posted INTO isPosted FROM _pages WHERE ID = _ID;

	/* Se il valore di posted cambia, allora eseguo la modifica */
	IF (isPosted <> _posted)
	THEN
		/* Eseguo l'update */
		UPDATE _pages SET posted=_posted WHERE ID = _ID;
		
		IF (_posted = FALSE) 
		THEN
		/* 	Se _posted è falso, allora isPosted è vero. 
				Quindi devo rendere le relazioni della pagina pendenti 
		*/
		
		/* Inserisco le relazioni tra quelle pendenti*/
			INSERT INTO _pendantRelations SELECT ID1, ID2, insTime
																		FROM _relations JOIN _pages ON ID1 = ID
																		WHERE ID1 = _ID OR ID2 =_ID;
																	
			/* Elimino le relazioni da quelle confermate */
			DELETE FROM _relations WHERE ID1 = _ID OR ID2 = _ID;
		ELSE
			/* Viceversa, se _posted è vero, allora isPosted è falso.
				 Quindi devo rendere le relazioni pendenti confermate
			*/
			
			/* Inserisco le relazioni pendenti tra quelle confermate */
			INSERT INTO _relations SELECT DISTINCT ID1, ID2
														 FROM _pendantRelations AS P
														 WHERE (ID1 = _ID AND ID2 IN (SELECT ID 
																													FROM postedPages)) 
																		OR (ID2 = _ID AND ID1 IN (SELECT ID 
																														 	FROM postedPages))
																		AND NOT EXISTS (SELECT ID1,ID2 
																										FROM _relations
																									 	WHERE P.ID1 = ID1 AND P.ID2 = ID2);
			/* Elimino le relazioni tra quelle pendenti */
			DELETE FROM _pendantRelations WHERE ((ID1 = _ID AND ID2 IN (SELECT ID 
																													FROM postedPages)) 
																					 	OR (ID2 = _ID AND ID1 IN (SELECT ID 
																																			FROM postedPages)));
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
		@param _ID1: codice identificativo della pagina
		@param _ID2: codice della pagina correlata
		@throws:		 se la relazione esiste segnala un errore
*/
DELIMITER |
CREATE PROCEDURE insertRelationship(_ID1 INTEGER, _ID2 INTEGER)
BEGIN
	IF (NOT EXISTS(SELECT * 
							FROM _relations 
							WHERE ID1 = _ID1 AND ID2 = _ID2))
	THEN
		INSERT INTO _relations VALUES (_ID1,_ID2);
	END IF;
	
END|
DELIMITER ;


/* Se non esiste, crea una relazione da una pagina pendente verso un'altra
		@param _ID1: 		 codice identificativo della pagina
		@param _ID2: 		 codice della pagina correlata
		@param _modTime: timestamp della modifica della pagina scelta
		@throws:				 se la relazione esiste segnala un errore
*/
DELIMITER |
CREATE PROCEDURE insertPendantRelationship(_ID1 INTEGER, _ID2 INTEGER, _modTime TIMESTAMP(6))
BEGIN
	IF (NOT EXISTS (SELECT * 
						  FROM _pendantRelations 
						  WHERE ID1 = _ID1 AND ID2 = _ID2 AND modTime = _modTime)
		 AND NOT EXISTS (SELECT * 
						  FROM _relations 
						  WHERE ID1 = _ID1 AND ID2 = _ID2))
	THEN
		INSERT INTO _pendantRelations(ID1,ID2,modTime) VALUES (_ID1,_ID2,_modTime);
	END IF;
END |
DELIMITER ;

/*	Elimina la pagina indicata 
		@param _ID: codice identificativo della pagina da eliminare
		@throws: 		se la pagina non esiste segnala un errore
*/
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
	 @param _username: 	nome utente
	 @param _name:			nome anagrafico
	 @param _surname:		cognome
	 @param _birthDate:	data di nascita
	 @param _gender:		sesso
	 @param _passw: password indicata
	 @param _admin: parametro che è true se l'utente inserito è un amministratore
	 @throws:				se l'utente già esiste segnala un errore
*/
DELIMITER |
CREATE PROCEDURE insertUser(_username VARCHAR(25),_name VARCHAR(25),_surname VARCHAR(25),_birthDate DATE, _gender ENUM('M','F'), _email VARCHAR(40),_passw VARCHAR(40), _admin BOOLEAN)
BEGIN
	IF (_username IN (SELECT username FROM _users))
	THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Utente esistente';
	END IF;
	
	INSERT INTO _users(username,name,surname,birthDate,gender,email,pass_word,is_admin) VALUES (_username,_name,_surname,_birthDate,_gender,_email,SHA1(_passw),_admin);
END|
DELIMITER ;

/* 	Elimina l'utente scelto 
		@param ID: codice identificativo dell'utente
		@throws:	 segnala un errore, se l'utente indicato è un admin
*/
DELIMITER |
CREATE PROCEDURE deleteUser(_ID INTEGER)
BEGIN
	IF (_ID IN (SELECT ID FROM admins))
	THEN 
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Impossibile eliminare un amministratore';
	END IF;
		
	DELETE FROM _users WHERE ID = _ID;
END|
DELIMITER ;

/* Inserisce un commento a una pagina */
DELIMITER |
CREATE PROCEDURE insertComment(_pageID INTEGER, _content LONGTEXT, _author INTEGER)
BEGIN
	INSERT INTO _comments (pageID,content,author) VALUES (_pageID, _content, _author);
END|
DELIMITER ;

/* Elimina un dato commento */
DELIMITER |
CREATE PROCEDURE deleteComment(_pageID INTEGER, _time_stamp TIMESTAMP(6), _author INTEGER)
BEGIN
	DELETE FROM _comments WHERE pageID = _pageID AND time_stamp = _time_stamp AND author = _author;
END|
DELIMITER ;

/* UTILITIES */
DELIMITER |
CREATE PROCEDURE insertInCategories(_ID INTEGER, _type1 VARCHAR(18), _type2 VARCHAR(18))
BEGIN
	SET _type1 = LOWER(_type1);
	SET _type2 = LOWER(_type2);
	IF _type1 = 'eventi' THEN
		INSERT INTO _events VALUES(_ID,_type2);
	ELSEIF _type1 = 'luoghi' THEN
		INSERT INTO _places VALUES(_ID,_type2);
	ELSE
		INSERT INTO _characters VALUES(_ID,_type2);
	END IF;
END|
DELIMITER ;
