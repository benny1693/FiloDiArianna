#create database Prova;
use maranzat;
source tables.sql;
source views.sql;
source procedures.sql;

call insertUser('admin','TecWeb','UniPD','1990-01-01','M','admin@unipd.it','admin1',TRUE);