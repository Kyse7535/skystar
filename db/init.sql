-- -----------------------------------------------------------------------------
--             G�n�ration d'une base de donn�es pour
--                      Oracle Version 9.xx
--                        (31/12/2021 12:54:24)
-- -----------------------------------------------------------------------------
--      Nom de la base : MLR2
--      Projet : 
--      Auteur : Diallo
--      Date de derni�re modification : 31/12/2021 12:54:20
-- -----------------------------------------------------------------------------

DROP TABLE CONSTELLATION CASCADE CONSTRAINTS;

DROP TABLE JEU CASCADE CONSTRAINTS;

DROP TABLE OBJET_DISTANT CASCADE CONSTRAINTS;

DROP TABLE OBJET_PROCHE CASCADE CONSTRAINTS;

DROP TABLE PARCOURS CASCADE CONSTRAINTS;

DROP TABLE GROUPER CASCADE CONSTRAINTS;

DROP TABLE DETERMINER CASCADE CONSTRAINTS;

-- -----------------------------------------------------------------------------
--       CREATION DE LA BASE 
-- -----------------------------------------------------------------------------

CREATE DATABASE MLR2;

-- -----------------------------------------------------------------------------
--       TABLE : CONSTELLATION
-- -----------------------------------------------------------------------------

CREATE TABLE CONSTELLATION
   (
    ID_CONSTELLATION NUMBER(8)  NOT NULL,
    LATIN_NAME CHAR(50)  NULL,
    OBSERVATION_SAISON CHAR(50)  NULL,
    ETOILE_PRINCIPALE CHAR(40)  NULL,
    RA CHAR(32)  NULL,
    DECA CHAR(32)  NULL,
    TAILLE NUMBER(15,5)  NULL,
    CREATED DATE  NULL,
    UPDATED DATE  NULL
,   CONSTRAINT PK_CONSTELLATION PRIMARY KEY (ID_CONSTELLATION)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : JEU
-- -----------------------------------------------------------------------------

CREATE TABLE JEU
   (
    ID_JEU NUMBER(5)  NOT NULL,
    ID_CONSTELLATION NUMBER(8)  NULL,
    ID_OBJET_DISTANT NUMBER(5)  NULL,
    PSEUDO CHAR(20)  NULL,
    TROUVER NUMBER(1)  NULL,
    DUREE DATE  NULL,
    DATE_CREATION DATE  NULL,
    CREATED DATE  NULL,
    UPDATED DATE  NULL
,   CONSTRAINT PK_JEU PRIMARY KEY (ID_JEU)  
   ) ;

-- -----------------------------------------------------------------------------
--       INDEX DE LA TABLE JEU
-- -----------------------------------------------------------------------------

CREATE  INDEX I_FK_JEU_CONSTELLATION
     ON JEU (ID_CONSTELLATION ASC)
    ;

CREATE  INDEX I_FK_JEU_OBJET_DISTANT
     ON JEU (ID_OBJET_DISTANT ASC)
    ;

-- -----------------------------------------------------------------------------
--       TABLE : OBJET_DISTANT
-- -----------------------------------------------------------------------------

CREATE TABLE OBJET_DISTANT
   (
    ID_OBJET_DISTANT NUMBER(5)  NOT NULL,
    RA NUMBER  NULL,
    DECA NUMBER  NULL,
    MAGNITUDE NUMBER  NULL,
    RA_RADIANS NUMBER  NULL,
    DEC_RADIANS NUMBER  NULL,
    TYPE CHAR(50)  NULL,
    CREATED DATE  NULL,
    UPDATED DATE  NULL
,   CONSTRAINT PK_OBJET_DISTANT PRIMARY KEY (ID_OBJET_DISTANT)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : OBJET_PROCHE
-- -----------------------------------------------------------------------------

CREATE TABLE OBJET_PROCHE
   (
    ID_OBJET_PROCHE NUMBER(5)  NOT NULL,
    NOM CHAR(32)  NULL,
    MAGNITUDE NUMBER  NULL,
    RA NUMBER  NULL,
    DECA NUMBER  NULL,
    TYPE CHAR(32)  NULL,
    DATE_APPROBATION CHAR(32)  NULL
,   CONSTRAINT PK_OBJET_PROCHE PRIMARY KEY (ID_OBJET_PROCHE)  
   ) ;

-- -----------------------------------------------------------------------------
--       TABLE : PARCOURS
-- -----------------------------------------------------------------------------

CREATE TABLE PARCOURS
   (
    ID_PARCOURS NUMBER(5)  NOT NULL,
    ID_JEU NUMBER(5)  NOT NULL,
    RA NUMBER  NULL,
    DECA NUMBER  NULL,
    MAGNITUDE NUMBER  NULL,
    CREATED DATE  NULL,
    UPDATED DATE  NULL
,   CONSTRAINT PK_PARCOURS PRIMARY KEY (ID_PARCOURS)  
   ) ;

-- -----------------------------------------------------------------------------
--       INDEX DE LA TABLE PARCOURS
-- -----------------------------------------------------------------------------

CREATE  INDEX I_FK_PARCOURS_JEU
     ON PARCOURS (ID_JEU ASC)
    ;

-- -----------------------------------------------------------------------------
--       TABLE : GROUPER
-- -----------------------------------------------------------------------------

CREATE TABLE GROUPER
   (
    ID_OBJET_DISTANT NUMBER(5)  NOT NULL,
    ID_CONSTELLATION NUMBER(8)  NOT NULL
,   CONSTRAINT PK_GROUPER PRIMARY KEY (ID_OBJET_DISTANT, ID_CONSTELLATION)  
   ) ;

-- -----------------------------------------------------------------------------
--       INDEX DE LA TABLE GROUPER
-- -----------------------------------------------------------------------------

CREATE  INDEX I_FK_GROUPER_OBJET_DISTANT
     ON GROUPER (ID_OBJET_DISTANT ASC)
    ;

CREATE  INDEX I_FK_GROUPER_CONSTELLATION
     ON GROUPER (ID_CONSTELLATION ASC)
    ;

-- -----------------------------------------------------------------------------
--       TABLE : DETERMINER
-- -----------------------------------------------------------------------------

CREATE TABLE DETERMINER
   (
    ID_OBJET_PROCHE NUMBER(5)  NOT NULL,
    ID_CONSTELLATION NUMBER(8)  NOT NULL
,   CONSTRAINT PK_DETERMINER PRIMARY KEY (ID_OBJET_PROCHE, ID_CONSTELLATION)  
   ) ;

-- -----------------------------------------------------------------------------
--       INDEX DE LA TABLE DETERMINER
-- -----------------------------------------------------------------------------

CREATE  INDEX I_FK_DETERMINER_OBJET_PROCHE
     ON DETERMINER (ID_OBJET_PROCHE ASC)
    ;

CREATE  INDEX I_FK_DETERMINER_CONSTELLATION
     ON DETERMINER (ID_CONSTELLATION ASC)
    ;


-- -----------------------------------------------------------------------------
--       CREATION DES REFERENCES DE TABLE
-- -----------------------------------------------------------------------------


ALTER TABLE JEU ADD (
     CONSTRAINT FK_JEU_CONSTELLATION
          FOREIGN KEY (ID_CONSTELLATION)
               REFERENCES CONSTELLATION (ID_CONSTELLATION))   ;

ALTER TABLE JEU ADD (
     CONSTRAINT FK_JEU_OBJET_DISTANT
          FOREIGN KEY (ID_OBJET_DISTANT)
               REFERENCES OBJET_DISTANT (ID_OBJET_DISTANT))   ;

ALTER TABLE PARCOURS ADD (
     CONSTRAINT FK_PARCOURS_JEU
          FOREIGN KEY (ID_JEU)
               REFERENCES JEU (ID_JEU))   ;

ALTER TABLE GROUPER ADD (
     CONSTRAINT FK_GROUPER_OBJET_DISTANT
          FOREIGN KEY (ID_OBJET_DISTANT)
               REFERENCES OBJET_DISTANT (ID_OBJET_DISTANT))   ;

ALTER TABLE GROUPER ADD (
     CONSTRAINT FK_GROUPER_CONSTELLATION
          FOREIGN KEY (ID_CONSTELLATION)
               REFERENCES CONSTELLATION (ID_CONSTELLATION))   ;

ALTER TABLE DETERMINER ADD (
     CONSTRAINT FK_DETERMINER_OBJET_PROCHE
          FOREIGN KEY (ID_OBJET_PROCHE)
               REFERENCES OBJET_PROCHE (ID_OBJET_PROCHE))   ;

ALTER TABLE DETERMINER ADD (
     CONSTRAINT FK_DETERMINER_CONSTELLATION
          FOREIGN KEY (ID_CONSTELLATION)
               REFERENCES CONSTELLATION (ID_CONSTELLATION))   ;


-- -----------------------------------------------------------------------------
--                FIN DE GENERATION
-- -----------------------------------------------------------------------------