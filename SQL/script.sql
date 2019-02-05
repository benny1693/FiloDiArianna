create database Prova;
use Prova;
source tables.sql;
source views.sql;
source procedures.sql;

call insertUser('ciccio90','ciccio','pasticcio','1993-01-01','M','ciccio@pasticcio.it','ciao',TRUE);

call insertPage('ciao',NULL,NULL,1,'Evento','Dei');
call insertPage('ciao1',NULL,NULL,1,'Personaggio','Eroe');
call insertPage('ciao2',NULL,NULL,1,'Luogo','mitologico');

call insertModification(1,NULL,NULL,'Evento','Eroi');
call insertModification(2,NULL,NULL,'Evento','Dei e Uomini');

call insertRelationship(1,2);
call insertPendantRelationship(1,2);
call insertRelationship(2,1);
call insertRelationship(1,3);
call insertRelationship(3,2);

call insertComment(1,"bello questo articolo",1);
call insertComment(1,"davvero bello questo articolo",1);
call insertComment(1,"bellissimo questo articolo",1);

call setPostStatus(1,1);
call setPostStatus(2,1);
call setPostStatus(3,1);