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
CREATE PROCEDURE insertPage(_title VARCHAR(30), _htmlCode TEXT, _img BLOB, _author VARCHAR(20),
														 	_type1 VARCHAR(18), _type2 VARCHAR(18))
BEGIN
	DECLARE _ID INTEGER;
	
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
	SET insTime=_modTime,htmlCode=_htmlCode,img=_img, posted = TRUE
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
END|
DELIMITER ;

/*	Imposta il valore posted della pagina indicata
		@param _ID indica il codice della pagina da postare
		@param _posted indica il nuovo valore a cui bisogna impostare posted
*/
DELIMITER |
CREATE PROCEDURE setPostStatus(_ID INTEGER, _posted BOOLEAN)
BEGIN
	UPDATE _pages
	SET posted=_posted
	WHERE ID = _ID;
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