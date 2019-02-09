create database Prova;
use Prova;
source tables.sql;
source views.sql;
source procedures.sql;

call insertUser('ciccio90','ciccio','pasticcio','1993-01-01','M','ciccio@pasticcio.it','ciao',TRUE);

call insertPage('ciao',NULL,NULL,NULL,1,'eventi','eradei');
call insertPage('ciao1',NULL,NULL,NULL,1,'personaggi','eroi');
call insertPage('ciao2',NULL,NULL,NULL,1,'luoghi','mitologici');

call insertModification(1,NULL,NULL,NULL,'eventi','eraeroi');
call insertModification(2,NULL,NULL,NULL,'eventi','eradeiuomini');

call insertRelationship(1,2);
call insertRelationship(2,1);
call insertRelationship(1,3);
call insertRelationship(3,2);

call insertComment(1,"bello questo articolo",1);
call insertComment(1,"davvero bello questo articolo",1);
call insertComment(1,"bellissimo questo articolo",1);

call setPostStatus(1,1);
call setPostStatus(2,1);
call setPostStatus(3,1);